@extends('layouts.admin')

@section('title', 'Edit Jadwal Operasional')
@section('page-title', 'Edit Jadwal')

@section('breadcrumb')
    <a href="{{ route('admin.jadwal.index') }}" class="breadcrumb-item">Jadwal</a>
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
        animation: fadeIn 0.5s ease-out;
        transition: background 0.3s ease, border-color 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.98); }
        to { opacity: 1; transform: scale(1); }
    }

    .form-group { margin-bottom: 24px; }

    .form-label {
        display: block;
        font-size: 12px;
        font-weight: 700;
        color: var(--accent);
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin-bottom: 12px;
    }

    .glass-input, .glass-select {
        width: 100%;
        background: rgba(0, 0, 0, 0.25) !important;
        border: 1px solid var(--glass-border) !important;
        border-radius: 16px !important;
        padding: 14px 18px !important;
        color: white !important;
        font-size: 15px;
        transition: all 0.3s ease;
    }

    .glass-input:focus {
        border-color: var(--accent) !important;
        background: rgba(0, 217, 139, 0.05) !important;
        box-shadow: 0 0 20px var(--accent-glow);
        outline: none;
    }

    /* Status Selector */
    .status-container { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

    .status-option {
        position: relative;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--glass-border);
        border-radius: 20px;
        padding: 18px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    input[type="radio"]:checked + .status-option {
        border-color: var(--accent);
        background: rgba(0, 217, 139, 0.1);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    .indicator { width: 10px; height: 10px; border-radius: 50%; background: #334155; }
    input[type="radio"]:checked + .status-option .indicator.online { background: #00d98b; box-shadow: 0 0 12px #00d98b; }
    input[type="radio"]:checked + .status-option .indicator.offline { background: #ff4757; box-shadow: 0 0 12px #ff4757; }

    .duration-badge {
        background: linear-gradient(90deg, rgba(0, 217, 139, 0.1), transparent);
        border-left: 3px solid var(--accent);
        padding: 15px 20px;
        border-radius: 0 15px 15px 0;
        margin-top: 10px;
    }

    /* ========== LIGHT MODE STYLES ========== */
    body.light-mode .glass-card {
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        backdrop-filter: none;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
    }

    body.light-mode .glass-card div[style*="border-bottom: 1px solid var(--glass-border)"] {
        border-bottom-color: #e2e8f0 !important;
    }

    body.light-mode .glass-card h2 {
        color: #1e293b !important;
    }

    body.light-mode .glass-card p[style*="color: #64748b"] {
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

    body.light-mode .glass-input:focus {
        border-color: #059669 !important;
        background: #f8fafc !important;
        box-shadow: 0 0 20px rgba(5, 150, 105, 0.2);
    }

    body.light-mode .glass-select option {
        background-color: #ffffff !important;
        color: #1e293b !important;
    }

    body.light-mode .status-option {
        background: #f8fafc;
        border-color: #e2e8f0;
    }

    body.light-mode .status-option div[style*="color: white"] {
        color: #1e293b !important;
    }

    body.light-mode input[type="radio"]:checked + .status-option {
        border-color: #059669;
        background: rgba(5, 150, 105, 0.08);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
    }

    body.light-mode input[type="radio"]:checked + .status-option .indicator.online {
        background: #059669;
        box-shadow: 0 0 12px #059669;
    }

    body.light-mode .indicator {
        background: #cbd5e1;
    }

    body.light-mode .duration-badge {
        background: linear-gradient(90deg, rgba(5, 150, 105, 0.08), transparent);
        border-left-color: #059669;
    }

    body.light-mode .duration-badge span[style*="color: #94a3b8"] {
        color: #64748b !important;
    }

    body.light-mode .duration-badge div[style*="color: white"] {
        color: #1e293b !important;
    }

    body.light-mode a[style*="color: #94a3b8"] {
        color: #64748b !important;
    }

    body.light-mode a[style*="color: #94a3b8"]:hover {
        color: #dc2626 !important;
    }

    body.light-mode button[style*="background: var(--accent)"] {
        background: #059669 !important;
        color: #ffffff !important;
        box-shadow: 0 10px 20px rgba(5, 150, 105, 0.3);
    }

    body.light-mode button[style*="background: var(--accent)"]:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(5, 150, 105, 0.4);
    }

    body.light-mode div[style*="border-top: 1px solid var(--glass-border)"] {
        border-top-color: #e2e8f0 !important;
    }

    body.light-mode div[style*="background: var(--accent)"] {
        background: #059669 !important;
    }

    body.light-mode input[type="time"] {
        color-scheme: light;
    }
</style>

<div class="glass-card" style="max-width: 750px; margin: 0 auto;">
    {{-- Header --}}
    <div style="padding: 40px 40px 20px; border-bottom: 1px solid var(--glass-border);">
        <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 10px;">
            <div style="background: var(--accent); width: 45px; height: 45px; border-radius: 14px; display: flex; align-items: center; justify-content: center; color: #0b1120;">
                <i class="fa-solid fa-calendar-check" style="font-size: 20px;"></i>
            </div>
            <div>
                <h2 style="color: white; font-size: 24px; font-weight: 800; margin: 0;">Update <span style="color: var(--accent)">Jadwal</span></h2>
                <p style="color: #64748b; font-size: 14px; margin: 0;">Fasilitas: {{ $jadwal->fasilitas->nama }}</p>
            </div>
        </div>
    </div>

    <div style="padding: 40px;">
        <form action="{{ route('admin.jadwal.update', $jadwal->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Fasilitas --}}
            <div class="form-group">
                <label class="form-label">Fasilitas Terpilih</label>
                <select name="fasilitas_id" required class="glass-select">
                    @foreach($fasilitas as $f)
                        <option value="{{ $f->id }}" {{ old('fasilitas_id', $jadwal->fasilitas_id) == $f->id ? 'selected' : '' }}>
                            {{ $f->nama }} ({{ strtoupper($f->jenis) }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Jam Operasional --}}
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 10px;">
                <div class="form-group">
                    <label class="form-label">Jam Buka</label>
                    <input type="time" name="jam_buka" id="jam_buka" value="{{ old('jam_buka', \Carbon\Carbon::parse($jadwal->jam_buka)->format('H:i')) }}" required class="glass-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Jam Tutup</label>
                    <input type="time" name="jam_tutup" id="jam_tutup" value="{{ old('jam_tutup', \Carbon\Carbon::parse($jadwal->jam_tutup)->format('H:i')) }}" required class="glass-input">
                </div>
            </div>

            {{-- Informasi Durasi (Dynamic) --}}
            <div class="form-group">
                <div class="duration-badge">
                    <span style="color: #94a3b8; font-size: 13px;">Estimasi Durasi Operasional:</span>
                    <div style="color: white; font-weight: 700; font-size: 16px; margin-top: 4px;">
                        <i class="fa-regular fa-clock me-2" style="color: var(--accent)"></i>
                        <span id="duration-display">Menghitung...</span>
                    </div>
                </div>
            </div>

            {{-- Status Operasional --}}
            <div class="form-group" style="margin-top: 30px;">
                <label class="form-label">Status Operasional</label>
                <div class="status-container">
                    <label style="width: 100%;">
                        <input type="radio" name="is_libur" value="0" {{ old('is_libur', $jadwal->is_libur) == 0 ? 'checked' : '' }} style="display: none;">
                        <div class="status-option">
                            <div class="indicator online"></div>
                            <div>
                                <div style="color: white; font-weight: 700; font-size: 14px;">Buka</div>
                                <div style="color: #64748b; font-size: 11px;">Aktif & Beroperasi</div>
                            </div>
                        </div>
                    </label>

                    <label style="width: 100%;">
                        <input type="radio" name="is_libur" value="1" {{ old('is_libur', $jadwal->is_libur) == 1 ? 'checked' : '' }} style="display: none;">
                        <div class="status-option">
                            <div class="indicator offline"></div>
                            <div>
                                <div style="color: white; font-weight: 700; font-size: 14px;">Libur</div>
                                <div style="color: #64748b; font-size: 11px;">Tutup Sementara</div>
                            </div>
                        </div>
                    </label>
                </div>
            </div>

            {{-- Footer Buttons --}}
            <div style="display: flex; align-items:center; justify-content: space-between; margin-top: 40px; padding-top: 30px; border-top: 1px solid var(--glass-border);">
                <a href="{{ route('admin.jadwal.index') }}" style="color: #94a3b8; text-decoration: none; font-size: 14px; font-weight: 600; transition: all 0.3s;" onmouseover="this.style.color='#ff4757'" onmouseout="this.style.color='#94a3b8'">
                    <i class="fa-solid fa-xmark me-2"></i> Batalkan Perubahan
                </a>

                <button type="submit" style="background: var(--accent); color: #0b1120; border: none; padding: 16px 35px; border-radius: 18px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; cursor: pointer; transition: all 0.3s; box-shadow: 0 10px 20px var(--accent-glow);">
                    <i class="fa-solid fa-check-double me-2"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Logika Hitung Durasi Real-time
    function calculateDuration() {
        const start = document.getElementById('jam_buka').value;
        const end = document.getElementById('jam_tutup').value;
        const display = document.getElementById('duration-display');

        if (start && end) {
            let startTime = new Date(`2024-01-01 ${start}`);
            let endTime = new Date(`2024-01-01 ${end}`);

            if (endTime < startTime) {
                endTime.setDate(endTime.getDate() + 1);
            }

            const diffMs = endTime - startTime;
            const diffHrs = Math.floor(diffMs / 3600000);
            const diffMins = Math.round((diffMs % 3600000) / 60000);

            display.innerText = `${diffHrs} Jam ${diffMins} Menit`;
        }
    }

    const jamBuka = document.getElementById('jam_buka');
    const jamTutup = document.getElementById('jam_tutup');
    
    if (jamBuka && jamTutup) {
        jamBuka.addEventListener('change', calculateDuration);
        jamTutup.addEventListener('change', calculateDuration);
        calculateDuration();
    }

    // Fix status option click
    document.querySelectorAll('.status-option').forEach(option => {
        option.addEventListener('click', function() {
            const radio = this.parentElement.querySelector('input[type="radio"]');
            if (radio) radio.checked = true;
        });
    });
</script>
@endsection