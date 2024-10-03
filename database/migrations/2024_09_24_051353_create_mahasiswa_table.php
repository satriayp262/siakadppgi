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
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->uuid('id_mahasiswa')->primary();
            $table->string('id_orangtua_wali')->nullable();
            // $table->foreignId('id');
            $table->string('NIM')->unique();
            $table->string('nama');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('jenis_kelamin');
            $table->string('NIK')->unique();
            $table->string('agama')->nullable();
            $table->text('alamat')->nullable();
            $table->string('jalur_pendaftaran')->nullable();
            $table->string('kewarganegaraan')->nullable();
            $table->string('jenis_pendaftaran')->nullable();
            $table->date('tanggal_masuk_kuliah')->nullable();
            $table->string('mulai_semester')->nullable();
            $table->string('jenis_tempat_tinggal')->nullable();
            $table->string('telp_rumah')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('email')->nullable();
            $table->string('terima_kps')->nullable();
            $table->string('no_kps')->nullable();
            $table->string('jenis_transportasi')->nullable();
            $table->string('kode_prodi');
            $table->integer('SKS_diakui')->nullable();
            $table->string('kode_pt_asal')->nullable();
            $table->string('nama_pt_asal')->nullable();
            $table->string('kode_prodi_asal')->nullable();
            $table->string('nama_prodi_asal')->nullable();
            $table->string('jenis_pembiayaan')->nullable();
            $table->integer('jumlah_biaya_masuk')->nullable();
            $table->foreignId('id_user')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreign('kode_prodi')->references('kode_prodi')->on('prodi');
            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswa');
    }
};
