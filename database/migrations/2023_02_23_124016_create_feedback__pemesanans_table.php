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
        Schema::create('feedback_pemesanan', function (Blueprint $table) {
            $table->integer('id_feedback')->foreign('id_feedback')->references('id')->on('feedback');
            $table->integer('id_pemesanan')->foreign('id_pemesanan')->references('id')->on('pemesanan');
            $table->string('username');
            $table->timestamp('tanggal');
            $table->primary(['id_feedback', 'id_pemesanan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback_pemesanan');
    }
};
