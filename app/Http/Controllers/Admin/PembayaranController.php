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
            ->when($request->search, fn ($q) => $q->whereHas('booking', fn ($q2) => $q2->where('kode_booking', 'like', '%'.$request->search.'%')
                ->orWhereHas('user', fn ($q3) => $q3->where('name', 'like', '%'.$request->search.'%')
                )
            )
            )
            ->when($request->status, fn ($q) => $q->where('status_bayar', $request->status)
            )
            ->when($request->metode, fn ($q) => $q->where('metode', $request->metode)
            )
            ->latest()
            ->paginate(10);

        // Stat cards
        $totalTagihan = Pembayaran::sum('total_tagihan');
        $totalLunas = Pembayaran::where('status_bayar', 'lunas')->sum('total_tagihan');
        $totalDp = Pembayaran::where('status_bayar', 'dp')->sum('nominal_dp');
        $countPending = Pembayaran::where('status_bayar', 'menunggu_verifikasi_dp')->count();
        $countBelum = Pembayaran::where('status_bayar', 'belum_bayar')->count();
        $countMenungguLunas = Pembayaran::where('status_bayar', 'menunggu_verifikasi_lunas')->count();

        return view('admin.pembayaran.index', compact(
            'pembayarans',
            'totalTagihan',
            'totalLunas',
            'totalDp',
            'countPending',
            'countBelum',
            'countMenungguLunas'
        ));
    }

    /**
     * Detail pembayaran
     */
    public function show(Pembayaran $pembayaran)
    {
        $pembayaran->load(['booking.user', 'booking.detailBooking.fasilitas']);

        return view('admin.pembayaran.show', compact('pembayaran'));
    }

    public function verifikasiDp($id)
    {
        // 1. Cari data pembayaran berdasarkan ID
        $pembayaran = Pembayaran::findOrFail($id);

        // 2. Update status pembayaran menjadi 'dp' (ini di tabel pembayaran, bukan booking)
        $pembayaran->update([
            'status_bayar' => 'dp',
            // jika ada field lain seperti tgl_verifikasi bisa dimasukkan di sini
        ]);

        // 3. SEPERTI KATA KAMU: Status booking-nya disamakan, langsung 'dikonfirmasi'
        if ($pembayaran->booking) {
            $pembayaran->booking->update([
                'status_booking' => 'dikonfirmasi', // Menggunakan 'dikonfirmasi' yang sudah pasti didukung database
            ]);
        }

        return redirect()->back()->with('success', 'Pembayaran DP berhasil diverifikasi dan booking telah dikonfirmasi!');
    }

    public function verifikasiLunas(Pembayaran $pembayaran)
    {
        // Jika sebelumnya DP, maka update nominal_lunas
        $nominalLunas = $pembayaran->total_tagihan - $pembayaran->nominal_dp;

        $pembayaran->update([
            'nominal_lunas' => $nominalLunas,
            'status_bayar' => 'lunas',
            'waktu_lunas' => now(),
            'verifikator_lunas' => auth()->id(),
        ]);

        // Update status booking jadi dikonfirmasi (bukan selesai, karena belum dipakai)
        $pembayaran->booking->update(['status_booking' => 'dikonfirmasi']);

        return redirect()->back()->with('success', 'Pembayaran lunas berhasil diverifikasi.');
    }

    /**
     * Tolak pembayaran (DP atau Lunas)
     */
    public function tolakPembayaran(Request $request, Pembayaran $pembayaran)
    {
        $request->validate([
            'alasan' => 'required|string|max:255',
        ]);

        $jenis = $request->jenis_tolak ?? 'dp'; // dp atau lunas

        if ($jenis === 'dp') {
            $pembayaran->update([
                'status_bayar' => 'belum_bayar',
                'bukti_dp' => null,
                'waktu_dp' => null,
                'verifikator_dp' => null,
            ]);
            $pembayaran->booking->update(['status_booking' => 'menunggu_pembayaran']);
            $message = 'Bukti DP ditolak. Alasan: '.$request->alasan;
        } else {
            $pembayaran->update([
                'status_bayar' => 'dp', // Kembali ke status DP
                'bukti_lunas' => null,
                'waktu_lunas' => null,
                'verifikator_lunas' => null,
            ]);
            $pembayaran->booking->update(['status_booking' => 'dp']);
            $message = 'Bukti pelunasan ditolak. Alasan: '.$request->alasan;
        }

        return redirect()->back()->with('error', $message);
    }

    /**
     * Hapus pembayaran (jika booking dibatalkan)
     */
    public function destroy(Pembayaran $pembayaran)
    {
        $pembayaran->delete();

        return redirect()->route('admin.pembayaran.index')
            ->with('success', 'Data pembayaran berhasil dihapus.');
    }
}
