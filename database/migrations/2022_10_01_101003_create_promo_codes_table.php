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
        Schema::create('promo_codes', function (Blueprint $table) {
            $table->id();
            $table->integer('admin_id');
            $table->string('promo_code');
            $table->string('message');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->integer('no_of_users');
            $table->integer('no_of_users_used')->nullable();
            $table->integer('minimum_order_amount');
            $table->integer('discount');
            $table->string('discount_type');
            $table->integer('max_order_amount');
            $table->string('status');
            $table->string('repeat_usage');
            $table->integer('no_of_repeat_usage')->nullable();
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
        Schema::dropIfExists('promo_codes');
    }
};
