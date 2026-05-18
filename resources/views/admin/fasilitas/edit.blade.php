@extends('layouts.admin')

@section('title', 'Edit Fasilitas')
@section('page-title', 'Edit Fasilitas')

@section('breadcrumb')
    <a href="{{ route('admin.fasilitas.index') }}" class="breadcrumb-item">Fasilitas</a>
    <span class="current">Edit</span>
@endsection

@section('content')
<style>
    :root {
        --accent: #00d98b;
        --accent-glow: rgba(0, 217, 139, 0.2);
        --glass-bg: rgba(15, 23, 42, 0.8);
        --glass-border: rgba(255, 255, 255, 0.08);
    }

    .glass-card {
        background: var(--glass-bg) !important;
        backdrop-filter: blur(20px);
        border: 1px solid var(--glass-border) !important;
        border-radius: 32px !important;
        overflow: hidden;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        animation: reveal 0.6s cubic-bezier(0.2, 0.8, 0.2, 1);
    }

    @keyframes reveal {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .form-label {
        display: block;
        font-size: 11px;
        font-weight: 800;
        color: var(--accent);
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin-bottom: 10px;
        padding-left: 4px;
    }

    .glass-input, .glass-select, .glass-textarea {
        width: 100%;
        background: rgba(0, 0, 0, 0.2) !important;
        border: 1px solid var(--glass-border) !important;
        border-radius: 16px !important;
        padding: 14px 18px !important;
        color: white !important;
        font-size: 15px;
        transition: all 0.3s ease;
    }

    .glass-input:focus, .glass-select:focus, .glass-textarea:focus {
        border-color: var(--accent) !important;
        background: rgba(0, 217, 139, 0.05) !important;
        box-shadow: 0 0 15px var(--accent-glow);
        outline: none;
    }

    .upload-zone {
        border: 2px dashed var(--glass-border);
        border-radius: 20px;
        padding: 20px;
        text-align: center;
        transition: all 0.3s ease;
        background: rgba(255,255,255,0.02);
        cursor: pointer;
    }

    .upload-zone:hover {
        border-color: var(--accent);
        background: rgba(0, 217, 139, 0.05);
    }

    .input-addon {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-addon i {
        position: absolute;
        left: 18px;
        color: var(--accent);
        opacity: 0.7;
    }

    .input-addon input, .input-addon select {
        padding-left: 45px !important;
    }

    .status-pill-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .status-pill {
        background: rgba(255,255,255,0.03);
        border: 1px solid var(--glass-border);
        border-radius: 16px;
        padding: 14px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        color: #64748b;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    input[type="radio"]:checked + .status-pill.active {
        background: rgba(0, 217, 139, 0.1);
        border-color: var(--accent);
        color: var(--accent);
        box-shadow: 0 0 15px var(--accent-glow);
    }

    input[type="radio"]:checked + .status-pill.inactive {
        background: rgba(239, 68, 68, 0.1);
        border-color: #ef4444;
        color: #f87171;
        box-shadow: 0 0 15px rgba(239, 68, 68, 0.1);
    }

    .current-photo-label {
        font-size: 10px;
        color: #94a3b8;
        margin-bottom: 8px;
        display: block;
        text-align: center;
    }
</style>

<div class="glass-card" style="max-width: 850px; margin: 0 auto;">
    {{-- Header --}}
    <div style="background: linear-gradient(to right, rgba(0, 217, 139, 0.12), transparent); padding: 40px 40px 30px;">
        <h2 style="color: white; font-size: 26px; font-weight: 800; margin: 0; letter-spacing: -0.5px;">
            Edit <span style="color: var(--accent);">{{ $fasilitas->nama }}</span>
        </h2>
        <p style="color: #94a3b8; font-size: 14px; margin-top: 8px;">Perbarui informasi atau status ketersediaan fasilitas ini.</p>
    </div>

    <div style="padding: 0 40px 40px;">
        <form action="{{ route('admin.fasilitas.update', $fasilitas->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div style="display: grid; grid-template-columns: 1.2fr 1fr; gap: 30px;">
                {{-- Kolom Kiri --}}
                <div>
                    {{-- Nama Fasilitas --}}
                    <div style="margin-bottom: 24px;">
                        <label class="form-label">Nama Fasilitas</label>
                        <div class="input-addon">
                            <i class="fa-solid fa-tag"></i>
                            <input type="text" name="nama" value="{{ old('nama', $fasilitas->nama) }}" required class="glass-input" placeholder="Contoh: Lapangan Futsal A">
                        </div>
                        @error('nama') <p style="color: #f87171; font-size: 11px; margin-top: 6px;">{{ $message }}</p> @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div style="margin-bottom: 24px;">
                        <label class="form-label">Deskripsi Fasilitas</label>
                        <textarea name="deskripsi" rows="5" class="glass-textarea" placeholder="Jelaskan detail fasilitas...">{{ old('deskripsi', $fasilitas->deskripsi) }}</textarea>
                    </div>

                    {{-- Jenis & Kapasitas --}}
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div style="margin-bottom: 24px;">
                            <label class="form-label">Jenis</label>
                            <div class="input-addon">
                                <i class="fa-solid fa-layer-group"></i>
                                <select name="jenis" required class="glass-select">
                                    <option value="lapangan" {{ old('jenis', $fasilitas->jenis) == 'lapangan' ? 'selected' : '' }}>🏟️ Lapangan</option>
                                    <option value="ruang_multimedia" {{ old('jenis', $fasilitas->jenis) == 'ruang_multimedia' ? 'selected' : '' }}>📺 Multimedia</option>
                                    <option value="lab" {{ old('jenis', $fasilitas->jenis) == 'lab' ? 'selected' : '' }}>🔬 Lab</option>
                                </select>
                            </div>
                        </div>
                        <div style="margin-bottom: 24px;">
                            <label class="form-label">Kapasitas</label>
                            <div class="input-addon">
                                <i class="fa-solid fa-users"></i>
                                <input type="number" name="kapasitas" value="{{ old('kapasitas', $fasilitas->kapasitas) }}" class="glass-input" placeholder="Orang">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan --}}
                <div>
                    {{-- Harga --}}
                    <div style="margin-bottom: 24px;">
                        <label class="form-label">Harga Sewa (Per Jam)</label>
                        <div class="input-addon">
                            <i class="fa-solid fa-money-bill-wave"></i>
                            <input type="number" name="harga_per_jam" value="{{ old('harga_per_jam', $fasilitas->harga_per_jam) }}" required class="glass-input" step="5000">
                        </div>
                    </div>

                    {{-- Update Foto --}}
                    <div style="margin-bottom: 24px;">
                        <label class="form-label">Media / Foto</label>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 12px;">
                            @if ($fasilitas->foto)
                                <div>
                                    <span class="current-photo-label">FOTO SAAT INI</span>
                                    <img src="{{ Storage::url($fasilitas->foto) }}"
                                         style="width: 100%; height: 100px; object-fit: cover; border-radius: 12px; border: 1px solid var(--glass-border);">
                                </div>
                            @endif
                            <div id="imagePreview" style="display: none;">
                                <span class="current-photo-label" style="color: var(--accent);">PREVIEW BARU</span>
                                <img id="preview" style="width: 100%; height: 100px; object-fit: cover; border-radius: 12px; border: 1px solid var(--accent);">
                            </div>
                        </div>

                        <div class="upload-zone" onclick="document.getElementById('fotoInput').click()">
                            <i class="fa-solid fa-camera-rotate" style="font-size: 24px; color: var(--accent); margin-bottom: 8px;"></i>
                            <p style="color: white; font-size: 12px; font-weight: 600; margin: 0;">Ganti Foto</p>
                        </div>
                        <input type="file" name="foto" id="fotoInput" style="display: none;" accept="image/*" onchange="previewImage(this)">
                    </div>

                    {{-- Status --}}
                    <div style="margin-bottom: 24px;">
                        <label class="form-label">Status Ketersediaan</label>
                        <div class="status-pill-container">
                            <label style="margin: 0;">
                                <input type="radio" name="status" value="aktif" {{ old('status', $fasilitas->status) == 'aktif' ? 'checked' : '' }} style="display: none;">
                                <div class="status-pill active">
                                    <i class="fa-solid fa-circle-check"></i> Aktif
                                </div>
                            </label>
                            <label style="margin: 0;">
                                <input type="radio" name="status" value="nonaktif" {{ old('status', $fasilitas->status) == 'nonaktif' ? 'checked' : '' }} style="display: none;">
                                <div class="status-pill inactive">
                                    <i class="fa-solid fa-circle-xmark"></i> Nonaktif
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div style="display: flex; align-items:center; justify-content: flex-end; gap: 20px; margin-top: 20px; padding-top: 30px; border-top: 1px solid var(--glass-border);">
                <a href="{{ route('admin.fasilitas.index') }}" style="color: #94a3b8; text-decoration: none; font-size: 14px; font-weight: 600; transition: color 0.3s;" onmouseover="this.style.color='white'" onmouseout="this.style.color='#94a3b8'">
                    Batal
                </a>

                <button type="submit" style="background: var(--accent); color: #0b1120; border: none; padding: 16px 40px; border-radius: 18px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; cursor: pointer; transition: all 0.3s; box-shadow: 0 10px 20px var(--accent-glow);">
                    <i class="fa-solid fa-arrows-rotate me-2"></i> Update Data
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(input) {
    const previewContainer = document.getElementById('imagePreview');
    const previewImg = document.getElementById('preview');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            previewContainer.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
