<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class OrderTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function testorder_database_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('orders', [
                'id', 'user_id', 'payment_id', 'product_id'
            ]),
            1
        );
    }
    #Test if it InsertDat truely
    public function testInsertData()
    {
        $data = Order::factory()->make()->toArray();
        Order::Create($data);
        $this->assertDatabaseHas('orders', $data);
    }


    // public function testShowOrder()
    // {
    //     $user = User::create([
    //         'Name' => 'MMD',
    //         'mobile_no' => '09357898967'
    //     ]);
    //     $brand = Brand::create([
    //         'brand_name' => 'HamraheAval',
    //     ]);
    //     $product = Product::create([
    //         'brand_id' => $brand->id,
    //         'product_name' => "charges",
    //         'price' => "898989",
    //     ]);
    //     $order = Order::create([
    //         'user_id' => $user->id,
    //         'product_id' => $product->id,
    //     ]);

    //     // Method 1: A product exists in a brands's product collections.
    //     $this->assertTrue($order->products->contains($product));

    //     // // Method 2: Count that a brand products collection exists.
    //     // $this->assertEquals(1, $order->products->count());

    //     // // Method 3: products are related to brands and is a collection instance.
    //     // $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $brand->products);
    // }
}
