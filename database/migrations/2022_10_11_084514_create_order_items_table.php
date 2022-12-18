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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('order_id');
            $table->integer('product_variant_id');
            $table->integer('quantity');
            $table->float('price');
            $table->integer('sgst')->nullable();
            $table->integer('cgst')->nullable();
            $table->integer('igst')->nullable();
            $table->integer('hsn_code')->nullable();
            $table->double('discounted_price')->nullable();
            $table->float('discount')->nullable();
            $table->float('sub_total');
            $table->integer('deliver_by')->nullable();
            $table->string('status');
            $table->string('active_status');
            $table->timestamps();
            $table->integer('admin_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
};
