<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Lấy dữ liệu từ database
        $categories = DB::table('categories')->whereNull('deleted_at')->pluck('id')->toArray();
        $colors = DB::table('colors')->whereNull('deleted_at')->pluck('id')->toArray();
        $sizes = DB::table('sizes')->whereNull('deleted_at')->pluck('id')->toArray();
        $textures = DB::table('textures')->whereNull('deleted_at')->pluck('id')->toArray();

        if (empty($categories)) {
            $categories = [1];
        }
        if (empty($colors)) {
            $colors = [2, 3, 4];
        }
        if (empty($sizes)) {
            $sizes = [8, 9, 10, 11];
        }
        if (empty($textures)) {
            $textures = [1, 2, 3];
        }

        $productNames = [
            'Áo thun nam cổ tròn', 'Áo sơ mi công sở', 'Quần jean nam', 'Áo khoác gió', 'Quần short thể thao',
            'Áo polo nam', 'Áo thun nữ', 'Váy đầm công sở', 'Áo len mùa đông', 'Quần tây nam',
            'Áo hoodie unisex', 'Áo ba lỗ thể thao', 'Quần jogger', 'Áo cardigan nữ', 'Áo blazer nam',
            'Áo thun có cổ', 'Quần legging nữ', 'Áo khoác bomber', 'Áo sơ mi kẻ sọc', 'Quần jean nữ'
        ];

        $descriptions = [
            'Chất liệu cotton cao cấp, thoáng mát, thấm hút mồ hôi tốt. Form dáng vừa vặn, phù hợp mọi hoàn cảnh.',
            'Thiết kế hiện đại, trẻ trung. Chất liệu bền đẹp, dễ giặt, không phai màu.',
            'Sản phẩm được may tỉ mỉ, đường chỉ chắc chắn. Kiểu dáng thời trang, dễ phối đồ.',
            'Chất liệu nhẹ, mềm mại. Phù hợp cho cả nam và nữ, nhiều size đa dạng.',
            'Thiết kế đơn giản nhưng tinh tế. Màu sắc đa dạng, dễ dàng mix & match.'
        ];

        for ($i = 1; $i <= 20; $i++) {
            $name = $productNames[$i - 1] ?? "Sản phẩm demo $i";
            $slug = Str::slug($name) . '-' . uniqid();
            $categoryId = $categories[array_rand($categories)];
            
            // Giá ngẫu nhiên: price từ 150k-600k, price_sale từ 100k-500k
            $price = rand(150000, 600000);
            $priceSale = rand(100000, min(500000, $price - 20000));
            
            $productId = DB::table('products')->insertGetId([
                'name' => $name,
                'category_id' => $categoryId,
                'slug' => $slug,
                'thumbnail' => 'products/product-' . $i . '.jpg',
                'price' => $price,
                'price_sale' => $priceSale,
                'is_active' => $i % 4 != 0 ? 1 : 0,
                'description' => $descriptions[array_rand($descriptions)] . " " . $name . " là lựa chọn hoàn hảo cho tủ đồ của bạn.",
                'is_featured' => $i <= 6 ? 1 : 0,
                'meta_title' => "$name - STYLEX",
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now()->subDays(rand(0, 10)),
            ]);

            // Tạo 2-4 variants cho mỗi product
            $variantCount = rand(2, 4);
            shuffle($colors);
            shuffle($sizes);
            shuffle($textures);

            for ($v = 0; $v < $variantCount; $v++) {
                $colorId = $colors[$v % count($colors)];
                $sizeId = $sizes[$v % count($sizes)];
                $textureId = $textures[$v % count($textures)];
                
                $sku = strtoupper(Str::random(12));
                $variantPrice = rand(0, 1) ? $priceSale + rand(-20000, 20000) : null; // 50% có giá riêng
                $quantity = rand(10, 100);
                
                $variantId = DB::table('product_variants')->insertGetId([
                    'product_id' => $productId,
                    'sku' => $sku,
                    'color_id' => $colorId,
                    'size_id' => $sizeId,
                    'texture_id' => $textureId,
                    'price' => $variantPrice,
                    'quantity' => $quantity,
                    'stock_quantity' => $quantity,
                    'is_default' => $v === 0 ? 1 : 0,
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Tạo 1-2 images cho variant - sử dụng ảnh placeholder có sẵn
                $imageCount = rand(1, 2);
                $productImageIndex = (($productId - 1) % 16) + 1; // Lặp lại từ 1-16
                for ($img = 0; $img < $imageCount; $img++) {
                    $imageNum = (($productImageIndex + $img - 1) % 16) + 1;
                    $imagePath = 'client/images/product-' . str_pad($imageNum, 2, '0', STR_PAD_LEFT) . '.jpg';
                    
                    DB::table('product_images')->insert([
                        'product_id' => $productId,
                        'variant_id' => $variantId,
                        'image_url' => $imagePath,
                        'image_path' => $imagePath,
                        'is_primary' => ($v === 0 && $img === 0) ? 1 : 0,
                        'is_main' => ($v === 0 && $img === 0) ? 1 : 0,
                        'sort_order' => $img,
                        'alt_text' => "$name - Variant " . ($v + 1),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // Tạo thêm 1-2 images chung cho product (không gắn variant) - sử dụng ảnh placeholder
            $productImageCount = rand(1, 2);
            $productImageIndex = (($productId - 1) % 16) + 1;
            for ($pimg = 0; $pimg < $productImageCount; $pimg++) {
                $imageNum = (($productImageIndex + $pimg) % 16) + 1;
                $imagePath = 'client/images/product-' . str_pad($imageNum, 2, '0', STR_PAD_LEFT) . '.jpg';
                
                DB::table('product_images')->insert([
                    'product_id' => $productId,
                    'variant_id' => null,
                    'image_url' => $imagePath,
                    'image_path' => $imagePath,
                    'is_primary' => 0,
                    'is_main' => 0,
                    'sort_order' => $pimg + 10,
                    'alt_text' => $name,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            
            // Cập nhật thumbnail cho product
            $thumbnailImageNum = (($productId - 1) % 16) + 1;
            DB::table('products')
                ->where('id', $productId)
                ->update([
                    'thumbnail' => 'client/images/product-' . str_pad($thumbnailImageNum, 2, '0', STR_PAD_LEFT) . '.jpg'
                ]);
        }
    }
}
