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
        Schema::create('buyers', function (Blueprint $table) {
            $table->id();
            $table->integer('admin_id');
            $table->integer('user_id');
            $table->string('name');
            $table->string('company_name');
            $table->bigInteger('phone')->unique();
            $table->string('email')->nullable();
            $table->string('gst_no');
            $table->integer('state_id');
            $table->integer('city_id');
            $table->integer('area_id')->nullable();
            $table->string('address');
            $table->integer('pincode');
            $table->integer('slab_id');
            $table->string('latitute')->nullable();
            $table->string('longitude')->nullable();
            $table->integer('invoice_type');
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
        Schema::dropIfExists('buyers');
    }
};
