<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        $enum = [0, 1];
        return [
            'brand_id' => Brand::factory(),
            'product_name' => fake()->name(),
            'price' => fake()->randomDigit(),
            'status' => $this->faker->numberBetween(0, 1),
            'marketable' => 1,
            'introduction' => $this->faker->text(150),
        ];
    }
}
