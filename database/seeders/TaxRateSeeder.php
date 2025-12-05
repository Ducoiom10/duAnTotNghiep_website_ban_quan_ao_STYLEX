<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TaxRate;

class TaxRateSeeder extends Seeder
{
    public function run(): void
    {
        // Xóa toàn bộ mức thuế hiện tại trước khi seed lại
        TaxRate::query()->delete();

        $data = [
            ['name' => 'VAT 0%',   'rate' => 0.00],   // 0%
            ['name' => 'VAT 0.5%', 'rate' => 0.005],  // 0.5%
            ['name' => 'VAT 1%',   'rate' => 0.01],   // 1%
        ];

        foreach ($data as $row) {
            TaxRate::updateOrCreate(
                ['name' => $row['name']],
                ['rate' => $row['rate']]
            );
        }

        // (Tuỳ chọn) thêm 10 bản ghi ngẫu nhiên từ factory
        // TaxRate::factory()->count(10)->create();
    }
}
