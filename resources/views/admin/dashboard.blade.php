@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('breadcrumb')
    <span class="current">Analytics</span>
@endsection

@section('content')

{{-- Header --}}
<div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:24px; flex-wrap:wrap; gap:12px;">
    <div>
        <h1 style="font-size:32px; font-weight:800; color:var(--text); line-height:1.2; margin-bottom:6px;">
            Dashboard<br>Ringkasan
        </h1>
        <p style="font-size:13px; color:var(--text-3);">
            Selamat datang kembali, <strong style="color:var(--text-2);">{{ auth()->user()->name }}</strong>.
            {{ now()->translatedFormat('l, d F Y') }}
        </p>
    </div>
    <div style="display:flex; gap:10px; flex-wrap:wrap;">
        <a href="#" class="btn btn-outline btn-sm">
            <i class="fa-regular fa-file-pdf"></i> Ekspor PDF
        </a>
        <a href="#" class="btn btn-outline btn-sm">
            <i class="fa-regular fa-file-excel"></i> Ekspor Excel
        </a>
    </div>
</div>

{{-- Stat Cards --}}
<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px,1fr)); gap:14px; margin-bottom:24px;">

    {{-- Total Pendapatan --}}
    <div class="stat-card">
        <div class="stat-label">
            Total Pendapatan
            <i class="fa-solid fa-circle-dollar-to-slot" style="color:var(--green); font-size:14px;"></i>
        </div>
        <div class="stat-value">
            Rp {{ number_format(\App\Models\Pembayaran::where('status_bayar','lunas')->sum('total_tagihan'), 0, ',', '.') }}
        </div>
        <div class="stat-sub">
            <span class="stat-change up">
                <i class="fa-solid fa-arrow-trend-up" style="font-size:10px;"></i>
                +12.5% bulan ini
            </span>
        </div>
    </div>

    {{-- Pengguna Aktif --}}
    <div class="stat-card">
        <div class="stat-label">
            Pengguna Aktif
            <i class="fa-solid fa-users" style="color:#60a5fa; font-size:14px;"></i>
        </div>
        <div class="stat-value">
            {{ \App\Models\User::whereNotIn('role',['admin'])->count() }}
        </div>
        <div class="stat-sub" style="color:var(--text-3); font-size:12px;">
            {{ \App\Models\User::where('role','guru')->count() }} guru
            · {{ \App\Models\User::whereIn('role',['umum','siswa_internal','siswa_luar'])->count() }} user
        </div>
    </div>

    {{-- Total Booking --}}
    <div class="stat-card">
        <div class="stat-label">
            Total Booking
            <i class="fa-solid fa-calendar-check" style="color:#a78bfa; font-size:14px;"></i>
        </div>
        <div class="stat-value">
            {{ \App\Models\Booking::count() }}
        </div>
        <div class="stat-sub" style="color:var(--text-3);">
            {{ \App\Models\Booking::where('status_booking','menunggu')->count() }} menunggu konfirmasi
        </div>
        <div class="progress" style="margin-top:10px;">
            <div class="progress-bar" style="width:72%;"></div>
        </div>
    </div>

    {{-- Verifikasi Pending --}}
    <div class="stat-card">
        <div class="stat-label">
            Verifikasi Pending
            <i class="fa-solid fa-money-bill-wave" style="color:#f87171; font-size:14px;"></i>
        </div>
        @php
            $pending = \App\Models\Pembayaran::where('status_bayar','dp')->count();
        @endphp
        <div class="stat-value" style="{{ $pending > 0 ? 'color:#f87171;' : '' }}">
            {{ $pending }}
        </div>
        <div class="stat-sub" style="color:var(--text-3);">
            pembayaran menunggu verifikasi
        </div>
        @if($pending > 0)
            <div class="progress" style="margin-top:10px;">
                <div class="progress-bar" style="width:100%; background:#f87171;"></div>
            </div>
        @endif
    </div>

</div>

