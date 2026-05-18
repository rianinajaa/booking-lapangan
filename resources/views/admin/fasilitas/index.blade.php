@extends('layouts.admin')

@section('title', 'Kelola Fasilitas')
@section('page-title', 'Fasilitas')

@section('breadcrumb')
    <span class="current">Kelola Fasilitas</span>
@endsection

@section('content')
<style>
    :root {
        --accent: #00d98b;
        --accent-glow: rgba(0, 217, 139, 0.3);
        --card-bg: rgba(15, 23, 42, 0.6);
        --glass-border: rgba(255, 255, 255, 0.08);
    }

    @keyframes revealScale {
        0% { opacity: 0; transform: scale(0.98); filter: blur(10px); }
        100% { opacity: 1; transform: scale(1); filter: blur(0); }
    }

    .animate-reveal {
        animation: revealScale 0.5s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
    }

    .facility-card {
        background: linear-gradient(145deg, rgba(18, 25, 45, 0.7), rgba(10, 15, 26, 0.9)) !important;
        border: 1px solid var(--glass-border) !important;
        backdrop-filter: blur(12px);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 28px !important;
    }

    .facility-card:hover {
        transform: translateY(-8px);
        border-color: rgba(0, 217, 139, 0.4) !important;
        box-shadow: 0 20px 40px rgba(0,0,0,0.4), 0 0 20px rgba(0, 217, 139, 0.1);
    }

    .stat-card {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--glass-border);
        border-radius: 20px;
        transition: 0.3s;
    }

    .stat-card:hover {
        background: rgba(255, 255, 255, 0.05);
        border-color: var(--accent);
    }

    .glass-input {
        background: rgba(0,0,0,0.2) !important;
        border: 1px solid var(--glass-border) !important;
        color: white !important;
        border-radius: 12px !important;
        transition: 0.3s;
    }

    .glass-input:focus {
        border-color: var(--accent) !important;
        box-shadow: 0 0 15px var(--accent-glow) !important;
    }

    .action-pill {
        padding: 8px 12px;
        border-radius: 14px;
        font-size: 12px;
        font-weight: 600;
        transition: 0.3s;
        display: flex;
        align-items: center;
        gap: 6px;
        border: 1px solid rgba(255,255,255,0.05);
        color: white;
        text-decoration: none;
    }

    .action-pill:hover {
        background: rgba(255,255,255,0.1);
        transform: scale(1.05);
        color: var(--accent);
    }
</style>

{{-- Header Section --}}
<div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:32px; gap:20px; flex-wrap:wrap;">
    <div class="animate-reveal">
        <div style="display:flex; align-items:center; gap:12px; margin-bottom:8px;">
            <div style="width:4px; height:24px; background:var(--accent); border-radius:4px;"></div>
            <span style="text-transform:uppercase; letter-spacing:3px; font-size:11px; font-weight:700; color:var(--accent);">Asset Management</span>
        </div>
        <h1 style="font-size:42px; font-weight:900; color:white; margin:0; line-height:1; letter-spacing:-1px;">
            Kelola <span style="color:var(--accent)">Fasilitas</span>
        </h1>
    </div>

    <a href="{{ route('admin.fasilitas.create') }}" class="btn btn-green animate-reveal"
       style="padding:14px 28px; border-radius:18px; font-weight:700; box-shadow: 0 10px 20px var(--accent-glow); background: var(--accent); color: #000; border:none;">
        <i class="fa-solid fa-plus me-2"></i> Tambah Fasilitas
    </a>
</div>

{{-- Alert --}}
@if(session('success'))
    <div class="animate-reveal" style="background:rgba(0,217,139,0.1); border-left:4px solid var(--accent); color:white; border-radius:12px; padding:16px 20px; font-size:14px; margin-bottom:24px; display:flex; align-items:center; gap:12px; backdrop-filter:blur(10px);">
        <i class="fa-solid fa-circle-check" style="color:var(--accent); font-size:18px;"></i>
        {{ session('success') }}
    </div>
@endif

{{-- Stats Ringkasan --}}
@php
    $totalFasilitas = $fasilitas->total();
    $totalActive = $fasilitas->where('status', 'aktif')->count();
    $avgPrice = $fasilitas->avg('harga_per_jam') ?? 0;
@endphp

