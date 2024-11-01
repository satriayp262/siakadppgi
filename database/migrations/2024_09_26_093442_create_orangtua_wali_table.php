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
            $table->string('nama_ayah')->nullable();
            $table->string('NIK_ayah')->nullable();
            $table->string('tanggal_lahir_ayah')->nullable();
            $table->string('pendidikan_ayah')->nullable();
            $table->string('pekerjaan_ayah')->nullable();
            $table->string('penghasilan_ayah')->nullable();

            $table->string('nama_ibu');
            $table->string('NIK_ibu')->nullable();
            $table->string('tanggal_lahir_ibu')->nullable();
            $table->string('no_telp_ibu')->nullable();
            $table->string('pekerjaan_ibu')->nullable();
            $table->string('pendidikan_ibu')->nullable();
            $table->string('penghasilan_ibu')->nullable();

            // Field wali yang nullable
            $table->string('nama_wali')->nullable();
            $table->string('NIK_wali')->nullable();
            $table->string('tanggal_lahir_wali')->nullable();
            $table->string('pekerjaan_wali')->nullable();
            $table->string('pendidikan_wali')->nullable();
            $table->string('penghasilan_wali')->nullable();
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