{{-- Row tengah: Booking + Fasilitas --}}
<div style="display:grid; grid-template-columns:1.4fr 1fr; gap:16px; margin-bottom:16px;">

    {{-- Manajemen Booking --}}
    <div class="card">
        <div class="card-header">
            <span class="card-title">Booking Terbaru</span>
            <a href="{{ route('admin.booking.index') }}"
                style="font-size:12.5px; color:var(--green); font-weight:600; text-decoration:none;">
                Lihat Semua
            </a>
        </div>
        <div class="tbl-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID / Pemesan</th>
                        <th>Fasilitas</th>
                        <th>Status</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(\App\Models\Booking::with(['user','detailBooking.fasilitas'])->latest()->take(6)->get() as $booking)
                        <tr>
                            <td>
                                <div style="font-family:monospace; font-size:11.5px; color:var(--green); margin-bottom:2px;">
                                    #{{ strtoupper(substr($booking->kode_booking,-6)) }}
                                </div>
                                <div style="font-size:13px; font-weight:600; color:var(--text);">
                                    {{ $booking->user->name }}
                                </div>
                                <div style="font-size:11px; color:var(--text-3);">
                                    {{ $booking->role_booker ?? '' }}
                                </div>
                            </td>
                            <td style="color:var(--text-2); font-size:13px;">
                                {{ $booking->detailBooking->first()?->fasilitas?->nama ?? '-' }}
                                @if($booking->detailBooking->count() > 1)
                                    <span style="font-size:11px; color:var(--text-3);">
                                        +{{ $booking->detailBooking->count()-1 }} lainnya
                                    </span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $sc = match($booking->status_booking) {
                                        'menunggu'     => ['badge-yellow','Menunggu'],
                                        'dikonfirmasi' => ['badge-blue','Konfirmasi'],
                                        'dibatalkan'   => ['badge-red','Batal'],
                                        'selesai'      => ['badge-green','Selesai'],
                                        default        => ['badge-gray', $booking->status_booking],
                                    };
                                @endphp
                                <span class="badge {{ $sc[0] }}">{{ $sc[1] }}</span>
                            </td>
                            <td>
                                <div style="display:flex; gap:6px;">
                                    <a href="{{ route('admin.booking.index') }}"
                                        class="btn btn-outline btn-sm btn-icon" title="Lihat">
                                        <i class="fa-solid fa-eye" style="font-size:11px;"></i>
                                    </a>
                                    <a href="{{ route('admin.booking.index') }}"
                                        class="btn btn-outline btn-sm btn-icon" title="Edit">
                                        <i class="fa-solid fa-pen" style="font-size:11px;"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align:center; padding:32px; color:var(--text-3);">
                                <i class="fa-solid fa-calendar-xmark" style="font-size:28px; opacity:0.3; display:block; margin-bottom:8px;"></i>
                                Belum ada booking
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Kolom kanan --}}
    <div style="display:flex; flex-direction:column; gap:16px;">

        {{-- Info Admin --}}
        <div class="card" style="padding:18px;">
            <div style="display:flex; align-items:center; gap:12px; margin-bottom:14px;">
                <div style="width:46px; height:46px; border-radius:12px; background:var(--green);
                    display:flex; align-items:center; justify-content:center;
                    font-size:20px; font-weight:800; color:#0f1621; flex-shrink:0;">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div style="overflow:hidden;">
                    <div style="font-size:14px; font-weight:700; color:var(--text);
                        white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                        {{ auth()->user()->name }}
                    </div>
                    <div style="font-size:11.5px; color:var(--text-3);
                        white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                        {{ auth()->user()->email }}
                    </div>
                    <span class="badge badge-green" style="margin-top:4px; font-size:10px;">Administrator</span>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline btn-sm"
                    style="width:100%; justify-content:center; color:#f87171; border-color:rgba(248,113,113,0.3);">
                    <i class="fa-solid fa-right-from-bracket"></i> Keluar
                </button>
            </form>
        </div>

        {{-- Akses Cepat --}}
        <div class="card" style="padding:18px;">
            <div style="font-size:13px; font-weight:700; color:var(--text-2);
                margin-bottom:10px; text-transform:uppercase; letter-spacing:0.05em;">
                Akses Cepat
            </div>
            <div style="display:flex; flex-direction:column; gap:6px;">
                <a href="{{ route('admin.fasilitas.create') }}" class="btn btn-outline btn-sm"
                    style="justify-content:flex-start;">
                    <i class="fa-solid fa-plus" style="color:var(--green); font-size:11px;"></i>
                    Tambah Fasilitas
                </a>
                <a href="{{ route('admin.fasilitas.index') }}" class="btn btn-outline btn-sm"
                    style="justify-content:flex-start;">
                    <i class="fa-solid fa-building" style="color:#60a5fa; font-size:11px;"></i>
                    Kelola Fasilitas
                </a>
                <a href="{{ route('admin.jadwal.index') }}" class="btn btn-outline btn-sm"
                    style="justify-content:flex-start;">
                    <i class="fa-solid fa-clock" style="color:#a78bfa; font-size:11px;"></i>
                    Kelola Jadwal
                </a>
                <a href="{{ route('admin.booking.index') }}" class="btn btn-outline btn-sm"
                    style="justify-content:flex-start;">
                    <i class="fa-solid fa-calendar-check" style="color:#fbbf24; font-size:11px;"></i>
                    Kelola Booking
                </a>
            </div>
        </div>

    </div>
