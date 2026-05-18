@extends('layouts.admin')

@section('title', 'Pengaturan Profil')

@section('breadcrumb')
    <a href="#">User</a>
    <span><i class="fa-solid fa-chevron-right" style="font-size:9px;"></i></span>
    <span class="current">Pengaturan Profil</span>
@endsection

@section('content')
<div style="max-width: 800px;">
    <h1 style="font-size: 24px; font-weight: 800; margin-bottom: 24px;">Pengaturan Profil</h1>

    <div style="display: grid; gap: 24px;">

        {{-- CARD: INFORMASI AKUN --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title"><i class="fa-solid fa-user-gear" style="margin-right: 8px; color: var(--green);"></i> Informasi Akun</div>
            </div>
            <div class="card-body">
                <form action="#" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}" placeholder="Masukkan nama lengkap">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Alamat Email</label>
                        <input type="email" name="email" class="form-control" value="{{ auth()->user()->email }}" placeholder="nama@email.com">
                        <small style="color: var(--text-3); font-size: 11px; margin-top: 4px; display: block;">Pastikan email aktif untuk keperluan notifikasi.</small>
                    </div>

                    <div style="margin-top: 24px;">
                        <button type="submit" class="btn btn-green">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- CARD: GANTI PASSWORD --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title"><i class="fa-solid fa-shield-halved" style="margin-right: 8px; color: var(--danger);"></i> Keamanan & Password</div>
            </div>
            <div class="card-body">
                <form action="#" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label class="form-label">Password Saat Ini</label>
                        <input type="password" name="current_password" class="form-control" placeholder="••••••••">
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div class="form-group">
                            <label class="form-label">Password Baru</label>
                            <input type="password" name="password" class="form-control" placeholder="••••••••">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••">
                        </div>
                    </div>

                    <div style="background: rgba(245,158,11,0.05); border: 1px solid rgba(245,158,11,0.2); padding: 12px; border-radius: 8px; margin-bottom: 20px;">
                        <p style="font-size: 12px; color: #fbbf24; line-height: 1.5;">
                            <i class="fa-solid fa-circle-info"></i> <strong>Tips Keamanan:</strong> Gunakan minimal 8 karakter dengan kombinasi huruf, angka, dan simbol untuk password yang lebih kuat.
                        </p>
                    </div>

                    <button type="submit" class="btn btn-outline" style="color: var(--text);">
                        <i class="fa-solid fa-key"></i> Perbarui Password
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
