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
        Schema::create('token', function (Blueprint $table) {
            $table->id('id_token')->primary();
            $table->string('token')->unique();
            $table->integer('id_mata_kuliah');
            $table->integer('id_kelas');
            $table->integer('id_semester');
            $table->timestamp('valid_until');
            $table->string('hari');
            $table->string('sesi');
            $table->integer('pertemuan');
            $table->foreignId('id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->foreign('id_mata_kuliah')->references('id_mata_kuliah')->on('matkul')->onDelete('cascade');
            $table->foreign('id_kelas')->references('id_kelas')->on('kelas')->onDelete('cascade');
            $table->foreign('id_semester')->references('id_semester')->on('semester')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('token');
    }
};
