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
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->integer('id_kelas')->nullable();
            // $table->foreign('id_kelas')->references('id_kelas')->on('kelas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            //
        });
    }
};
