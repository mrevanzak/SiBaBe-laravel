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
        Schema::create('product_carts', function (Blueprint $table) {
            $table->integer('product_id')->foreign('product_id')->references('id')->on('products');
            $table->integer('cart_id')->foreign('cart_id')->references('id')->on('carts');
            $table->integer('quantity');
            $table->integer('total_price');
            $table->primary(['product_id', 'cart_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_carts');
    }
};
