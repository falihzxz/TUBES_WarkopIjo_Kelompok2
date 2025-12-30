<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('metode_pembayaran', ['tunai', 'qris'])->default('tunai')->after('status');
            $table->enum('status_pembayaran', ['belum_bayar', 'lunas'])->default('belum_bayar')->after('metode_pembayaran');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['metode_pembayaran', 'status_pembayaran']);
        });
    }
};
