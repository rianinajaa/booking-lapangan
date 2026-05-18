<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\DetailBooking;
use App\Models\User;
use App\Models\Fasilitas;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BookingController extends Controller
{
    // 1. Menampilkan Semua Data (Index) - FIX 5 DATA PER HALAMAN
    public function index(Request $request)
    {
        // Tarik semua relasi murni Eloquent (user, detail, dan fasilitas di dalam detail)
        $query = Booking::with(['user', 'detailBooking.fasilitas'])->latest();

        if ($request->search) {
            $query->where('kode_booking', 'like', "%{$request->search}%")
                  ->orWhereHas('user', function($q) use ($request) {
                      $q->where('name', 'like', "%{$request->search}%");
                  });
        }

        if ($request->status) {
            $query->where('status_booking', $request->status);
        }

        // DISINI KUNCINYA JING! Diubah dari 10 jadi 5 sesuai request lu
        $bookings = $query->paginate(5);

        return view('admin.booking.index', compact('bookings'));
    }

    // 2. Menampilkan Form Tambah (Create)
    public function create()
    {
        $users = User::whereNotIn('role', ['admin'])->get();
        $fasilitas = Fasilitas::all();

        return view('admin.booking.create', compact('users', 'fasilitas'));
    }

    // 3. Menyimpan Data Baru (Store)
    public function store(Request $request)
    {
        $request->validate([
            'user_id'       => 'required',
            'fasilitas_id'  => 'required',
            'role_booker'   => 'required',
            'tanggal'       => 'required|date',
            'jam_mulai'     => 'required',
            'jam_selesai'   => 'required',
            'total_harga'   => 'required|numeric',
        ]);

        $kode = 'BK-' . date('Ymd') . '-' . strtoupper(Str::random(4));
        $hargaFinal = $request->total_harga <= 0 ? 150000 : $request->total_harga;

        // Simpan Data Booking
        $booking = Booking::create([
            'kode_booking'   => $kode,
            'user_id'        => $request->user_id,
            'diskon_persen'  => $request->diskon_persen ?? 0,
            'total_diskon'   => 0,
            'total_harga'    => $hargaFinal,
            'status_booking' => 'menunggu',
            'role_booker'    => $request->role_booker,
        ]);

        // Hitung durasi jam
        $mulai = Carbon::parse($request->jam_mulai);
        $selesai = Carbon::parse($request->jam_selesai);
        $durasi = $mulai->diffInMinutes($selesai) / 60;
        if ($durasi <= 0) { $durasi = 1.0; }

        // Simpan Data Detail Booking
        DetailBooking::create([
            'booking_id'   => $booking->id,
            'fasilitas_id' => $request->fasilitas_id,
            'tanggal'      => $request->tanggal,
            'jam_mulai'    => $mulai->format('H:i:s'),
            'jam_selesai'  => $selesai->format('H:i:s'),
            'durasi_jam'   => $durasi,
            'subtotal'     => $hargaFinal,
        ]);

        return redirect()->route('admin.booking.index')->with('success', 'Booking berhasil disimpan!');
    }

    // 4. Menampilkan Form Edit
    public function edit(Booking $booking)
    {
        $users = User::whereNotIn('role', ['admin'])->get();
        $fasilitas = Fasilitas::all();
        $booking->load('detailBooking');

        return view('admin.booking.edit', compact('booking', 'users', 'fasilitas'));
    }

    // 5. Mengupdate Data (Update)
    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'status_booking' => 'required',
            'total_harga'    => 'required|numeric',
        ]);

        $booking->update([
            'status_booking' => $request->status_booking,
            'total_harga'    => $request->total_harga,
            'role_booker'    => $request->role_booker ?? $booking->role_booker,
            'diskon_persen'  => $request->diskon_persen ?? $booking->diskon_persen,
        ]);

        $detail = DetailBooking::where('booking_id', $booking->id)->first();
        if ($detail) {
            $mulai = $request->jam_mulai ? Carbon::parse($request->jam_mulai) : Carbon::parse($detail->jam_mulai);
            $selesai = $request->jam_selesai ? Carbon::parse($request->jam_selesai) : Carbon::parse($detail->jam_selesai);
            $durasi = $mulai->diffInMinutes($selesai) / 60;
            if ($durasi <= 0) { $durasi = 1.0; }

            $detail->update([
                'fasilitas_id' => $request->fasilitas_id ?? $detail->fasilitas_id,
                'tanggal'      => $request->tanggal ?? $detail->tanggal,
                'jam_mulai'    => $mulai->format('H:i:s'),
                'jam_selesai'  => $selesai->format('H:i:s'),
                'durasi_jam'   => $durasi,
                'subtotal'     => $request->total_harga,
            ]);
        }

        return redirect()->route('admin.booking.index')->with('success', 'Booking berhasil diupdate!');
    }

    // Menampilkan detail struk pop-up modal iframe
    public function show($id)
    {
        // Cari data booking berdasarkan ID beserta relasi user dan detailBooking-nya
        $booking = Booking::with(['user', 'detailBooking.fasilitas'])->findOrFail($id);

        // Lempar data ke blade show.blade.php yang udah lu buat
        return view('admin.booking.show', compact('booking'));
    }

    // 6. Menghapus Data (Destroy)
    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('admin.booking.index')->with('success', 'Booking berhasil dihapus!');
    }
}
