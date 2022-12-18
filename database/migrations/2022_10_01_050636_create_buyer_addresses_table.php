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
        Schema::create('buyer_addresses', function (Blueprint $table) {
            $table->id();
            $table->integer('admin_id');
            $table->integer('user_id');
            $table->string('name');
            $table->bigInteger('phone');
            $table->string('email')->nullable();
            $table->string('address');
            $table->integer('area_id')->nullable();
            $table->integer('city_id');
            $table->integer('state_id');
            $table->integer('pincode');
            $table->double('lattitude')->nullable();
            $table->double('longitude')->nullable();
            $table->integer('is_default');
            $table->integer('status');
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
        Schema::dropIfExists('buyer_addresses');
    }
};
