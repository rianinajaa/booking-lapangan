<?php

namespace Database\Seeders;

use App\Models\Fasilitas;
use Illuminate\Database\Seeder;

class FasilitasSeeder extends Seeder
{
    public function run(): void
    {
        $fasilitas = [
            // ── Lapangan Olahraga ──
            [
                'nama'         => 'Lapangan Futsal Indoor',
                'jenis'        => 'lapangan',
                'deskripsi'    => 'Lapangan futsal indoor dengan lantai vinyl, kapasitas 10 orang.',
                'harga_per_jam'=> 100000,
                'status'       => 'aktif',
            ],
            [
                'nama'         => 'Lapangan Basket',
                'jenis'        => 'lapangan',
                'deskripsi'    => 'Lapangan basket outdoor dengan ring standar.',
                'harga_per_jam'=> 75000,
                'status'       => 'aktif',
            ],
            [
                'nama'         => 'Lapangan Voli',
                'jenis'        => 'lapangan',
                'deskripsi'    => 'Lapangan voli outdoor dengan net standar.',
                'harga_per_jam'=> 60000,
                'status'       => 'aktif',
            ],

            // ── Lab Akademik ──
            [
                'nama'         => 'Lab Komputer',
                'jenis'        => 'lab',
                'deskripsi'    => 'Lab komputer dengan 30 unit PC, AC, dan koneksi internet.',
                'harga_per_jam'=> 50000,
                'status'       => 'aktif',
            ],
            [
                'nama'         => 'Lab Bahasa',
                'jenis'        => 'lab',
                'deskripsi'    => 'Lab bahasa dilengkapi headset dan software pembelajaran.',
                'harga_per_jam'=> 45000,
                'status'       => 'aktif',
            ],

            // ── Ruang Multimedia & Event ──
            [
                'nama'         => 'Ruang Multimedia',
                'jenis'        => 'ruang_multimedia',
                'deskripsi'    => 'Ruang multimedia dengan proyektor, sound system, dan AC.',
                'harga_per_jam'=> 80000,
                'status'       => 'aktif',
            ],
            [
                'nama'         => 'Aula Sekolah',
                'jenis'        => 'ruang_multimedia',
                'deskripsi'    => 'Aula besar kapasitas 300 orang, cocok untuk acara dan event.',
                'harga_per_jam'=> 200000,
                'status'       => 'aktif',
            ],
        ];

        foreach ($fasilitas as $item) {
            Fasilitas::create($item);
        }
    }
}