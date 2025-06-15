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
            $table->integer('id_emonev')->primary()->autoIncrement();
            $table->integer('id_mata_kuliah');
            $table->string('nidn');
            $table->string('saran', 50);
            $table->foreign('id_mata_kuliah')->references('id_mata_kuliah')->on('matkul');
            $table->foreign('nidn')->references('nidn')->on('dosen');
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
