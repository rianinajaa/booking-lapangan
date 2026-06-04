<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\DetailBooking;
use App\Models\Fasilitas;
use App\Models\Pembayaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class UserBookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['detailBooking.fasilitas', 'pembayaran'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('user.booking-index', compact('bookings'));
    }

    public function create(Request $request)
    {
        $fasilitas = Fasilitas::with('jadwal')
            ->where('status', 'aktif')
            ->orderBy('nama')
            ->get();

        return view('user.booking-create', compact('fasilitas'));
    }

    public function store(Request $request)
    {
        // Validasi dasar
        $request->validate([
            'fasilitas_id' => 'required|exists:fasilitas,id',
            'tanggal' => 'required|date|after_or_equal:today',
            'jam_mulai' => 'required',
            'durasi_jam' => 'required|integer|min:1|max:8',
            'metode_bayar' => 'required|in:transfer,cash',
        ]);

        // Validasi tambahan untuk transfer
        if ($request->metode_bayar === 'transfer') {
            $request->validate([
                'jenis_pembayaran' => 'required|in:full,dp',
                'bank_tujuan_final' => 'required|string',
                'bukti_pembayaran' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            ]);
        }

        $fasilitas = Fasilitas::findOrFail($request->fasilitas_id);
        $user = Auth::user();
        $durasi = (int) $request->durasi_jam;
        $jamMulai = Carbon::parse($request->jam_mulai);
        $jamSelesai = $jamMulai->copy()->addHours($durasi);

        // Hitung harga + diskon
        $isGuru = $user->role === 'guru';
        $subtotal = $isGuru ? 0 : $fasilitas->harga_per_jam * $durasi;
        $diskonPersen = 0;

        if ($user->role === 'siswa_internal' && ! $isGuru) {
            $tanggal = Carbon::parse($request->tanggal);
            $jam = $jamMulai->hour;
            if ($tanggal->isWeekday() && $jam >= 8 && $jam < 15) {
                $diskonPersen = 20;
            }
        }

        $totalDiskon = $subtotal * ($diskonPersen / 100);
        $totalHarga = $subtotal - $totalDiskon;

        // Upload bukti jika transfer
        $buktiPath = null;
        if ($request->metode_bayar === 'transfer' && $request->hasFile('bukti_pembayaran')) {
            $buktiPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
        }

        DB::beginTransaction();
        try {
            // Buat booking
            $booking = Booking::create([
                'kode_booking' => 'BK-'.date('Ymd').'-'.strtoupper(Str::random(4)),
                'user_id' => $user->id,
                'diskon_persen' => $isGuru ? 100 : $diskonPersen,
                'total_diskon' => $isGuru ? $fasilitas->harga_per_jam * $durasi : $totalDiskon,
                'total_harga' => $totalHarga,
                'status_booking' => $isGuru ? 'dikonfirmasi' : ($request->metode_bayar === 'transfer' ? 'menunggu_verifikasi' : 'menunggu'),
                'role_booker' => $user->role,
            ]);

            // Buat detail booking
            DetailBooking::create([
                'booking_id' => $booking->id,
                'fasilitas_id' => $fasilitas->id,
                'tanggal' => $request->tanggal,
                'jam_mulai' => $jamMulai->format('H:i:s'),
                'jam_selesai' => $jamSelesai->format('H:i:s'),
                'durasi_jam' => $durasi,
                'subtotal' => $totalHarga,
            ]);

            // Siapkan data pembayaran
            $pembayaranData = [
                'booking_id' => $booking->id,
                'metode' => $isGuru ? 'cash' : $request->metode_bayar,
                'nominal_dp' => 0,
                'nominal_lunas' => 0,
                'total_tagihan' => $totalHarga,
                'status_bayar' => 'belum_bayar',
                'waktu_lunas' => null,
            ];

            // Jika transfer, tambahkan data tambahan
            if ($request->metode_bayar === 'transfer') {
                $jenisBayar = $request->jenis_pembayaran;
                $pembayaranData['bank_tujuan'] = $request->bank_tujuan_final;

                if ($jenisBayar === 'dp') {
                    $pembayaranData['nominal_dp'] = $totalHarga / 2;
                    $pembayaranData['bukti_dp'] = $buktiPath;
                    $pembayaranData['waktu_dp'] = now();
                    $pembayaranData['status_bayar'] = 'menunggu_verifikasi_dp';
                } else {
                    $pembayaranData['bukti_lunas'] = $buktiPath;
                    $pembayaranData['waktu_lunas'] = now();
                    $pembayaranData['status_bayar'] = 'menunggu_verifikasi';
                }
            }

            Pembayaran::create($pembayaranData);

           DB::commit();

            if ($isGuru) {
                $msg = 'Booking berhasil! Fasilitas langsung terkonfirmasi.';
            } elseif ($request->metode_bayar === 'cash') {
                $msg = 'Booking berhasil diajukan! Menunggu konfirmasi admin.';
            } else {
                $msg = 'Booking berhasil! Bukti pembayaran sudah diupload. Menunggu verifikasi admin.';
            }

            // UBAH DI SINI: Kembalikan JSON agar bisa dibaca oleh Fetch
            return response()->json([
                'success' => true,
                'message' => $msg,
                'redirect' => route('user.booking.index')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            // Hapus file yang terlanjur diupload jika database error
            if ($buktiPath && Storage::disk('public')->exists($buktiPath)) {
                Storage::disk('public')->delete($buktiPath);
            }

            // UBAH DI SINI: Kembalikan JSON error
            return response()->json([
                'success' => false,
                'error' => 'Error: '.$e->getMessage().' on line '.$e->getLine()
            ], 500);
        }
    }

    public function show(Booking $booking)
    {
        // Pastikan hanya pemilik yang bisa lihat
        abort_if($booking->user_id !== Auth::id(), 403);

        $booking->load(['detailBooking.fasilitas', 'pembayaran']);

        return view('user.booking-show', compact('booking'));
    }

    /**
     * Upload bukti pembayaran (untuk booking yang sudah ada)
     */
    public function uploadBukti(Request $request, Booking $booking)
    {
        // Pastikan milik user yang login
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'jenis_bukti' => 'required|in:dp,lunas',
            'bukti' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $pembayaran = $booking->pembayaran;

        if (! $pembayaran) {
            return back()->with('error', 'Data pembayaran tidak ditemukan.');
        }

        $path = $request->file('bukti')->store('bukti_pembayaran', 'public');

        if ($request->jenis_bukti === 'dp') {
            $pembayaran->update([
                'bukti_dp' => $path,
                'waktu_dp' => now(),
                'status_bayar' => 'menunggu_verifikasi_dp',
            ]);
            $booking->update(['status_booking' => 'menunggu_verifikasi_dp']);
            $msg = 'Bukti DP berhasil diupload! Menunggu verifikasi admin.';
        } else {
            $pembayaran->update([
                'bukti_lunas' => $path,
                'waktu_lunas' => now(),
                'status_bayar' => 'menunggu_verifikasi_lunas',
            ]);
            $booking->update(['status_booking' => 'menunggu_verifikasi_lunas']);
            $msg = 'Bukti pelunasan berhasil diupload! Menunggu verifikasi admin.';
        }

        return redirect()->back()->with('success', $msg);
    }

    /**
     * AJAX: return slot jam tersedia untuk fasilitas + tanggal tertentu
     */
    public function slots(Fasilitas $fasilitas, Request $request)
    {
        $tanggal = $request->tanggal ?? date('Y-m-d');
        $jadwal = $fasilitas->jadwal;

        if (! $jadwal || $jadwal->is_libur) {
            return response()->json(['libur' => true, 'slots' => []]);
        }

        $jamBuka = Carbon::parse($jadwal->jam_buka);
        $jamTutup = Carbon::parse($jadwal->jam_tutup);

        $slots = [];
        $current = $jamBuka->copy();
        while ($current->lt($jamTutup)) {
            $slots[] = $current->format('H:i');
            $current->addHour();
        }

        $bookedRanges = DetailBooking::where('fasilitas_id', $fasilitas->id)
            ->where('tanggal', $tanggal)
            ->whereHas('booking', fn ($q) => $q->whereNotIn('status_booking', ['dibatalkan'])
            )
            ->get(['jam_mulai', 'jam_selesai']);

        $unavailable = [];
        foreach ($bookedRanges as $b) {
            $cur = Carbon::parse($b->jam_mulai);
            $end = Carbon::parse($b->jam_selesai);
            while ($cur->lt($end)) {
                $unavailable[] = $cur->format('H:i');
                $cur->addHour();
            }
        }

        return response()->json([
            'libur' => false,
            'slots' => array_map(fn ($jam) => [
                'jam' => $jam,
                'available' => ! in_array($jam, $unavailable),
            ], $slots),
        ]);
    }

    /**
     * Batalkan booking
     */
    public function cancel(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        if (in_array($booking->status_booking, ['menunggu', 'menunggu_pembayaran', 'menunggu_verifikasi', 'menunggu_verifikasi_dp'])) {
            DB::beginTransaction();
            try {
                $booking->update(['status_booking' => 'dibatalkan']);

                if ($booking->pembayaran) {
                    $booking->pembayaran->update(['status_bayar' => 'dibatalkan']);
                }

                DB::commit();

                return redirect()->back()->with('success', 'Booking berhasil dibatalkan.');
            } catch (\Exception $e) {
                DB::rollBack();

                return redirect()->back()->with('error', 'Gagal membatalkan booking.');
            }
        }

        return redirect()->back()->with('error', 'Booking tidak dapat dibatalkan.');
    }
}
