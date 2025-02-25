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
        Schema::create('bobot', function (Blueprint $table) {
            $table->integer('id_bobot')->autoIncrement();
            $table->integer('id_kelas');
            $table->integer('id_mata_kuliah');
            $table->integer('tugas')->default(20);
            $table->integer('uts')->default(30);
            $table->integer('uas')->default(40);
            $table->integer('partisipasi')->default(10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bobot');
    }
};
