<?php

namespace App\Support;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;

class ImageOptimizer
{
    protected ImageManager $imageManager;
    protected string $disk;
    /** @var array<string,int> map size => max width */
    protected array $sizes;
    /** @var array<int,string> formats to encode */
    protected array $formats;
    protected int $quality;
    protected bool $backupOriginal;

    public function __construct()
    {
        $driver = extension_loaded('imagick') ? new ImagickDriver() : new GdDriver();
        $this->imageManager = new ImageManager($driver);

        $config                 = config('image', []);
        $this->disk             = $config['disk'] ?? 'public';
        $this->sizes            = $this->normalizeSizes($config['sizes'] ?? ['lg' => 1600, 'md' => 1024, 'sm' => 640]);
        $this->formats          = $config['formats'] ?? ['webp', 'jpg'];
        $this->quality          = (int)($config['quality'] ?? 88);
        $this->backupOriginal   = (bool)($config['backup_original'] ?? true);
    }

    /**
     * Chuẩn hoá cấu hình sizes:
     * Chấp nhận ['lg'=>1600] hoặc ['lg'=>[1600,1600]] (lấy width).
     * @param array<string,int|array> $sizes
     * @return array<string,int>
     */
    protected function normalizeSizes(array $sizes): array
    {
        $normalized = [];
        foreach ($sizes as $key => $value) {
            if (is_array($value)) {
                $normalized[$key] = (int)($value[0] ?? 0);
            } else {
                $normalized[$key] = (int)$value;
            }
        }

        // Đảm bảo thứ tự lg, md, sm trước
        $order = ['lg', 'md', 'sm'];
        $sorted = [];
        foreach ($order as $key) {
            if (isset($normalized[$key])) {
                $sorted[$key] = $normalized[$key];
            }
        }
        foreach ($normalized as $key => $value) {
            if (!isset($sorted[$key])) {
                $sorted[$key] = $value;
            }
        }
        return $sorted;
    }

    /** Không bao giờ upscale: chỉ scaleDown theo maxWidth, giữ tỉ lệ. */
    protected function scaleDown(\Intervention\Image\Interfaces\ImageInterface $image, int $maxWidth)
    {
        if ($maxWidth <= 0) {
            return $image;
        }
        return $image->scaleDown(width: $maxWidth);
    }

    /** Encode theo format */
    protected function encode(\Intervention\Image\Interfaces\ImageInterface $image, string $format, int $quality): string
    {
        $format = strtolower($format);
        return match ($format) {
            'webp'                => $image->toWebp($quality),
            'jpg', 'jpeg'         => $image->toJpeg($quality),
            'png'                 => $image->toPng($quality),
            'avif'                => method_exists($image, 'toAvif') ? $image->toAvif($quality) : $image->toJpeg($quality),
            default               => $image->toJpeg($quality),
        };
    }

    protected function put(string $path, string $binary): void
    {
        Storage::disk($this->disk)->put($path, $binary);
    }

    protected function makeName(string $baseDirectory, string $prefix, string $extension): string
    {
        $uuid = Str::uuid()->toString();
        return rtrim($baseDirectory, '/') . "/{$prefix}_{$uuid}.{$extension}";
    }

    /**
     * Tối ưu một file: tạo các bản lg/md/sm (theo max width) và encode theo formats.
     * - Bản gốc: lưu ở /storage/products với TÊN GỐC (không prefix "orig_").
     * - Bản đã nén/resize: lưu theo $baseDirectory (thường là products/{id} hoặc products/variants/{id})
     *
     * @return array{
     *   original?: string,
     *   variants: array<string, array<string,string>>
     * }
     */
    public function process(UploadedFile $file, string $baseDirectory, ?string $basename = null): array
    {
        $basename      = $basename ?: Str::uuid()->toString();
        $baseDirectory = trim($baseDirectory, '/');

        $image = $this->imageManager->read($file->getRealPath());

        $result = [
            'variants' => [],
        ];

        // LƯU BẢN GỐC Ở /storage/products VỚI TÊN GỐC
        if ($this->backupOriginal) {
            $originalDirectory = 'products';
            $originalFilename  = $file->getClientOriginalName() ?: ("file." . strtolower($file->getClientOriginalExtension() ?: 'jpg'));
            $originalFilename  = basename(str_replace('\\', '/', $originalFilename)); // tránh path bất thường
            $originalPath      = $originalDirectory . '/' . $originalFilename;

            // Lưu nguyên file gốc
            Storage::disk($this->disk)->putFileAs($originalDirectory, $file, $originalFilename);
            $result['original'] = $originalPath;
        }

        // Tạo các size đã cấu hình
        foreach ($this->sizes as $sizeKey => $maxWidth) {
            $resized = $this->imageManager->read($file->getRealPath());
            $resized = $this->scaleDown($resized, $maxWidth);

            foreach ($this->formats as $format) {
                $pathRelative = $this->makeName($baseDirectory, $sizeKey, $format);
                $binary       = $this->encode($resized, $format, $this->quality);
                $this->put($pathRelative, $binary);
                $result['variants'][$sizeKey][$format] = $pathRelative;
            }
        }

        return $result;
    }

    /** Chọn đường dẫn “chuẩn” để lưu DB (ưu tiên lg.webp, rồi lg.jpg, rồi phần tử đầu tiên; nếu không có thì bản gốc). */
    protected function canonical(array $saved): string
    {
        $variants = $saved['variants'] ?? [];
        if (isset($variants['lg']['webp'])) {
            return $variants['lg']['webp'];
        }
        if (isset($variants['lg']['jpg'])) {
            return $variants['lg']['jpg'];
        }
        if (!empty($variants)) {
            $firstSize = reset($variants);
            if (is_array($firstSize) && !empty($firstSize)) {
                return reset($firstSize);
            }
        }
        return $saved['original'] ?? '';
    }

    /** Generic: Lưu file vào $baseDirectory (nén/resize, KHÔNG ghi DB) */
    public function saveTo(string $baseDirectory, UploadedFile $file): array
    {
        return $this->process($file, trim($baseDirectory, '/'));
    }

    /** Generic: Lưu file + gán path vào $model->$column rồi save() */
    public function assignTo(Model $model, string $column, UploadedFile $file, array $options = []): array
    {
        $baseDirectory = $options['base'] ?? (class_basename($model) . '/' . $model->getKey());
        $saved         = $this->process($file, $baseDirectory);
        $model->setAttribute($column, $this->canonical($saved));
        $model->save();
        return $saved;
    }

    /**
     * PRODUCT: nén/resize + cập nhật products.thumbnail.
     */
    public function saveForProduct(Product $product, UploadedFile $file, array $options = []): array
    {
        $baseDirectory = $options['base'] ?? ("products/{$product->id}");
        $saved         = $this->process($file, $baseDirectory);
        $canonical     = $this->canonical($saved);

        if ($canonical !== '') {
            $product->update(['thumbnail' => $canonical]);
        }

        return $saved;
    }

    /**
     * VARIANT: nén/resize + cập nhật product_variants.image.
     */
    public function saveForVariant(ProductVariant $variant, UploadedFile $file, array $options = []): array
    {
        $baseDirectory = $options['base'] ?? ("products/variants/{$variant->id}");
        $saved         = $this->process($file, $baseDirectory);
        $canonical     = $this->canonical($saved);

        if ($canonical !== '') {
            $variant->update(['image' => $canonical]);
        }

        return $saved;
    }

    /** Xoá file cũ an toàn */
    public function deletePath(?string $path): void
    {
        if ($path && Storage::disk($this->disk)->exists($path)) {
            Storage::disk($this->disk)->delete($path);
        }
    }
}
