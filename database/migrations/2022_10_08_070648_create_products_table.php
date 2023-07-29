<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brand_id');
            $table->string('product_name')->nullable();
            $table->string('product_image')->nullable();
            $table->text('introduction');
            $table->string('price')->nullable();
            $table->tinyInteger('marketable')->default(1)->comment('1 => marketable, 0 => not marketable');
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
            $table->foreign('brand_id')
                ->references('id')->on('brands')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
