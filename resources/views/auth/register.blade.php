<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — Booking Lapangan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; box-sizing: border-box; margin: 0; padding: 0; }

        html, body { height: 100%; overflow: hidden; }

        .bg-lapangan {
            background-image:
                url('https://images.unsplash.com/photo-1574629810360-7efbbe195018?w=1600&auto=format&fit=crop&q=85');
            background-size: cover;
            background-position: center;
            position: fixed;
            inset: 0;
            z-index: 0;
        }

        .bg-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.38);
            z-index: 1;
        }

        .panel-right {
            position: fixed;
            top: 0; right: 0; bottom: 0;
            width: 480px;
            background: rgba(8, 12, 22, 0.62);
            backdrop-filter: blur(28px);
            -webkit-backdrop-filter: blur(28px);
            border-left: 1px solid rgba(255,255,255,0.08);
            z-index: 10;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 44px 44px;
            overflow-y: auto;
        }

        .panel-left {
            position: fixed;
            top: 0; left: 0; bottom: 0;
            right: 420px;
            z-index: 5;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 40px 48px;
        }

        .input-glass {
            width: 100%;
            padding: 12px 16px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.14);
            border-radius: 10px;
            font-size: 14px;
            color: #fff;
            outline: none;
            transition: all 0.2s;
        }
        .input-glass:focus {
            border-color: rgba(74,222,128,0.55);
            background: rgba(255,255,255,0.09);
            box-shadow: 0 0 0 3px rgba(74,222,128,0.10);
        }
        .input-glass::placeholder { color: rgba(255,255,255,0.28); }
        .input-glass.err { border-color: rgba(248,113,113,0.55); }

        label { display: block; color: rgba(255,255,255,0.65); font-size: 13px; font-weight: 600; margin-bottom: 6px; }

        .btn-masuk {
            width: 100%;
            background: #ffffff;
            color: #08090f;
            padding: 13px;
            border-radius: 10px;
            font-weight: 800;
            font-size: 14.5px;
            letter-spacing: 0.02em;
            border: none;
            cursor: pointer;
            transition: background 0.2s, box-shadow 0.2s, transform 0.1s;
        }
        .btn-masuk:hover {
            background: #dcfce7;
            box-shadow: 0 6px 24px rgba(74,222,128,0.22);
        }
        .btn-masuk:active { transform: scale(0.99); }

        .divider { display: flex; align-items: center; gap: 12px; }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(255,255,255,0.10);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateX(18px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        .fade-in { animation: fadeIn 0.5s cubic-bezier(.22,.68,0,1.1) both; }
        .d1{animation-delay:.05s} .d2{animation-delay:.10s} .d3{animation-delay:.15s}
        .d4{animation-delay:.20s} .d5{animation-delay:.25s} .d6{animation-delay:.30s}
        .d7{animation-delay:.35s} .d8{animation-delay:.40s} .d9{animation-delay:.45s}

        @media (max-width: 640px) {
            .panel-right { width: 100%; border-left: none; padding: 36px 24px; }
            .panel-left  { display: none; }
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.4; }
        }

        /* ── OTP Toast ── */
        #otp-toast {
            position: fixed;
            top: 24px;
            left: 50%;
            transform: translateX(-50%) translateY(-8px);
            background: rgba(20, 83, 45, 0.55);
            border: 1px solid rgba(74, 222, 128, 0.40);
            color: #86efac;
            font-size: 13.5px;
            font-weight: 600;
            padding: 12px 22px;
            border-radius: 12px;
            z-index: 9999;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 8px;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.35s ease, transform 0.35s cubic-bezier(.22,.68,0,1.1);
        }
        #otp-toast.show {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }
        #otp-toast.hide {
            opacity: 0;
            transform: translateX(-50%) translateY(-8px);
        }
        #otp-toast .toast-dot {
            width: 7px;
            height: 7px;
            background: #4ade80;
            border-radius: 50%;
            flex-shrink: 0;
        }
    </style>
