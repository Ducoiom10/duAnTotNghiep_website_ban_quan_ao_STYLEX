<?php

namespace Database\Factories;

use App\Models\ShippingCarrier;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShippingCarrierFactory extends Factory
{
    protected $model = ShippingCarrier::class;

    public function definition(): array
    {
        // dùng unique để tránh trùng tên khi tạo nhiều bản ghi
        return [
            'name' => fake()->unique()->randomElement([
                'Giao Hàng Nhanh (GHN)',
                'Giao Hàng Tiết Kiệm (GHTK)',
                'Viettel Post',
                'VNPost',
                'J&T Express',
                'Ninja Van',
                'Best Express',
                'DHL',
                'FedEx',
                'UPS',
            ]),
        ];
    }
}
