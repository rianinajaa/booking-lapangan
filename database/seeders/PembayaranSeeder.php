<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Pembayaran;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PembayaranSeeder extends Seeder
{
    public function run(): void
    {
        $bookings = Booking::with('detailBooking')->get();

        if ($bookings->isEmpty()) {
            $this->command->warn('Jalankan BookingSeeder terlebih dahulu!');
            return;
        }

        foreach ($bookings as $booking) {
            // Skip kalau sudah ada pembayaran
            if ($booking->pembayaran) continue;

            $totalTagihan = $booking->total_harga;

            switch ($booking->status_booking) {

                // Booking selesai → lunas penuh
                case 'selesai':
                    Pembayaran::create([
                        'booking_id'       => $booking->id,
                        'metode'           => 'transfer',
                        'nominal_dp'       => $totalTagihan * 0.5,
                        'nominal_lunas'    => $totalTagihan * 0.5,
                        'total_tagihan'    => $totalTagihan,
                        'status_bayar'     => 'lunas',
                        'waktu_dp'         => Carbon::now()->subDays(3),
                        'waktu_lunas'      => Carbon::now()->subDays(1),
                    ]);
                    break;

                // Booking dikonfirmasi → sudah bayar DP, belum lunas
                case 'dikonfirmasi':
                    Pembayaran::create([
                        'booking_id'       => $booking->id,
                        'metode'           => 'transfer',
                        'nominal_dp'       => $totalTagihan * 0.5,
                        'nominal_lunas'    => 0,
                        'total_tagihan'    => $totalTagihan,
                        'status_bayar'     => 'dp',
                        'waktu_dp'         => Carbon::now()->subDays(1),
                        'waktu_lunas'      => null,
                    ]);
                    break;

                // Booking menunggu / dibatalkan → belum bayar
                case 'menunggu':
                case 'dibatalkan':
                default:
                    Pembayaran::create([
                        'booking_id'       => $booking->id,
                        'metode'           => 'transfer',
                        'nominal_dp'       => 0,
                        'nominal_lunas'    => 0,
                        'total_tagihan'    => $totalTagihan,
                        'status_bayar'     => 'belum_bayar',
                        'waktu_dp'         => null,
                        'waktu_lunas'      => null,
                    ]);
                    break;
            }
        }

        $this->command->info('PembayaranSeeder selesai: ' . $bookings->count() . ' data pembayaran dibuat.');
    }
}