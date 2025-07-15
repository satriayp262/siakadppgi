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
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->integer('id_mahasiswa')->autoIncrement()->primary();
            $table->string('id_orangtua_wali')->nullable();
            // $table->foreignId('id');
            $table->char('NIM', 12)->unique();
            $table->char('NPWP', 20)->nullable();
            $table->string('NISN');
            $table->string('nama', 64);
            $table->string('tempat_lahir', 64);
            $table->date('tanggal_lahir');
            $table->string('jenis_kelamin', 64);
            $table->string('NIK', 64)->unique();
            $table->string('agama', 64)->nullable();
            $table->text('alamat')->nullable();
            $table->string('jalur_pendaftaran', 64)->nullable();
            $table->string('kewarganegaraan', 64)->nullable();
            $table->string('jenis_pendaftaran', 64)->nullable();
            $table->date('tanggal_masuk_kuliah')->nullable();
            $table->integer('mulai_semester')->nullable();
            $table->string('jenis_tempat_tinggal', 64)->nullable();
            $table->string('telp_rumah', 64)->nullable();
            $table->string('no_hp', 64)->nullable();
            $table->string('email', 64)->nullable();
            $table->string('terima_kps', 64)->nullable();
            $table->string('no_kps', 64)->nullable();
            $table->string('jenis_transportasi', 64)->nullable();
            $table->string('kode_prodi', 64);
            $table->integer('SKS_diakui')->nullable();
            $table->string('kode_pt_asal', 64)->nullable();
            $table->string('nama_pt_asal', 64)->nullable();
            $table->string('kode_prodi_asal', 64)->nullable();
            $table->string('nama_prodi_asal', 64)->nullable();
            $table->string('jenis_pembiayaan', 64)->nullable();
            $table->integer('jumlah_biaya_masuk')->nullable();

            // $table->foreignId('id_user')->nullable()->constrained('users')->onDelete('cascade');
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
