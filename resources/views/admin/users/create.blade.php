@extends('layouts.admin')

@section('title', 'Tambah User Baru')
@section('page-title', 'Tambah User')

@section('breadcrumb')
    <a href="{{ route('admin.users.index') }}">Manajemen Users</a>
    <i class="fa-solid fa-angle-right" style="font-size: 10px; margin: 0 8px; color: var(--text-3);"></i>
    <span class="current">Tambah User</span>
@endsection

@section('content')
<div style="max-width: 600px; margin: 0 auto;">

    <div style="margin-bottom: 24px;">
        <h1 style="font-size:28px; font-weight:800; color:var(--text); margin-bottom:4px;">Tambah User Baru</h1>
        <p style="font-size:13px; color:var(--text-3);">Buat akun pengguna baru dengan hak akses tertentu.</p>
    </div>

    {{-- Error Handling --}}
    @if ($errors->any())
        <div style="background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.25); color:#ef4444; border-radius:10px; padding:12px 16px; font-size:13px; margin-bottom:20px;">
            <ul class="mb-0" style="padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Kotak Form SpaceGo Style --}}
    <div class="card" style="padding: 24px; background: #12192d; border: 1px solid rgba(255,255,255,0.08); border-radius: 16px;">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div style="margin-bottom: 20px;">
                <label style="display:block; font-size: 13px; font-weight:600; color: var(--text-2); margin-bottom:8px;">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" style="width:100%; height:40px; background:rgba(0,0,0,0.2); border:1px solid rgba(255,255,255,0.15); color:#fff; border-radius:8px; padding:0 12px; font-size:14px;" required>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display:block; font-size: 13px; font-weight:600; color: var(--text-2); margin-bottom:8px;">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="contoh@domain.com" style="width:100%; height:40px; background:rgba(0,0,0,0.2); border:1px solid rgba(255,255,255,0.15); color:#fff; border-radius:8px; padding:0 12px; font-size:14px;" required>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display:block; font-size: 13px; font-weight:600; color: var(--text-2); margin-bottom:8px;">Role Akses</label>
                <select name="role" style="width:100%; height:40px; background:#12192d; border:1px solid rgba(255,255,255,0.15); color:#fff; border-radius:8px; padding:0 12px; font-size:14px;" required>
                    <option value="umum" selected>Umum</option>
                    <option value="siswa_internal">Siswa Internal</option>
                    <option value="siswa_luar">Siswa Luar</option>
                    <option value="guru">Guru</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <div style="margin-bottom: 24px;">
                <label style="display:block; font-size: 13px; font-weight:600; color: var(--text-2); margin-bottom:8px;">Password</label>
                <input type="password" name="password" placeholder="Minimal 8 karakter" style="width:100%; height:40px; background:rgba(0,0,0,0.2); border:1px solid rgba(255,255,255,0.15); color:#fff; border-radius:8px; padding:0 12px; font-size:14px;" required>
            </div>

            {{-- Tombol Submit --}}
            <div style="display: flex; gap: 12px; justify-content: flex-end; border-top: 1px solid rgba(255,255,255,0.06); pt: 20px; padding-top: 16px;">
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline" style="color: #fff; border-color: rgba(255,255,255,0.1); border-radius:8px; text-decoration:none; display:flex; align-items:center; height:38px; padding:0 16px; font-size:13px;">Batal</a>
                <button type="submit" class="btn" style="background: #00d98b; color: #000; font-weight:700; border-radius:8px; height:38px; padding:0 20px; font-size:13px; border:none; cursor:pointer;">Simpan User</button>
            </div>
        </form>
    </div>
</div>
@endsection
