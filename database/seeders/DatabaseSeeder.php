<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Product::factory()
            ->hasImages(3)
            ->hasColors(3)
            ->hasSizes(3)
            ->count(10)
            ->create();
    }
}
