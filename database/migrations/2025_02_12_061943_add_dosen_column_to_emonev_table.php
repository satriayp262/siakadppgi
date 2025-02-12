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
        Schema::table('emonev', function (Blueprint $table) {
            $table->integer('id_mata_kuliah');
            $table->string('nidn');
            $table->foreign('id_mata_kuliah')->references('id_mata_kuliah')->on('matakuliah');
            $table->foreign('nidn')->references('nidn')->on('dosen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('emonev', function (Blueprint $table) {
            //
        });
    }
};
