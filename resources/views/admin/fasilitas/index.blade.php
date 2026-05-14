@extends('layouts.admin')

@section('title', 'Kelola Fasilitas')
@section('page-title', 'Fasilitas')

@section('breadcrumb')
    <span class="current">Kelola Fasilitas</span>
@endsection

@section('content')

{{-- Header --}}
<div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:24px; flex-wrap:wrap; gap:12px;">
    <div>
        <h1 style="font-size:32px; font-weight:800; color:var(--text); line-height:1.2; margin-bottom:6px;">
            Kelola<br>Fasilitas
        </h1>
        <p style="font-size:13px; color:var(--text-3);">
            Manajemen lapangan dan fasilitas olahraga
        </p>
    </div>
    <a href="{{ route('admin.fasilitas.create') }}" class="btn btn-green btn-sm" style="background:#00d98b; border-color:#00d98b; color:#000; font-weight:600;">
        <i class="fa-solid fa-plus"></i> Tambah Fasilitas
    </a>
</div>

{{-- Alert --}}
@if(session('success'))
    <div style="background:rgba(0,217,139,0.1); border:1px solid rgba(0,217,139,0.25); color:#00d98b;
        border-radius:10px; padding:12px 16px; font-size:13px; margin-bottom:20px; display:flex; align-items:center; gap:8px;">
        <i class="fa-solid fa-circle-check"></i>
        {{ session('success') }}
    </div>
@endif

{{-- Filter Bar --}}
<div class="card" style="margin-bottom:24px; border:1px solid rgba(255,255,255,0.06);">
    <form method="GET" action="{{ route('admin.fasilitas.index') }}"
        style="display:flex; gap:10px; flex-wrap:wrap; padding:14px 18px; align-items:center;">
        <div style="flex:1; min-width:200px; position:relative;">
            <i class="fa-solid fa-magnifying-glass" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); font-size:12px; color:var(--text-3);"></i>
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari nama fasilitas..."
                style="width:100%; height:36px; background:rgba(255,255,255,0.05);
                    border:1px solid rgba(255,255,255,0.1); border-radius:8px;
                    padding:0 12px 0 32px; font-size:13px; color:var(--text);">
        </div>

        <select name="jenis"
            style="height:36px; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1);
                border-radius:8px; padding:0 24px 0 12px; font-size:13px; color:var(--text); min-width:150px;">
            <option value="">Semua Jenis</option>
            <option value="lapangan" {{ request('jenis') === 'lapangan' ? 'selected' : '' }}>🏟️ Lapangan</option>
            <option value="ruang_multimedia" {{ request('jenis') === 'ruang_multimedia' ? 'selected' : '' }}>📺 Ruang Multimedia</option>
            <option value="lab" {{ request('jenis') === 'lab' ? 'selected' : '' }}>🔬 Lab</option>
        </select>

        <select name="status"
            style="height:36px; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1);
                border-radius:8px; padding:0 24px 0 12px; font-size:13px; color:var(--text); min-width:130px;">
            <option value="">Semua Status</option>
            <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>✅ Aktif</option>
            <option value="nonaktif" {{ request('status') === 'nonaktif' ? 'selected' : '' }}>⛔ Nonaktif</option>
        </select>

        <button type="submit" class="btn btn-outline btn-sm">
            <i class="fa-solid fa-magnifying-glass"></i> Cari
        </button>
        @if(request('search') || request('jenis') || request('status'))
            <a href="{{ route('admin.fasilitas.index') }}" class="btn btn-outline btn-sm">
                <i class="fa-solid fa-xmark"></i> Reset
            </a>
        @endif
    </form>
</div>

{{-- Stats Ringkasan --}}
@php
    $totalFasilitas = $fasilitas->total();
    $totalLapangan = $fasilitas->where('jenis', 'lapangan')->count();
    $totalActive = $fasilitas->where('status', 'aktif')->count();
    $avgPrice = $fasilitas->avg('harga_per_jam') ?? 0;
@endphp