<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(240px, 1fr)); gap:20px; margin-bottom:32px;" class="animate-reveal">
    <div class="stat-card" style="padding:20px; position:relative; overflow:hidden;">
        <div style="position:absolute; right:-10px; bottom:-10px; font-size:80px; color:rgba(0,217,139,0.05); transform:rotate(-15deg)"><i class="fa-solid fa-building"></i></div>
        <div style="font-size:12px; color:rgba(255,255,255,0.5); text-transform:uppercase; letter-spacing:1px; margin-bottom:8px;">Total Aset</div>
        <div style="font-size:32px; font-weight:800; color:white;">{{ $totalFasilitas }} <span style="font-size:14px; color:var(--accent); font-weight:400;">Unit</span></div>
    </div>
    <div class="stat-card" style="padding:20px; position:relative; overflow:hidden;">
        <div style="position:absolute; right:-10px; bottom:-10px; font-size:80px; color:rgba(0,217,139,0.05); transform:rotate(-15deg)"><i class="fa-solid fa-circle-check"></i></div>
        <div style="font-size:12px; color:rgba(255,255,255,0.5); text-transform:uppercase; letter-spacing:1px; margin-bottom:8px;">Status Aktif</div>
        <div style="font-size:32px; font-weight:800; color:white;">{{ $totalActive }} <span style="font-size:14px; color:rgba(255,255,255,0.3); font-weight:400;">/ {{ $totalFasilitas }}</span></div>
    </div>
    <div class="stat-card" style="padding:20px; position:relative; overflow:hidden;">
        <div style="position:absolute; right:-10px; bottom:-10px; font-size:80px; color:rgba(0,217,139,0.05); transform:rotate(-15deg)"><i class="fa-solid fa-wallet"></i></div>
        <div style="font-size:12px; color:rgba(255,255,255,0.5); text-transform:uppercase; letter-spacing:1px; margin-bottom:8px;">Rata-rata Harga</div>
        <div style="font-size:28px; font-weight:800; color:white;">Rp{{ number_format($avgPrice, 0, ',', '.') }}<span style="font-size:14px; color:rgba(255,255,255,0.3); font-weight:400;">/jam</span></div>
    </div>
</div>

{{-- Filter Bar Modern (Tersambung ke Jadwal) --}}
<div class="animate-reveal" style="margin-bottom: 35px;">
    <form method="GET" action="{{ route('admin.fasilitas.index') }}"
          style="display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">

        {{-- Search Input --}}
        <div style="flex: 1; min-width: 250px; position: relative;">
            <i class="fa-solid fa-magnifying-glass"
               style="position: absolute; left: 18px; top: 50%; transform: translateY(-50%); color: rgba(255,255,255,0.3);"></i>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari data..." class="glass-input"
                   style="width: 100%; padding: 12px 12px 12px 48px; background: rgba(255,255,255,0.05) !important; border: 1px solid rgba(255,255,255,0.1) !important; border-radius: 12px !important; color: white;">
        </div>

        {{-- NEW: Filter Status Operasional (Realtime dari Jadwal) --}}
        <div style="position: relative;">
            <select name="status_operasional" class="glass-input"
                    style="padding: 12px 40px 12px 15px; min-width: 160px; background: rgba(255,255,255,0.05) !important; border: 1px solid rgba(255,255,255,0.1) !important; border-radius: 12px !important; appearance: none; cursor: pointer;">
                <option value="">Semua Jadwal</option>
                <option value="buka" {{ request('status_operasional') == 'buka' ? 'selected' : '' }}>🟢 Sedang Buka</option>
                <option value="tutup" {{ request('status_operasional') == 'tutup' ? 'selected' : '' }}>🔴 Sedang Tutup</option>
            </select>
            <i class="fa-solid fa-clock" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: rgba(255,255,255,0.3); pointer-events: none;"></i>
        </div>

        {{-- Dropdown Jenis --}}
        <div style="position: relative;">
            <select name="jenis" class="glass-input"
                    style="padding: 12px 40px 12px 15px; min-width: 160px; background: rgba(255,255,255,0.05) !important; border: 1px solid rgba(255,255,255,0.1) !important; border-radius: 12px !important; appearance: none; cursor: pointer;">
                <option value="">Semua Jenis</option>
                <option value="lapangan" {{ request('jenis') == 'lapangan' ? 'selected' : '' }}>🏟️ Lapangan</option>
                <option value="ruang_multimedia" {{ request('jenis') == 'ruang_multimedia' ? 'selected' : '' }}>📺 Multimedia</option>
                <option value="lab" {{ request('jenis') == 'lab' ? 'selected' : '' }}>🔬 Lab</option>
            </select>
            <i class="fa-solid fa-chevron-down" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: rgba(255,255,255,0.3); pointer-events: none;"></i>
        </div>

        <button type="submit" class="btn" style="height: 46px; padding: 0 25px; background: var(--accent); color: #000; border-radius: 12px; font-weight: 700;">
            Terapkan
        </button>
    </form>
