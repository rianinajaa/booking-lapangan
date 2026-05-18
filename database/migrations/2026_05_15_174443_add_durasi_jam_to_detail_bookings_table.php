<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detail_bookings', function (Blueprint $table) {
            // Kita tambah kolom durasi_jam setelah jam_selesai
            // Pake nullable() biar aman kalo ada data lama yang kosong
            $table->decimal('durasi_jam', 8, 1)->nullable()->after('jam_selesai');
        });
    }

    public function down(): void
    {
        Schema::table('detail_bookings', function (Blueprint $table) {
            $table->dropColumn('durasi_jam');
        });
    }
};  
