@extends('layouts.admin')

@section('title', 'Jadwal Operasional')
@section('page-title', 'Jadwal')

@section('breadcrumb')
    <span class="current">Jadwal Operasional</span>
@endsection

@section('content')

{{-- Header --}}
<div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:24px; flex-wrap:wrap; gap:12px;">
    <div>
        <h1 style="font-size:32px; font-weight:800; color:var(--text); line-height:1.2; margin-bottom:6px;">
            Jadwal<br>Operasional
        </h1>
        <p style="font-size:13px; color:var(--text-3);">
            Kelola jam operasional dan status libur setiap fasilitas.
        </p>
    </div>
    <a href="{{ route('admin.jadwal.create') }}" class="btn btn-green btn-sm">
        <i class="fa-solid fa-plus"></i> Tambah Jadwal
    </a>
</div>

{{-- Alert --}}
@if(session('success'))
    <div style="background:rgba(34,197,94,0.1); border:1px solid rgba(34,197,94,0.25); color:var(--green);
        border-radius:10px; padding:12px 16px; font-size:13px; margin-bottom:20px; display:flex; align-items:center; gap:8px;">
        <i class="fa-solid fa-circle-check"></i>
        {{ session('success') }}
    </div>
@endif

{{-- Filter --}}
<div class="card" style="margin-bottom:16px;">
    <form method="GET" action="{{ route('admin.jadwal.index') }}"
        style="display:flex; gap:10px; flex-wrap:wrap; padding:14px 18px; align-items:center;">
        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Cari fasilitas..."
            style="flex:1; min-width:180px; height:36px; background:rgba(255,255,255,0.05);
                border:1px solid rgba(255,255,255,0.1); border-radius:8px;
                padding:0 12px; font-size:13px; color:var(--text);">

        <select name="status"
            style="height:36px; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1);
                border-radius:8px; padding:0 12px; font-size:13px; color:var(--text); min-width:140px;">
            <option value="">Semua Status</option>
            <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Buka</option>
            <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Libur</option>
        </select>

        <button type="submit" class="btn btn-outline btn-sm">
            <i class="fa-solid fa-magnifying-glass"></i> Cari
        </button>
        @if(request('search') || request('status') !== null && request('status') !== '')
            <a href="{{ route('admin.jadwal.index') }}" class="btn btn-outline btn-sm">
                <i class="fa-solid fa-xmark"></i> Reset
            </a>
        @endif
    </form>
</div>