<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:16px; margin-bottom:24px;">
    <div style="background:rgba(255,255,255,0.02); border:1px solid rgba(255,255,255,0.06); border-radius:16px; padding:14px 16px;">
        <div style="display:flex; align-items:center; gap:10px;">
            <div style="width:40px; height:40px; background:rgba(0,217,139,0.1); border-radius:12px; display:flex; align-items:center; justify-content:center;">
                <i class="fa-solid fa-building" style="color:#00d98b; font-size:18px;"></i>
            </div>
            <div>
                <div style="font-size:22px; font-weight:800; color:var(--text);">{{ $totalFasilitas }}</div>
                <div style="font-size:11px; color:var(--text-3);">Total Fasilitas</div>
            </div>
        </div>
    </div>
    <div style="background:rgba(255,255,255,0.02); border:1px solid rgba(255,255,255,0.06); border-radius:16px; padding:14px 16px;">
        <div style="display:flex; align-items:center; gap:10px;">
            <div style="width:40px; height:40px; background:rgba(0,217,139,0.1); border-radius:12px; display:flex; align-items:center; justify-content:center;">
                <i class="fa-solid fa-futbol" style="color:#00d98b; font-size:18px;"></i>
            </div>
            <div>
                <div style="font-size:22px; font-weight:800; color:var(--text);">{{ $totalLapangan }}</div>
                <div style="font-size:11px; color:var(--text-3);">Lapangan</div>
            </div>
        </div>
    </div>
    <div style="background:rgba(255,255,255,0.02); border:1px solid rgba(255,255,255,0.06); border-radius:16px; padding:14px 16px;">
        <div style="display:flex; align-items:center; gap:10px;">
            <div style="width:40px; height:40px; background:rgba(0,217,139,0.1); border-radius:12px; display:flex; align-items:center; justify-content:center;">
                <i class="fa-solid fa-circle-check" style="color:#00d98b; font-size:18px;"></i>
            </div>
            <div>
                <div style="font-size:22px; font-weight:800; color:var(--text);">{{ $totalActive }}</div>
                <div style="font-size:11px; color:var(--text-3);">Aktif</div>
            </div>
        </div>
    </div>
    <div style="background:rgba(255,255,255,0.02); border:1px solid rgba(255,255,255,0.06); border-radius:16px; padding:14px 16px;">
        <div style="display:flex; align-items:center; gap:10px;">
            <div style="width:40px; height:40px; background:rgba(0,217,139,0.1); border-radius:12px; display:flex; align-items:center; justify-content:center;">
                <i class="fa-solid fa-tag" style="color:#00d98b; font-size:18px;"></i>
            </div>
            <div>
                <div style="font-size:22px; font-weight:800; color:var(--text);">Rp{{ number_format($avgPrice, 0, ',', '.') }}</div>
                <div style="font-size:11px; color:var(--text-3);">Rata-rata Harga</div>
            </div>
        </div>
    </div>
</div>

