<?php

namespace Database\Seeders;

use App\Models\Warehouse;
use App\Models\WarehouseStock;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo kho mặc định
        $warehouse = Warehouse::create([
            'name' => 'Kho Chính',
            'code' => 'WH001',
            'address' => 'Hà Nội, Việt Nam',
            'phone' => '0123456789',
            'email' => 'warehouse@stylex.com',
            'operational_status' => 'ACTIVE',
            'description' => 'Kho chính của StyleX',
        ]);

        // Tạo stock cho tất cả variants hiện có
        $variants = ProductVariant::all();
        foreach ($variants as $variant) {
            WarehouseStock::create([
                'warehouse_id' => $warehouse->id,
                'variant_id' => $variant->id,
                'on_hand' => rand(0, 100),
                'available' => rand(0, 80),
                'reserved' => rand(0, 10),
                'quarantine' => rand(0, 5),
                'damaged' => rand(0, 3),
            ]);
        }
    }
}