{{-- Tabel dengan desain Time Cards --}}
<div class="card" style="padding:0; overflow:hidden;">
    <div class="card-header" style="border-bottom:1px solid rgba(255,255,255,0.06);">
        <span class="card-title">
            <i class="fa-regular fa-clock" style="margin-right:8px; color: #00d98b;"></i>
            Schedule Overview
        </span>
        <span style="font-size:12px; color:var(--text-3); display:flex; align-items:center; gap:6px;">
            <i class="fa-regular fa-calendar"></i>
            {{ $jadwals->total() }} active schedules
        </span>
    </div>

    {{-- Grid Cards Layout --}}
    <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(340px, 1fr)); gap:16px; padding:20px;">
        @forelse($jadwals as $jadwal)
            @php
                $buka   = \Carbon\Carbon::parse($jadwal->jam_buka);
                $tutup  = \Carbon\Carbon::parse($jadwal->jam_tutup);
                $durasi = $buka->diffInHours($tutup);
                $progress = ($buka->format('H') * 60 + $buka->format('i')) / 1440 * 100;
                
                // Warna berdasarkan status
                $statusColor = $jadwal->is_libur ? '#f97316' : '#00d98b'; // Orange untuk libur, Hijau untuk buka
                $statusColorDark = $jadwal->is_libur ? '#ef4444' : '#00d98bcc';
                $statusBg = $jadwal->is_libur ? 'rgba(249,115,22,0.1)' : 'rgba(0,217,139,0.1)';
                $statusBorder = $jadwal->is_libur ? 'rgba(249,115,22,0.3)' : 'rgba(0,217,139,0.3)';
                $glowColor = $jadwal->is_libur ? 'rgba(249,115,22,0.5)' : 'rgba(0,217,139,0.5)';
                $hoverBorderColor = $jadwal->is_libur ? 'rgba(249,115,22,0.4)' : 'rgba(0,217,139,0.4)';
                $hoverShadow = $jadwal->is_libur ? '0 12px 24px -8px rgba(249,115,22,0.2)' : '0 12px 24px -8px rgba(0,217,139,0.2)';
            @endphp

            <div class="schedule-card" style="
                background: linear-gradient(135deg, rgba(18,25,45,0.95) 0%, rgba(12,18,30,0.98) 100%);
                border-radius:20px;
                border:1px solid rgba(255,255,255,0.08);
                backdrop-filter: blur(10px);
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                position: relative;
                overflow: hidden;
                cursor: pointer;
            " onmouseover="this.style.transform='translateY(-4px)'; this.style.borderColor='{{ $hoverBorderColor }}'; this.style.boxShadow='{{ $hoverShadow }}'" onmouseout="this.style.transform='translateY(0)'; this.style.borderColor='rgba(255,255,255,0.08)'; this.style.boxShadow='none'">
                
                {{-- Gradient Accent Line --}}
                <div style="
                    position: absolute;
                    top:0;
                    left:0;
                    right:0;
                    height:3px;
                    background: linear-gradient(90deg, {{ $statusColor }}, {{ $statusColorDark }});
                "></div>

                <div style="padding:20px;">
                    {{-- Header with status --}}
                    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:16px;">
                        <div style="flex:1;">
                            <div style="display:flex; align-items:center; gap:8px; margin-bottom:6px;">
                                <div style="
                                    width:8px;
                                    height:8px;
                                    border-radius:50%;
                                    background: {{ $statusColor }};
                                    box-shadow: 0 0 8px {{ $glowColor }};
                                    animation: pulse 2s infinite;
                                "></div>
                                <span style="font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:1px; color:var(--text-3);">
                                    {{ $jadwal->is_libur ? 'CLOSED / LIBUR' : 'ACTIVE / BUKA' }}
                                </span>
                            </div>
                            <h3 style="font-size:18px; font-weight:800; color:var(--text); margin:0 0 4px 0;">
                                {{ $jadwal->fasilitas->nama ?? '-' }}
                            </h3>
                            <span style="font-size:11px; color:var(--text-3); background:{{ $statusBg }}; padding:4px 8px; border-radius:20px; display:inline-block; border:1px solid {{ $statusBorder }};">
                                <i class="fa-regular fa-building" style="margin-right:4px; color:{{ $statusColor }};"></i>
                                {{ ucfirst(str_replace('_', ' ', $jadwal->fasilitas->jenis ?? '')) }}
                            </span>
                        </div>
                        
                        {{-- Duration Circle --}}
                        <div style="
                            width:70px;
                            height:70px;
                            border-radius:50%;
                            background: radial-gradient(circle at 30% 30%, {{ $statusBg }}, transparent);
                            display:flex;
                            flex-direction:column;
                            align-items:center;
                            justify-content:center;
                            border:1px solid {{ $statusBorder }};
                        ">
                            <span style="font-size:20px; font-weight:800; color:{{ $statusColor }}; line-height:1;">{{ $durasi }}</span>
                            <span style="font-size:9px; color:var(--text-3);">hours</span>
                        </div>
                    </div>

                    {{-- Time Info --}}
                    <div style="
                        background:rgba(0,0,0,0.3);
                        border-radius:16px;
                        padding:14px;
                        margin:16px 0;
                        border:1px solid rgba(255,255,255,0.04);
                    ">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
                            <div style="text-align:center; flex:1;">
                                <div style="font-size:10px; color:var(--text-3); margin-bottom:6px;">
                                    <i class="fa-regular fa-clock"></i> BUKA
                                </div>
                                <div style="font-size:28px; font-weight:800; color:var(--text); font-family:monospace; letter-spacing:2px;">
                                    {{ $buka->format('H:i') }}
                                </div>
                            </div>
                            <div style="color:{{ $statusColor }}; font-size:20px; margin:0 8px;">
                                <i class="fa-solid fa-arrow-right-long"></i>
                            </div>
                            <div style="text-align:center; flex:1;">
                                <div style="font-size:10px; color:var(--text-3); margin-bottom:6px;">
                                    <i class="fa-regular fa-clock"></i> TUTUP
                                </div>
                                <div style="font-size:28px; font-weight:800; color:var(--text); font-family:monospace; letter-spacing:2px;">
                                    {{ $tutup->format('H:i') }}
                                </div>
                            </div>
                        </div>
                        
                        {{-- Time Progress Bar --}}
                        <div style="margin-top:8px;">
                            <div style="display:flex; justify-content:space-between; font-size:10px; color:var(--text-3); margin-bottom:4px;">
                                <span>00:00</span>
                                <span style="color:{{ $statusColor }};">Now</span>
                                <span>24:00</span>
                            </div>
                            <div style="height:4px; background:rgba(255,255,255,0.05); border-radius:10px; overflow:hidden;">
                                <div style="
                                    width: {{ $progress }}%;
                                    height:100%;
                                    background: linear-gradient(90deg, {{ $statusColor }}, {{ $statusColorDark }});
                                    border-radius:10px;
                                "></div>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div style="display:flex; gap:10px; margin-top:16px;">
                        @if($jadwal->is_libur)
                            {{-- Button untuk libur -> buka (WARNA HIJAU) --}}
                            <form action="{{ route('admin.jadwal.toggle', $jadwal->id) }}" method="POST" style="flex:1;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" style="
                                    width:100%;
                                    background: rgba(0,217,139,0.1);
                                    border: 1px solid rgba(0,217,139,0.3);
                                    border-radius:40px;
                                    padding:10px;
                                    font-size:12px;
                                    font-weight:600;
                                    color: #00d98b;
                                    cursor:pointer;
                                    transition:all 0.2s;
                                    display:flex;
                                    align-items:center;
                                    justify-content:center;
                                    gap:6px;
                                " onmouseover="this.style.transform='scale(1.02)'; this.style.background='rgba(0,217,139,0.2)'" onmouseout="this.style.transform='scale(1)'; this.style.background='rgba(0,217,139,0.1)'">
                                    <i class="fa-solid fa-door-open"></i>
                                    Buka Sekarang
                                </button>
                            </form>
                        @else
                            {{-- Button untuk buka -> libur (WARNA MERAH/ORANGE) --}}
                            <form action="{{ route('admin.jadwal.toggle', $jadwal->id) }}" method="POST" style="flex:1;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" style="
                                    width:100%;
                                    background: rgba(239,68,68,0.1);
                                    border: 1px solid rgba(239,68,68,0.3);
                                    border-radius:40px;
                                    padding:10px;
                                    font-size:12px;
                                    font-weight:600;
                                    color: #ef4444;
                                    cursor:pointer;
                                    transition:all 0.2s;
                                    display:flex;
                                    align-items:center;
                                    justify-content:center;
                                    gap:6px;
                                " onmouseover="this.style.transform='scale(1.02)'; this.style.background='rgba(239,68,68,0.2)'" onmouseout="this.style.transform='scale(1)'; this.style.background='rgba(239,68,68,0.1)'">
                                    <i class="fa-solid fa-moon"></i>
                                    Tutup / Libur
                                </button>
                            </form>
                        @endif

                        <div style="display:flex; gap:6px;">
                            <a href="{{ route('admin.jadwal.edit', $jadwal->id) }}" style="
                                width:38px;
                                height:38px;
                                display:flex;
                                align-items:center;
                                justify-content:center;
                                background:rgba(255,255,255,0.03);
                                border:1px solid rgba(255,255,255,0.1);
                                border-radius:12px;
                                color:var(--text-2);
                                transition:all 0.2s;
                            " onmouseover="this.style.background='{{ $statusBg }}'; this.style.borderColor='{{ $statusColor }}'; this.style.color='{{ $statusColor }}'" onmouseout="this.style.background='rgba(255,255,255,0.03)'; this.style.borderColor='rgba(255,255,255,0.1)'; this.style.color='var(--text-2)'">
                                <i class="fa-solid fa-pen" style="font-size:12px;"></i>
                            </a>

                            <form action="{{ route('admin.jadwal.destroy', $jadwal->id) }}" method="POST" onsubmit="return confirm('Yakin hapus jadwal {{ $jadwal->fasilitas->nama ?? '' }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="
                                    width:38px;
                                    height:38px;
                                    display:flex;
                                    align-items:center;
                                    justify-content:center;
                                    background:rgba(255,255,255,0.03);
                                    border:1px solid rgba(255,255,255,0.1);
                                    border-radius:12px;
                                    color:#f87171;
                                    transition:all 0.2s;
                                    cursor:pointer;
                                " onmouseover="this.style.background='rgba(239,68,68,0.2)'; this.style.borderColor='#ef4444'" onmouseout="this.style.background='rgba(255,255,255,0.03)'; this.style.borderColor='rgba(255,255,255,0.1)'">
                                    <i class="fa-solid fa-trash" style="font-size:12px;"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div style="grid-column:1/-1; text-align:center; padding:60px 20px;">
                <div style="font-size:48px; margin-bottom:16px; opacity:0.3;">
                    <i class="fa-regular fa-calendar-xmark"></i>
                </div>
                <h3 style="font-size:18px; color:var(--text); margin-bottom:8px;">No schedules found</h3>
                <p style="font-size:13px; color:var(--text-3);">Belum ada data jadwal yang tersedia</p>
                <a href="{{ route('admin.jadwal.create') }}" class="btn btn-green btn-sm" style="margin-top:16px; background:#00d98b; border-color:#00d98b;">
                    <i class="fa-solid fa-plus"></i> Tambah Jadwal Pertama
                </a>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($jadwals->hasPages())
        <div style="display:flex; justify-content:space-between; align-items:center;
            padding:16px 20px; border-top:1px solid rgba(255,255,255,0.06); background:rgba(0,0,0,0.2);">
            <span style="font-size:12px; color:var(--text-3);">
                <i class="fa-regular fa-eye"></i>
                Showing {{ $jadwals->firstItem() }}–{{ $jadwals->lastItem() }}
                of {{ $jadwals->total() }} schedules
            </span>
            {{ $jadwals->withQueryString()->links() }}
        </div>
    @endif
</div>

<style>
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.5;
        }
    }
    
    .schedule-card {
        animation: fadeInUp 0.5s ease-out;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

@endsection