{{-- Grid Cards Layout --}}
<div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(360px, 1fr)); gap:20px;">
    @forelse($fasilitas as $f)
        @php
            // Simulasi data okupansi (bisa diganti dengan data real dari booking)
            $okupansi = rand(45, 98);
            $bookingBulanIni = rand(20, 85);
            $statusColor = $f->status === 'aktif' ? '#00d98b' : '#6b7280';
            $statusBg = $f->status === 'aktif' ? 'rgba(0,217,139,0.1)' : 'rgba(107,114,128,0.1)';
            
            // Icon berdasarkan jenis
            $jenisIcon = match($f->jenis) {
                'lapangan' => 'fa-futbol',
                'ruang_multimedia' => 'fa-tv',
                'lab' => 'fa-flask',
                default => 'fa-building'
            };
            
            $jenisLabel = match($f->jenis) {
                'lapangan' => 'Lapangan',
                'ruang_multimedia' => 'Multimedia',
                'lab' => 'Lab',
                default => ucfirst($f->jenis)
            };
        @endphp
        
        <div class="facility-card" style="
            background: linear-gradient(135deg, rgba(18,25,45,0.95) 0%, rgba(12,18,30,0.98) 100%);
            border-radius:20px;
            border:1px solid rgba(255,255,255,0.08);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        " onmouseover="this.style.transform='translateY(-4px)'; this.style.borderColor='rgba(0,217,139,0.4)'; this.style.boxShadow='0 12px 24px -8px rgba(0,217,139,0.2)'" onmouseout="this.style.transform='translateY(0)'; this.style.borderColor='rgba(255,255,255,0.08)'; this.style.boxShadow='none'">
            
            {{-- Status Badge --}}
            <div style="position:absolute; top:16px; right:16px; z-index:2;">
                <form action="{{ route('admin.fasilitas.toggle-status', $f->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" style="
                        background: {{ $statusBg }};
                        border:1px solid {{ $f->status === 'aktif' ? 'rgba(0,217,139,0.3)' : 'rgba(107,114,128,0.3)' }};
                        border-radius:20px;
                        padding:4px 10px;
                        font-size:10px;
                        font-weight:600;
                        color: {{ $statusColor }};
                        cursor:pointer;
                        transition:all 0.2s;
                    " onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                        {{ $f->status === 'aktif' ? '● AKTIF' : '○ NONAKTIF' }}
                    </button>
                </form>
            </div>
            
            {{-- Content --}}
            <div style="padding:20px;">
                {{-- Header with Image/Icon --}}
                <div style="display:flex; align-items:center; gap:14px; margin-bottom:16px;">
                    @if($f->foto)
                        <img src="{{ Storage::url($f->foto) }}" alt="{{ $f->nama }}"
                            style="width:56px; height:56px; border-radius:16px; object-fit:cover; border:1px solid rgba(255,255,255,0.1);">
                    @else
                        <div style="width:56px; height:56px; border-radius:16px; background:linear-gradient(135deg, rgba(0,217,139,0.15), rgba(0,217,139,0.05));
                            display:flex; align-items:center; justify-content:center; border:1px solid rgba(0,217,139,0.2);">
                            <i class="fa-solid {{ $jenisIcon }}" style="color:#00d98b; font-size:24px;"></i>
                        </div>
                    @endif
                    
                    <div style="flex:1;">
                        <h3 style="font-size:18px; font-weight:800; color:var(--text); margin:0 0 4px 0;">
                            {{ $f->nama }}
                        </h3>
                        <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                            <span style="font-size:11px; color:var(--text-3); background:rgba(255,255,255,0.05); padding:2px 8px; border-radius:12px;">
                                <i class="fa-regular fa-building"></i> {{ $jenisLabel }}
                            </span>
                            @if($f->kapasitas)
                                <span style="font-size:11px; color:var(--text-3); background:rgba(255,255,255,0.05); padding:2px 8px; border-radius:12px;">
                                    <i class="fa-regular fa-user"></i> Kapasitas {{ $f->kapasitas }} org
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                
                {{-- Deskripsi --}}
                @if($f->deskripsi)
                    <p style="font-size:12px; color:var(--text-2); line-height:1.5; margin-bottom:16px;">
                        {{ Str::limit($f->deskripsi, 80) }}
                    </p>
                @endif
                
                {{-- Harga --}}
                <div style="margin-bottom:16px;">
                    <span style="font-size:24px; font-weight:800; color:#00d98b;">
                        Rp{{ number_format($f->harga_per_jam, 0, ',', '.') }}
                    </span>
                    <span style="font-size:12px; color:var(--text-3);">/jam</span>
                </div>
                
                {{-- Okupansi & Booking (khusus lapangan) --}}
                @if($f->jenis === 'lapangan')
                <div style="background:rgba(0,0,0,0.3); border-radius:14px; padding:12px; margin-bottom:16px; border:1px solid rgba(255,255,255,0.04);">
                    <div style="display:flex; justify-content:space-between; margin-bottom:6px;">
                        <span style="font-size:11px; color:var(--text-3);">Tingkat Okupansi</span>
                        <span style="font-size:12px; font-weight:600; color:#00d98b;">{{ $okupansi }}%</span>
                    </div>
                    <div style="height:6px; background:rgba(255,255,255,0.05); border-radius:10px; overflow:hidden; margin-bottom:12px;">
                        <div style="width: {{ $okupansi }}%; height:100%; background: linear-gradient(90deg, #00d98b, #00d98bcc); border-radius:10px;"></div>
                    </div>
                    <div style="display:flex; justify-content:space-between;">
                        <span style="font-size:11px; color:var(--text-3);">
                            <i class="fa-regular fa-calendar"></i> {{ $bookingBulanIni }} booking bulan ini
                        </span>
                    </div>
                </div>
                @endif
                
                {{-- Jadwal Operasional --}}
                <div style="margin-bottom:16px;">
                    @if($f->jadwal)
                        <div style="display:flex; align-items:center; gap:8px; font-size:12px;">
                            <i class="fa-regular fa-clock" style="color:#00d98b;"></i>
                            <span style="color:var(--text-2);">
                                {{ \Carbon\Carbon::parse($f->jadwal->jam_buka)->format('H:i') }}
                                <i class="fa-solid fa-arrow-right-long" style="margin:0 6px; font-size:10px;"></i>
                                {{ \Carbon\Carbon::parse($f->jadwal->jam_tutup)->format('H:i') }}
                            </span>
                            @if($f->jadwal->is_libur)
                                <span style="background:rgba(239,68,68,0.15); color:#f87171; padding:2px 8px; border-radius:12px; font-size:9px; font-weight:600;">
                                    LIBUR
                                </span>
                            @else
                                <span style="background:rgba(0,217,139,0.15); color:#00d98b; padding:2px 8px; border-radius:12px; font-size:9px; font-weight:600;">
                                    BUKA
                                </span>
                            @endif
                        </div>
                    @else
                        <div style="font-size:11px; color:var(--text-3);">
                            <i class="fa-regular fa-clock"></i> Belum ada jadwal
                        </div>
                    @endif
                </div>
                
               {{-- Action Buttons --}}
