@extends('layouts.admin')

@section('title', 'Detail Fasilitas')
@section('page-title', 'Detail Fasilitas')

@section('breadcrumb')
    <a href="{{ route('admin.fasilitas.index') }}" class="breadcrumb-item">Fasilitas</a>
    <span class="current">Detail</span>
@endsection

@section('content')
<div class="card" style="max-width: 900px; margin: 0 auto;">
    <div class="card-header">
        <span class="card-title">
            <i class="fa-solid fa-info-circle" style="margin-right: 8px; color: #00d98b;"></i>
            Detail Fasilitas
        </span>
        <div style="display: flex; gap: 8px;">
            <a href="{{ route('admin.fasilitas.edit', $fasilitas->id) }}" class="btn btn-outline btn-sm">
                <i class="fa-solid fa-pen"></i> Edit
            </a>
            <a href="{{ route('admin.fasilitas.index') }}" class="btn btn-outline btn-sm">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
    
    <div style="padding: 24px;">
        <div style="display: grid; grid-template-columns: auto 1fr; gap: 24px;">
            {{-- Foto --}}
            <div style="text-align: center;">
                @if($fasilitas->foto)
                    <img src="{{ Storage::url($fasilitas->foto) }}" alt="{{ $fasilitas->nama }}"
                        style="width: 200px; height: 200px; object-fit: cover; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1);">
                @else
                    <div style="width: 200px; height: 200px; background: rgba(255,255,255,0.05); border-radius: 16px; 
                        display: flex; align-items: center; justify-content: center; border: 1px solid rgba(255,255,255,0.1);">
                        <i class="fa-solid fa-building" style="font-size: 64px; color: var(--text-3);"></i>
                    </div>
                @endif
            </div>
            
            {{-- Info --}}
            <div>
                <h2 style="font-size: 24px; font-weight: 800; color: var(--text); margin-bottom: 8px;">
                    {{ $fasilitas->nama }}
                </h2>
                
                <div style="display: flex; gap: 8px; margin-bottom: 16px;">
                    <span class="badge {{ $fasilitas->jenis == 'lapangan' ? 'badge-blue' : ($fasilitas->jenis == 'lab' ? 'badge-gray' : 'badge-yellow') }}">
                        {{ ucfirst(str_replace('_', ' ', $fasilitas->jenis)) }}
                    </span>
                    <span class="badge {{ $fasilitas->status == 'aktif' ? 'badge-green' : 'badge-red' }}">
                        {{ $fasilitas->status == 'aktif' ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
                
                <div style="margin-bottom: 16px;">
                    <div style="font-size: 28px; font-weight: 800; color: #00d98b;">
                        Rp{{ number_format($fasilitas->harga_per_jam, 0, ',', '.') }}
                    </div>
                    <div style="font-size: 12px; color: var(--text-3);">per jam</div>
                </div>
                
                @if($fasilitas->kapasitas)
                    <div style="margin-bottom: 16px;">
                        <div style="font-size: 13px; color: var(--text-2);">
                            <i class="fa-regular fa-user"></i> Kapasitas: {{ $fasilitas->kapasitas }} orang
                        </div>
                    </div>
                @endif
                
                @if($fasilitas->deskripsi)
                    <div style="margin-bottom: 16px;">
                        <div style="font-size: 13px; font-weight: 600; color: var(--text); margin-bottom: 6px;">Deskripsi:</div>
                        <p style="font-size: 13px; color: var(--text-2); line-height: 1.6;">{{ $fasilitas->deskripsi }}</p>
                    </div>
                @endif
            </div>
        </div>
        
        {{-- Jadwal Operasional --}}
        <div style="margin-top: 24px; border-top: 1px solid rgba(255,255,255,0.06); padding-top: 20px;">
            <h3 style="font-size: 16px; font-weight: 700; color: var(--text); margin-bottom: 12px;">
                <i class="fa-regular fa-clock" style="color: #00d98b;"></i> Jadwal Operasional
            </h3>
            
            @if($fasilitas->jadwal)
                <div style="background: rgba(0,0,0,0.3); border-radius: 12px; padding: 16px;">
                    <div style="display: flex; align-items: center; gap: 16px; flex-wrap: wrap;">
                        <div style="text-align: center;">
                            <div style="font-size: 11px; color: var(--text-3);">Jam Buka</div>
                            <div style="font-size: 20px; font-weight: 700; color: var(--text);">{{ \Carbon\Carbon::parse($fasilitas->jadwal->jam_buka)->format('H:i') }}</div>
                        </div>
                        <i class="fa-solid fa-arrow-right-long" style="color: #00d98b;"></i>
                        <div style="text-align: center;">
                            <div style="font-size: 11px; color: var(--text-3);">Jam Tutup</div>
                            <div style="font-size: 20px; font-weight: 700; color: var(--text);">{{ \Carbon\Carbon::parse($fasilitas->jadwal->jam_tutup)->format('H:i') }}</div>
                        </div>
                        <div style="margin-left: auto;">
                            @if($fasilitas->jadwal->is_libur)
                                <span class="badge badge-red">🔴 Sedang Libur</span>
                            @else
                                <span class="badge badge-green">🟢 Beroperasi</span>
                            @endif
                        </div>
                    </div>
                </div>
            @else
                <div style="text-align: center; padding: 32px; background: rgba(0,0,0,0.2); border-radius: 12px;">
                    <i class="fa-regular fa-calendar-xmark" style="font-size: 32px; color: var(--text-3); margin-bottom: 8px;"></i>
                    <p style="font-size: 13px; color: var(--text-3);">Belum ada jadwal operasional</p>
                    <a href="{{ route('admin.jadwal.create', ['fasilitas_id' => $fasilitas->id]) }}" class="btn btn-green btn-sm" style="background: #00d98b; color: #000;">
                        <i class="fa-solid fa-plus"></i> Tambah Jadwal
                    </a>
                </div>
            @endif
        </div>
        
        {{-- Informasi Tambahan --}}
        <div style="margin-top: 20px; display: flex; gap: 16px; justify-content: flex-end; border-top: 1px solid rgba(255,255,255,0.06); padding-top: 20px;">
            <div style="font-size: 11px; color: var(--text-3);">
                <i class="fa-regular fa-calendar"></i> Dibuat: {{ $fasilitas->created_at->format('d/m/Y H:i') }}
            </div>
            <div style="font-size: 11px; color: var(--text-3);">
                <i class="fa-regular fa-clock"></i> Diupdate: {{ $fasilitas->updated_at->format('d/m/Y H:i') }}
            </div>
        </div>
    </div>
</div>
@endsection