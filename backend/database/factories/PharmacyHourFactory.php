<?php

namespace Database\Factories;

use App\Models\PharmacyHour;
use App\Models\Pharmacy;
use Illuminate\Database\Eloquent\Factories\Factory;

class PharmacyHourFactory extends Factory
{
    protected $model = PharmacyHour::class;

    public function definition(): array
    {
        return [
            'pharmacy_id' => Pharmacy::factory(), // 建立 pharmacy 並關聯
            'weekday' => 'Mon',
            'open_time' => '09:00',
            'close_time' => '18:00',
        ];
    }
}
