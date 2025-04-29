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
        Schema::create('komponen_kartu_ujian', function (Blueprint $table) {
            $table->id('id_komponen')->primary()->autoIncrement();
            $table->string('jabatan');
            $table->string('nama');
            $table->string('ttd')->nullable();
            $table->date('tanggal_dibuat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komponen_kartu_ujian');
    }
};
