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
        Schema::create('request_dosen', function (Blueprint $table) {
            $table->id('id_request')->autoIncrement()->primary();
            $table->string('nidn');
            $table->integer('id_mata_kuliah');
            $table->integer('id_kelas');
            $table->string('hari');
            $table->integer('sesi');
            $table->string(column: 'to_hari')->nullable();
            $table->integer('to_sesi')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_dosen');
    }
};
