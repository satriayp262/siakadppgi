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
        Schema::create('paket_krs', function (Blueprint $table) {
            $table->integer('id_paket_krs', true);
            $table->integer('id_semester');
            $table->integer('id_prodi');
            $table->integer('id_mata_kuliah');
            $table->integer('id_kelas');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paket_krs');
    }
};