<div style="display:flex; gap:10px; margin-top:8px;">
    {{-- Detail --}}
    <a href="{{ route('admin.fasilitas.show', $f) }}" style="
        flex:1;
        background:rgba(255,255,255,0.03);
        border:1px solid rgba(255,255,255,0.08);
        border-radius:12px;
        padding:8px;
        font-size:12px;
        font-weight:500;
        color:var(--text-2);
        text-align:center;
        text-decoration:none;
        transition:all 0.2s;
    " onmouseover="this.style.background='rgba(0,217,139,0.1)'; this.style.borderColor='rgba(0,217,139,0.3)'; this.style.color='#00d98b'" onmouseout="this.style.background='rgba(255,255,255,0.03)'; this.style.borderColor='rgba(255,255,255,0.08)'; this.style.color='var(--text-2)'">
        <i class="fa-regular fa-eye"></i> Detail
    </a>
    
    {{-- Edit --}}
    <a href="{{ route('admin.fasilitas.edit', $f) }}" style="
        background:rgba(255,255,255,0.03);
        border:1px solid rgba(255,255,255,0.08);
        border-radius:12px;
        padding:8px 12px;
        font-size:12px;
        font-weight:500;
        color:var(--text-2);
        text-decoration:none;
        transition:all 0.2s;
        display:inline-flex;
        align-items:center;
        gap:6px;
    " onmouseover="this.style.background='rgba(0,217,139,0.1)'; this.style.borderColor='rgba(0,217,139,0.3)'; this.style.color='#00d98b'" onmouseout="this.style.background='rgba(255,255,255,0.03)'; this.style.borderColor='rgba(255,255,255,0.08)'; this.style.color='var(--text-2)'">
        <i class="fa-regular fa-pen-to-square"></i> Edit
    </a>
    
    {{-- Jadwal --}}
    @if($f->jadwal)
        <a href="{{ route('admin.jadwal.edit', $f->jadwal->id) }}" style="
            background:rgba(0,217,139,0.1);
            border:1px solid rgba(0,217,139,0.3);
            border-radius:12px;
            padding:8px 12px;
            font-size:12px;
            font-weight:600;
            color:#00d98b;
            text-decoration:none;
            transition:all 0.2s;
            display:inline-flex;
            align-items:center;
            gap:6px;
        " onmouseover="this.style.background='rgba(0,217,139,0.2)'; this.style.transform='scale(1.02)'" onmouseout="this.style.background='rgba(0,217,139,0.1)'; this.style.transform='scale(1)'">
            <i class="fa-regular fa-calendar"></i> Jadwal
        </a>
    @else
        <a href="{{ route('admin.jadwal.create') }}?fasilitas_id={{ $f->id }}" style="
            background:rgba(255,255,255,0.03);
            border:1px solid rgba(255,255,255,0.08);
            border-radius:12px;
            padding:8px 12px;
            font-size:12px;
            font-weight:500;
            color:var(--text-3);
            text-decoration:none;
            transition:all 0.2s;
            display:inline-flex;
            align-items:center;
            gap:6px;
        " onmouseover="this.style.background='rgba(0,217,139,0.1)'; this.style.borderColor='rgba(0,217,139,0.3)'; this.style.color='#00d98b'" onmouseout="this.style.background='rgba(255,255,255,0.03)'; this.style.borderColor='rgba(255,255,255,0.08)'; this.style.color='var(--text-3)'">
            <i class="fa-regular fa-calendar-plus"></i> +Jadwal
        </a>
    @endif
    
    {{-- Delete --}}
    <form action="{{ route('admin.fasilitas.destroy', $f) }}" method="POST" onsubmit="return confirm('Yakin hapus fasilitas {{ $f->nama }}?')" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" style="
            background:rgba(239,68,68,0.1);
            border:1px solid rgba(239,68,68,0.3);
            border-radius:12px;
            padding:8px 12px;
            font-size:12px;
            color:#f87171;
            cursor:pointer;
            transition:all 0.2s;
        " onmouseover="this.style.background='rgba(239,68,68,0.2)'; this.style.transform='scale(1.02)'" onmouseout="this.style.background='rgba(239,68,68,0.1)'; this.style.transform='scale(1)'">
            <i class="fa-regular fa-trash-can"></i>
        </button>
    </form>
