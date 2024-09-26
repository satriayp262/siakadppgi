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
        Schema::create('pt_asal', function (Blueprint $table) {
            $table->integer('id_pt_asal')->primary()->autoIncrement();
            $table->string('kode_pt_asal')->unique();
            $table->string('nama_pt_asal');
            $table->string('kode_prodi_asal');
            $table->string('nama_prodi_asal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pt_asal');
    }
};
