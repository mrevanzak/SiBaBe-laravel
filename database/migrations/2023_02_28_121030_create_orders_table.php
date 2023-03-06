<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('invoice')->unique();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->integer('cart_id')->foreign('cart_id')->references('id')->on('carts');
            $table->string('customer_username')->foreign('customer_username')->references('username')->on('customers');
            $table->integer('total_product');
            $table->integer('total_price');
            $table->string('status');
            $table->string('address');
            $table->string('courier');
            $table->string('payment_proof')->nullable();
            $table->string('validated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
