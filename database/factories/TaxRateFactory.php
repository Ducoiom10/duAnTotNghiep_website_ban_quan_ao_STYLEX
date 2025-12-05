<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TaxRateFactory extends Factory
{
    public function definition(): array
    {
      
        $percent = $this->faker->randomElement([0,5,8,10,15,20]);
        return [
            'name' => "VAT {$percent}%",
            'rate' => round($percent / 100, 4),
        ];
    }
}
