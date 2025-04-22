<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cicilan_bpp', function (Blueprint $table) {
            $table->integer('id_cicilan')->autoIncrement()->primary();
            $table->integer('id_tagihan');
            $table->foreign('id_tagihan')->references('id_tagihan')->on('tagihan')->onDelete('cascade');
            $table->string('order_id')->unique();
            $table->foreign('order_id')->references('order_id')->on('transaksi')->onDelete('cascade');
            $table->integer('id_semester');
            $table->foreign('id_semester')->references('id_semester')->on('semester')->onDelete('cascade');
            $table->string('bulan_cicilan');
            $table->integer('cicilan_ke');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cicilan_bpp');
    }
};
