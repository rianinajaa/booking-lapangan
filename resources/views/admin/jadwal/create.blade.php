@extends('layouts.admin')

@section('title', 'Tambah Jadwal Operasional')
@section('page-title', 'Tambah Jadwal')

@section('breadcrumb')
    <a href="{{ route('admin.jadwal.index') }}" class="breadcrumb-item">Jadwal</a>
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
        animation: slideUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1);
        transition: background 0.3s ease, border-color 0.3s ease;
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .form-group {
        margin-bottom: 24px;
        position: relative;
    }

    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: var(--accent);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 10px;
        padding-left: 4px;
    }

    .glass-input, .glass-select {
        width: 100%;
        background: rgba(0, 0, 0, 0.2) !important;
        border: 1px solid var(--glass-border) !important;
        border-radius: 16px !important;
        padding: 14px 18px !important;
        color: white !important;
        font-size: 15px;
        transition: all 0.3s ease;
    }

    .glass-input:focus, .glass-select:focus {
        border-color: var(--accent) !important;
        background: rgba(0, 217, 139, 0.05) !important;
        box-shadow: 0 0 15px var(--accent-glow);
        outline: none;
    }

    /* Custom Radio Styling */
    .radio-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .radio-card {
        position: relative;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--glass-border);
        border-radius: 20px;
        padding: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .radio-card:hover {
        background: rgba(255, 255, 255, 0.05);
    }

    input[type="radio"]:checked + .radio-card {
        border-color: var(--accent);
        background: rgba(0, 217, 139, 0.1);
    }

    .dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #334155;
    }

    input[type="radio"]:checked + .radio-card .dot.open { background: #00d98b; box-shadow: 0 0 10px #00d98b; }
    input[type="radio"]:checked + .radio-card .dot.closed { background: #ff4757; box-shadow: 0 0 10px #ff4757; }

    .btn-save {
        background: var(--accent) !important;
        color: #0b1120 !important;
        font-weight: 800 !important;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 16px 32px !important;
        border-radius: 18px !important;
        border: none !important;
        transition: all 0.3s ease !important;
        box-shadow: 0 10px 20px var(--accent-glow);
        cursor: pointer;
    }

    .btn-save:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 25px var(--accent-glow);
    }

    /* ========== LIGHT MODE STYLES ========== */
    body.light-mode .glass-card {
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        backdrop-filter: none;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
    }

    body.light-mode .glass-card div[style*="background: linear-gradient"] {
        background: linear-gradient(to right, rgba(0, 217, 139, 0.08), transparent) !important;
    }

    body.light-mode .glass-card h2 {
        color: #1e293b !important;
    }

    body.light-mode .glass-card p[style*="color: #94a3b8"] {
        color: #64748b !important;
    }

    body.light-mode .form-label {
        color: #059669 !important;
    }

    body.light-mode .glass-input,
    body.light-mode .glass-select {
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        color: #1e293b !important;
    }

    body.light-mode .glass-input::placeholder {
        color: #94a3b8 !important;
    }

    body.light-mode .glass-input:focus,
    body.light-mode .glass-select:focus {
        border-color: #059669 !important;
        background: #f8fafc !important;
        box-shadow: 0 0 15px rgba(5, 150, 105, 0.2);
    }

    body.light-mode .glass-select option {
        background-color: #ffffff !important;
        color: #1e293b !important;
    }

    body.light-mode .radio-card {
        background: #f8fafc;
        border-color: #e2e8f0;
    }

    body.light-mode .radio-card:hover {
        background: #f1f5f9;
    }

    body.light-mode .radio-card span[style*="color: white"] {
        color: #1e293b !important;
    }

    body.light-mode .radio-card span[style*="color: #64748b"] {
        color: #64748b !important;
    }

    body.light-mode input[type="radio"]:checked + .radio-card {
        border-color: #059669;
        background: rgba(5, 150, 105, 0.08);
    }

    body.light-mode input[type="radio"]:checked + .radio-card .dot.open {
        background: #059669;
        box-shadow: 0 0 10px #059669;
    }

    body.light-mode input[type="radio"]:checked + .radio-card .dot.closed {
        background: #dc2626;
        box-shadow: 0 0 10px #dc2626;
    }

    body.light-mode .dot {
        background: #cbd5e1;
    }

    body.light-mode .btn-save {
        background: #059669 !important;
        color: #ffffff !important;
        box-shadow: 0 10px 20px rgba(5, 150, 105, 0.3);
    }

    body.light-mode .btn-save:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 25px rgba(5, 150, 105, 0.4);
    }

    body.light-mode a[style*="color: #94a3b8"] {
        color: #64748b !important;
    }

    body.light-mode a[style*="color: #94a3b8"]:hover {
        color: #dc2626 !important;
    }

    body.light-mode div[style*="border-top: 1px solid var(--glass-border)"] {
        border-top-color: #e2e8f0 !important;
    }

    body.light-mode .fa-building-circle-check {
        color: #059669 !important;
        opacity: 0.7 !important;
    }

    /* Fix for time input in light mode */
    body.light-mode input[type="time"] {
        color-scheme: light;
    }
