<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Color;
use App\Models\Size;
use App\Models\Texture;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy tất cả products
        $products = Product::all();
        
        foreach ($products as $product) {
            // Tạo 3-5 hình ảnh cho mỗi sản phẩm
            $imageCount = rand(3, 5);
            
            for ($i = 0; $i < $imageCount; $i++) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => "uploads/products/{$product->slug}/image_" . ($i + 1) . ".jpg",
                    'image_url' => "uploads/products/{$product->slug}/image_" . ($i + 1) . ".jpg",
                    'alt_text' => "Hình ảnh " . ($i + 1) . " của {$product->name}",
                    'sort_order' => $i,
                    'is_primary' => $i === 0, // Hình đầu tiên là primary
                ]);
            }
            
            // Tạo biến thể sản phẩm
            $colors = Color::take(2)->get();
            $sizes = Size::take(3)->get();
            $textures = Texture::take(2)->get();
            
            foreach ($colors as $color) {
                foreach ($sizes as $size) {
                    foreach ($textures as $texture) {
                        ProductVariant::create([
                            'product_id' => $product->id,
                            'color_id' => $color->id,
                            'size_id' => $size->id,
                            'texture_id' => $texture->id,
                            'sku' => $product->slug . '-' . $color->id . '-' . $size->id . '-' . $texture->id,
                            'image' => "uploads/products/{$product->slug}/variant_" . $color->id . "_" . $size->id . "_" . $texture->id . ".jpg",
                            'price' => $product->price + rand(0, 100000),
                            'quantity' => rand(0, 100),
                            'status' => 1,
                        ]);
                    }
                }
            }
        }
    }
}
