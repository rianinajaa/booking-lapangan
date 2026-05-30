<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use Illuminate\Http\Request;

class FasilitasController extends Controller
{
    /**
     * Menampilkan halaman utama (welcome) dengan data fasilitas dari database.
     */
    public function index()
    {
        // 1. Mengambil data fasilitas yang statusnya 'aktif' dari database
        // Jika ingin semua data (aktif & nonaktif) muncul, ganti menjadi: Fasilitas::all();
        $daftarFasilitas = Fasilitas::where('status', 'aktif')->get();

        // 2. Mengirimkan variabel $daftarFasilitas ke file view welcome.blade.php
        return view('welcome', compact('daftarFasilitas'));
    }
}