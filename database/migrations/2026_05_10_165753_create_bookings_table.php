<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('kode_booking')->unique();
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();
            $table->integer('diskon_persen')->default(0); // 0 / 30 / 50 / 100
            $table->decimal('total_diskon', 10, 2)->default(0);
            $table->decimal('total_harga', 10, 2);
            $table->enum('status_booking', [
                'menunggu',
                'dikonfirmasi',
                'dibatalkan',
                'selesai'
            ])->default('menunggu');
            $table->enum('role_booker', [
                'guru',
                'siswa_internal',
                'siswa_luar',
                'umum'
            ]);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};