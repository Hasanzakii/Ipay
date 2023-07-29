<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'product_id' => Product::factory(),
            'payment_id' => Payment::factory(),
            'mobile_no' => function (array $attributes) {
                return User::find($attributes['user_id'])->mobile_no;
            }
        ];
    }
}
