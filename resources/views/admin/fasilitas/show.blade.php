@extends('layouts.admin')

@section('title', 'Detail Fasilitas')
@section('page-title', 'Detail Fasilitas')

@section('breadcrumb')
    <a href="{{ route('admin.fasilitas.index') }}" class="breadcrumb-item">Fasilitas</a>
    <span class="current">Detail</span>
@endsection

@section('content')
<style>
    :root {
        --accent: #00d98b;
        --accent-glow: rgba(0, 217, 139, 0.3);
        --glass-bg: rgba(15, 23, 42, 0.6);
        --glass-border: rgba(255, 255, 255, 0.08);
    }

    @keyframes revealCard {
        0% { opacity: 0; transform: translateY(30px); filter: blur(10px); }
        100% { opacity: 1; transform: translateY(0); filter: blur(0); }
    }

    .detail-card {
        background: linear-gradient(145deg, rgba(18, 25, 45, 0.8), rgba(10, 15, 26, 0.95)) !important;
        border: 1px solid var(--glass-border) !important;
        backdrop-filter: blur(20px);
        border-radius: 32px !important;
        overflow: hidden;
        animation: revealCard 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }

    .info-label {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: rgba(255, 255, 255, 0.4);
        margin-bottom: 6px;
        font-weight: 700;
    }

    .glass-pill {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--glass-border);
        padding: 15px 20px;
        border-radius: 20px;
        transition: 0.3s;
    }

    .schedule-box {
        background: rgba(0, 0, 0, 0.2);
        border: 1px solid var(--glass-border);
        border-radius: 24px;
        padding: 30px;
        position: relative;
    }

    .status-badge {
        padding: 6px 14px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .dot-pulse {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.6); opacity: 0.4; }
        100% { transform: scale(1); opacity: 1; }
    }
</style>

