<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $pembayarans = Pembayaran::with(['booking.user', 'booking.detailBooking.fasilitas'])
            ->when($request->search, fn($q) =>
                $q->whereHas('booking', fn($q2) =>
                    $q2->where('kode_booking', 'like', '%'.$request->search.'%')
                       ->orWhereHas('user', fn($q3) =>
                            $q3->where('name', 'like', '%'.$request->search.'%')
                       )
                )
            )
            ->when($request->status, fn($q) =>
                $q->where('status_bayar', $request->status)
            )
            ->when($request->metode, fn($q) =>
                $q->where('metode', $request->metode)
            )
            ->latest()
            ->paginate(10);

        // Stat cards
        $totalTagihan  = Pembayaran::sum('total_tagihan');
        $totalLunas    = Pembayaran::where('status_bayar', 'lunas')->sum('total_tagihan');
        $totalDp       = Pembayaran::where('status_bayar', 'dp')->sum('nominal_dp');
        $countPending  = Pembayaran::where('status_bayar', 'dp')->count();
        $countBelum    = Pembayaran::where('status_bayar', 'belum_bayar')->count();

        return view('admin.pembayaran.index', compact(
            'pembayarans',
            'totalTagihan',
            'totalLunas',
            'totalDp',
            'countPending',
            'countBelum'
        ));
    }

    public function verifikasiDp(Pembayaran $pembayaran)
    {
        $pembayaran->update([
            'status_bayar'    => 'dp',
            'waktu_dp'        => now(),
            'verifikator_dp'  => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'DP berhasil diverifikasi.');
    }

    public function verifikasiLunas(Pembayaran $pembayaran)
    {
        $pembayaran->update([
            'status_bayar'      => 'lunas',
            'waktu_lunas'       => now(),
            'verifikator_lunas' => auth()->id(),
        ]);

        // Update status booking jadi selesai
        $pembayaran->booking->update(['status_booking' => 'selesai']);

        return redirect()->back()->with('success', 'Pembayaran lunas berhasil diverifikasi.');
    }
}