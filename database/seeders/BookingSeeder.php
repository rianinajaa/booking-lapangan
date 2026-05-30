<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\DetailBooking;
use App\Models\User;
use App\Models\Fasilitas;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil user yang bukan admin
        $users     = User::whereNotIn('role', ['admin'])->get();
        $fasilitas = Fasilitas::all();

        if ($users->isEmpty() || $fasilitas->isEmpty()) {
            $this->command->warn('Jalankan AdminSeeder & FasilitasSeeder terlebih dahulu!');
            return;
        }

        $data = [
            // 1. Booking guru — langsung selesai, gratis
            [
                'user_role'      => 'guru',
                'fasilitas_nama' => 'Lab Komputer',
                'tanggal'        => Carbon::today()->addDays(1)->format('Y-m-d'),
                'jam_mulai'      => '08:00',
                'jam_selesai'    => '10:00',
                'status_booking' => 'selesai',
                'diskon_persen'  => 100,
            ],

            // 2. Booking siswa internal — menunggu konfirmasi
            [
                'user_role'      => 'umum',
                'fasilitas_nama' => 'Lapangan Futsal Indoor',
                'tanggal'        => Carbon::today()->addDays(2)->format('Y-m-d'),
                'jam_mulai'      => '09:00',
                'jam_selesai'    => '11:00',
                'status_booking' => 'menunggu',
                'diskon_persen'  => 0,
            ],

            // 3. Booking umum — sudah dikonfirmasi
            [
                'user_role'      => 'umum',
                'fasilitas_nama' => 'Lapangan Basket',
                'tanggal'        => Carbon::today()->addDays(3)->format('Y-m-d'),
                'jam_mulai'      => '13:00',
                'jam_selesai'    => '15:30',
                'status_booking' => 'dikonfirmasi',
                'diskon_persen'  => 0,
            ],

            // 4. Booking umum — sudah selesai
            [
                'user_role'      => 'umum',
                'fasilitas_nama' => 'Ruang Multimedia',
                'tanggal'        => Carbon::today()->subDays(2)->format('Y-m-d'),
                'jam_mulai'      => '10:00',
                'jam_selesai'    => '12:00',
                'status_booking' => 'selesai',
                'diskon_persen'  => 0,
            ],

            // 5. Booking umum — dibatalkan
            [
                'user_role'      => 'umum',
                'fasilitas_nama' => 'Lapangan Voli',
                'tanggal'        => Carbon::today()->addDays(5)->format('Y-m-d'),
                'jam_mulai'      => '16:00',
                'jam_selesai'    => '18:00',
                'status_booking' => 'dibatalkan',
                'diskon_persen'  => 0,
            ],
        ];

        foreach ($data as $index => $item) {
            // Cari user sesuai role, kalau tidak ada pakai user pertama
            $user = $users->firstWhere('role', $item['user_role']) ?? $users->first();

            // Cari fasilitas sesuai nama, kalau tidak ada pakai fasilitas pertama
            $fas = $fasilitas->firstWhere('nama', $item['fasilitas_nama']) ?? $fasilitas->first();

            // Hitung durasi & harga
            $mulai      = Carbon::parse($item['jam_mulai']);
            $selesai    = Carbon::parse($item['jam_selesai']);
            $durasi     = $mulai->diffInMinutes($selesai) / 60;
            $hargaDasar = $fas->harga_per_jam * $durasi;
            $diskon     = $item['diskon_persen'];
            $totalDiskon = $hargaDasar * ($diskon / 100);
            $totalHarga  = $hargaDasar - $totalDiskon;

            // Buat kode booking unik
            $kode = 'BK-' . date('Ymd') . '-' . strtoupper(Str::random(4));

            // Simpan booking
            $booking = Booking::create([
                'kode_booking'   => $kode,
                'user_id'        => $user->id,
                'diskon_persen'  => $diskon,
                'total_diskon'   => $totalDiskon,
                'total_harga'    => $totalHarga,
                'status_booking' => $item['status_booking'],
                'role_booker'    => $user->role,
            ]);

            // Simpan detail booking
            DetailBooking::create([
                'booking_id'   => $booking->id,
                'fasilitas_id' => $fas->id,
                'tanggal'      => $item['tanggal'],
                'jam_mulai'    => $mulai->format('H:i:s'),
                'jam_selesai'  => $selesai->format('H:i:s'),
                'durasi_jam'   => $durasi,
                'subtotal'     => $totalHarga,
            ]);
        }
    }
}