<?php

namespace Database\Seeders;

use App\Models\PhoneBrand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PhoneBrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $phoneBrands = [
            'Iphone',
            'Nokia',
            'Samsung',
            'Xiaomi',
        ];
        foreach ($phoneBrands as $phoneBrand) {
            PhoneBrand::query()->firstOrCreate([
                'name' => $phoneBrand,
            ], [
                'name' => $phoneBrand,
            ]);
        }
    }
}
