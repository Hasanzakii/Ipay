<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Productseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            "brand_id" => "1",
            "product_name" => "123465",
            "introduction" => "charge",
            "price" => "20",
            "marketable" => 1,
            "status" => 1

        ]);
    }
}
