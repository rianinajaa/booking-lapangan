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
        Schema::table('bookings', function (Blueprint $table) {
            // Kita definisikan ulang ENUM-nya dengan menambahkan 'menunggu_verifikasi' ke dalam list
            $table->enum('status_booking', [
                'menunggu',
                'menunggu_verifikasi', // <-- Tambah opsi baru ini
                'dikonfirmasi',
                'dibatalkan',
                'selesai'
            ])->default('menunggu')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Kembalikan ke struktur ENUM asli Anda sebelumnya jika di-rollback
            $table->enum('status_booking', [
                'menunggu',
                'dikonfirmasi',
                'dibatalkan',
                'selesai'
            ])->default('menunggu')->change();
        });
    }
};