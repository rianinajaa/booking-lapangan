<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FasilitasController extends Controller
{
    /**
     * INDEX
     */
    public function index(Request $request)
    {
        $query = Fasilitas::with('jadwal');

        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        $query->when($request->search, function ($q) use ($request) {

            $q->where(function ($sub) use ($request) {

                $sub->where('nama', 'like', '%' . $request->search . '%')
                    ->orWhere('deskripsi', 'like', '%' . $request->search . '%');

            });

        });

        /*
        |--------------------------------------------------------------------------
        | FILTER JENIS
        |--------------------------------------------------------------------------
        */

        $query->when($request->jenis, function ($q) use ($request) {

            $q->where('jenis', $request->jenis);

        });

        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS
        |--------------------------------------------------------------------------
        */

        $query->when($request->status, function ($q) use ($request) {

            $q->where('status', $request->status);

        });

        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS OPERASIONAL
        |--------------------------------------------------------------------------
        */

        $query->when($request->status_operasional, function ($query) use ($request) {

            $now = now('Asia/Jakarta')->format('H:i:s');

            /*
            |--------------------------------------------------------------------------
            | BUKA
            |--------------------------------------------------------------------------
            */

            if ($request->status_operasional === 'buka') {

                $query->whereHas('jadwal', function ($q) use ($now) {

                    $q->where('is_libur', false)

                        ->where(function ($sub) use ($now) {

                            /*
                            |--------------------------------------------------------------------------
                            | NORMAL
                            |--------------------------------------------------------------------------
                            */

                            $sub->where(function ($normal) use ($now) {

                                $normal->whereRaw('jam_buka < jam_tutup')
                                    ->whereRaw('? BETWEEN jam_buka AND jam_tutup', [$now]);

                            })

                            /*
                            |--------------------------------------------------------------------------
                            | LEWAT TENGAH MALAM
                            |--------------------------------------------------------------------------
                            */

                            ->orWhere(function ($overnight) use ($now) {

                                $overnight->whereRaw('jam_buka > jam_tutup')

                                    ->where(function ($time) use ($now) {

                                        $time->whereRaw('? >= jam_buka', [$now])
                                             ->orWhereRaw('? <= jam_tutup', [$now]);

                                    });

                            });

                        });

                });

            }

            /*
            |--------------------------------------------------------------------------
            | TUTUP
            |--------------------------------------------------------------------------
            */

            elseif ($request->status_operasional === 'tutup') {

                $query->where(function ($q) use ($now) {

                    /*
                    |--------------------------------------------------------------------------
                    | PUNYA JADWAL TAPI TUTUP
                    |--------------------------------------------------------------------------
                    */

                    $q->whereHas('jadwal', function ($jadwal) use ($now) {

                        $jadwal->where(function ($sub) use ($now) {

                            /*
                            |--------------------------------------------------------------------------
                            | LIBUR
                            |--------------------------------------------------------------------------
                            */

                            $sub->where('is_libur', true)

                            /*
                            |--------------------------------------------------------------------------
                            | DILUAR JAM OPERASIONAL
                            |--------------------------------------------------------------------------
                            */

                            ->orWhere(function ($offline) use ($now) {

                                /*
                                |--------------------------------------------------------------------------
                                | NORMAL
                                |--------------------------------------------------------------------------
                                */

                                $offline->where(function ($normal) use ($now) {

                                    $normal->whereRaw('jam_buka < jam_tutup')
                                        ->whereRaw('? NOT BETWEEN jam_buka AND jam_tutup', [$now]);

                                })

                                /*
                                |--------------------------------------------------------------------------
                                | LEWAT TENGAH MALAM
                                |--------------------------------------------------------------------------
                                */

                                ->orWhere(function ($overnight) use ($now) {

                                    $overnight->whereRaw('jam_buka > jam_tutup')

                                        ->whereRaw('? < jam_buka', [$now])
                                        ->whereRaw('? > jam_tutup', [$now]);

                                });

                            });

                        });

                    })

                    /*
                    |--------------------------------------------------------------------------
                    | BELUM PUNYA JADWAL
                    |--------------------------------------------------------------------------
                    */

                    ->orWhereDoesntHave('jadwal');

                });

            }

        });

        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */

        $fasilitas = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | STATISTIK
        |--------------------------------------------------------------------------
        */

        $totalFasilitas = Fasilitas::count();

        $totalActive = Fasilitas::where('status', 'aktif')->count();

        $avgPrice = Fasilitas::avg('harga_per_jam') ?? 0;

        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view('admin.fasilitas.index', compact(
            'fasilitas',
            'totalFasilitas',
            'totalActive',
            'avgPrice'
        ));
    }

    /**
     * FORM CREATE
     */
    public function create()
    {
        return view('admin.fasilitas.create');
    }

    /**
     * STORE
     */
    public function store(Request $request)
    {
        $data = $this->validateData($request);

        /*
        |--------------------------------------------------------------------------
        | UPLOAD FOTO
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('foto')) {

            $data['foto'] = $request->file('foto')
                ->store('fasilitas', 'public');

        }

        Fasilitas::create($data);

        return redirect()
            ->route('admin.fasilitas.index')
            ->with('success', 'Fasilitas berhasil ditambahkan!');
    }

    /**
     * SHOW
     */
    public function show(Fasilitas $fasilitas)
    {
        $fasilitas->load('jadwal');

        return view('admin.fasilitas.show', compact('fasilitas'));
    }

    /**
     * FORM EDIT
     */
    public function edit(Fasilitas $fasilitas)
    {
        return view('admin.fasilitas.edit', compact('fasilitas'));
    }

    /**
     * UPDATE
     */
    public function update(Request $request, Fasilitas $fasilitas)
    {
        $data = $this->validateData($request);

        /*
        |--------------------------------------------------------------------------
        | FOTO BARU
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('foto')) {

            /*
            |--------------------------------------------------------------------------
            | HAPUS FOTO LAMA
            |--------------------------------------------------------------------------
            */

            if ($fasilitas->foto &&
                Storage::disk('public')->exists($fasilitas->foto)) {

                Storage::disk('public')->delete($fasilitas->foto);

            }

            /*
            |--------------------------------------------------------------------------
            | STORE FOTO BARU
            |--------------------------------------------------------------------------
            */

            $data['foto'] = $request->file('foto')
                ->store('fasilitas', 'public');
        }

        $fasilitas->update($data);

        return redirect()
            ->route('admin.fasilitas.index')
            ->with('success', 'Fasilitas berhasil diperbarui!');
    }

    /**
     * DESTROY
     */
    public function destroy(Fasilitas $fasilitas)
    {
        /*
        |--------------------------------------------------------------------------
        | DELETE FOTO
        |--------------------------------------------------------------------------
        */

        if ($fasilitas->foto &&
            Storage::disk('public')->exists($fasilitas->foto)) {

            Storage::disk('public')->delete($fasilitas->foto);

        }

        $fasilitas->delete();

        return redirect()
            ->route('admin.fasilitas.index')
            ->with('success', 'Fasilitas berhasil dihapus!');
    }

    /**
     * TOGGLE STATUS
     */
    public function toggleStatus(Fasilitas $fasilitas)
    {
        $fasilitas->update([

            'status' => $fasilitas->status === 'aktif'
                ? 'nonaktif'
                : 'aktif'

        ]);

        return back()->with(
            'success',
            'Status fasilitas berhasil diubah!'
        );
    }

    /**
     * VALIDATION
     */
    private function validateData(Request $request)
    {
        return $request->validate([

            'nama' => [
                'required',
                'string',
                'max:255'
            ],

            'jenis' => [
                'required',
                'in:lapangan,ruang_multimedia,lab'
            ],

            'deskripsi' => [
                'nullable',
                'string'
            ],

            'foto' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048'
            ],

            'harga_per_jam' => [
                'required',
                'numeric',
                'min:0'
            ],

            'status' => [
                'required',
                'in:aktif,nonaktif'
            ],

            'kapasitas' => [
                'nullable',
                'integer',
                'min:1'
            ],

        ]);
    }
}