</div>
            </div>
        </div>
    @empty
        <div style="grid-column:1/-1; text-align:center; padding:60px 20px;">
            <div style="font-size:48px; margin-bottom:16px; opacity:0.3;">
                <i class="fa-solid fa-building-circle-xmark"></i>
            </div>
            <h3 style="font-size:18px; color:var(--text); margin-bottom:8px;">Belum ada fasilitas</h3>
            <p style="font-size:13px; color:var(--text-3);">Mulai dengan menambahkan fasilitas pertama Anda</p>
            <a href="{{ route('admin.fasilitas.create') }}" class="btn btn-green btn-sm" style="margin-top:16px; background:#00d98b; border-color:#00d98b; color:#000;">
                <i class="fa-solid fa-plus"></i> Tambah Fasilitas
            </a>
        </div>
    @endforelse
</div>

{{-- Pagination --}}
@if($fasilitas->hasPages())
    <div style="display:flex; justify-content:space-between; align-items:center; margin-top:24px;
        padding:16px 20px; background:rgba(255,255,255,0.02); border-radius:16px; border:1px solid rgba(255,255,255,0.06);">
        <span style="font-size:12px; color:var(--text-3);">
            <i class="fa-regular fa-eye"></i>
            Menampilkan {{ $fasilitas->firstItem() }}–{{ $fasilitas->lastItem() }}
            dari {{ $fasilitas->total() }} data
        </span>
        {{ $fasilitas->withQueryString()->links() }}
    </div>
@endif

<style>
    .facility-card {
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