<div class="detail-card" style="max-width: 1100px; margin: 0 auto;">
    {{-- Header Action Bar --}}
    <div style="padding: 25px 35px; border-bottom: 1px solid var(--glass-border); display: flex; justify-content: space-between; align-items: center;">
        <div style="display: flex; align-items: center; gap: 15px;">
            <div style="width: 45px; height: 45px; background: var(--accent)15; border-radius: 14px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--accent)30;">
                @php
                    $jenisIcon = match($fasilitas->jenis) {
                        'lapangan' => 'fa-futbol',
                        'ruang_multimedia' => 'fa-tv',
                        'lab' => 'fa-flask',
                        default => 'fa-building'
                    };
                @endphp
                <i class="fa-solid {{ $jenisIcon }}" style="color: var(--accent); font-size: 20px;"></i>
            </div>
            <div>
                <span class="info-label" style="margin: 0; display: block; line-height: 1;">Asset Detail</span>
                <span style="font-weight: 800; color: white; font-size: 14px;">{{ strtoupper($fasilitas->jenis) }}</span>
            </div>
        </div>
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('admin.fasilitas.edit', $fasilitas->id) }}" class="btn" style="background: rgba(255,255,255,0.05); color: white; border-radius: 14px; border: 1px solid var(--glass-border); padding: 10px 20px; font-weight: 600;">
                <i class="fa-solid fa-pen-to-square me-2"></i> Edit
            </a>
            <a href="{{ route('admin.fasilitas.index') }}" class="btn" style="background: rgba(255,255,255,0.05); color: white; border-radius: 14px; border: 1px solid var(--glass-border); padding: 10px 20px; font-weight: 600;">
                <i class="fa-solid fa-arrow-left me-2"></i> Kembali
            </a>
        </div>
    </div>

    <div style="padding: 45px;">
        <div style="display: grid; grid-template-columns: 350px 1fr; gap: 50px;">

            {{-- Media & Stats Section --}}
            <div style="display: flex; flex-direction: column; gap: 25px;">
                <div style="position: relative;">
                    @if($fasilitas->foto)
                        <img src="{{ Storage::url($fasilitas->foto) }}" alt="{{ $fasilitas->nama }}"
                            style="width: 100%; aspect-ratio: 1/1; object-fit: cover; border-radius: 28px; border: 1px solid var(--glass-border); box-shadow: 0 20px 40px rgba(0,0,0,0.4);">
                    @else
                        <div style="width: 100%; aspect-ratio: 1/1; background: rgba(0,0,0,0.3); border-radius: 28px; display: flex; flex-direction: column; align-items: center; justify-content: center; border: 2px dashed var(--glass-border);">
                            <i class="fa-solid fa-image" style="font-size: 50px; color: rgba(255,255,255,0.05); margin-bottom: 15px;"></i>
                            <span style="color: rgba(255,255,255,0.2); font-size: 12px; font-weight: 600;">NO IMAGE FOUND</span>
                        </div>
                    @endif
                </div>

                <div class="glass-pill" style="display: flex; align-items: center; justify-content: space-between;">
                    <span class="info-label" style="margin:0;">Database Status</span>
                    <span style="font-weight: 800; color: {{ $fasilitas->status == 'aktif' ? 'var(--accent)' : '#6b7280' }}; font-size: 12px; text-transform: uppercase;">
                        {{ $fasilitas->status }}
                    </span>
                </div>

                {{-- Okupansi Simulation (Match dengan Index) --}}
                <div style="background:rgba(0,0,0,0.2); border-radius:20px; padding:20px; border:1px solid var(--glass-border);">
                    <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
                        <span class="info-label" style="margin:0;">Tingkat Okupansi</span>
                        <span style="font-size:11px; font-weight:700; color:var(--accent);">{{ rand(60,95) }}%</span>
                    </div>
                    <div style="height:6px; background:rgba(255,255,255,0.05); border-radius:10px; overflow:hidden;">
                        <div style="width: {{ rand(60,95) }}%; height:100%; background: linear-gradient(90deg, var(--accent), #00ffaa); border-radius:10px; box-shadow: 0 0 15px var(--accent-glow);"></div>
                    </div>
                </div>
            </div>

            {{-- Content Section --}}
            <div style="display: flex; flex-direction: column; gap: 35px;">
                <div>
                    <h1 style="font-size: 48px; font-weight: 900; color: white; margin: 0; letter-spacing: -2px; line-height: 1;">
                        {{ $fasilitas->nama }}
                    </h1>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="glass-pill">
                        <div class="info-label">Harga Sewa</div>
                        <div style="font-size: 26px; font-weight: 800; color: var(--accent);">
                            Rp{{ number_format($fasilitas->harga_per_jam, 0, ',', '.') }}<span style="font-size: 14px; color: rgba(255,255,255,0.3); font-weight: 400;"> / Jam</span>
                        </div>
                    </div>
                    <div class="glass-pill">
                        <div class="info-label">Kapasitas Maks.</div>
                        <div style="font-size: 26px; font-weight: 800; color: white;">
                            {{ $fasilitas->kapasitas ?? 'N/A' }} <span style="font-size: 14px; color: rgba(255,255,255,0.3); font-weight: 400;">Orang</span>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="info-label">Deskripsi</div>
                    <div style="background: rgba(255,255,255,0.02); padding: 25px; border-radius: 24px; border: 1px solid var(--glass-border); line-height: 1.8; color: rgba(255,255,255,0.6); font-size: 15px;">
                        {{ $fasilitas->deskripsi ?: 'Tidak ada deskripsi tambahan untuk fasilitas ini.' }}
                    </div>
                </div>

                {{-- Operational Schedule (Match dengan Tabel) --}}
                <div>
                    <div class="info-label" style="margin-bottom: 15px;">Jadwal Operasional</div>
                    @if($fasilitas->jadwal)
                        <div class="schedule-box">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <div style="display: flex; align-items: center; gap: 40px;">
                                    <div>
                                        <div class="info-label">Open</div>
                                        <div style="font-size: 32px; font-weight: 900; color: white;">
                                            {{ $fasilitas->jadwal->jam_buka->format('H:i') }}
                                        </div>
                                    </div>
                                    <div style="width: 50px; height: 2px; background: rgba(255,255,255,0.1); position: relative;">
                                        <i class="fa-solid fa-chevron-right" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: var(--accent); font-size: 10px;"></i>
                                    </div>
                                    <div>
                                        <div class="info-label">Close</div>
                                        <div style="font-size: 32px; font-weight: 900; color: white;">
                                            {{ $fasilitas->jadwal->jam_tutup->format('H:i') }}
                                        </div>
                                    </div>
                                </div>

                                <div style="text-align: right;">
                                    <div class="status-badge" style="background: {{ $fasilitas->jadwal->status_color }}20; color: {{ $fasilitas->jadwal->status_color }}; border: 1px solid {{ $fasilitas->jadwal->status_color }}40;">
                                        <div class="dot-pulse" style="background: {{ $fasilitas->jadwal->status_color }}; box-shadow: 0 0 10px {{ $fasilitas->jadwal->status_color }};"></div>
                                        {{ $fasilitas->jadwal->status_label }}
                                    </div>
                                    <div style="font-size: 10px; color: rgba(255,255,255,0.2); margin-top: 10px; font-weight: 600; text-transform: uppercase;">
                                        System Time: {{ now('Asia/Jakarta')->format('H:i') }} WIB
                                    </div>
                                </div>
                            </div>

                            @if($fasilitas->jadwal->is_libur)
                                <div style="margin-top: 20px; padding: 12px 20px; background: rgba(239, 68, 68, 0.1); border-radius: 14px; border: 1px solid rgba(239, 68, 68, 0.2); color: #f87171; font-size: 13px; font-weight: 600; display: flex; align-items: center; gap: 10px;">
                                    <i class="fa-solid fa-calendar-xmark"></i>
                                    Fasilitas sedang diliburkan sementara.
                                </div>
                            @endif
                        </div>
                    @else
                        <div style="text-align: center; padding: 40px; background: rgba(255,255,255,0.02); border-radius: 24px; border: 1px dashed var(--glass-border);">
                            <i class="fa-regular fa-calendar-plus" style="font-size: 30px; color: rgba(255,255,255,0.05); margin-bottom: 15px; display: block;"></i>
                            <a href="{{ route('admin.jadwal.create', ['fasilitas_id' => $fasilitas->id]) }}" style="color: var(--accent); font-weight: 700; text-decoration: none;">
                                <i class="fa-solid fa-plus me-1"></i> Atur Jadwal Sekarang
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Footer Metadata --}}
        <div style="margin-top: 50px; padding-top: 30px; border-top: 1px solid var(--glass-border); display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; gap: 30px;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <i class="fa-regular fa-calendar" style="color: rgba(255,255,255,0.2); font-size: 12px;"></i>
                    <span style="font-size: 12px; color: rgba(255,255,255,0.4); font-weight: 600;">TERDAFTAR: {{ $fasilitas->created_at->format('d M Y') }}</span>
                </div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <i class="fa-regular fa-clock" style="color: rgba(255,255,255,0.2); font-size: 12px;"></i>
                    <span style="font-size: 12px; color: rgba(255,255,255,0.4); font-weight: 600;">UPDATE: {{ $fasilitas->updated_at->diffForHumans() }}</span>
                </div>
            </div>
            <div style="font-size: 11px; color: rgba(255,255,255,0.15); font-weight: 800; letter-spacing: 2px;">
                ID: {{ strtoupper(substr($fasilitas->id, 0, 13)) }}
            </div>
        </div>
    </div>
</div>
@endsection
