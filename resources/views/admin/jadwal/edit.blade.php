@extends('layouts.admin')

@section('title', 'Edit Jadwal')
@section('page-title', 'Edit Jadwal')

@section('breadcrumb')
    <a href="{{ route('admin.jadwal.index') }}" class="breadcrumb-item">Jadwal</a>
    <span class="current">Edit</span>
@endsection

@section('content')
<div class="card" style="max-width: 600px; margin: 0 auto;">
    <div class="card-header">
        <span class="card-title">
            <i class="fa-regular fa-calendar-pen" style="margin-right: 8px; color: #00d98b;"></i>
            Form Edit Jadwal: {{ $jadwal->fasilitas->nama ?? '-' }}
        </span>
    </div>
    
    <div style="padding: 24px;">
        <form action="{{ route('admin.jadwal.update', ['jadwal' => $jadwal->id]) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Pilih Fasilitas --}}
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text); margin-bottom: 6px;">
                    Fasilitas <span style="color: #ef4444;">*</span>
                </label>
                <select name="fasilitas_id" required
                    style="width: 100%; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); 
                        border-radius: 10px; padding: 10px 14px; font-size: 14px; color: var(--text);">
                    <option value="">Pilih Fasilitas</option>
                    @foreach($fasilitas as $f)
                        <option value="{{ $f->id }}" {{ old('fasilitas_id', $jadwal->fasilitas_id) == $f->id ? 'selected' : '' }}>
                            {{ $f->nama }} ({{ ucfirst(str_replace('_', ' ', $f->jenis)) }})
                        </option>
                    @endforeach
                </select>
                @error('fasilitas_id')
                    <div style="color: #f87171; font-size: 11px; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>

            {{-- Jam Buka & Jam Tutup --}}
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text); margin-bottom: 6px;">
                        Jam Buka <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="time" name="jam_buka" value="{{ old('jam_buka', $jadwal->jam_buka) }}" required
                        style="width: 100%; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); 
                            border-radius: 10px; padding: 10px 14px; font-size: 14px; color: var(--text);">
                    @error('jam_buka')
                        <div style="color: #f87171; font-size: 11px; margin-top: 4px;">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text); margin-bottom: 6px;">
                        Jam Tutup <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="time" name="jam_tutup" value="{{ old('jam_tutup', $jadwal->jam_tutup) }}" required
                        style="width: 100%; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); 
                            border-radius: 10px; padding: 10px 14px; font-size: 14px; color: var(--text);">
                    @error('jam_tutup')
                        <div style="color: #f87171; font-size: 11px; margin-top: 4px;">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Status Libur --}}
            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text); margin-bottom: 6px;">
                    Status Operasional
                </label>
                <div style="display: flex; gap: 16px;">
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="radio" name="is_libur" value="0" {{ old('is_libur', $jadwal->is_libur ? '0' : '1') == '0' ? 'checked' : '' }} 
                            style="accent-color: #00d98b;">
                        <span style="font-size: 13px; color: var(--text);">🟢 Buka / Beroperasi</span>
                    </label>
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="radio" name="is_libur" value="1" {{ old('is_libur', $jadwal->is_libur ? '1' : '0') == '1' ? 'checked' : '' }}
                            style="accent-color: #f97316;">
                        <span style="font-size: 13px; color: var(--text);">🔴 Libur / Tutup</span>
                    </label>
                </div>
                @error('is_libur')
                    <div style="color: #f87171; font-size: 11px; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>

            {{-- Informasi Durasi --}}
            @php
                $buka = \Carbon\Carbon::parse($jadwal->jam_buka);
                $tutup = \Carbon\Carbon::parse($jadwal->jam_tutup);
                $durasi = $buka->diffInHours($tutup);
            @endphp
            <div style="margin-bottom: 24px; padding: 12px; background: rgba(0,217,139,0.05); border-radius: 10px; border: 1px solid rgba(0,217,139,0.15);">
                <div style="font-size: 12px; color: var(--text-3);">
                    <i class="fa-regular fa-hourglass-half"></i> Durasi operasional saat ini: 
                    <strong style="color: #00d98b;">{{ $durasi }} jam</strong>
                </div>
            </div>

            {{-- Buttons --}}
            <div style="display: flex; gap: 12px; justify-content: flex-end; border-top: 1px solid rgba(255,255,255,0.06); padding-top: 20px;">
                <a href="{{ route('admin.jadwal.index') }}" class="btn btn-outline btn-sm">
                    <i class="fa-solid fa-arrow-left"></i> Batal
                </a>
                <button type="submit" class="btn btn-green btn-sm" style="background: #00d98b; border-color: #00d98b; color: #000;">
                    <i class="fa-solid fa-save"></i> Update Jadwal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection