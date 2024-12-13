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
            $table->integer('id_emonev', true)->primary();
            $table->string('nama_evaluasi', 100);
            $table->enum('penilaian', ['6', '7', '8', '9', '10']);
            $table->string('saran');
            $table->integer('id_kelas');
            $table->integer('id_user');
            $table->timestamps();

            $table->foreign('id_kelas')->references('id_kelas')->on('kelas')->onUpdate('CASCADE')->onDelete('CASCADE');
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
