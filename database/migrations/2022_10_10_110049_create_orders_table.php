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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('payment_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->longText('product_object')->nullable();
            $table->tinyInteger('payment_type')->default(0);
            $table->tinyInteger('payment_status')->default(0);
            $table->string('mobile_no')->nullable();
            $table->decimal('order_final_amount', 20, 3)->nullable();
            $table->decimal('order_discount_amount', 20, 3)->nullable();
            $table->string('transaction')->nullable();
            $table->tinyInteger('order_status')->default(0)->comment('0 => Not checked, 1 => Awaiting confirmation, 2 => NotConfirmed, 3 => confirmed, 4 => invalid , 5 => refund ')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')
                ->references('id')->on('users')->onDelete('cascade');
            $table->foreign('payment_id')
                ->references('id')->on('payments')->onDelete('cascade');
            $table->foreign('product_id')
                ->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
