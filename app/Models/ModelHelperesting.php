<?php

use App\Models\Brand;

trait ModelHelperTesting
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function testInsertData()
    {
        $data = Brand::factory()->make()->toArray();

        Brand::create($data);

        $this->assertDatabaseHas('brands', $data);
    }
}
