@extends('layouts.admin')

@section('title', 'Buat Booking Baru')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    :root {
        --primary: #00d98b;
        --primary-glow: rgba(0, 217, 139, 0.25);
        --bg-dark: #0b0f1a;
        --card-bg: #111827;
        --border-glass: rgba(255, 255, 255, 0.15);
        --input-bg: #1f2937;
        --text-gray: #94a3b8;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background: var(--bg-dark);
        color: white;
        color-scheme: dark;
    }

    .create-container { max-width: 900px; margin: 40px auto; padding: 0 20px; }

    .form-header { margin-bottom: 40px; text-align: center; }
    .form-header h2 { font-weight: 800; font-size: 34px; letter-spacing: -1px; margin-bottom: 8px; }

    .glass-form-card {
        background: var(--card-bg);
        border: 1px solid var(--border-glass);
        border-radius: 32px;
        padding: 45px;
        box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.8);
    }

    .form-group-custom { margin-bottom: 28px; }
    .label-custom {
        display: block;
        color: #ffffff;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1.8px;
        margin-bottom: 12px;
    }

    .input-wrapper { position: relative; }
    .input-wrapper i:not(.fa-chevron-down) {
        position: absolute; left: 20px; top: 18px;
        color: var(--primary); font-size: 18px; z-index: 10;
    }

    .form-control-custom {
        width: 100%;
        background-color: var(--input-bg) !important;
        border: 2px solid var(--border-glass);
        border-radius: 16px;
        padding: 15px 20px 15px 55px;
        color: #ffffff !important;
        font-size: 15px;
        font-weight: 600;
        transition: 0.3s;
        outline: none;
        appearance: none;
    }

    /* --- FIX FLASHBANG SELECT OPTIONS --- */
    .form-control-custom option {
        background-color: #1f2937 !important;
        color: white !important;
    }

    select.form-control-custom {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%2300d98b' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 1.25rem center;
        background-size: 1.5em;
    }

    .form-control-custom:focus {
        border-color: var(--primary);
        box-shadow: 0 0 20px var(--primary-glow);
        background-color: #2d3748 !important;
    }

    .price-info-box {
        background: rgba(0, 217, 139, 0.05);
        border: 1px dashed var(--primary);
        border-radius: 20px;
        padding: 20px;
        margin-bottom: 35px;
        display: flex;
        justify-content: space-around;
        text-align: center;
    }

    .price-info-item span { display: block; font-size: 10px; color: var(--text-gray); font-weight: 800; text-transform: uppercase; margin-bottom: 5px;}
    .price-info-item strong { font-size: 18px; color: var(--primary); font-weight: 800; }

    .btn-submit {
        background: var(--primary); color: #0b0f1a; border: none; border-radius: 18px;
        padding: 20px; font-weight: 800; font-size: 16px; width: 100%; transition: 0.3s;
        cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 12px;
        text-transform: uppercase; letter-spacing: 1px;
    }
    .btn-submit:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(0, 217, 139, 0.4);
    }

    .btn-cancel {
        display: block; text-align: center; margin-top: 25px;
        color: var(--text-gray); text-decoration: none;
        font-size: 13px; font-weight: 700; transition: 0.3s;
    }
    .btn-cancel:hover { color: #ef4444; }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
</style>

<div class="create-container">
    <div class="form-header">
        <h2>New <span style="color:var(--primary)">Reservation</span></h2>
        <p style="color: var(--text-gray)">Buat jadwal booking baru untuk fasilitas E-Market.</p>
    </div>

    <div class="glass-form-card">
        <form action="{{ route('admin.booking.store') }}" method="POST">
            @csrf

            <div class="price-info-box">
                <div class="price-info-item">
                    <span>Durasi Terhitung</span>
                    <strong id="label_durasi">0 Jam</strong>
                </div>
                <div style="width: 1px; background: var(--border-glass);"></div>
                <div class="price-info-item">
                    <span>Harga / Jam</span>
                    <strong id="label_harga_per_jam">Rp 0</strong>
                </div>
                <div style="width: 1px; background: var(--border-glass);"></div>
                <div class="price-info-item">
                    <span>Potongan</span>
                    <strong id="label_potongan" style="color: #ef4444;">- Rp 0</strong>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 form-group-custom">
                    <label class="label-custom">Customer / Pemesan</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-circle-user"></i>
                        <select name="user_id" class="form-control-custom" required>
                            <option value="" disabled selected>Pilih Akun User</option>
                            @foreach($users as $u)
                                <option value="{{ $u->id }}">{{ $u->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6 form-group-custom">
                    <label class="label-custom">Kategori Booker</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-address-card"></i>
                        <select name="role_booker" class="form-control-custom" required>
                            <option value="guru">Guru / Staff</option>
                            <option value="siswa_internal">Siswa SMK (Internal)</option>
                            <option value="siswa_luar">Siswa Luar</option>
                            <option value="umum">Umum</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-12 form-group-custom">
                    <label class="label-custom">Fasilitas yang Disewa</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-map-location-dot"></i>
                        <select name="fasilitas_id" id="fasilitas_id" class="form-control-custom" required>
                            <option value="" disabled selected>— Pilih Fasilitas —</option>
                            @foreach($fasilitas as $f)
                                <option value="{{ $f->id }}" data-harga="{{ $f->harga_per_jam ?? 0 }}">
                                    {{-- FIX: Cek berbagai kemungkinan nama kolom database --}}
                                    {{ $f->nama_fasilitas ?? $f->nama ?? $f->nama_lapangan ?? 'Fasilitas #'.$f->id }}
                                    (Rp {{ number_format($f->harga_per_jam ?? 0, 0, ',', '.') }}/jam)
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-4 form-group-custom">
                    <label class="label-custom">Tanggal Main</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-calendar-day"></i>
                        <input type="date" name="tanggal" class="form-control-custom" required>
                    </div>
                </div>
                <div class="col-md-4 form-group-custom">
                    <label class="label-custom">Jam Mulai</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-clock"></i>
                        <input type="time" name="jam_mulai" id="jam_mulai" class="form-control-custom" required>
                    </div>
                </div>
                <div class="col-md-4 form-group-custom">
                    <label class="label-custom">Jam Selesai</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-hourglass-end"></i>
                        <input type="time" name="jam_selesai" id="jam_selesai" class="form-control-custom" required>
                    </div>
                </div>

                <div class="col-md-4 form-group-custom">
                    <label class="label-custom">Potongan (%)</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-tag"></i>
                        <input type="number" name="diskon_persen" id="diskon_persen" class="form-control-custom" placeholder="0" value="0" min="0" max="100">
                    </div>
                </div>
                <div class="col-md-8 form-group-custom">
                    <label class="label-custom">Total Pembayaran (IDR)</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-money-bill-wave"></i>
                        <input type="number" name="total_harga" id="total_harga" class="form-control-custom" placeholder="0" readonly style="background: rgba(0, 217, 139, 0.05) !important; border-color: var(--primary);">
                    </div>
                </div>
            </div>

            <div style="margin-top: 20px;">
                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-file-invoice-dollar"></i> KONFIRMASI & SIMPAN BOOKING
                </button>
                <a href="{{ route('admin.booking.index') }}" class="btn-cancel">
                    <i class="fa-solid fa-xmark me-1"></i> Batalkan Input Data
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fasilitasSelect = document.getElementById('fasilitas_id');
        const jamMulai = document.getElementById('jam_mulai');
        const jamSelesai = document.getElementById('jam_selesai');
        const diskonInput = document.getElementById('diskon_persen');
        const totalInput = document.getElementById('total_harga');

        const labelDurasi = document.getElementById('label_durasi');
        const labelHargaJam = document.getElementById('label_harga_per_jam');
        const labelPotongan = document.getElementById('label_potongan');

        function hitungSemua() {
            const selectedOption = fasilitasSelect.options[fasilitasSelect.selectedIndex];
            if(!selectedOption || selectedOption.disabled) return;

            const hargaPerJam = parseFloat(selectedOption.getAttribute('data-harga')) || 0;

            let durasi = 0;
            if (jamMulai.value && jamSelesai.value) {
                // Trik Pecah String Waktu (Aman dari Bug format AM/PM Browser)
                const startParts = jamMulai.value.split(':');
                const endParts = jamSelesai.value.split(':');

                // Ambil jam dan menit murni
                const startHour = parseInt(startParts[0], 10);
                const startMin = parseInt(startParts[1], 10);
                const endHour = parseInt(endParts[0], 10);
                const endMin = parseInt(endParts[1], 10);

                // Convert semuanya ke dalam satuan Menit murni
                let totalMenitMulai = (startHour * 60) + startMin;
                let totalMenitSelesai = (endHour * 60) + endMin;

                // Handle jika waktu sewa melewati tengah malam (contoh: 22:00 - 01:00)
                if (totalMenitSelesai < totalMenitMulai) {
                    totalMenitSelesai += 24 * 60; // Tambah durasi 1 hari (1440 menit)
                }

                // Hitung selisih jam bersih
                let selisihMenit = totalMenitSelesai - totalMenitMulai;
                durasi = selisihMenit / 60;
            }

            const subtotal = hargaPerJam * durasi;
            const diskonPersen = parseFloat(diskonInput.value) || 0;
            const nominalPotongan = (diskonPersen / 100) * subtotal;
            const totalAkhir = subtotal - nominalPotongan;

            // Tampilkan data hasil kalkulasi ke element info box
            labelDurasi.innerText = durasi.toFixed(1) + " Jam";
            labelHargaJam.innerText = "Rp " + hargaPerJam.toLocaleString('id-ID');
            labelPotongan.innerText = "- Rp " + Math.round(nominalPotongan).toLocaleString('id-ID');

            // Set value ke input form utama agar terkirim ke Controller pas di-submit
            totalInput.value = Math.round(totalAkhir);
        }

        // Dengerin setiap kali user ngetik atau mindahin inputan
        [fasilitasSelect, jamMulai, jamSelesai, diskonInput].forEach(el => {
            el.addEventListener('input', hitungSemua);
            el.addEventListener('change', hitungSemua);
        });
    });
</script>
@endsection
