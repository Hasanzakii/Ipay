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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('City')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('language')->default('EN');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('gender')->default('male');
            $table->string('mobile_no')->nullable();
            $table->boolean('isVerified')->default(false);
            $table->boolean('status')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
