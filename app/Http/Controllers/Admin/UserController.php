<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // READ (Menampilkan data utama berbentuk grid card)
    public function index(Request $request)
    {
        $search = $request->get('search');

        $users = User::withCount(['bookings' => function($query) {
                // Menghitung jumlah booking yang sukses/selesai/dikonfirmasi
                $query->whereIn('status_booking', ['dikonfirmasi', 'selesai']);
            }])
            ->withSum(['bookings' => function($query) {
                $query->whereIn('status_booking', ['dikonfirmasi', 'selesai']);
            }], 'total_harga')
            ->when($search, function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(12); // Ubah jadi paginate agar tidak terlalu banyak data

        return view('admin.users.index', compact('users'));
    }

    /**
     * 1. BARU: MENAMPILKAN HALAMAN CREATE USER (Pindah Halaman)
     */
    public function create()
    {
        return view('admin.users.create');
    }

    // CREATE (Menyimpan Data dari Form Create User)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,guru,siswa_internal,siswa_luar,umum',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Dialihkan kembali ke halaman utama manajemen users dengan alert sukses
        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * 2. BARU: MENAMPILKAN HALAMAN EDIT USER (Pindah Halaman)
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    // UPDATE (Memproses Perubahan dari Form Edit User)
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'role' => 'required|in:admin,guru,siswa_internal,siswa_luar,umum',
            'password' => 'nullable|string|min:8', // Validasi jika password diisi
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        // Dialihkan kembali ke halaman utama manajemen users dengan alert sukses
        return redirect()->route('admin.users.index')->with('success', 'Data user berhasil diubah!');
    }

    // DELETE (Menghapus User) - DENGAN PROTEKSI AKUN SENDIRI
    public function destroy($id)
    {
        // Cegah admin menghapus akun sendiri
        if (auth()->id() == $id) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Anda tidak dapat menghapus akun sendiri!');
        }

        $user = User::findOrFail($id);
        
        // Cek apakah user yang akan dihapus adalah admin
        if ($user->role === 'admin') {
            // Hitung jumlah admin yang tersisa setelah penghapusan
            $adminCount = User::where('role', 'admin')->count();
            
            // Jika hanya 1 admin yang tersisa (yaitu user yang akan dihapus)
            if ($adminCount <= 1) {
                return redirect()->route('admin.users.index')
                    ->with('error', 'Tidak dapat menghapus admin terakhir! Minimal harus ada satu admin.');
            }
        }
        
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus!');
    }
}