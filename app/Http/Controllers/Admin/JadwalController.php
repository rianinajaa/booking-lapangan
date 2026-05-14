<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Fasilitas;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $jadwals = Jadwal::with('fasilitas')
            ->when($request->search, fn($q) =>
                $q->whereHas('fasilitas', fn($q2) =>
                    $q2->where('nama', 'like', '%'.$request->search.'%')))
            ->when($request->status !== null && $request->status !== '', fn($q) =>
                $q->where('is_libur', $request->status))
            ->latest()
            ->paginate(10);

        return view('admin.jadwal.index', compact('jadwals'));
    }

    public function create()
    {
        $fasilitas = Fasilitas::where('status', 'aktif')->orderBy('nama')->get();
        return view('admin.jadwal.create', compact('fasilitas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fasilitas_id' => 'required|exists:fasilitas,id',
            'jam_buka'     => 'required',
            'jam_tutup'    => 'required|after:jam_buka',
            'is_libur'     => 'boolean',
        ]);

        Jadwal::create([
            'fasilitas_id' => $request->fasilitas_id,
            'jam_buka'     => $request->jam_buka,
            'jam_tutup'    => $request->jam_tutup,
            'is_libur'     => $request->boolean('is_libur'),
        ]);

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal berhasil ditambahkan!');
    }

    public function edit(Jadwal $jadwal)
    {
        $fasilitas = Fasilitas::where('status', 'aktif')->orderBy('nama')->get();
        return view('admin.jadwal.edit', compact('jadwal', 'fasilitas'));
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        $request->validate([
            'fasilitas_id' => 'required|exists:fasilitas,id',
            'jam_buka'     => 'required',
            'jam_tutup'    => 'required|after:jam_buka',
            'is_libur'     => 'boolean',
        ]);

        $jadwal->update([
            'fasilitas_id' => $request->fasilitas_id,
            'jam_buka'     => $request->jam_buka,
            'jam_tutup'    => $request->jam_tutup,
            'is_libur'     => $request->boolean('is_libur'),
        ]);

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal berhasil diupdate!');
    }

    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal berhasil dihapus!');
    }

    public function toggleLibur(Jadwal $jadwal)
    {
        $jadwal->update(['is_libur' => !$jadwal->is_libur]);

        return redirect()->back()
            ->with('success', 'Status jadwal berhasil diubah!');
    }
}