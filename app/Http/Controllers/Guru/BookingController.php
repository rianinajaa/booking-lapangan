<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fasilitas;

class BookingController extends Controller
{
    // halaman booking
    public function index()
    {
       $fasilitas = Fasilitas::all();

        return response()->json($fasilitas);
    }

    // simpan booking
    public function store(Request $request)
    {
        return 'Booking berhasil disimpan';
    }

    // riwayat booking guru
    public function riwayat()
    {
        return 'Riwayat Booking Guru';
    }
}
