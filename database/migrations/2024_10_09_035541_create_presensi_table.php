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
        Schema::create('presensi', function (Blueprint $table) {
            $table->uuid('id_presensi')->primary();
            $table->foreignId('id')->constrained('users'); // Menghubungkan ke tabel users (mahasiswa)
            $table->string('kode_mata_kuliah'); // Menghubungkan ke tabel matkuls
            $table->timestamp('submitted_at'); // Waktu submit
            $table->timestamps(); // Menyimpan created_at dan updated_at
            $table->foreign('kode_mata_kuliah')->references('kode_mata_kuliah')->on('matkul')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensi');
    }
};
