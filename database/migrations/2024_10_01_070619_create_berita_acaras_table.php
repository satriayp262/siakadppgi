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
        Schema::create('berita_acara', function (Blueprint $table) {
            $table->uuid('id_berita_acara')->primary();
            $table->date('tanggal');
            $table->string('nidn');
            $table->integer('id_mata_kuliah');
            $table->string('materi');
            $table->integer('jumlah_mahasiswa');
            $table->integer('id_kelas');
            $table->integer('id_semester');
            $table->timestamps();
            $table->foreign('nidn')->references('nidn')->on('dosen')->onDelete('cascade');
            $table->foreign('id_mata_kuliah')->references('id_mata_kuliah')->on('matkul')->onDelete('cascade');
            $table->foreign('id_kelas')->references('id_kelas')->on('kelas')->onDelete('cascade');
            $table->foreign('id_semester')->references('id_semester')->on('semester')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita_acara');
    }
};
