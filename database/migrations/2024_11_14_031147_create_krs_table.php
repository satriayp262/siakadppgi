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
        Schema::create('krs', function (Blueprint $table) {
            $table->id('id_krs')->primary();
            $table->string('NIM');
            $table->integer('id_semester');
            $table->integer('id_mata_kuliah');
            $table->integer('id_kelas');
            $table->integer('id_prodi');
            $table->string('nilai_huruf');
            $table->string('nilai_index');
            $table->string('nilai_angka');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('krs');
    }
};
