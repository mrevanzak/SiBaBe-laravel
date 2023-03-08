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
        Schema::create('feedback__orders', function (Blueprint $table) {
            $table->integer('order_id');
            $table->integer('feedback_id');
            $table->string('username');
            $table->timestamp('date')->useCurrent();
            $table->primary(['order_id', 'feedback_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback__orders');
    }
};
