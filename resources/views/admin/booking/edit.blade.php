@extends('layouts.admin')

@section('title', 'Update Booking #' . $booking->kode_booking)

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    :root {
        --primary: #00d98b;
        --primary-glow: rgba(0, 217, 139, 0.15);
        --bg-dark: #0b0f1a;
        --card-bg: #111827;
        --border-glass: rgba(255, 255, 255, 0.08);
        --input-bg: #1f2937;
        --text-gray: #94a3b8;
    }

    body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg-dark); color: white; }
    .edit-container { max-width: 900px; margin: 40px auto; padding: 0 20px; }
    .glass-form-card {
        background: var(--card-bg);
        border: 1px solid var(--border-glass);
        border-radius: 32px;
        padding: 40px;
        box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.6);
        transition: background 0.3s ease, border-color 0.3s ease;
    }
    .label-custom {
        display: block; color: var(--text-gray); font-size: 11px; font-weight: 800;
        text-transform: uppercase; letter-spacing: 1.8px; margin-bottom: 10px;
    }
    .form-control-custom {
        width: 100%; background: var(--input-bg); border: 1px solid var(--border-glass);
        border-radius: 16px; padding: 15px 20px; color: white !important;
        font-size: 15px; font-weight: 600; transition: 0.3s; outline: none;
    }
    .form-control-custom:focus { border-color: var(--primary); box-shadow: 0 0 15px var(--primary-glow); }
    .form-control-custom:read-only { opacity: 0.6; cursor: not-allowed; }

    .section-divider {
        height: 1px; background: var(--border-glass); margin: 30px 0;
        position: relative; text-align: center;
    }
    .section-divider span {
        position: absolute; top: -12px; background: var(--card-bg);
        padding: 0 15px; color: var(--text-gray); font-size: 10px; font-weight: 800;
        transition: background 0.3s ease;
    }

    .btn-update {
        background: var(--primary); color: #0b0f1a; border: none; border-radius: 18px;
        padding: 18px; font-weight: 800; width: 100%; cursor: pointer; transition: 0.3s;
    }
    .btn-update:hover { transform: translateY(-3px); box-shadow: 0 10px 20px var(--primary-glow); }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }

    /* ========== LIGHT MODE STYLES ========== */
    body.light-mode {
        background: #f1f5f9 !important;
    }

    body.light-mode .glass-form-card {
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.1);
    }

    body.light-mode .glass-form-card h2 {
        color: #1e293b !important;
    }

    body.light-mode .label-custom {
        color: #475569 !important;
    }

    body.light-mode .form-control-custom {
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        color: #1e293b !important;
    }

    body.light-mode .form-control-custom:read-only {
        background: #f8fafc !important;
        opacity: 0.8;
    }

    body.light-mode .form-control-custom:focus {
        border-color: #059669 !important;
        box-shadow: 0 0 15px rgba(5, 150, 105, 0.2);
    }

    body.light-mode .section-divider {
        background: #e2e8f0;
    }

    body.light-mode .section-divider span {
        background: #ffffff;
        color: #64748b;
    }

    body.light-mode .btn-update {
        background: #059669 !important;
        color: #ffffff !important;
    }

    body.light-mode .btn-update:hover {
        box-shadow: 0 10px 20px rgba(5, 150, 105, 0.3);
    }

    body.light-mode a[style*="color: var(--text-gray)"] {
        color: #64748b !important;
    }

    body.light-mode a[style*="color: var(--text-gray)"]:hover {
        color: #dc2626 !important;
    }

    body.light-mode p[style*="color: var(--text-gray)"] {
        color: #64748b !important;
    }

    body.light-mode div[style*="background: rgba(0, 217, 139, 0.05)"] {
        background: rgba(5, 150, 105, 0.05) !important;
        border-color: #059669 !important;
    }

    body.light-mode div[style*="background: rgba(239, 68, 68, 0.1)"] {
        background: #fef2f2 !important;
        border-color: #fecaca !important;
    }

    body.light-mode div[style*="background: rgba(239, 68, 68, 0.1)"] span {
        color: #dc2626 !important;
    }

    body.light-mode small[id="nominal_potongan"] {
        color: #059669 !important;
    }

    body.light-mode select option {
        background-color: #ffffff !important;
        color: #1e293b !important;
    }

    body.light-mode input[type="date"],
    body.light-mode input[type="time"],
    body.light-mode input[type="number"] {
        color-scheme: light;
    }
</style>

