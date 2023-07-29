<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
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
            'name' => $this->faker->name(),
            'city' => $this->faker->city(),
            'email' => $this->faker->unique()->email(),
            'language' => $this->faker->randomElement(["en", "ab", "fa"]),
            'password' => \Hash::make('password'),
            'gender' => $this->faker->randomElement(["male", "female"]),
            'mobile_no' => $this->faker->phoneNumber(),
            'isVerified' => $this->faker->randomElement($enum),
            'mobile_no' => '09' . $this->faker->unique()->randomNumber(9, true)
        ];
    }
}
