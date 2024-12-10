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
            $table->id();
            $table->string('nama');
            $table->string('nim');
            $table->integer('id_mata_kuliah');
            $table->integer('id_kelas');
            $table->string('token');
            $table->string('keterangan');
            $table->string('alasan')->nullable();
            $table->timestamp('waktu_submit');
            $table->timestamps();

            $table->foreign('token')->references('token')->on('token')->onDelete('cascade');
            $table->foreign('id_mata_kuliah')->references('id_mata_kuliah')->on('matkul')->onDelete('cascade');
            $table->foreign('id_kelas')->references('id_kelas')->on('kelas')->onDelete('cascade');
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
