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
        Schema::create('matkul', function (Blueprint $table) {
            $table->integer('id_mata_kuliah')->autoIncrement()->primary();
            $table->string('kode_mata_kuliah');
            $table->string('nama_mata_kuliah');
            $table->string(column: 'jenis_mata_kuliah');
            $table->string('kode_prodi')->nullable();
            $table->integer('sks_tatap_muka');
            $table->integer('sks_praktek');
            $table->integer('sks_praktek_lapangan');
            $table->integer('sks_simulasi');
            $table->string('metode_pembelajaran');
            $table->date('tgl_mulai_efektif');
            $table->date('tgl_akhir_efektif');
            $table->timestamps();

            $table->foreign('kode_prodi')->references('kode_prodi')->on('prodi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matkul');
    }
};
