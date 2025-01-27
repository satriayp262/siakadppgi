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
        Schema::create('jadwal', function (Blueprint $table) {
            $table->id('id_jadwal')->autoIncrement()->primary();
            $table->integer('id_kelas');
            $table->string('nidn');
            $table->string('kode_prodi');
            $table->integer('id_semester');
            $table->date('tanggal')->nullable(); 
            $table->string('jenis_ujian')->nullable();
            $table->string('hari'); // Hari dalam seminggu
            $table->integer('sesi'); // Menyimpan urutan jam ke berapa
            $table->time('jam_mulai'); // Jam mulai
            $table->time('jam_selesai'); // Jam selesai
            $table->string('id_ruangan');
            $table->timestamps();
            $table->foreign('id_kelas')->references('id_kelas')->on('kelas')->onDelete('cascade');
            $table->foreign('kode_prodi')->references('kode_prodi')->on('prodi')->onDelete('cascade');
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
