@extends('layouts.admin')

@section('title', 'Tambah Fasilitas')
@section('page-title', 'Tambah Fasilitas')

@section('breadcrumb')
    <a href="{{ route('admin.fasilitas.index') }}" class="breadcrumb-item">Fasilitas</a>
    <span class="current">Tambah</span>
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
        padding: 30px;
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
    }
</style>

<div class="glass-card" style="max-width: 850px; margin: 0 auto;">
    {{-- Header --}}
    <div style="background: linear-gradient(to right, rgba(0, 217, 139, 0.12), transparent); padding: 40px 40px 30px;">
        <h2 style="color: white; font-size: 26px; font-weight: 800; margin: 0; letter-spacing: -0.5px;">
            Registrasi <span style="color: var(--accent);">Fasilitas Baru</span>
        </h2>
        <p style="color: #94a3b8; font-size: 14px; margin-top: 8px;">Lengkapi data di bawah untuk menambahkan aset ke dalam sistem.</p>
    </div>

    <div style="padding: 0 40px 40px;">
        <form action="{{ route('admin.fasilitas.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div style="display: grid; grid-template-columns: 1.2fr 1fr; gap: 30px;">
                {{-- Kolom Kiri --}}
                <div>
                    {{-- Nama Fasilitas --}}
                    <div style="margin-bottom: 24px;">
                        <label class="form-label">Nama Fasilitas</label>
                        <div class="input-addon">
                            <i class="fa-solid fa-tag"></i>
                            <input type="text" name="nama" value="{{ old('nama') }}" required class="glass-input" placeholder="Contoh: Lapangan Futsal A">
                        </div>
                        @error('nama') <p style="color: #f87171; font-size: 11px; margin-top: 6px;">{{ $message }}</p> @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div style="margin-bottom: 24px;">
                        <label class="form-label">Deskripsi Fasilitas</label>
                        <textarea name="deskripsi" rows="5" class="glass-textarea" placeholder="Jelaskan detail fasilitas, keunggulan, atau fasilitas pendukung lainnya...">{{ old('deskripsi') }}</textarea>
                    </div>

                    {{-- Jenis & Kapasitas --}}
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div style="margin-bottom: 24px;">
                            <label class="form-label">Jenis</label>
                            <div class="input-addon">
                                <i class="fa-solid fa-layer-group"></i>
                                <select name="jenis" required class="glass-select">
                                    <option value="" disabled selected>Pilih...</option>
                                    <option value="lapangan">🏟️ Lapangan</option>
                                    <option value="ruang_multimedia">📺 Multimedia</option>
                                    <option value="lab">🔬 Lab</option>
                                </select>
                            </div>
                        </div>
                        <div style="margin-bottom: 24px;">
                            <label class="form-label">Kapasitas</label>
                            <div class="input-addon">
                                <i class="fa-solid fa-users"></i>
                                <input type="number" name="kapasitas" value="{{ old('kapasitas') }}" class="glass-input" placeholder="Orang">
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
                            <input type="number" name="harga_per_jam" value="{{ old('harga_per_jam') }}" required class="glass-input" placeholder="0">
                        </div>
                    </div>

                    {{-- Upload Foto --}}
                    <div style="margin-bottom: 24px;">
                        <label class="form-label">Media / Foto</label>
                        <div class="upload-zone" onclick="document.getElementById('fotoInput').click()" id="dropZone">
                            <div id="uploadContent">
                                <i class="fa-solid fa-cloud-arrow-up" style="font-size: 30px; color: var(--accent); margin-bottom: 12px;"></i>
                                <p style="color: white; font-size: 13px; font-weight: 600; margin: 0;">Pilih Gambar</p>
                                <p style="color: #64748b; font-size: 11px; margin-top: 4px;">JPG, PNG atau WEBP (Max. 2MB)</p>
                            </div>
                            <div id="imagePreview" style="display: none;">
                                <img id="preview" style="width: 100%; border-radius: 12px; height: 150px; object-fit: cover;">
                                <p style="color: var(--accent); font-size: 11px; margin-top: 8px; font-weight: 600;">Klik untuk ganti foto</p>
                            </div>
                        </div>
                        <input type="file" name="foto" id="fotoInput" style="display: none;" accept="image/*" onchange="previewImage(this)">
                    </div>

                    {{-- Status --}}
                    <div style="margin-bottom: 24px;">
                        <label class="form-label">Status Aset</label>
                        <div class="status-pill-container">
                            <label style="margin: 0;">
                                <input type="radio" name="status" value="aktif" {{ old('status', 'aktif') == 'aktif' ? 'checked' : '' }} style="display: none;">
                                <div class="status-pill active">
                                    <i class="fa-solid fa-circle-check"></i> Aktif
                                </div>
                            </label>
                            <label style="margin: 0;">
                                <input type="radio" name="status" value="nonaktif" {{ old('status') == 'nonaktif' ? 'checked' : '' }} style="display: none;">
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
                    <i class="fa-solid fa-plus me-2"></i> Tambahkan Fasilitas
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('preview');
    const content = document.getElementById('uploadContent');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
            content.style.display = 'none';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
