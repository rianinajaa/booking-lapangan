<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('fasilitas', function (Blueprint $table) {
        $table->id(); // Primary Key (ID otomatis)
        $table->string('nama'); // Kolom teks untuk nama
        $table->enum('jenis', ['lapangan', 'lab', 'ruang_multimedia']); // Pilihan kategori
        $table->decimal('harga_per_jam', 10, 2); // Kolom angka desimal untuk harga
        $table->integer('kapasitas')->nullable(); // Kolom angka untuk kapasitas (boleh kosong)
        $table->text('deskripsi')->nullable(); // Kolom teks panjang
        $table->string('foto')->nullable(); // Kolom untuk menyimpan nama file foto
        $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
        $table->timestamps(); // Otomatis membuat kolom created_at & updated_at
    });
}

    public function down(): void
    {
        Schema::dropIfExists('fasilitas');
    }
};
