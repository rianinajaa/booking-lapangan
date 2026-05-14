@extends('layouts.admin')

@section('title', 'Tambah Fasilitas')
@section('page-title', 'Tambah Fasilitas')

@section('breadcrumb')
    <a href="{{ route('admin.fasilitas.index') }}" class="breadcrumb-item">Fasilitas</a>
    <span class="current">Tambah</span>
@endsection

@section('content')
<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div class="card-header">
        <span class="card-title">
            <i class="fa-solid fa-plus-circle" style="margin-right: 8px; color: #00d98b;"></i>
            Form Tambah Fasilitas
        </span>
    </div>
    
    <div style="padding: 24px;">
        <form action="{{ route('admin.fasilitas.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            {{-- Nama Fasilitas --}}
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text); margin-bottom: 6px;">
                    Nama Fasilitas <span style="color: #ef4444;">*</span>
                </label>
                <input type="text" name="nama" value="{{ old('nama') }}" required
                    style="width: 100%; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); 
                        border-radius: 10px; padding: 10px 14px; font-size: 14px; color: var(--text);">
                @error('nama')
                    <div style="color: #f87171; font-size: 11px; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>
            
            {{-- Jenis Fasilitas --}}
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text); margin-bottom: 6px;">
                    Jenis Fasilitas <span style="color: #ef4444;">*</span>
                </label>
                <select name="jenis" required
                    style="width: 100%; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); 
                        border-radius: 10px; padding: 10px 14px; font-size: 14px; color: var(--text);">
                    <option value="">Pilih Jenis</option>
                    <option value="lapangan" {{ old('jenis') == 'lapangan' ? 'selected' : '' }}>🏟️ Lapangan</option>
                    <option value="ruang_multimedia" {{ old('jenis') == 'ruang_multimedia' ? 'selected' : '' }}>📺 Ruang Multimedia</option>
                    <option value="lab" {{ old('jenis') == 'lab' ? 'selected' : '' }}>🔬 Lab</option>
                </select>
                @error('jenis')
                    <div style="color: #f87171; font-size: 11px; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>
            
            {{-- Harga per Jam --}}
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text); margin-bottom: 6px;">
                    Harga per Jam <span style="color: #ef4444;">*</span>
                </label>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span style="color: var(--text-2); font-weight: 600;">Rp</span>
                    <input type="number" name="harga_per_jam" value="{{ old('harga_per_jam') }}" required
                        min="0" step="5000"
                        style="flex: 1; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); 
                            border-radius: 10px; padding: 10px 14px; font-size: 14px; color: var(--text);">
                </div>
                @error('harga_per_jam')
                    <div style="color: #f87171; font-size: 11px; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>
            
            {{-- Kapasitas (Optional) --}}
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text); margin-bottom: 6px;">
                    Kapasitas (Opsional)
                </label>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <i class="fa-regular fa-user" style="color: var(--text-3);"></i>
                    <input type="number" name="kapasitas" value="{{ old('kapasitas') }}" 
                        min="1"
                        placeholder="Jumlah maksimal orang"
                        style="flex: 1; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); 
                            border-radius: 10px; padding: 10px 14px; font-size: 14px; color: var(--text);">
                </div>
                <div style="font-size: 11px; color: var(--text-3); margin-top: 4px;">
                    <i class="fa-regular fa-info-circle"></i> Isi jika fasilitas memiliki batasan kapasitas
                </div>
                @error('kapasitas')
                    <div style="color: #f87171; font-size: 11px; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>
            
            {{-- Foto Fasilitas --}}
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text); margin-bottom: 6px;">
                    Foto Fasilitas
                </label>
                <div style="border: 2px dashed rgba(255,255,255,0.15); border-radius: 12px; padding: 20px; text-align: center; cursor: pointer;"
                    onclick="document.getElementById('fotoInput').click()">
                    <i class="fa-solid fa-cloud-upload-alt" style="font-size: 32px; color: #00d98b; margin-bottom: 8px;"></i>
                    <p style="font-size: 12px; color: var(--text-3); margin: 0;">
                        Klik untuk upload foto<br>
                        <span style="font-size: 10px;">Format: JPG, PNG (max 2MB)</span>
                    </p>
                </div>
                <input type="file" name="foto" id="fotoInput" style="display: none;" accept="image/*" onchange="previewImage(this)">
                <div id="imagePreview" style="margin-top: 12px; display: none;">
                    <img id="preview" style="max-width: 200px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.1);">
                </div>
                @error('foto')
                    <div style="color: #f87171; font-size: 11px; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>
            
            {{-- Deskripsi --}}
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text); margin-bottom: 6px;">
                    Deskripsi
                </label>
                <textarea name="deskripsi" rows="4"
                    style="width: 100%; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); 
                        border-radius: 10px; padding: 10px 14px; font-size: 14px; color: var(--text); resize: vertical;">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <div style="color: #f87171; font-size: 11px; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>
            
            {{-- Status --}}
            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text); margin-bottom: 6px;">
                    Status <span style="color: #ef4444;">*</span>
                </label>
                <div style="display: flex; gap: 16px;">
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="radio" name="status" value="aktif" {{ old('status', 'aktif') == 'aktif' ? 'checked' : '' }} 
                            style="accent-color: #00d98b;">
                        <span style="font-size: 13px; color: var(--text);">✅ Aktif</span>
                    </label>
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="radio" name="status" value="nonaktif" {{ old('status') == 'nonaktif' ? 'checked' : '' }}
                            style="accent-color: #ef4444;">
                        <span style="font-size: 13px; color: var(--text);">⛔ Nonaktif</span>
                    </label>
                </div>
                @error('status')
                    <div style="color: #f87171; font-size: 11px; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>
            
            {{-- Buttons --}}
            <div style="display: flex; gap: 12px; justify-content: flex-end; border-top: 1px solid rgba(255,255,255,0.06); padding-top: 20px;">
                <a href="{{ route('admin.fasilitas.index') }}" class="btn btn-outline btn-sm">
                    <i class="fa-solid fa-arrow-left"></i> Batal
                </a>
                <button type="submit" class="btn btn-green btn-sm" style="background: #00d98b; border-color: #00d98b; color: #000;">
                    <i class="fa-solid fa-save"></i> Simpan Fasilitas
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('preview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection