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
        Schema::table('berita_acara', function (Blueprint $table) {
            $table->string(column: 'token');
            $table->foreign('token')->references('token')->on('token')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('berita_acaras', function (Blueprint $table) {
            //
        });
    }
};
