<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\File;

class CopyProductImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy tất cả products
        $products = Product::all();
        
        // Ảnh mẫu có sẵn
        $sampleImages = [
            'product-01.jpg', 'product-02.jpg', 'product-03.jpg', 
            'product-04.jpg', 'product-05.jpg', 'product-06.jpg',
            'product-07.jpg', 'product-08.jpg', 'product-09.jpg', 'product-10.jpg'
        ];
        
        foreach ($products as $product) {
            // Tạo thư mục cho sản phẩm
            $productDir = public_path("uploads/products/{$product->slug}");
            if (!File::exists($productDir)) {
                File::makeDirectory($productDir, 0755, true);
            }
            
            // Lấy ảnh của sản phẩm từ database
            $productImages = ProductImage::where('product_id', $product->id)->get();
            
            foreach ($productImages as $index => $productImage) {
                // Chọn ảnh mẫu dựa trên index
                $sampleImage = $sampleImages[$index % count($sampleImages)];
                $sourcePath = public_path("client/images/{$sampleImage}");
                $destPath = public_path($productImage->image_path);
                
                echo "Source: {$sourcePath}\n";
                echo "Dest: {$destPath}\n";
                echo "Source exists: " . (File::exists($sourcePath) ? 'Yes' : 'No') . "\n";
                
                // Copy ảnh mẫu vào vị trí database
                if (File::exists($sourcePath)) {
                    // Tạo thư mục đích nếu chưa có
                    $destDir = dirname($destPath);
                    if (!File::exists($destDir)) {
                        File::makeDirectory($destDir, 0755, true);
                    }
                    
                    File::copy($sourcePath, $destPath);
                    echo "Copied {$sampleImage} to {$productImage->image_path}\n";
                } else {
                    echo "Source file not found: {$sourcePath}\n";
                }
            }
        }
        
        echo "All product images copied successfully!\n";
    }
}
