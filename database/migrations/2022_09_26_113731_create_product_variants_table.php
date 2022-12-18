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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->integer('admin_id');
            $table->integer('product_id');
            $table->string('type');
            $table->integer('measurement');
            $table->integer('measurement_unit_id');
            $table->integer('weight')->nullable();
            $table->string('price');
            $table->integer('discounted_price')->nullable();
            $table->integer('price1')->nullable();
            $table->integer('discounted_price1')->nullable();
            $table->integer('min_qty');
            $table->string('serve_for');
            $table->integer('stock');
            $table->integer('stock_unit_id')->nullable();
            $table->integer('barcode_data')->nullable();
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
        Schema::dropIfExists('product_variants');
    }
};
