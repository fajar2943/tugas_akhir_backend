<?php

namespace Database\Seeders;

use App\Models\Discount;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Discount::create(['name' => 'Tidak ada diskon', 'value' => '0', 'type' => 'Nominal', 'status' => 'ON']);
    }
}