</div>

{{-- Row bawah: Kelola Fasilitas --}}
<div class="card">
    <div class="card-header">
        <span class="card-title">Kelola Fasilitas</span>
        <a href="{{ route('admin.fasilitas.create') }}" class="btn btn-green btn-sm">
            <i class="fa-solid fa-plus"></i>
        </a>
    </div>
    <div style="padding:8px 0;">
        @forelse(\App\Models\Fasilitas::with('jadwal')->take(5)->get() as $f)
            <div style="display:flex; align-items:center; gap:12px; padding:11px 18px;
                border-bottom:1px solid rgba(255,255,255,0.04);">

                {{-- Foto/Icon --}}
                @if($f->foto)
                    <img src="{{ Storage::url($f->foto) }}" alt="{{ $f->nama }}"
                        style="width:42px; height:42px; border-radius:10px; object-fit:cover; flex-shrink:0;">
                @else
                    <div style="width:42px; height:42px; border-radius:10px; background:rgba(255,255,255,0.06);
                        display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <i class="fa-solid {{ $f->jenis === 'lapangan' ? 'fa-futbol' : ($f->jenis === 'lab' ? 'fa-flask' : 'fa-tv') }}"
                            style="color:var(--text-3); font-size:16px;"></i>
                    </div>
                @endif

                {{-- Info --}}
                <div style="flex:1; overflow:hidden;">
                    <div style="font-size:13.5px; font-weight:600; color:var(--text);
                        white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                        {{ $f->nama }}
                    </div>
                    <div style="font-size:12px; color:var(--text-3);">
                        Rp{{ number_format($f->harga_per_jam, 0, ',', '.') }}/jam
                        @if($f->jadwal)
                            · {{ $f->jadwal->jam_buka }}–{{ $f->jadwal->jam_tutup }}
                        @endif
                    </div>
                </div>

                {{-- Status --}}
                <span class="badge {{ $f->status === 'aktif' ? 'badge-green' : 'badge-red' }}"
                    style="font-size:11px; flex-shrink:0;">
                    {{ $f->status === 'aktif' ? 'Aktif' : 'Nonaktif' }}
                </span>
            </div>
        @empty
            <div style="text-align:center; padding:32px; color:var(--text-3); font-size:13px;">
                Belum ada fasilitas
            </div>
        @endforelse

        <div style="padding:12px 18px;">
            <a href="{{ route('admin.fasilitas.index') }}"
                class="btn btn-outline" style="width:100%; justify-content:center; font-size:12.5px;">
                Lihat Semua Fasilitas
            </a>
        </div>
    </div>
</div>

@endsection