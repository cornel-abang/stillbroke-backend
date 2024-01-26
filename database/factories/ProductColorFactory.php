<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductColor>
 */
class ProductColorFactory extends Factory
{
    public function definition(): array
    {
        return [
            'color_code' => fake()->safeColorName,
            'product_id' => Product::factory(),
        ];
    }
}
