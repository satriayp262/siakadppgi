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
        Schema::create('konfirmasi', function (Blueprint $table) {
            $table->integer('id_konfirmasi')->autoIncrement();
            $table->integer('id_tagihan');
            $table->string('tanggal_pembayaran');
            $table->string('jumlah_pembayaran');
            $table->string('bukti_pembayaran');
            $table->string('status')->default('Menunggu Konfirmasi');
            $table->string('bulan')->nullable();
            $table->foreign('id_tagihan')->references('id_tagihan')->on('tagihan')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konfirmasi');
    }
};
