<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductSize>
 */
class ProductSizeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'size_code' => fake()->randomElement(['M','L', 'S', 'XL', '40', '32', '45', '33']),
            'product_id' => Product::factory(),
        ];
    }
}
