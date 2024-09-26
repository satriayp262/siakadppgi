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
        Schema::create('kelas', function (Blueprint $table) {
            $table->uuid('kode_kelas')->primary();
            $table->string('nama_kelas');
            $table->string('lingkup_kelas');
            $table->string('kode_prodi');
            $table->string('kode_mata_kuliah');
            $table->timestamps();
            $table->foreign('kode_prodi')->references('kode_prodi')->on('prodi')->onDelete('cascade');
            $table->foreign('kode_mata_kuliah')->references('kode_mata_kuliah')->on('matkul')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
