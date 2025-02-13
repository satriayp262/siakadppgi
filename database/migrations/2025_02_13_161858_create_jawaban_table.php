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
        Schema::create('jawaban', function (Blueprint $table) {
            $table->integer('id_jawaban')->autoIncrement();
            $table->integer('id_pertanyaan');
            $table->integer('id_emonev');
            $table->string('nilai');
            $table->foreign('id_pertanyaan')->references('id_pertanyaan')->on('pertanyaan');
            $table->foreign('id_emonev')->references('id_emonev')->on('emonev');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban');
    }
};
