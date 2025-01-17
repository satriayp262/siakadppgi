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
        Schema::create('status_do', function (Blueprint $table) {
            $table->integer('id_status_do', true);
            $table->string('NIM');
            $table->string('jenis_keluar', 1);
            $table->integer('periode_keluar');
            $table->date('tanggal_keluar');
            $table->string('sk_yudisium')->nullable();
            $table->date('tanggal_sk_yudisium')->nullable();
            $table->string('IPK')->nullable();
            $table->string('nomor_ijazah')->nullable();
            $table->string('kode_prodi');
            $table->foreign('NIM')->references('NIM')->on('mahasiswa');
            $table->foreign('kode_prodi')->references('kode_prodi')->on('prodi');
            $table->foreign('periode_keluar')->references('id_semester')->on('semester');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_do');
    }
};
