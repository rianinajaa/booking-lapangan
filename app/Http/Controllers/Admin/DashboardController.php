<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Fasilitas;
use App\Models\User;
use App\Models\Pembayaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function admin()
    {
        /*
        |----------------------------------------------------------------------
        | CARD STATISTIK
        |----------------------------------------------------------------------
        */

        // FIX: cukup cek status_bayar = 'lunas' langsung di tabel pembayaran
        $totalPendapatan = Pembayaran::where('status_bayar', 'lunas')
            ->sum('total_tagihan') ?? 0;

        $totalBooking = Booking::count();

        $totalUsers = User::whereNotIn('role', ['admin'])->count();

        // Pembayaran DP yang menunggu verifikasi admin
        $pendingPembayaran = Pembayaran::where('status_bayar', 'dp')->count();

        // Booking baru yang belum diproses admin sama sekali
        $bookingMenunggu = Booking::where('status_booking', 'menunggu')->count();

        /*
        |----------------------------------------------------------------------
        | BOOKING TERBARU
        |----------------------------------------------------------------------
        */
        $recentBookings = Booking::with(['user', 'detailBooking.fasilitas'])
            ->latest()
            ->take(5)
            ->get();

        /*
        |----------------------------------------------------------------------
        | DATA FASILITAS
        |----------------------------------------------------------------------
        */
        $fasilitas = Fasilitas::all();

        /*
        |----------------------------------------------------------------------
        | CHART BOOKING 7 HARI TERAKHIR
        |----------------------------------------------------------------------
        */
        $bookingChart = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $bookingChart[] = [
                'tanggal' => $date->translatedFormat('d M'),
                'total'   => Booking::whereDate('created_at', $date->format('Y-m-d'))->count(),
            ];
        }

        /*
        |----------------------------------------------------------------------
        | CHART PENDAPATAN 7 HARI TERAKHIR
        |----------------------------------------------------------------------
        */
        $incomeChart = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $incomeChart[] = [
                'tanggal' => $date->translatedFormat('d M'),
                // FIX: cukup filter status_bayar = 'lunas' tanpa join booking
                'total'   => Pembayaran::where('status_bayar', 'lunas')
                    ->whereDate('created_at', $date->format('Y-m-d'))
                    ->sum('total_tagihan'),
            ];
        }

        /*
        |----------------------------------------------------------------------
        | DONUT CHART DISTRIBUSI FASILITAS
        |----------------------------------------------------------------------
        */
        $facilityChart = Fasilitas::select('jenis', DB::raw('COUNT(*) as total'))
            ->groupBy('jenis')
            ->get();

        /*
        |----------------------------------------------------------------------
        | PERSENTASE GROWTH BOOKING
        |----------------------------------------------------------------------
        */
        $bookingBulanIni  = Booking::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)->count();

        $bookingBulanLalu = Booking::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)->count();

        $persenBooking = 0;
        if ($bookingBulanLalu > 0) {
            $persenBooking = (($bookingBulanIni - $bookingBulanLalu) / $bookingBulanLalu) * 100;
        } elseif ($bookingBulanIni > 0) {
            $persenBooking = 100;
        }

        /*
        |----------------------------------------------------------------------
        | PERSENTASE GROWTH PENDAPATAN
        |----------------------------------------------------------------------
        */
        // FIX: filter langsung status_bayar = 'lunas'
        $pendapatanBulanIni = Pembayaran::where('status_bayar', 'lunas')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_tagihan');

        $pendapatanBulanLalu = Pembayaran::where('status_bayar', 'lunas')
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->sum('total_tagihan');

        $persenPendapatan = 0;
        if ($pendapatanBulanLalu > 0) {
            $persenPendapatan = (($pendapatanBulanIni - $pendapatanBulanLalu) / $pendapatanBulanLalu) * 100;
        } elseif ($pendapatanBulanIni > 0) {
            $persenPendapatan = 100;
        }

        /*
        |----------------------------------------------------------------------
        | OKUPANSI FASILITAS
        |----------------------------------------------------------------------
        */
        $totalFasilitas = Fasilitas::count();
        $fasilitasAktif = Booking::whereIn('status_booking', ['aktif', 'dikonfirmasi'])->count();

        $okupansi = $totalFasilitas > 0
            ? ($fasilitasAktif / $totalFasilitas) * 100
            : 0;

        /*
        |----------------------------------------------------------------------
        | RETURN VIEW
        |----------------------------------------------------------------------
        */
        return view('admin.dashboard', compact(
            'totalPendapatan',
            'totalBooking',
            'totalUsers',
            'pendingPembayaran',
            'bookingMenunggu',
            'recentBookings',
            'fasilitas',
            'bookingChart',
            'incomeChart',
            'facilityChart',
            'persenBooking',
            'persenPendapatan',
            'okupansi'
        ));
    }
}