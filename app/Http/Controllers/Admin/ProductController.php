<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\StoreProductRequest;
use App\Http\Requests\Admin\Product\UpdateProductRequest;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use App\Models\Texture;
use App\Models\User;
use App\Traits\LoggableTrait;
use App\Traits\UploadToLocalTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    use LoggableTrait, UploadToLocalTrait;

    const FOLDER = 'products';
    public function index(Request $request)
    {
        $queryproducts = Product::query()->with(['category', 'productImages', 'productVariants.color', 'productVariants.size', 'productVariants.texture'])->latest('id');

        if ($request->filled('name')) {
            $queryproducts->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('category_id')) {
            $queryproducts->where('category_id', $request->category_id);
        }
        if ($request->filled('status')) {
            $queryproducts->where('is_active', $request->status);
        }
        if ($request->filled('is_featured')) {
            $queryproducts->where('is_featured', $request->is_featured);
        }

        $queryproductCounts =
            Product::query()
            ->selectRaw('
                    count(id) as total_products,
                    sum(is_active = "1") as active_products,
                    sum(is_active = "0") as inactive_products,
                    sum(is_featured = 1) as featured_products
                ');
        $items = $queryproducts->paginate(10);
        $productCounts = $queryproductCounts->first();
        $categories = Category::all();
        return view('admin.products.index', compact('items', 'productCounts', 'categories'));
    }
    public function create()
    {
        $categories = Category::query()->where('status', 1)->get();
        $colors = Color::query()->where('status', 1)->get();
        $textures = Texture::query()->where('status', 1)->get();
        $sizes = Size::query()->where('status', 1)->get();
        return view('admin.products.create', compact('categories', 'colors', 'textures', 'sizes'));
    }
    public function store(StoreProductRequest $request)
    {

        try {
            DB::transaction(function () use ($request) {
                $data = $request->validated();
                
                // Tự động tạo slug nếu không có
                if (empty($data['slug'])) {
                    $data['slug'] = Str::slug($data['name']);
                }
                
                if (!empty($data['thumbnail'])) {
                    $urlThumbnail = Storage::disk('public')->put(self::FOLDER, $data['thumbnail']);
                    if ($urlThumbnail) {
                        $data['thumbnail'] = $urlThumbnail;
                    } else {
                        $data['thumbnail'] = null;
                    }
                } else {
                    $data['thumbnail'] = null;
                }

                $product = Product::query()->create($data);

                // Xử lý product images
                if (!empty($data['product_images'])) {
                    foreach ($data['product_images'] as $index => $image) {
                        $imagePath = Storage::disk('public')->put(self::FOLDER, $image);
                        if ($imagePath) {
                            $product->productImages()->create([
                                'image_path' => $imagePath,
                                'image_url' => $imagePath,
                                'alt_text' => $data['alt_texts'][$index] ?? "Hình ảnh " . ($index + 1) . " của " . $product->name,
                                'sort_order' => $index,
                                'is_primary' => $index === 0,
                            ]);
                        }
                    }
                }

                if (!empty($data['variants'])) {
                    foreach ($data['variants'] ?? [] as $variant) {
                        $variant['product_id'] = $product->id;
                        $variant['sku'] = Str::upper(Str::random(12));

                        if (isset($variant['image'])) {
                            $variant['image'] = Storage::disk('public')->put(self::FOLDER, $variant['image']);
                        } else {
                            $variant['image'] = null;
                        }

                        $product->productVariants()->create($variant);
                    }
                }
            });
            return redirect()->route('admin.products.index')->with('success', 'Thêm mới thành công');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại sau');
        }

        // try {
        //     DB::beginTransaction();

        //     $data = $request->except('thumbnail');

        //     if ($request->hasFile('thumbnail')) {
        //         $urlThumbnail = $this->uploadToLocal($request->file('thumbnail'), self::FOLDER);
        //         $data['thumbnail'] = $urlThumbnail;
        //     }

        //     $data['slug'] = Str::slug($data['name']);
        //     // dd($data);
        //     $product = Product::query()->create($data);

        //     DB::commit();

        //     return redirect()->route('admin.products.index')->with('success', 'Thêm mới thành công');
        // } catch (\Exception $e) {
        //     DB::rollBack();

        //     if (isset($urlThumbnail) && filter_var($urlThumbnail, FILTER_VALIDATE_URL)) {
        //         $this->deleteFromLocal($urlThumbnail, self::FOLDER);
        //     }

        //     $this->logError($e);

        //     return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại sau');
        // }
    }
    public function toggleFeature(Request $request, Product $product)
    {
        $product->is_featured = $request->input('is_featured') ? 1 : 0;
        $product->save();

        return response()->json(['message' => 'Cập nhật trạng thái sản phẩm nổi bật thành công.']);
    }
    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }
    public function edit(Product $product)
    {
        $categories = Category::query()->where('status', 1)->get();
        $colors = Color::query()->where('status', 1)->get();
        $textures = Texture::query()->where('status', 1)->get();
        $sizes = Size::query()->where('status', 1)->get();
        return view('admin.products.edit', compact('categories', 'product', 'colors', 'textures', 'sizes'));
    }
    public function update(UpdateProductRequest $request, Product $product)
    {
        try {
            DB::transaction(function () use ($request, $product) {
                $data = $request->validated();

                // Debug: Log dữ liệu để kiểm tra
                Log::info('Update Product Data:', [
                    'thumbnail' => isset($data['thumbnail']) ? 'Has thumbnail' : 'No thumbnail',
                    'variants_count' => count($data['variants'] ?? []),
                    'request_files' => array_keys($request->allFiles()),
                    'all_data_keys' => array_keys($data)
                ]);

                // 1) Thumbnail: xử lý riêng biệt, không để bị ảnh hưởng bởi variants
                $thumbnailPath = null;
                if ($request->hasFile('thumbnail')) {
                    $thumbnailFile = $request->file('thumbnail');
                    if ($product->thumbnail) {
                        Storage::disk('public')->delete($product->thumbnail);
                    }
                    $thumbnailPath = Storage::disk('public')->put(self::FOLDER, $thumbnailFile);
                    $data['thumbnail'] = $thumbnailPath;
                    Log::info('Thumbnail saved to:', ['path' => $thumbnailPath]);
                } else {
                    // Không có file thumbnail mới, giữ nguyên thumbnail cũ
                    unset($data['thumbnail']);
                }

                // 2) Update product
                $product->update($data);

                // 3) Update/Create variants (KHÔNG xoá biến thể cũ)
                foreach ($data['variants'] ?? [] as $row) {
                    $payload = [
                        'product_id'  => $product->id,
                        'color_id'    => $row['color_id'] ?? null,
                        'size_id'     => $row['size_id'] ?? null,
                        'texture_id'  => $row['texture_id'] ?? null,
                        'price'       => $row['price'] ?? 0,
                        'status'      => $row['status'] ?? 0,
                    ];

                    // Ảnh biến thể mới - chỉ xử lý khi có file upload thực sự
                    $newImagePath = null;
                    if (isset($row['image']) && $row['image'] instanceof \Illuminate\Http\UploadedFile) {
                        $newImagePath = Storage::disk('public')->put(self::FOLDER, $row['image']);
                        $payload['image'] = $newImagePath;
                        Log::info('Variant image saved to:', ['path' => $newImagePath, 'variant_id' => $row['id'] ?? 'new']);
                    }

                    if (!empty($row['id'])) {
                        // Cập nhật biến thể hiện có
                        $variant = $product->productVariants()->where('id', $row['id'])->first();

                        if ($variant) {
                            // Nếu có ảnh mới → xoá ảnh cũ
                            if ($newImagePath && $variant->image) {
                                Storage::disk('public')->delete($variant->image);
                            }
                            $variant->update($payload);
                        }
                    } else {
                        // Tạo mới biến thể (sku tự sinh)
                        $payload['sku'] = Str::upper(Str::random(12));
                        $product->productVariants()->create($payload);
                    }
                }

                // 4) KHÔNG xoá biến thể trong update theo yêu cầu
            });

            return redirect()->route('admin.products.index')->with('success', 'Cập nhật thành công');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại sau')->withInput();
        }
    }
    public function destroy(Product $product)
    {
        try {
            $product->delete();

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Đã chuyển vào thùng rác!');
        } catch (\Exception $e) {
            $this->logError($e);

            return redirect()
                ->back()
                ->with('error', 'Có lỗi xảy ra, vui lòng thử lại sau');
        }
    }

    public function trash()
    {
        try {
            $productsDeleted = Product::onlyTrashed()->latest('id')->paginate(10);
            $categories = Category::all();
            return view('admin.products.trash', compact('productsDeleted', 'categories'));
        } catch (\Exception $e) {
            $this->logError($e);

            return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại sau');
        }
    }
    public function restore($id)
    {
        try {
            $product = Product::withTrashed()->findOrFail($id);
            $product->restore();
            return redirect()->route('admin.products.trash')->with('success', 'Khôi phục sản phẩm thành công');
        } catch (\Exception $e) {
            $this->logError($e);

            return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại sau');
        }
    }
    public function forceDelete($id)
    {
        try {
            $product = Product::withTrashed()->findOrFail($id);
            $product->forceDelete();
            return redirect()->route('admin.products.trash')->with('success', 'Xóa cứng sản phẩm thành công');
        } catch (\Exception $e) {
            $this->logError($e);

            return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại sau');
        }
    }
}