</head>
<body>

    <div class="bg-lapangan"></div>
    <div class="bg-overlay"></div>

    {{-- OTP Toast Notification --}}
    <div id="otp-toast" role="alert" aria-live="polite">
        <span class="toast-dot"></span>
        Kode OTP baru telah dikirim ke email kamu.
    </div>

    {{-- Branding kiri --}}
    <div class="panel-left">
        <div class="fade-in">
            <div style="display:flex;align-items:center;margin-top:-74px;margin-left:-34px;">
                <img src="{{ asset('images/spacego_logo.png') }}" alt="SpaceGo"
                    style="height:190px;width:auto;object-fit:contain;">
            </div>
        </div>
        <div class="fade-in d2" style="padding-bottom:60px;">
            <p style="color:#4ade80;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.18em;margin-bottom:16px;display:flex;align-items:center;gap:8px;">
                <span style="width:8px;height:8px;background:#4ade80;border-radius:50%;display:inline-block;animation:pulse 2s infinite;"></span>
                Daftar Gratis
            </p>
            <h1 style="color:white;font-size:clamp(2.2rem,3.5vw,3.2rem);font-weight:900;line-height:1.12;margin-bottom:20px;">
                Mulai Booking<br>
                <span style="color:#4ade80;">Lapangan</span> Hari Ini.
            </h1>
            <p style="color:rgba(255,255,255,0.45);font-size:14px;line-height:1.75;max-width:360px;">
                Buat akun dan nikmati kemudahan booking lapangan kapan saja dengan sistem pembayaran yang transparan.
            </p>
        </div>
    </div>

    {{-- Panel kanan: Form register --}}
    <div class="panel-right">

        <div class="fade-in">
            <p style="color:rgba(255,255,255,0.35);font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.18em;margin-bottom:6px;">SpaceGo</p>
            <h2 style="color:white;font-size:24px;font-weight:800;line-height:1.25;">Buat Akun Baru ✨</h2>
            <p style="color:rgba(255,255,255,0.45);font-size:13px;margin-top:8px;margin-bottom:24px;line-height:1.6;">
                Isi data di bawah untuk mendaftar sebagai User.
            </p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- Nama --}}
            <div class="fade-in d1" style="margin-bottom:14px;">
                <label>Nama Lengkap</label>
                <input
                    type="text" name="name"
                    value="{{ old('name') }}"
                    class="input-glass {{ $errors->has('name') ? 'err' : '' }}"
                    placeholder="Nama lengkap kamu"
                    required autofocus
                />
                @error('name')
                    <p style="color:#f87171;font-size:12px;margin-top:5px;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div class="fade-in d2" style="margin-bottom:14px;">
                <label>Email</label>
                <input
                    type="email" name="email"
                    value="{{ old('email') }}"
                    class="input-glass {{ $errors->has('email') ? 'err' : '' }}"
                    placeholder="nama@email.com"
                    required
                />
                @error('email')
                    <p style="color:#f87171;font-size:12px;margin-top:5px;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div class="fade-in d3" style="margin-bottom:14px;">
                <label>Password</label>
                <div style="position:relative;">
                    <input
                        type="password" name="password" id="pwd1"
                        class="input-glass {{ $errors->has('password') ? 'err' : '' }}"
                        style="padding-right:44px;"
                        placeholder="Minimal 8 karakter"
                        required
                    />
                    <button type="button" onclick="togglePwd('pwd1','es1','eh1')"
                        style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:rgba(255,255,255,0.35);display:flex;align-items:center;">
                        <svg id="es1" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <svg id="eh1" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:none;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p style="color:#f87171;font-size:12px;margin-top:5px;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div class="fade-in d4" style="margin-bottom:14px;">
                <label>Konfirmasi Password</label>
                <div style="position:relative;">
                    <input
                        type="password" name="password_confirmation" id="pwd2"
                        class="input-glass"
                        style="padding-right:44px;"
                        placeholder="Ulangi password"
                        required
                    />
                    <button type="button" onclick="togglePwd('pwd2','es2','eh2')"
                        style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:rgba(255,255,255,0.35);display:flex;align-items:center;">
                        <svg id="es2" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <svg id="eh2" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:none;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Info --}}
            <div class="fade-in d5" style="margin-bottom:18px;padding:11px 14px;background:rgba(251,191,36,0.10);border:1px solid rgba(251,191,36,0.20);border-radius:10px;">
                <p style="color:rgba(253,224,71,0.85);font-size:12px;line-height:1.6;">
                    ℹ️ Daftar mandiri hanya untuk <strong>User</strong>.
                     <strong> & </strong>Pastikan Email Aktif Untuk Meminta<strong> Kode Verifikasi‼️</strong>
                </p>
            </div>

            {{-- Submit --}}
            <div class="fade-in d6">
                <button type="submit" class="btn-masuk">Daftar Sekarang →</button>
            </div>
        </form>

        <div class="divider fade-in d7" style="margin:20px 0;">
            <span style="color:rgba(255,255,255,0.28);font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.12em;">atau</span>
        </div>

        <p class="fade-in d8" style="text-align:center;font-size:14px;color:rgba(255,255,255,0.4);">
            Sudah punya akun?
            <a href="{{ route('login') }}" style="color:#4ade80;font-weight:700;text-decoration:none;">
                Masuk di sini
            </a>
        </p>

        <p class="fade-in d9" style="text-align:center;font-size:11.5px;color:rgba(255,255,255,0.18);margin-top:28px;">
            &copy; {{ date('Y') }} SpaceGo Management System.
        </p>
    </div>

    <script>
        /* ── Toggle password visibility ── */
        function togglePwd(inp, showId, hideId) {
            const i = document.getElementById(inp);
            const s = document.getElementById(showId);
            const h = document.getElementById(hideId);
            const isPass = i.type === 'password';
            i.type = isPass ? 'text' : 'password';
            s.style.display = isPass ? 'none' : 'block';
            h.style.display = isPass ? 'block' : 'none';
        }

        /* ── OTP Toast ── */
        let _otpTimer = null;

        function showOtpToast() {
            const toast = document.getElementById('otp-toast');

            // Reset timer jika toast sudah muncul
            if (_otpTimer) {
                clearTimeout(_otpTimer);
                _otpTimer = null;
            }

            // Paksa reflow agar transisi berjalan ulang
            toast.classList.remove('show', 'hide');
            void toast.offsetWidth;

            toast.classList.add('show');

            // Hilang setelah 3 detik
            _otpTimer = setTimeout(function () {
                toast.classList.remove('show');
                toast.classList.add('hide');
                _otpTimer = null;
            }, 3000);
        }

        /* ── Tampilkan toast otomatis jika ada session flash dari Laravel ── */
        @if(session('otp_sent'))
            document.addEventListener('DOMContentLoaded', function () {
                showOtpToast();
            });
        @endif
    </script>
</body>
</html>
