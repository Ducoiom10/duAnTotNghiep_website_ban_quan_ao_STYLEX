<?php

namespace Database\Seeders;

use App\Models\LoyaltyTier;
use Illuminate\Database\Seeder;

class LoyaltyTierSeeder extends Seeder
{
    public function run(): void
    {
        // Định nghĩa các cấp độ với ngưỡng chi tiêu và ưu đãi tương ứng
        $tiers = [
            // Cấp độ khởi điểm
            ['name' => 'Bronze', 'min_spend_required' => 0, 'discount_rate' => 0.0],

            // Các cấp độ trung bình
            ['name' => 'Silver', 'min_spend_required' => 5000000, 'discount_rate' => 5.0],
            ['name' => 'Gold', 'min_spend_required' => 15000000, 'discount_rate' => 10.0],

            // Các cấp độ cao cấp (VIP)
            ['name' => 'Platinum', 'min_spend_required' => 35000000, 'discount_rate' => 15.0],
            ['name' => 'Diamond', 'min_spend_required' => 80000000, 'discount_rate' => 20.0],
        ];

        foreach ($tiers as $tierData) {
            LoyaltyTier::updateOrCreate(
                ['name' => $tierData['name']], // Tìm theo tên
                $tierData                      // Cập nhật hoặc tạo mới
            );
        }

        // Tùy chọn: Đảm bảo người dùng hiện tại có cấp độ mặc định (Bronze)
        // Lưu ý: Chỉ thực hiện nếu bạn đã có User Model
    }
}
