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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->uuid('id_transaksi')->primary();
            $table->string('NIM');
            $table->integer('nominal'); //Nominal bayar bukan total tagihan
            $table->string('snap_token')->nullable();
            $table->string('id_tagihan');
            $table->string('order_id')->unique();
            $table->string('status')->default('pending');
            $table->string('va_number')->nullable();
            $table->string('bank')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('tanggal_transaksi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
