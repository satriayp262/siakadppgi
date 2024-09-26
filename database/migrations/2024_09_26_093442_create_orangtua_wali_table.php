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
        Schema::create('orangtua_wali', function (Blueprint $table) {
            $table->uuid('id_orangtua_wali')->primary();  // UUID sebagai primary key
            $table->string('nama_ayah');
            $table->string('NIK_ayah');
            $table->string('no_telp_ayah');
            $table->string('pendidikan_ayah');
            $table->string('pekerjaan_ayah');
            $table->integer('penghasilan_ayah');

            $table->string('nama_ibu');
            $table->string('NIK_ibu');
            $table->string('no_telp_ibu');
            $table->string('pekerjaan_ibu');
            $table->string('pendidikan_ibu');
            $table->integer('penghasilan_ibu');

            // Field wali yang nullable
            $table->string('nama_wali')->nullable();
            $table->string('NIK_wali')->nullable();
            $table->string('no_telp_wali')->nullable();
            $table->string('pekerjaan_wali')->nullable();
            $table->string('pendidikan_wali')->nullable();
            $table->integer('penghasilan_wali')->nullable();

            $table->foreign('pendidikan_ayah')->references('id_pendidikan_terakhir')->on('pendidikan_terakhir');
            $table->foreign('pendidikan_ibu')->references('id_pendidikan_terakhir')->on('pendidikan_terakhir');
            $table->foreign('pendidikan_wali')->references('id_pendidikan_terakhir')->on('pendidikan_terakhir');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orangtua_wali');
    }
};
