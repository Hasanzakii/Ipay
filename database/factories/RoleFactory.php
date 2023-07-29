<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $roles = [

            [
                'id' => 1,
                'name' => 'customer',
                'name_fa' => 'رئیس اداره مسافری استان',
                'guard_name' => 'api',
            ],
            [
                'id' => 2,
                'name' => 'Admin',
                'name_fa' => 'کارشناس ماشین آلات',
                'guard_name' => 'api',
            ],

        ];

        $randomIndex = rand(0, count($roles) - 1);
        $name = $roles[$randomIndex]['name'];
        $name_fa = $roles[$randomIndex]['name_fa'];
        $guard_name = $roles[$randomIndex]['guard_name'];

        return [
            "name" => $name,
            "guard_name" => $guard_name,
            "name_fa" => $name_fa,

        ];
    }
}