</div>

{{-- Grid Cards --}}
<div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(380px, 1fr)); gap:25px;" class="animate-reveal">
    @forelse($fasilitas as $f)
        @php
            $statusColor = $f->status === 'aktif' ? '#00d98b' : '#6b7280';
            $jenisIcon = match($f->jenis) {
                'lapangan' => 'fa-futbol',
                'ruang_multimedia' => 'fa-tv',
                'lab' => 'fa-flask',
                default => 'fa-building'
            };
        @endphp

        <div class="facility-card" style="padding:24px; position:relative;">
            {{-- Top Badge Row --}}
            <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:20px;">
                <div style="width:50px; height:50px; background:{{ $statusColor }}15; border-radius:16px; display:flex; align-items:center; justify-content:center; border:1px solid {{ $statusColor }}30;">
                    <i class="fa-solid {{ $jenisIcon }}" style="color:{{ $statusColor }}; font-size:22px;"></i>
                </div>
                <form action="{{ route('admin.fasilitas.toggle-status', $f->id) }}" method="POST">
                    @csrf @method('PATCH')
                    <button type="submit" style="background:{{ $statusColor }}20; color:{{ $statusColor }}; border:1px solid {{ $statusColor }}40; padding:5px 12px; border-radius:10px; font-size:10px; font-weight:800; cursor:pointer; text-transform:uppercase; letter-spacing:0.5px;">
                        {{ $f->status }}
                    </button>
                </form>
            </div>

            {{-- Main Info --}}
            <div style="margin-bottom:20px;">
                <h3 style="color:white; font-size:22px; font-weight:800; margin-bottom:6px; letter-spacing:-0.5px;">{{ $f->nama }}</h3>
                <div style="display:flex; align-items:center; gap:12px;">
                    <span style="font-size:20px; font-weight:800; color:var(--accent);">Rp{{ number_format($f->harga_per_jam, 0, ',', '.') }}</span>
                    <span style="font-size:12px; color:rgba(255,255,255,0.4);">/ jam</span>
                </div>
            </div>

            {{-- Visual Progress (Okupansi Sim) --}}
            @if($f->jenis === 'lapangan')
            <div style="background:rgba(0,0,0,0.2); border-radius:18px; padding:15px; border:1px solid rgba(255,255,255,0.03); margin-bottom:20px;">
                <div style="display:flex; justify-content:space-between; margin-bottom:8px;">
                    <span style="font-size:11px; color:rgba(255,255,255,0.5); text-transform:uppercase;">Tingkat Okupansi</span>
                    <span style="font-size:11px; font-weight:700; color:var(--accent);">{{ rand(60,95) }}%</span>
                </div>
                <div style="height:6px; background:rgba(255,255,255,0.05); border-radius:10px; overflow:hidden;">
                    <div style="width: {{ rand(60,95) }}%; height:100%; background: linear-gradient(90deg, var(--accent), #00ffaa); border-radius:10px; box-shadow: 0 0 10px var(--accent-glow);"></div>
                </div>
            </div>
            @endif

            {{-- Schedule Row --}}
<div style="
    padding:14px 0;
    border-top:1px solid rgba(255,255,255,0.05);
    margin-bottom:20px;
