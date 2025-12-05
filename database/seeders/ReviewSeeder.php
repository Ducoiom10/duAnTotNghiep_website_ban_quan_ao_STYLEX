<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Order;
use App\Models\Review;
use App\Models\ReviewMedia;
use App\Models\ReviewExperience;
use Illuminate\Support\Facades\DB;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        // Lấy danh sách sản phẩm có sẵn
        $products = Product::withTrashed()->get();
        
        if ($products->isEmpty()) {
            $this->command->warn('⚠️ Không tìm thấy sản phẩm nào trong database');
            return;
        }

        // Lấy danh sách user có sẵn
        $users = User::all();
        
        if ($users->isEmpty()) {
            $this->command->warn('⚠️ Không tìm thấy user nào trong database');
            return;
        }

        // Lấy danh sách order đã hoàn thành (nếu có)
        $completedOrders = Order::whereIn('status', ['completed', 'delivered'])->get();

        // Tags mẫu
        $sampleTags = [
            ['Chất lượng tốt', 'Đáng mua'],
            ['Giao hàng nhanh', 'Đóng gói cẩn thận'],
            ['Sản phẩm đẹp', 'Vừa vặn'],
            ['Chất liệu tốt', 'Bền đẹp'],
            ['Màu sắc đẹp', 'Đúng như mô tả'],
            ['Giá cả hợp lý', 'Nên mua'],
        ];

        // Nội dung đánh giá mẫu
        $sampleContents = [
            'Sản phẩm rất đẹp, chất lượng tốt, đúng như mô tả. Tôi rất hài lòng với sản phẩm này.',
            'Giao hàng nhanh, đóng gói cẩn thận. Sản phẩm vừa vặn và đẹp hơn cả mong đợi.',
            'Chất liệu vải tốt, mềm mại. Màu sắc đúng như hình ảnh. Rất đáng mua!',
            'Sản phẩm chất lượng cao, giá cả hợp lý. Sẽ ủng hộ shop tiếp.',
            'Đẹp, chất lượng tốt. Phù hợp với giá tiền. Giao hàng nhanh.',
            'Rất hài lòng với sản phẩm. Đúng như mô tả, chất lượng tốt.',
            'Sản phẩm đẹp, vừa vặn. Chất liệu tốt, bền đẹp. Nên mua!',
            'Giao hàng nhanh, đóng gói cẩn thận. Sản phẩm đẹp, đúng như hình.',
        ];

        $totalReviews = 0;

        // Tạo review cho mỗi sản phẩm (tối đa 10 sản phẩm đầu tiên)
        foreach ($products->take(10) as $product) {
            // Lấy variant của sản phẩm (nếu có)
            $variants = ProductVariant::where('product_id', $product->id)->get();
            
            // Tạo 3-8 review ngẫu nhiên cho mỗi sản phẩm
            $reviewCount = rand(3, 8);
            
            for ($i = 0; $i < $reviewCount; $i++) {
                // Chọn user ngẫu nhiên
                $user = $users->random();
                
                // Chọn variant ngẫu nhiên (nếu có)
                $variant = $variants->isNotEmpty() ? $variants->random() : null;
                
                // Kiểm tra variant có tồn tại không
                $variantId = null;
                if ($variant && ProductVariant::where('id', $variant->id)->exists()) {
                    $variantId = $variant->id;
                }
                
                // Chọn order ngẫu nhiên (nếu có)
                $order = $completedOrders->isNotEmpty() ? $completedOrders->random() : null;
                
                // Tạo review
                $review = Review::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'product_variant_id' => $variantId,
                    'order_id' => $order ? $order->id : null,
                    'rating' => rand(3, 5), // Rating từ 3-5 sao
                    'content' => $sampleContents[array_rand($sampleContents)],
                    'tags' => $sampleTags[array_rand($sampleTags)],
                    'status' => 'public',
                ]);

                // Thêm ảnh mẫu (50% khả năng có ảnh)
                if (rand(1, 2) === 1) {
                    ReviewMedia::create([
                        'review_id' => $review->id,
                        'url' => 'https://res.cloudinary.com/demo/image/upload/sample.jpg',
                        'type' => 'image',
                    ]);
                }

                // Thêm đánh giá chi tiết theo trải nghiệm (70% khả năng)
                if (rand(1, 10) <= 7) {
                    $criteria = ['Chất liệu vải', 'Độ vừa vặn', 'Màu sắc'];
                    foreach ($criteria as $criterion) {
                        ReviewExperience::create([
                            'review_id' => $review->id,
                            'criterion' => $criterion,
                            'rating' => rand(3, 5),
                        ]);
                    }
                }
                
                $totalReviews++;
            }
            
            $this->command->info("✅ Đã tạo {$reviewCount} review cho sản phẩm: {$product->name} (ID: {$product->id})");
        }

        $this->command->info("🎉 Hoàn thành! Đã tạo tổng cộng {$totalReviews} review.");
    }
}
