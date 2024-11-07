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
        Schema::create('kelas', function (Blueprint $table) {
            $table->integer('id_kelas')->primary()->autoIncrement();
            $table->string('kode_kelas')->unique();
            $table->string('nama_kelas', 5);
            $table->string('kode_prodi');
            $table->integer('id_mata_kuliah');
            $table->integer('semester');
            $table->string('bahasan')->nullable();
            $table->string('mode_kuliah')->nullable();
            $table->string('lingkup_kelas');
            $table->timestamps();
            $table->foreign('semester')->references('id_semester')->on('semester')->onDelete('cascade');
            $table->foreign('kode_prodi')->references('kode_prodi')->on('prodi')->onDelete('cascade');
            $table->foreign('id_mata_kuliah')->references('id_mata_kuliah')->on('matkul')->onDelete('cascade');
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
