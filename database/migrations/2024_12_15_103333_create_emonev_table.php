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
        Schema::create('emonev', function (Blueprint $table) {
            $table->uuid('id_emonev')->primary();
            $table->enum('Nilai', ['6', '7', '8', '9', '10']);
            $table->integer('id_semester');
            $table->integer('id_pertanyaan');
            $table->string(column: 'NIM');
            $table->foreign('NIM')->references('NIM')->on('mahasiswa');
            $table->foreign('id_semester')->references('id_semester')->on('semester');
            $table->foreign('id_pertanyaan')->references('id_pertanyaan')->on('pertanyaan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emonev');
    }
};
