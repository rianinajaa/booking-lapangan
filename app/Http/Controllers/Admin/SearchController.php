<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Fasilitas;
use App\Models\User;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $q = trim($request->get('q', ''));

        if (strlen($q) < 2) {
            return response()->json([]);
        }

        $results = [];

        // Booking
        $bookings = Booking::with('user')
            ->where('kode_booking', 'like', "%$q%")
            ->orWhereHas('user', fn($query) => $query->where('name', 'like', "%$q%"))
            ->latest()->take(4)->get();

        foreach ($bookings as $b) {
            $results[] = [
                'type'     => 'booking',
                'icon'     => 'fa-calendar-check',
                'color'    => '#a78bfa',
                'title'    => '#' . strtoupper(substr($b->kode_booking, -6)) . ' — ' . ($b->user?->name ?? '-'),
                'subtitle' => 'Booking · ' . ucfirst($b->status_booking),
                'url'      => route('admin.booking.index'),
            ];
        }

        // User
        $users = User::whereNotIn('role', ['admin'])
            ->where(fn($query) =>
                $query->where('name', 'like', "%$q%")
                      ->orWhere('email', 'like', "%$q%")
            )
            ->take(3)->get();

        foreach ($users as $u) {
            $results[] = [
                'type'     => 'user',
                'icon'     => 'fa-user',
                'color'    => '#4ea8ff',
                'title'    => $u->name,
                'subtitle' => ucfirst($u->role) . ' · ' . $u->email,
                'url'      => route('admin.users.index'),
            ];
        }

        // Fasilitas
        $fasilitas = Fasilitas::where('nama', 'like', "%$q%")
            ->take(3)->get();

        foreach ($fasilitas as $f) {
            $results[] = [
                'type'     => 'fasilitas',
                'icon'     => 'fa-building',
                'color'    => '#34f5a1',
                'title'    => $f->nama,
                'subtitle' => 'Fasilitas · Rp' . number_format($f->harga_per_jam, 0, ',', '.') . '/jam',
                'url'      => route('admin.fasilitas.edit', $f->id),
            ];
        }

        // Pembayaran by kode booking
        $pembayarans = Pembayaran::with('booking.user')
            ->whereHas('booking', fn($query) =>
                $query->where('kode_booking', 'like', "%$q%")
            )
            ->take(3)->get();

        foreach ($pembayarans as $p) {
            $results[] = [
                'type'     => 'pembayaran',
                'icon'     => 'fa-money-bill-wave',
                'color'    => '#facc15',
                'title'    => 'Rp' . number_format($p->total_tagihan, 0, ',', '.') . ' — ' . ($p->booking?->user?->name ?? '-'),
                'subtitle' => 'Pembayaran · ' . ucfirst(str_replace('_', ' ', $p->status_bayar)),
                'url'      => route('admin.pembayaran.index'),
            ];
        }

        return response()->json($results);
    }
}