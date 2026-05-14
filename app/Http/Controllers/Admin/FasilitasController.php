<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FasilitasController extends Controller
{
   public function index(Request $request)
{
    $fasilitas = Fasilitas::with('jadwal')
        ->when($request->search, fn($q) =>
            $q->where('nama', 'like', '%'.$request->search.'%'))
        ->when($request->jenis, fn($q) =>
            $q->where('jenis', $request->jenis))
        ->when($request->status, fn($q) =>
            $q->where('status', $request->status))
        ->latest()
        ->paginate(10);

    return view('admin.fasilitas.index', compact('fasilitas'));
}

    // Form tambah fasilitas
    public function create()
    {
        return view('admin.fasilitas.create');
    }

    // Simpan fasilitas baru
    public function store(Request $request)
    {
        $request->validate([
            'nama'         => 'required|string|max:255',
            'jenis'        => 'required|in:lapangan,ruang_multimedia,lab',
            'deskripsi'    => 'nullable|string',
            'foto'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'harga_per_jam'=> 'required|numeric|min:0',
            'status'       => 'required|in:aktif,nonaktif',
        ]);

        $data = $request->except('foto');

        // Upload foto jika ada
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('fasilitas', 'public');
        }

        Fasilitas::create($data);

        return redirect()->route('admin.fasilitas.index')
            ->with('success', 'Fasilitas berhasil ditambahkan!');
    }

    // Tampilkan detail fasilitas
    public function show(Fasilitas $fasilitas)
    {
        return view('admin.fasilitas.show', compact('fasilitas'));
    }

    // Form edit fasilitas
    public function edit(Fasilitas $fasilitas)
    {
        return view('admin.fasilitas.edit', compact('fasilitas'));
    }

    // Update fasilitas
    public function update(Request $request, Fasilitas $fasilitas)
    {
        $request->validate([
            'nama'         => 'required|string|max:255',
            'jenis'        => 'required|in:lapangan,ruang_multimedia,lab',
            'deskripsi'    => 'nullable|string',
            'foto'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'harga_per_jam'=> 'required|numeric|min:0',
            'status'       => 'required|in:aktif,nonaktif',
        ]);

        $data = $request->except('foto');

        // Upload foto baru jika ada
        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($fasilitas->foto) {
                Storage::disk('public')->delete($fasilitas->foto);
            }
            $data['foto'] = $request->file('foto')->store('fasilitas', 'public');
        }

        $fasilitas->update($data);

        return redirect()->route('admin.fasilitas.index')
            ->with('success', 'Fasilitas berhasil diupdate!');
    }

    // Hapus fasilitas
    public function destroy(Fasilitas $fasilitas)
    {
        // Hapus foto jika ada
        if ($fasilitas->foto) {
            Storage::disk('public')->delete($fasilitas->foto);
        }

        $fasilitas->delete();

        return redirect()->route('admin.fasilitas.index')
            ->with('success', 'Fasilitas berhasil dihapus!');
    }

    // Toggle status aktif/nonaktif
    public function toggleStatus(Fasilitas $fasilitas)
    {
        $fasilitas->update([
            'status' => $fasilitas->status === 'aktif' ? 'nonaktif' : 'aktif'
        ]);

        return redirect()->back()
            ->with('success', 'Status fasilitas berhasil diubah!');
    }
}