</style>

<div class="glass-card" style="max-width: 700px; margin: 0 auto;">
    {{-- Header with Gradient --}}
    <div style="background: linear-gradient(to right, rgba(0, 217, 139, 0.1), transparent); padding: 32px 32px 20px;">
        <h2 style="color: white; font-size: 28px; font-weight: 800; margin: 0; letter-spacing: -0.5px;">
            Konfigurasi <span style="color: var(--accent);">Jadwal</span>
        </h2>
        <p style="color: #94a3b8; font-size: 14px; margin-top: 8px;">Tentukan waktu operasional untuk fasilitas aset kamu.</p>
    </div>

    <div style="padding: 0 32px 40px;">
        <form action="{{ route('admin.jadwal.store') }}" method="POST">
            @csrf

            {{-- Row 1: Fasilitas --}}
            <div class="form-group">
                <label class="form-label">Target Fasilitas</label>
                <div style="position: relative;">
                    <i class="fa-solid fa-building-circle-check" style="position: absolute; right: 18px; top: 18px; color: var(--accent); opacity: 0.5; z-index: 1;"></i>
                    <select name="fasilitas_id" required class="glass-select" style="appearance: none;">
                        <option value="" disabled selected>Pilih salah satu fasilitas...</option>
                        @foreach($fasilitas as $f)
                            <option value="{{ $f->id }}" {{ old('fasilitas_id') == $f->id ? 'selected' : '' }}>
                                {{ $f->nama }} — {{ strtoupper($f->jenis) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('fasilitas_id')
                    <p style="color: #ff4757; font-size: 12px; margin: 8px 0 0 4px;"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                @enderror
            </div>

            {{-- Row 2: Jam Operasional --}}
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                <div class="form-group">
                    <label class="form-label">Jam Buka</label>
                    <input type="time" name="jam_buka" value="{{ old('jam_buka', '08:00') }}" required class="glass-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Jam Tutup</label>
                    <input type="time" name="jam_tutup" value="{{ old('jam_tutup', '21:00') }}" required class="glass-input">
                </div>
            </div>

            {{-- Row 3: Status Terkini --}}
            <div class="form-group">
                <label class="form-label">Status Awal</label>
                <div class="radio-container">
                    {{-- Option Open --}}
                    <label style="cursor: pointer; width: 100%;">
                        <input type="radio" name="is_libur" value="0" {{ old('is_libur', '0') == '0' ? 'checked' : '' }} style="display: none;">
                        <div class="radio-card">
                            <div class="dot open"></div>
                            <div style="display: flex; flex-direction: column;">
                                <span style="color: white; font-weight: 600; font-size: 14px;">Buka</span>
                                <span style="color: #64748b; font-size: 11px;">Beroperasi normal</span>
                            </div>
                        </div>
                    </label>

                    {{-- Option Holiday --}}
                    <label style="cursor: pointer; width: 100%;">
                        <input type="radio" name="is_libur" value="1" {{ old('is_libur') == '1' ? 'checked' : '' }} style="display: none;">
                        <div class="radio-card">
                            <div class="dot closed"></div>
                            <div style="display: flex; flex-direction: column;">
                                <span style="color: white; font-weight: 600; font-size: 14px;">Libur</span>
                                <span style="color: #64748b; font-size: 11px;">Tutup sementara</span>
                            </div>
                        </div>
                    </label>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div style="display: flex; align-items:center; justify-content: space-between; margin-top: 20px; padding-top: 30px; border-top: 1px solid var(--glass-border);">
                <a href="{{ route('admin.jadwal.index') }}" style="color: #94a3b8; text-decoration: none; font-size: 14px; font-weight: 600; transition: color 0.3s;" onmouseover="this.style.color='white'" onmouseout="this.style.color='#94a3b8'">
                    <i class="fa-solid fa-arrow-left-long me-2"></i> Kembali
                </a>

                <button type="submit" class="btn btn-save">
                    <i class="fa-solid fa-cloud-arrow-up me-2"></i> Simpan Konfigurasi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Fix radio button styling - ensure proper click handling
    document.querySelectorAll('.radio-card').forEach(card => {
        card.addEventListener('click', function() {
            const radio = this.parentElement.querySelector('input[type="radio"]');
            if (radio) {
                radio.checked = true;
                // Trigger change event to update any dependent logic
                const event = new Event('change', { bubbles: true });
                radio.dispatchEvent(event);
            }
        });
    });
</script>
@endsection