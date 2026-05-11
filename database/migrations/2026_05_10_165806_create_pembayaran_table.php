<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')
                  ->constrained('bookings')
                  ->cascadeOnDelete();
            $table->enum('metode', ['transfer', 'cash']);
            $table->decimal('nominal_dp', 10, 2)->default(0);
            $table->decimal('nominal_lunas', 10, 2)->default(0);
            $table->decimal('total_tagihan', 10, 2);
            $table->enum('status_bayar', [
                'belum_bayar',
                'dp',
                'lunas'
            ])->default('belum_bayar');
            $table->string('bukti_dp')->nullable();
            $table->string('bukti_lunas')->nullable();
            $table->timestamp('waktu_dp')->nullable();
            $table->timestamp('waktu_lunas')->nullable();
            $table->foreignId('verifikator_dp')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();
            $table->foreignId('verifikator_lunas')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};