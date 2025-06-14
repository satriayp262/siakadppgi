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
        Schema::create('khs', function (Blueprint $table) {
            $table->integer('id_khs')->autoIncrement()->primary();
            $table->string('NIM');
            $table->integer('id_semester');
            $table->integer('id_mata_kuliah');
            $table->integer('id_kelas');
            $table->integer('id_prodi');
            $table->float('bobot');
            $table->enum('publish', ['Yes', 'No'])->default('No');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('khs');
    }
};
