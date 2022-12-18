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
            $table->integer('admin_id');
            $table->string('name');
            $table->integer('category_id');
            $table->integer('sub_category_id');
            $table->integer('brand_id');
            $table->integer('indicator')->nullable();
            $table->string('pimage');
            $table->string('gimage')->nullable();
            $table->string('description');
            $table->integer('sgst')->nullable();
            $table->integer('cgst')->nullable();
            $table->integer('igst')->nullable();
            $table->integer('min_stock');
            $table->string('hsn_code')->nullable();
            $table->integer('min_stock_notified')->nullable();
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
        Schema::dropIfExists('products');
    }
};
