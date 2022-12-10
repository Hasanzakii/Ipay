<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class BrandTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    // @group skip 

    public function testbrand_database_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('brands', [
                'id', 'brand_name'
            ]),
            1
        );
    }
    #Test if it InsertDat truely
    public function testInsertData()
    {
        $data = Brand::factory()->create()->toArray();

        $this->assertDatabaseHas('brands', $data);
    }
    public function testBrandRelationWithProduct()
    {
        $count = rand(0, 2);
        $brand = Brand::factory()
            ->hasProducts($count)
            ->create();
        // has(Product::factory()->count($count))
        $this->assertCount($count, $brand->products);
        // $this->assertTrue($brand->products->first() instanceof Brand);
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $brand->products);
    }
    // /** @test */
    // public function a_brand_has_many_products()
    // {

    //     $brand = Brand::create([
    //         'brand_name' => 'IranCell',
    //     ]);
    //     // $brand = factory(Brand::class)->create();
    //     $product = Product::create([
    //         'brand_id' => $brand->id,
    //         'product_name' => "charge",
    //         'price' => "10000",
    //     ]);
    //     // $product = factory(Product::class)->create(['brand_id' => $brand->id]);

    //     $this->assertModelExists($product);

    //     // Method 1: A product exists in a brands's product collections.
    //     $this->assertTrue($brand->products->contains($product));


    //     // Method 2: Count that a brand products collection exists.
    //     $this->assertEquals(1, $brand->products->count());

    //     // Method 3: products are related to brands and is a collection instance.
    //     $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $brand->products);
    // }
}
