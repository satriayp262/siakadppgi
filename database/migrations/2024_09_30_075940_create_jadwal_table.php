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
        Schema::create('jadwal', function (Blueprint $table) {
            $table->uuid('id_jadwal')->autoIncrement()->primary();
            $table->string('nidn');
            $table->string('kode_mata_kuliah');
            $table->string('kode_kelas');
            $table->integer('minggu'); // Menyimpan minggu ke berapa jadwal ini berlaku
            $table->string('hari'); // Hari dalam seminggu
            $table->integer('jam_ke'); // Menyimpan urutan jam ke berapa
            $table->time('jam_mulai'); // Jam mulai
            $table->time('jam_selesai'); // Jam selesai
            $table->timestamps();
            $table->foreign('nidn')->references('nidn')->on('dosen')->onDelete('cascade');
            $table->foreign('kode_mata_kuliah')->references('kode_mata_kuliah')->on('matkul')->onDelete('cascade');
            $table->foreign('kode_kelas')->references('kode_kelas')->on('kelas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal');
    }
};
