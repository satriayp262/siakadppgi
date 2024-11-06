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
        Schema::create('kurikulum', function (Blueprint $table) {
            $table->integer('id_kurikulum')->primary()->autoIncrement();
            $table->string('nama_kurikulum');
            $table->integer('mulai_berlaku');
            $table->integer('jumlah_sks_lulus');
            $table->integer('jumlah_sks_wajib');
            $table->integer('jumlah_sks_pilihan');
            $table->foreign('mulai_berlaku')->references('id_semester')->on('semester');
            $table->string('kode_prodi'); // Kode program studi
            $table->foreign('kode_prodi')->references('kode_prodi')->on('prodi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kurikulum');
    }
};
