<?php

namespace Database\Seeders;

use App\Models\Jadwal;
use App\Models\Fasilitas;
use Illuminate\Database\Seeder;

class JadwalSeeder extends Seeder
{
    public function run(): void
    {
        $semuaFasilitas = Fasilitas::all();

        foreach ($semuaFasilitas as $fasilitas) {

            if ($fasilitas->jenis === 'lapangan') {
                // Cek apakah lapangan indoor (futsal) atau outdoor
                if (str_contains(strtolower($fasilitas->nama), 'futsal') || 
                    str_contains(strtolower($fasilitas->nama), 'indoor')) {
                    // Lapangan futsal indoor tutup jam 21:00
                    $jamBuka  = '08:00';
                    $jamTutup = '21:00';
                } else {
                    // Lapangan outdoor (basket, voli) tutup jam 18:00
                    $jamBuka  = '08:00';
                    $jamTutup = '18:00';
                }
            } else {
                // Lab & ruang multimedia tutup jam 17:00
                $jamBuka  = '08:00';
                $jamTutup = '17:00';
            }

            Jadwal::create([
                'fasilitas_id' => $fasilitas->id,
                'jam_buka'     => $jamBuka,
                'jam_tutup'    => $jamTutup,
                'is_libur'     => false,
            ]);
        }
    }
}