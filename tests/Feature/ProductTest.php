<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test*/
    public function testproducts_database_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('products', [
                'id', 'brand_id'
            ]),
            1
        );
    }
    #Test if it InsertDat truely
    public function testInsertData()
    {
        $data = Product::factory()->make()->toArray();

        Product::create($data);

        $this->assertDatabaseHas('products', $data);
    }
    #Test the relation Between Product & Brand
    public function testProductRelationWithBrand()
    {
        $product = Product::factory()
            ->for(Brand::factory()
                ->create());
        $this->assertTrue($product instanceof Brand);
    }

    // public function a_product_belongs_to_a_brand()
    // { 

    //     $brand = Brand::create([
    //         'brand_name' => 'Ritel',
    //     ]);

    //     $product = Product::create([
    //         'brand_id' => $brand->id,
    //         'product_name' => "charges",
    //         'price' => "898989",
    //     ]);

    //     // Method 1: Test by count that a comment has a parent relationship with post
    //     // $this->assertEquals(1, $product->brand->count());

    //     // Method 2: 
    //     $this->assertInstanceOf(Brand::class, $product->brand);
    // }
}
