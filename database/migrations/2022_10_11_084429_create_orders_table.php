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
            $table->integer('user_id');
            $table->integer('order_by');
            $table->integer('address_id');
            $table->integer('delivery_boy_id')->nullable();
            $table->float('total');
            $table->float('delivery_charge')->nullable();
            $table->float('tax_amount')->nullable();
            $table->float('tax_percentage')->nullable();
            $table->float('wallet_balance')->nullable();
            $table->float('credit_balance')->nullable();
            $table->float('credit_paid')->nullable();
            $table->float('credit_available')->nullable();
            $table->dateTime('credit_paid_date')->nullable();
            $table->float('discount')->nullable();
            $table->string('promo_code')->nullable();
            $table->float('promo_discount')->nullable();
            $table->float('final_total');
            $table->string('payment_method');
            $table->string('lattitude');
            $table->string('longitude');
            $table->string('delivery_time');
            $table->string('status');
            $table->string('active_status');
            $table->timestamps();
            $table->integer('admin_id');
            $table->integer('invoice_type')->nullable();
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
