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
    |--------------------------------------------------------------------------
    | CARD STATISTIK
    |--------------------------------------------------------------------------
    | SEKARANG AMAN COK: Duit otomatis nambah kalau status_booking sudah 'selesai'
    */
    $totalPendapatan = Pembayaran::whereHas('booking', function ($query) {
            $query->where('status_booking', 'selesai');
        })->sum('total_tagihan') ?? 0;

    // Jika relasi model lu kebalik atau total_harga ada di table bookings, pake query alternatif ini:
    // $totalPendapatan = Booking::where('status_booking', 'selesai')->sum('total_harga') ?? 0;

    $totalBooking = Booking::count() ?? 0;

    $totalUsers = User::whereNotIn('role', ['admin'])
        ->count() ?? 0;

    $pendingPembayaran = Pembayaran::whereIn('status_bayar', ['pending', 'dp'])
        ->count() ?? 0;

    /*
    |--------------------------------------------------------------------------
    | BOOKING TERBARU (FIX EAGER LOADING RELASI DETAIL)
    |--------------------------------------------------------------------------
    */
    $recentBookings = Booking::with([
            'user',
            'detailBooking.fasilitas'
        ])
        ->latest()
        ->take(5)
        ->get();

    /*
    |--------------------------------------------------------------------------
    | DATA FASILITAS
    |--------------------------------------------------------------------------
    */
    $fasilitas = Fasilitas::all();

    /*
    |--------------------------------------------------------------------------
    | CHART BOOKING 7 HARI TERAKHIR
    |--------------------------------------------------------------------------
    */
    $bookingChart = [];
    for ($i = 6; $i >= 0; $i--) {
        $dateObject = Carbon::now()->subDays($i);
        $dateString = $dateObject->format('Y-m-d');

        $bookingChart[] = [
            'tanggal' => $dateObject->translatedFormat('d M'),
            'total'   => Booking::whereDate('created_at', $dateString)->count()
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | CHART PENDAPATAN 7 HARI TERAKHIR
    |--------------------------------------------------------------------------
    */
    $incomeChart = [];
    for ($i = 6; $i >= 0; $i--) {
        $dateObject = Carbon::now()->subDays($i);
        $dateString = $dateObject->format('Y-m-d');

        $incomeChart[] = [
            'tanggal' => $dateObject->translatedFormat('d M'),
            'total'   => Pembayaran::whereHas('booking', function ($query) {
                    $query->where('status_booking', 'selesai');
                })
                ->whereDate('created_at', $dateString)
                ->sum('total_tagihan') ?? 0
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | DONUT CHART DISTRIBUSI FASILITAS
    |--------------------------------------------------------------------------
    */
    $facilityChart = Fasilitas::select(
            'jenis',
            DB::raw('COUNT(*) as total')
        )
        ->groupBy('jenis')
        ->get();

    /*
    |--------------------------------------------------------------------------
    | PERSENTASE GROWTH BULANAN (BOOKING)
    |--------------------------------------------------------------------------
    */
    $bookingBulanIni = Booking::whereMonth('created_at', now()->month)
        ->whereYear('created_at', now()->year)
        ->count();

    $bookingBulanLalu = Booking::whereMonth('created_at', now()->subMonth()->month)
        ->whereYear('created_at', now()->subMonth()->year)
        ->count();

    $persenBooking = 0;
    if ($bookingBulanLalu > 0) {
        $persenBooking = (($bookingBulanIni - $bookingBulanLalu) / $bookingBulanLalu) * 100;
    } elseif ($bookingBulanIni > 0) {
        $persenBooking = 100;
    }

    /*
    |--------------------------------------------------------------------------
    | PERSENTASE GROWTH BULANAN (PENDAPATAN)
    |--------------------------------------------------------------------------
    */
    $pendapatanBulanIni = Pembayaran::whereHas('booking', function ($query) {
            $query->where('status_booking', 'selesai');
        })
        ->whereMonth('created_at', now()->month)
        ->whereYear('created_at', now()->year)
        ->sum('total_tagihan') ?? 0;

    $pendapatanBulanLalu = Pembayaran::whereHas('booking', function ($query) {
            $query->where('status_booking', 'selesai');
        })
        ->whereMonth('created_at', now()->subMonth()->month)
        ->whereYear('created_at', now()->subMonth()->year)
        ->sum('total_tagihan') ?? 0;

    $persenPendapatan = 0;
    if ($pendapatanBulanLalu > 0) {
        $persenPendapatan = (($pendapatanBulanIni - $pendapatanBulanLalu) / $pendapatanBulanLalu) * 100;
    } elseif ($pendapatanBulanIni > 0) {
        $persenPendapatan = 100;
    }

    /*
    |--------------------------------------------------------------------------
    | OKUPANSI FASILITAS
    |--------------------------------------------------------------------------
    */
    $totalFasilitas = Fasilitas::count();
    $fasilitasAktif = Booking::whereIn('status_booking', ['aktif', 'dikonfirmasi'])->count();

    $okupansi = 0;
    if ($totalFasilitas > 0) {
        $okupansi = ($fasilitasAktif / $totalFasilitas) * 100;
    }

    /*
    |--------------------------------------------------------------------------
    | RETURN VIEW (Variabel utuh, ga ada yang dibuang biar ga ngerusak blade lu)
    |--------------------------------------------------------------------------
    */
    return view('admin.dashboard', compact(
        'totalPendapatan',
        'totalBooking',
        'totalUsers',
        'pendingPembayaran',
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
};