">

    @if($f->jadwal)

        {{-- JAM --}}
        <div style="
            display:flex;
            align-items:center;
            justify-content:space-between;
            margin-bottom:12px;
        ">

            <div style="display:flex; align-items:center; gap:8px;">

                <i class="fa-regular fa-clock"
                   style="color:{{ $f->jadwal->status_color }};">
                </i>

                <span style="
                    font-size:13px;
                    color:rgba(255,255,255,0.75);
                    font-weight:600;
                ">

                    {{ $f->jadwal->jam_buka->format('H:i') }}
                    -
                    {{ $f->jadwal->jam_tutup->format('H:i') }}

                </span>
            </div>

            {{-- STATUS --}}
            <div style="
                padding:6px 12px;
                border-radius:12px;
                background:{{ $f->jadwal->status_color }}20;
                color:{{ $f->jadwal->status_color }};
                border:1px solid {{ $f->jadwal->status_color }}40;
                font-size:10px;
                font-weight:800;
                letter-spacing:.5px;
                display:flex;
                align-items:center;
                gap:6px;
                text-transform:uppercase;
            ">

                <span style="
                    width:6px;
                    height:6px;
                    border-radius:50%;
                    background:{{ $f->jadwal->status_color }};
                    box-shadow:0 0 10px {{ $f->jadwal->status_color }};
                "></span>

                {{ $f->jadwal->status_label }}

            </div>
        </div>

        {{-- HOLIDAY INFO --}}
        @if($f->jadwal->is_libur)

            <div style="
                margin-top:8px;
                padding:10px 14px;
                border-radius:14px;
                background:rgba(255,71,87,.08);
                color:#ff4757;
                font-size:12px;
                font-weight:700;
                border:1px solid rgba(255,71,87,.15);
            ">

                <i class="fa-solid fa-calendar-xmark me-2"></i>

                Fasilitas sedang diliburkan

            </div>

        @endif

    @else

        <div style="
            padding:14px;
            border-radius:14px;
            background:rgba(255,255,255,.03);
            border:1px dashed rgba(255,255,255,.08);
            color:rgba(255,255,255,.45);
            font-size:13px;
            text-align:center;
        ">

            <i class="fa-regular fa-calendar-xmark me-2"></i>

            Jadwal Belum Diatur

        </div>

    @endif

    {{-- KAPASITAS --}}
    @if($f->kapasitas)

        <div style="
            margin-top:14px;
            font-size:12px;
            color:rgba(255,255,255,0.4);
            display:flex;
            align-items:center;
            gap:6px;
        ">

            <i class="fa-solid fa-users"></i>

            {{ $f->kapasitas }} Orang

        </div>

    @endif

</div>

            {{-- Final Actions --}}
            <div style="display:flex; gap:10px;">
                <a href="{{ route('admin.fasilitas.show', $f) }}" class="action-pill" style="flex:1; justify-content:center; background:rgba(255,255,255,0.03);">
                    <i class="fa-regular fa-eye"></i> Detail
                </a>
                <a href="{{ route('admin.fasilitas.edit', $f) }}" class="action-pill" style="background:rgba(255,255,255,0.03);">
                    <i class="fa-regular fa-pen-to-square"></i>
                </a>
                @if($f->jadwal)
                    <a href="{{ route('admin.jadwal.edit', $f->jadwal->id) }}" class="action-pill" style="background:var(--accent); color:#000; border:none;">
                        <i class="fa-regular fa-calendar"></i>
                    </a>
                @else
                    <a href="{{ route('admin.jadwal.create') }}?fasilitas_id={{ $f->id }}" class="action-pill" style="border-color:var(--accent); color:var(--accent);">
                        <i class="fa-solid fa-calendar-plus"></i>
                    </a>
                @endif
                <form action="{{ route('admin.fasilitas.destroy', $f) }}" method="POST" onsubmit="return confirm('Hapus aset ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="action-pill" style="background:rgba(239,68,68,0.1); color:#f87171; border-color:rgba(239,68,68,0.2); cursor:pointer;">
                        <i class="fa-regular fa-trash-can"></i>
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div style="grid-column: 1/-1; text-align:center; padding:80px 0;">
            <i class="fa-solid fa-folder-open" style="font-size:60px; color:rgba(255,255,255,0.1); margin-bottom:20px;"></i>
            <h3 style="color:white;">Data Tidak Ditemukan</h3>
            <p style="color:rgba(255,255,255,0.4);">Silahkan tambah fasilitas atau sesuaikan filter pencarian.</p>
        </div>
    @endforelse
</div>

{{-- Pagination Modern --}}
@if($fasilitas->hasPages())
    <div style="margin-top:40px; padding:20px; background:rgba(0,0,0,0.2); border-radius:24px; display:flex; justify-content:space-between; align-items:center; border:1px solid var(--glass-border);">
        <span style="font-size:13px; color:rgba(255,255,255,0.4);">Menampilkan <b>{{ $fasilitas->firstItem() }} - {{ $fasilitas->lastItem() }}</b> dari {{ $fasilitas->total() }} aset</span>
        <div class="modern-pagination">
            {{ $fasilitas->withQueryString()->links() }}
        </div>
    </div>
@endif

@endsection
