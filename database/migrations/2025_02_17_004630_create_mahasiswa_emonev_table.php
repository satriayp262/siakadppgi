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
        Schema::create('mahasiswa_emonev', function (Blueprint $table) {
            $table->integer('id_mahasiswa_emonev')->primary()->autoIncrement();
            $table->string('NIM');
            $table->integer('id_semester');
            $table->integer('id_mata_kuliah');
            $table->string('nidn');
            $table->integer('sesi');
            $table->foreign('id_mata_kuliah')->references('id_mata_kuliah')->on('matkul');
            $table->foreign('nidn')->references('nidn')->on('dosen');
            $table->foreign('NIM')->references('NIM')->on('mahasiswa');
            $table->foreign('id_semester')->references('id_semester')->on('semester');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswa_emonev');
    }
};
