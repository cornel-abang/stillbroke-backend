<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->word,
            'price' => fake()->numberBetween(100,5000),
            'category_id' => Category::factory(),
            'color' => fake()->randomElement(['red','black','white','blue','cream','brown']),
            'primary_image' => fake()->imageUrl,
            'description' => fake()->text(500)
        ];
    }
}
