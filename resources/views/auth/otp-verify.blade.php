<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP — SpaceGo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html,
        body {
            height: 100%;
            overflow: hidden;
        }

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
            top: 0;
            right: 0;
            bottom: 0;
            width: 480px;
            background: rgba(8, 12, 22, 0.62);
            backdrop-filter: blur(28px);
            -webkit-backdrop-filter: blur(28px);
            border-left: 1px solid rgba(255, 255, 255, 0.08);
            z-index: 10;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 44px 44px;
            overflow-y: auto;
        }

        .panel-left {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
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
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.14);
            border-radius: 10px;
            font-size: 14px;
            color: #fff;
            outline: none;
            transition: all 0.2s;
        }

        .input-glass:focus {
            border-color: rgba(74, 222, 128, 0.55);
            background: rgba(255, 255, 255, 0.09);
            box-shadow: 0 0 0 3px rgba(74, 222, 128, 0.10);
        }

        .input-glass::placeholder {
            color: rgba(255, 255, 255, 0.28);
        }

        .input-glass.err {
            border-color: rgba(248, 113, 113, 0.55);
        }

        label {
            display: block;
            color: rgba(255, 255, 255, 0.65);
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 6px;
        }

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
            box-shadow: 0 6px 24px rgba(74, 222, 128, 0.22);
        }

        .btn-masuk:active {
            transform: scale(0.99);
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(255, 255, 255, 0.10);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateX(18px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        .fade-in { animation: fadeIn 0.5s cubic-bezier(.22, .68, 0, 1.1) both; }
        .d1 { animation-delay: .05s }
        .d2 { animation-delay: .10s }
        .d3 { animation-delay: .15s }
        .d4 { animation-delay: .20s }
        .d5 { animation-delay: .25s }
        .d6 { animation-delay: .30s }
        .d7 { animation-delay: .35s }
        .d8 { animation-delay: .40s }
        .d9 { animation-delay: .45s }

        @media (max-width: 640px) {
            .panel-right { width: 100%; border-left: none; padding: 36px 24px; }
            .panel-left  { display: none; }
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50%       { opacity: 0.4; }
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
            transition: opacity 0.35s ease, transform 0.35s cubic-bezier(.22, .68, 0, 1.1);
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

    {{-- Toast OTP (muncul otomatis jika session resent ada) --}}
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
                Verifikasi Email
            </p>
            <h1 style="color:white;font-size:clamp(2.2rem,3.5vw,3.2rem);font-weight:900;line-height:1.12;margin-bottom:20px;">
                Satu Langkah<br>
                <span style="color:#4ade80;">Lagi</span> Menuju Akun.
            </h1>
            <p style="color:rgba(255,255,255,0.45);font-size:14px;line-height:1.75;max-width:360px;">
                Kami telah mengirimkan kode verifikasi ke email kamu. Masukkan kode tersebut untuk mengaktifkan akun.
            </p>
        </div>
    </div>

    {{-- Panel kanan: Form OTP --}}
    <div class="panel-right">

        <div class="fade-in">
            <p style="color:rgba(255,255,255,0.35);font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.18em;margin-bottom:6px;">
                SpaceGo
            </p>
            <h2 style="color:white;font-size:24px;font-weight:800;line-height:1.25;">Verifikasi Email 📩</h2>
            <p style="color:rgba(255,255,255,0.45);font-size:13px;margin-top:8px;margin-bottom:24px;line-height:1.6;">
                Kode OTP telah dikirim ke
                <span style="color:#4ade80;font-weight:700;">{{ session('otp_email') }}</span>.
                Berlaku selama <span id="countdown" style="color:#4ade80;font-weight:700;">05:00</span>.
            </p>
        </div>

        {{-- Form verifikasi OTP --}}
        <form method="POST" action="{{ route('register.otp.verify') }}">
            @csrf

            {{-- Input OTP --}}
            <div class="fade-in d1" style="margin-bottom:24px;">
                <label>Kode OTP</label>
                <input
                    type="text"
                    name="otp"
                    maxlength="6"
                    class="input-glass {{ $errors->has('otp') ? 'err' : '' }}"
                    style="text-align:center;font-size:26px;font-weight:800;letter-spacing:12px;padding:16px;"
                    placeholder="••••••"
                    autofocus
                    required
                    inputmode="numeric"
                    autocomplete="one-time-code"
                />
                @error('otp')
                    <p style="color:#f87171;font-size:12px;margin-top:5px;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit --}}
            <div class="fade-in d2">
                <button type="submit" class="btn-masuk">Verifikasi Sekarang →</button>
            </div>
        </form>

        {{-- Kirim ulang OTP --}}
        <form method="POST" action="{{ route('register.resend') }}" id="resend-form">
            @csrf
            <div class="fade-in d3" style="margin-top:16px;text-align:center;">
                <p style="color:rgba(255,255,255,0.4);font-size:13px;">
                    Tidak dapat kode?
                    <button type="submit" id="resend-btn" disabled
                        style="background:none;border:none;font-size:13px;cursor:not-allowed;font-family:inherit;">
                        <span id="resend-label" style="color:rgba(255,255,255,0.25);font-weight:700;">
                            Kirim ulang (<span id="resend-countdown">30</span>s)
                        </span>
                    </button>
                </p>
            </div>
        </form>

        <div class="divider fade-in d4" style="margin:20px 0;">
            <span style="color:rgba(255,255,255,0.28);font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.12em;">atau</span>
        </div>

        <p class="fade-in d5" style="text-align:center;font-size:14px;color:rgba(255,255,255,0.4);">
            Salah email?
            <a href="{{ route('register') }}" style="color:#4ade80;font-weight:700;text-decoration:none;">
                Daftar ulang
            </a>
        </p>

        <p class="fade-in d6" style="text-align:center;font-size:11.5px;color:rgba(255,255,255,0.18);margin-top:28px;">
            &copy; {{ date('Y') }} SpaceGo Management System.
        </p>
    </div>

    <script>
        /* ── Countdown 5 menit ── */
        let seconds = 300;
        const el = document.getElementById('countdown');
        const timer = setInterval(() => {
            seconds--;
            const m = String(Math.floor(seconds / 60)).padStart(2, '0');
            const s = String(seconds % 60).padStart(2, '0');
            el.textContent = `${m}:${s}`;
            if (seconds <= 0) {
                clearInterval(timer);
                el.textContent = 'Kedaluwarsa';
                el.style.color = '#f87171';
            }
        }, 1000);

        /* ── Countdown tombol kirim ulang ── */
        let sisa = 30;
        const btn    = document.getElementById('resend-btn');
        const label  = document.getElementById('resend-label');
        const countEl = document.getElementById('resend-countdown');

        const resendInterval = setInterval(() => {
            sisa--;
            if (countEl) countEl.textContent = sisa;
            if (sisa <= 0) {
                clearInterval(resendInterval);
                btn.disabled = false;
                btn.style.cursor = 'pointer';
                label.style.color = '#4ade80';
                label.innerHTML = 'Kirim ulang OTP';
            }
        }, 1000);

        /* ── OTP Toast ── */
        let _otpTimer = null;

        function showOtpToast() {
            const toast = document.getElementById('otp-toast');
            if (_otpTimer) {
                clearTimeout(_otpTimer);
                _otpTimer = null;
            }
            toast.classList.remove('show', 'hide');
            void toast.offsetWidth; // reflow
            toast.classList.add('show');

            _otpTimer = setTimeout(function () {
                toast.classList.remove('show');
                toast.classList.add('hide');
                _otpTimer = null;
            }, 3000);
        }

        /* ── Tampilkan toast jika session('resent') ada ── */
        @if(session('resent'))
            document.addEventListener('DOMContentLoaded', function () {
                showOtpToast();
            });
        @endif
    </script>
</body>

</html>
