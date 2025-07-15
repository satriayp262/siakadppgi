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
        Schema::table('emonev', function (Blueprint $table) {
            $table->string('nama_periode', 20);
            $table->foreign('nama_periode')->references('nama_periode')->on('periode_emonev')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('emonev', function (Blueprint $table) {
            //
        });
    }
};
