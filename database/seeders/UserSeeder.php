<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            "name" => "Selena",
            "City" => "NYC",
            "email" => "selena@gmail.com",
            "language" => "en",
            "password" => Hash::make('1234'),
            "gender" => "female",
            "mobile_no" => "09001200298",
            "isVerified" => 1,
            "status" => 1

        ]);
    }
}
