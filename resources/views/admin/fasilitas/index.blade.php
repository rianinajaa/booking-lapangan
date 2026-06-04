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
        --glass-border: rgba(255, 255, 255, 0.08);
    }

    @keyframes revealScale {
        0% { opacity: 0; transform: scale(0.98); filter: blur(10px); }
        100% { opacity: 1; transform: scale(1); filter: blur(0); }
    }

    @keyframes blink-green {
        0%, 100% { opacity: 1; box-shadow: 0 0 0px #00d98b; }
        50% { opacity: 0.5; box-shadow: 0 0 10px #00d98b, 0 0 20px #00d98b; }
    }

    @keyframes blink-red {
        0%, 100% { opacity: 1; box-shadow: 0 0 0px #f97316; }
        50% { opacity: 0.5; box-shadow: 0 0 10px #f97316, 0 0 20px #f97316; }
    }

    .blink-green {
        animation: blink-green 1.5s infinite ease-in-out;
    }

    .blink-red {
        animation: blink-red 1.5s infinite ease-in-out;
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

    .btn-detail {
        padding: 10px 20px;
        border-radius: 14px;
        font-size: 13px;
        font-weight: 600;
        transition: 0.3s;
        display: flex;
        align-items: center;
        gap: 8px;
        border: 1px solid rgba(255,255,255,0.1);
        color: white;
        text-decoration: none;
        background: rgba(255,255,255,0.05);
    }

    .btn-detail:hover {
        background: var(--accent);
        color: #000;
        border-color: var(--accent);
        transform: scale(1.02);
    }

    /* ========== LIGHT MODE STYLES ========== */
    body.light-mode .main {
        background-color: #f1f5f9 !important;
    }

    body.light-mode .facility-card {
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        backdrop-filter: none;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    body.light-mode .facility-card:hover {
        transform: translateY(-8px);
        border-color: var(--accent) !important;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1), 0 0 20px rgba(0, 217, 139, 0.2);
    }

    body.light-mode h1, 
    body.light-mode h3 {
        color: #1e293b !important;
    }

    body.light-mode .stat-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
    }

    body.light-mode .stat-card:hover {
        background: #f8fafc;
        border-color: var(--accent);
    }

    body.light-mode .glass-input {
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        color: #1e293b !important;
    }

    body.light-mode .glass-input:focus {
        border-color: var(--accent) !important;
        box-shadow: 0 0 15px rgba(0, 217, 139, 0.2) !important;
    }

    body.light-mode .glass-input::placeholder {
        color: #94a3b8 !important;
    }

    body.light-mode select.glass-input {
        background: #ffffff !important;
        color: #1e293b !important;
    }

    body.light-mode .btn-detail {
        background: #f8fafc !important;
        border: 1px solid #e2e8f0 !important;
        color: #475569 !important;
    }

    body.light-mode .btn-detail:hover {
        background: var(--accent) !important;
        color: #000 !important;
    }

    body.light-mode .fa-magnifying-glass {
        color: #64748b !important;
    }

    body.light-mode .fa-chevron-down,
    body.light-mode .fa-clock {
        color: #64748b !important;
    }

    body.light-mode .modern-pagination .pagination {
        background: transparent;
    }
    
    body.light-mode .modern-pagination .page-item .page-link {
        background: #f1f5f9 !important;
        color: #1e293b !important;
        border-color: #e2e8f0 !important;
    }
    
    body.light-mode .modern-pagination .page-item.active .page-link {
        background: var(--accent) !important;
        color: #000 !important;
        border-color: var(--accent) !important;
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
       style="padding:14px 28px; border-radius:18px; font-weight:700; box-shadow: 0 10px 20px var(--accent-glow); background: var(--accent); color: #000; border:none; text-decoration:none;">
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

{{-- Filter Bar --}}
<div class="animate-reveal" style="margin-bottom: 35px;">
    <form method="GET" action="{{ route('admin.fasilitas.index') }}"
          style="display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">
        <div style="flex: 1; min-width: 250px; position: relative;">
            <i class="fa-solid fa-magnifying-glass"
               style="position: absolute; left: 18px; top: 50%; transform: translateY(-50%); color: rgba(255,255,255,0.3);"></i>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari data..." class="glass-input"
                   style="width: 100%; padding: 12px 12px 12px 48px; border-radius: 12px;">
        </div>
        <div style="position: relative;">
            <select name="jenis" class="glass-input"
                    style="padding: 12px 40px 12px 15px; min-width: 160px; appearance: none; cursor: pointer;">
                <option value="">Semua Jenis</option>
                <option value="lapangan" {{ request('jenis') == 'lapangan' ? 'selected' : '' }}>🏟️ Lapangan</option>
                <option value="ruang_multimedia" {{ request('jenis') == 'ruang_multimedia' ? 'selected' : '' }}>📺 Multimedia</option>
                <option value="lab" {{ request('jenis') == 'lab' ? 'selected' : '' }}>🔬 Lab</option>
            </select>
            <i class="fa-solid fa-chevron-down" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: rgba(255,255,255,0.3); pointer-events: none;"></i>
        </div>
        <button type="submit" class="btn" style="height: 46px; padding: 0 25px; background: var(--accent); color: #000; border-radius: 12px; font-weight: 700; cursor:pointer;">
            Terapkan
        </button>
    </form>
</div>

{{-- Grid Cards --}}
<div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(300px, 1fr)); gap:25px;" class="animate-reveal">
    @forelse($fasilitas as $f)
        @php
            $statusColor = $f->status === 'aktif' ? '#00d98b' : '#6b7280';
            $jenisIcon = match($f->jenis) {
                'lapangan' => 'fa-futbol',
                'ruang_multimedia' => 'fa-tv',
                'lab' => 'fa-flask',
                default => 'fa-building'
            };
            
            $jadwal = $f->jadwal;
            $jamBuka = $jadwal ? \Carbon\Carbon::parse($jadwal->jam_buka)->format('H:i') : '-';
            $jamTutup = $jadwal ? \Carbon\Carbon::parse($jadwal->jam_tutup)->format('H:i') : '-';
            $isOpen = ($jadwal && !$jadwal->is_libur);
        @endphp

        <div class="facility-card" style="padding:24px;">
            
            {{-- Top: Icon dan Status Badge --}}
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                <div style="width:50px; height:50px; background:{{ $statusColor }}15; border-radius:16px; display:flex; align-items:center; justify-content:center;">
                    <i class="fa-solid {{ $jenisIcon }}" style="color:{{ $statusColor }}; font-size:24px;"></i>
                </div>
                <form action="{{ route('admin.fasilitas.toggle-status', $f->id) }}" method="POST">
                    @csrf @method('PATCH')
                    <button type="submit" style="background:{{ $statusColor }}20; color:{{ $statusColor }}; border:1px solid {{ $statusColor }}40; padding:6px 14px; border-radius:20px; font-size:11px; font-weight:800; cursor:pointer; text-transform:uppercase;">
                        {{ $f->status }}
                    </button>
                </form>
            </div>

            {{-- Nama Fasilitas --}}
            <h3 style="color:white; font-size:20px; font-weight:800; margin-bottom:8px;">{{ $f->nama }}</h3>
            
            {{-- Harga --}}
            <div style="margin-bottom:16px;">
                <span style="font-size:18px; font-weight:800; color:var(--accent);">Rp{{ number_format($f->harga_per_jam, 0, ',', '.') }}</span>
                <span style="font-size:12px; color:rgba(255,255,255,0.4);">/jam</span>
            </div>

            {{-- Jam Operasional --}}
            <div style="margin-bottom:16px;">
                <span style="font-size:13px; color:rgba(255,255,255,0.6);">{{ $jamBuka }} - {{ $jamTutup }}</span>
            </div>

            {{-- Status OPEN NOW / LIBUR dengan animasi blinking --}}
            <div style="margin-bottom:20px; display:flex; align-items:center; gap:8px;">
                @if($jadwal)
                    @if($isOpen)
                        <div class="blink-green" style="width:10px; height:10px; border-radius:50%; background:#00d98b;"></div>
                        <span style="color:#00d98b; font-size:11px; font-weight:700;">OPEN NOW</span>
                    @else
                        <div class="blink-red" style="width:10px; height:10px; border-radius:50%; background:#f97316;"></div>
                        <span style="color:#f97316; font-size:11px; font-weight:700;">LIBUR</span>
                    @endif
                @else
                    <div style="width:10px; height:10px; border-radius:50%; background:rgba(255,255,255,0.3);"></div>
                    <span style="color:rgba(255,255,255,0.5); font-size:11px; font-weight:700;">NO SCHEDULE</span>
                @endif
            </div>

            {{-- Tombol Detail --}}
            <a href="{{ route('admin.fasilitas.show', $f) }}" class="btn-detail" style="display:inline-flex; width:100%; justify-content:center;">
                <i class="fa-regular fa-eye"></i> Detail
            </a>
        </div>
    @empty
        <div style="grid-column: 1/-1; text-align:center; padding:80px 0;">
            <i class="fa-solid fa-folder-open" style="font-size:60px; color:rgba(255,255,255,0.1); margin-bottom:20px;"></i>
            <h3 style="color:white;">Data Tidak Ditemukan</h3>
            <p style="color:rgba(255,255,255,0.4);">Silahkan tambah fasilitas atau sesuaikan filter pencarian.</p>
        </div>
    @endforelse
</div>

{{-- Pagination --}}
@if($fasilitas->hasPages())
    <div style="margin-top:40px; padding:20px; background:rgba(0,0,0,0.2); border-radius:24px; display:flex; justify-content:space-between; align-items:center; border:1px solid var(--glass-border); flex-wrap:wrap; gap:15px;">
        <span style="font-size:13px; color:rgba(255,255,255,0.4);">Menampilkan <b>{{ $fasilitas->firstItem() }} - {{ $fasilitas->lastItem() }}</b> dari {{ $fasilitas->total() }} aset</span>
        <div class="modern-pagination">
            {{ $fasilitas->withQueryString()->links() }}
        </div>
    </div>
@endif

@endsection