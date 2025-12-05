<?php

namespace Database\Seeders;

use App\Models\Voucher;
use Illuminate\Database\Seeder;

class VoucherSeeder extends Seeder
{
    public function run(): void
    {
        // Xóa toàn bộ voucher hiện tại (kể cả đã soft delete)
        Voucher::query()->forceDelete();

        // Các voucher mẫu (tiếng Việt) cho giỏ hàng
        $now = now();

        $data = [
            [
                'code'              => 'GIAM10',
                'description'       => 'Giảm 10% cho mọi đơn hàng từ 200.000đ',
                'type'              => 'percent',
                'value'             => 10,          // 10%
                'min_order_amount'  => 200000,      // 200k
                'usage_limit'       => null,        // không giới hạn lượt
                'used_count'        => 0,
                'starts_at'         => $now->copy()->subDays(1),
                'ends_at'           => $now->copy()->addMonths(3),
                'is_active'         => true,
            ],
            [
                'code'              => 'GIAM50K',
                'description'       => 'Giảm 50.000đ cho đơn từ 500.000đ',
                'type'              => 'fixed',
                'value'             => 50000,
                'min_order_amount'  => 500000,
                'usage_limit'       => 100,
                'used_count'        => 0,
                'starts_at'         => $now->copy()->subDays(1),
                'ends_at'           => $now->copy()->addMonths(1),
                'is_active'         => true,
            ],
            [
                'code'              => 'FREESHIP',
                'description'       => 'Giảm 30.000đ phí ship cho đơn từ 300.000đ',
                'type'              => 'fixed',
                'value'             => 30000,
                'min_order_amount'  => 300000,
                'usage_limit'       => null,
                'used_count'        => 0,
                'starts_at'         => $now->copy()->subDays(1),
                'ends_at'           => $now->copy()->addMonths(2),
                'is_active'         => true,
            ],
        ];

        foreach ($data as $row) {
       	    Voucher::updateOrCreate(
                ['code' => $row['code']],
                $row
            );
        }
    }
}


