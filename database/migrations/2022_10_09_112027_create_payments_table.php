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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('Balance')->default(0)->nullable();
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('type')->default(0)->comment('0 => online, 1 => wallet');
            $table->string('paymentable_id');
            $table->string('paymentable_type');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('to_pubkey')->nullable();
            $table->string('txid')->nullable();
            $table->string('nickname')->nullable();
            $table->string('from_pubkey')->nullable();
            $table->string('txtime')->nullable();
            $table->string('fee')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