<div class="edit-container">
    <div style="text-align: center; margin-bottom: 30px;">
        <h2 style="font-weight: 800; font-size: 30px; color: white;">Edit <span style="color:var(--primary)">Booking #{{ $booking->kode_booking }}</span></h2>
        <p style="color: var(--text-gray);">Pemesan: <strong>{{ $booking->user->name }}</strong></p>
    </div>

    <div class="glass-form-card">
        @php
            // Cek apakah form harus dikunci
            $isLocked = in_array($booking->status_booking, ['selesai', 'dibatalkan']);
        @endphp

        {{-- Notifikasi kalau status sudah terkunci --}}
        @if($isLocked)
            <div style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); padding: 15px; border-radius: 12px; margin-bottom: 25px; display: flex; align-items: center; gap: 12px;">
                <i class="fa-solid fa-lock" style="color: #ef4444;"></i>
                <span style="font-size: 13px; color: #ef4444; font-weight: 600;">
                    Booking ini sudah berstatus <strong>{{ strtoupper($booking->status_booking) }}</strong>. Data tidak dapat diubah kembali untuk menjaga integritas histori.
                </span>
            </div>
        @endif

        <form action="{{ route('admin.booking.update', $booking->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="label-custom">STATUS RESERVASI</label>
                <div class="input-wrapper" style="position: relative;">
                    @if($isLocked)
                        <input type="hidden" name="status_booking" value="{{ $booking->status_booking }}">
                    @endif

                    <select name="status_booking" class="form-control-custom" {{ $isLocked ? 'disabled' : '' }}>
                        <option value="menunggu" {{ $booking->status_booking == 'menunggu' ? 'selected' : '' }}>⏳ Menunggu Konfirmasi</option>
                        <option value="dikonfirmasi" {{ $booking->status_booking == 'dikonfirmasi' ? 'selected' : '' }}>✅ Dikonfirmasi</option>
                        <option value="selesai" {{ $booking->status_booking == 'selesai' ? 'selected' : '' }}>🏆 Selesai</option>
                        <option value="dibatalkan" {{ $booking->status_booking == 'dibatalkan' ? 'selected' : '' }}>❌ Dibatalkan</option>
                    </select>
                </div>
            </div>

            <div class="section-divider"><span>PENJADWALAN ULANG</span></div>

            @php $detail = $booking->detailBooking->first(); @endphp

            <div class="mb-4">
                <label class="label-custom">TANGGAL BOOKING</label>
                <input type="date" name="tanggal" value="{{ $detail ? $detail->tanggal->format('Y-m-d') : '' }}"
                       class="form-control-custom" {{ $isLocked ? 'readonly' : '' }}>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <label class="label-custom">JAM MULAI</label>
                    <input type="time" name="jam_mulai" value="{{ $detail ? substr($detail->jam_mulai, 0, 5) : '' }}"
                           class="form-control-custom" {{ $isLocked ? 'readonly' : '' }}>
                </div>
                <div class="col-md-6 mb-4">
                    <label class="label-custom">JAM SELESAI</label>
                    <input type="time" name="jam_selesai" value="{{ $detail ? substr($detail->jam_selesai, 0, 5) : '' }}"
                           class="form-control-custom" {{ $isLocked ? 'readonly' : '' }}>
                </div>
            </div>

            <div class="section-divider"><span>BIAYA & DISKON</span></div>

            <div class="row">
                <div class="col-md-4 mb-4">
                    <label class="label-custom">HARGA AWAL (IDR)</label>
                    <input type="number" id="harga_asli" value="{{ (int)($detail->subtotal ?? $booking->total_harga) }}"
                           class="form-control-custom" readonly>
                </div>

                <div class="col-md-4 mb-4">
                    <label class="label-custom">DISKON (%)</label>
                    <input type="number" name="diskon_persen" id="diskon_persen" value="{{ $booking->diskon_persen }}"
                           class="form-control-custom" placeholder="0" min="0" max="100" {{ $isLocked ? 'readonly' : '' }}>
                    <small id="nominal_potongan" style="font-size: 11px; font-weight: 700; margin-top: 8px; display: block; color: var(--primary);">
                        Potongan: Rp 0
                    </small>
                </div>

                <div class="col-md-4 mb-4">
                    <label class="label-custom">TOTAL HARGA AKHIR</label>
                    <input type="number" name="total_harga" id="total_harga" value="{{ (int)$booking->total_harga }}"
                           class="form-control-custom" readonly style="background: rgba(0, 217, 139, 0.05); border-color: var(--primary);">
                </div>
            </div>

            @if(!$isLocked)
                <button type="submit" class="btn-update">
                    <i class="fa-solid fa-save me-2"></i> SIMPAN PERUBAHAN DATA
                </button>
            @endif

            <a href="{{ route('admin.booking.index') }}" style="display: block; text-align: center; margin-top: 20px; color: var(--text-gray); text-decoration: none; font-size: 13px;">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke List
            </a>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputDiskon = document.getElementById('diskon_persen');
        const inputHargaAsli = document.getElementById('harga_asli');
        const inputTotalHarga = document.getElementById('total_harga');
        const previewPotongan = document.getElementById('nominal_potongan');

        function calculateDiscount() {
            const hargaDasar = parseFloat(inputHargaAsli.value) || 0;
            const persenDiskon = parseFloat(inputDiskon.value) || 0;

            const potongan = (persenDiskon / 100) * hargaDasar;
            const hasilAkhir = hargaDasar - potongan;

            inputTotalHarga.value = Math.round(hasilAkhir);
            previewPotongan.innerText = "Potongan: -Rp " + Math.round(potongan).toLocaleString('id-ID');
        }

        if (inputDiskon) {
            inputDiskon.addEventListener('input', calculateDiscount);
            calculateDiscount();
        }
    });
</script>
@endsection