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
        Schema::create('tagihan', function (Blueprint $table) {
            $table->integer('id_tagihan')->autoIncrement();
            $table->string('NIM');
            $table->integer('total_tagihan');
            $table->string('status_tagihan');
            $table->integer('id_semester');
            $table->string('bukti_bayar_tagihan')->nullable();
            $table->foreign('NIM')->references('NIM')->on('mahasiswa')->omDelete('cascade');
            $table->foreign('id_semester')->references('id_semester')->on('semester')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihan');
    }
};
