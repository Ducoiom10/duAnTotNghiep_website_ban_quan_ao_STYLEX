<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ShippingCarrier;

class ShippingCarrierSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            // fee: phí ship cố định (VNĐ) cho mỗi đơn vị vận chuyển
            ['name' => 'Giao Hàng Nhanh (GHN)',       'code' => 'GHN',    'fee' => 25000],
            ['name' => 'Giao Hàng Tiết Kiệm (GHTK)', 'code' => 'GHTK',   'fee' => 22000],
            ['name' => 'Viettel Post',               'code' => 'VIETTEL','fee' => 28000],
            ['name' => 'VNPost',                     'code' => 'VNPOST', 'fee' => 20000],
            ['name' => 'J&T Express',                'code' => 'JT',     'fee' => 23000],
            ['name' => 'Ninja Van',                  'code' => 'NINJA',  'fee' => 24000],
            ['name' => 'Best Express',               'code' => 'BEST',   'fee' => 21000],
            ['name' => 'DHL',                        'code' => 'DHL',    'fee' => 50000],
            ['name' => 'FedEx',                      'code' => 'FEDEX',  'fee' => 55000],
            ['name' => 'UPS',                        'code' => 'UPS',    'fee' => 52000],
        ];

        foreach ($rows as $row) {
            ShippingCarrier::updateOrCreate(
                ['code' => $row['code']],
                [
                    'name' => $row['name'],
                    'fee' => $row['fee'],
                    'active' => true,
                ]
            );
        }

        // Nếu muốn random thêm vài hãng giả lập:
        // ShippingCarrier::factory()->count(5)->create();
    }
}
