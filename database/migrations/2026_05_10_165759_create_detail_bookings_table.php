<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::create('detail_bookings', function (Blueprint $table) {
        $table->id();
        $table->foreignId('booking_id')
              ->constrained('bookings')
              ->cascadeOnDelete();
        $table->foreignId('fasilitas_id')
              ->constrained('fasilitas')
              ->cascadeOnDelete();
        $table->date('tanggal');
        $table->time('jam_mulai');
        $table->time('jam_selesai');
        $table->decimal('durasi_jam', 4, 1); // contoh: 2.5 jam
        $table->decimal('subtotal', 10, 2);
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('detail_bookings');
    }
};