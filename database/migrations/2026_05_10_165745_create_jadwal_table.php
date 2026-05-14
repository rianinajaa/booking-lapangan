<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fasilitas_id')
                ->constrained('fasilitas')
                ->cascadeOnDelete();
            $table->time('jam_buka')->default('08:00');
            $table->time('jam_tutup')->default('21:00');
            $table->boolean('is_libur')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal');
    }
};
