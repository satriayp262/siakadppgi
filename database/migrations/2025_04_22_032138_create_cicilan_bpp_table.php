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
            $table->uuid('id_transaksi')->nullable();
            $table->foreign('id_transaksi')->references('id_transaksi')->on('transaksi')->onDelete('cascade');
            $table->integer('id_konfirmasi')->nullable();
            $table->foreign('id_konfirmasi')->references('id_konfirmasi')->on('konfirmasi')->onDelete('cascade');
            $table->string('metode_pembayaran');
            $table->string('bulan');
            $table->integer('jumlah_bayar');
            $table->string('tanggal_bayar');
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
