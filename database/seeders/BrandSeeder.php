<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('brands')
            ->insert([
                ['id' => 1, 'brand_name' => 'Asiacell', 'brand_status' => '1', 'created_at' => now(), 'updated_at' => now()],
                ['id' => 2, 'brand_name' => 'Korek', 'brand_status' => '1', 'created_at' => now(), 'updated_at' => now()],
                ['id' => 3, 'brand_name' => 'Zain', 'brand_status' => '1', 'created_at' => now(), 'updated_at' => now()],

            ]);
    }
}
