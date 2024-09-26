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
        Schema::create('kurikulum', function (Blueprint $table) {
            $table->uuid('id_kurikulum')->primary(); // UUID sebagai primary key
            $table->string('nama_kurikulum');
            $table->date('mulai_berlaku'); // Tanggal mulai berlaku kurikulum
            $table->string('kode_mata_kuliah');
            $table->string('kode_prodi'); // Kode program studi
            $table->foreign('kode_prodi')->references('kode_prodi')->on('prodi'); // Menambah foreign key kode_prodi yang merujuk ke kode_prodi pada tabel prodi
            $table->foreign('kode_mata_kuliah')->references('kode_mata_kuliah')->on('matkul')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kurikulum');
    }
};
