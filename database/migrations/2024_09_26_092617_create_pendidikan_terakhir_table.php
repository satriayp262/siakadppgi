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
        Schema::create('pendidikan_terakhir', function (Blueprint $table) {
            $table->id('id_pendidikan_terakhir')->primary();
            $table->string('nama_pendidikan_terakhir');
            $table->string('kode_pendidikan_terakhir');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendidikan_terakhir');
    }
};
