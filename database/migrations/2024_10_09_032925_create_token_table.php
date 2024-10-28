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
        Schema::create('token', function (Blueprint $table) {
            $table->id('id_token')->primary();
            $table->string('token')->unique();
            $table->integer('id_mata_kuliah');
            $table->timestamp('valid_until');
            $table->foreignId('id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->foreign('id_mata_kuliah')->references('id_mata_kuliah')->on('matkul')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('token');
    }
};
