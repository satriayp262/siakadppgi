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
        Schema::create('kelas', function (Blueprint $table) {
            $table->integer('id_kelas')->primary()->autoIncrement();
            $table->string('nama_kelas');
            $table->string('kode_prodi');
            $table->integer('id_semester');
            $table->string('bahasan')->nullable();
            $table->string('mode_kuliah', 1)->nullable();
            $table->string('lingkup_kelas', 1)->nullable();
            $table->integer('tugas')->default(40);
            $table->integer('uts')->default(30);
            $table->integer('uas')->default(30);
            $table->integer('lainnya')->nullable();
            $table->timestamps();
            $table->foreign('kode_prodi')->references('kode_prodi')->on('prodi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
