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
        Schema::create('dosen', function (Blueprint $table) {
            $table->integer('id_dosen')->autoIncrement()->primary();
            $table->foreignId('id');
            $table->string('nama_dosen');
            $table->string('nidn')->unique();
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan'])->default('laki-laki');
            $table->string('jabatan_fungsional');
            $table->string('kepangkatan');
            $table->string('kode_prodi');
            $table->timestamps();
            $table->foreign('kode_prodi')->references('kode_prodi')->on('prodi')->onDelete('cascade');

            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosen');
    }
};
