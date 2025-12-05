<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            LoyaltyTierSeeder::class,
            // ProductSeeder::class,
            // ProductImageSeeder::class,
            ShippingCarrierSeeder::class,
            TaxRateSeeder::class,
            TextureSeeder::class,
            BannerSeeder::class,
            PostSeeder::class,
            TagSeeder::class,
            VoucherSeeder::class,
        ]);
    }
}
