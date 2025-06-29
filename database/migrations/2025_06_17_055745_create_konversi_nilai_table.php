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
        Schema::create('konversi_nilai', function (Blueprint $table) {
            $table->id('id_konversi_nilai')->autoIncrement()->primary();
            $table->integer('id_krs');
            $table->string('keterangan');
            $table->string('file')->nullable();
            $table->integer('nilai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konversi_nilai');
    }
};
