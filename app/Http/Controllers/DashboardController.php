<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use App\Models\Jadwal;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function admin()
    {
        // Admin dashboard sudah punya controller sendiri di Admin\DashboardController
        return view('admin.dashboard');
    }

    public function guru()
    {
        return view('guru.dashboard');
    }

    public function user()
    {
        $fasilitas = Fasilitas::with('jadwal')
            ->where('status', 'aktif')
            ->orderBy('nama')
            ->get();

        return view('user.dashboard', compact('fasilitas'));
    }
}