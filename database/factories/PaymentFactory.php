<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        $enum = [0, 1];

        return [
            // 'user_id' => User::factory(),
            "Balance" => $this->faker->numberBetween(1000, 99999),
            'status' => $this->faker->randomElement($enum),
            "paymentable_id" => $this->faker->numerify('####'),
            "paymentable_type" => $this->faker->randomElement(['1,2,3']),


        ];
    }
}
