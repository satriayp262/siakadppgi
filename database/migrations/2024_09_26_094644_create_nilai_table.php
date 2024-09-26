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
        Schema::create('nilai', function (Blueprint $table) {
            $table->uuid('id_nilai')->primary(); // UUID sebagai primary key
            $table->string('NIM'); // NIM mahasiswa
            $table->string('kode_mata_kuliah'); // Kode mata kuliah
            $table->string('id_semester'); // Semester
            $table->string('nilai_huruf'); // Nilai dalam bentuk huruf (A, B, C, dll)
            $table->float('nilai_indeks'); // Nilai indeks
            $table->float('nilai_angka'); // Nilai angka
            $table->float('aktivitas_partisipatif'); // Nilai aktivitas partisipatif
            $table->float('hasil_proyek'); // Nilai hasil proyek
            $table->float('quiz'); // Nilai quiz
            $table->float('tugas'); // Nilai tugas
            $table->float('UTS'); // Nilai UTS
            $table->float('UAS'); // Nilai UAS

            $table->string('kode_prodi'); // Kode prodi mahasiswa
            $table->string('kode_kelas'); // Kode prodi kelas

            $table->foreign('NIM')->references('NIM')->on('mahasiswa')->onDelete('cascade');
            $table->foreign('kode_mata_kuliah')->references('kode_mata_kuliah')->on('matkul')->onDelete('cascade');
            $table->foreign('id_semester')->references('id_semester')->on('semester')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai');
    }
};
