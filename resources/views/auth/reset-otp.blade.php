<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP — BookLap</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; box-sizing: border-box; margin: 0; padding: 0; }
        html, body { height: 100%; overflow: hidden; }
        .bg-lapangan { background-image: url('https://images.unsplash.com/photo-1574629810360-7efbbe195018?w=1600&auto=format&fit=crop&q=85'); background-size: cover; background-position: center; position: fixed; inset: 0; z-index: 0; }
        .bg-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.38); z-index: 1; }
        .panel-right { position: fixed; top: 0; right: 0; bottom: 0; width: 480px; background: rgba(8,12,22,0.62); backdrop-filter: blur(28px); -webkit-backdrop-filter: blur(28px); border-left: 1px solid rgba(255,255,255,0.08); z-index: 10; display: flex; flex-direction: column; justify-content: center; padding: 44px; overflow-y: auto; }
        .panel-left { position: fixed; top: 0; left: 0; bottom: 0; right: 420px; z-index: 5; display: flex; flex-direction: column; justify-content: space-between; padding: 40px 48px; }
        .input-glass { width: 100%; padding: 12px 16px; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.14); border-radius: 10px; font-size: 14px; color: #fff; outline: none; transition: all 0.2s; }
        .input-glass:focus { border-color: rgba(74,222,128,0.55); background: rgba(255,255,255,0.09); box-shadow: 0 0 0 3px rgba(74,222,128,0.10); }
        .input-glass::placeholder { color: rgba(255,255,255,0.28); }
        .input-glass.err { border-color: rgba(248,113,113,0.55); }
        label { display: block; color: rgba(255,255,255,0.65); font-size: 13px; font-weight: 600; margin-bottom: 6px; }
        .btn-masuk { width: 100%; background: #ffffff; color: #08090f; padding: 13px; border-radius: 10px; font-weight: 800; font-size: 14.5px; letter-spacing: 0.02em; border: none; cursor: pointer; transition: background 0.2s, box-shadow 0.2s, transform 0.1s; }
        .btn-masuk:hover { background: #dcfce7; box-shadow: 0 6px 24px rgba(74,222,128,0.22); }
        .btn-masuk:active { transform: scale(0.99); }
        @keyframes fadeIn { from { opacity: 0; transform: translateX(18px); } to { opacity: 1; transform: translateX(0); } }
        .fade-in { animation: fadeIn 0.5s cubic-bezier(.22,.68,0,1.1) both; }
        .d1{animation-delay:.05s} .d2{animation-delay:.10s} .d3{animation-delay:.15s} .d4{animation-delay:.20s} .d5{animation-delay:.25s}
        @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.4; } }
        @media (max-width: 640px) { .panel-right { width: 100%; border-left: none; padding: 36px 24px; } .panel-left { display: none; } }
    </style>
</head>
<body>
    <div class="bg-lapangan"></div>
    <div class="bg-overlay"></div>

    <div class="panel-left">
        <div class="fade-in">
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:36px;height:36px;background:#4ade80;border-radius:10px;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 16px rgba(74,222,128,0.35);">
                    <svg width="18" height="18" fill="none" stroke="#14532d" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <span style="color:white;font-weight:900;font-size:18px;letter-spacing:0.15em;text-transform:uppercase;">BookLap</span>
            </div>
        </div>
        <div class="fade-in d2" style="padding-bottom:60px;">
            <p style="color:#4ade80;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.18em;margin-bottom:16px;display:flex;align-items:center;gap:8px;">
                <span style="width:8px;height:8px;background:#4ade80;border-radius:50%;display:inline-block;animation:pulse 2s infinite;"></span>
                Verifikasi OTP
            </p>
            <h1 style="color:white;font-size:clamp(2.2rem,3.5vw,3.2rem);font-weight:900;line-height:1.12;margin-bottom:20px;">
                Cek <span style="color:#4ade80;">Email</span><br>Kamu Sekarang.
            </h1>
            <p style="color:rgba(255,255,255,0.45);font-size:14px;line-height:1.75;max-width:360px;">
                Kode OTP sudah dikirim. Masukkan kode tersebut untuk melanjutkan proses reset password.
            </p>
        </div>
    </div>

    <div class="panel-right">
        <div class="fade-in">
            <p style="color:rgba(255,255,255,0.35);font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.18em;margin-bottom:6px;">BookLap</p>
            <h2 style="color:white;font-size:24px;font-weight:800;line-height:1.25;">Masukkan Kode OTP 📩</h2>
            <p style="color:rgba(255,255,255,0.45);font-size:13px;margin-top:8px;margin-bottom:24px;line-height:1.6;">
                Kode OTP dikirim ke <span style="color:#4ade80;font-weight:700;">{{ session('reset_email') }}</span>.
            </p>
        </div>

        @if(session('resent'))
            <div class="fade-in" style="margin-bottom:16px;padding:11px 14px;background:rgba(74,222,128,0.10);border:1px solid rgba(74,222,128,0.25);border-radius:10px;">
                <p style="color:#4ade80;font-size:12px;">✅ {{ session('resent') }}</p>
            </div>
        @endif

        <form method="POST" action="{{ route('password.otp.verify') }}">
            @csrf
            <div class="fade-in d1" style="margin-bottom:24px;">
                <label>Kode OTP</label>
                <input type="text" name="otp" maxlength="6"
                    class="input-glass {{ $errors->has('otp') ? 'err' : '' }}"
                    style="text-align:center;font-size:26px;font-weight:800;letter-spacing:12px;padding:16px;"
                    placeholder="••••••" autofocus required inputmode="numeric" autocomplete="one-time-code"/>
                @error('otp')
                    <p style="color:#f87171;font-size:12px;margin-top:5px;">{{ $message }}</p>
                @enderror
            </div>
            <div class="fade-in d2">
                <button type="submit" class="btn-masuk">Verifikasi →</button>
            </div>
        </form>

        <form method="POST" action="{{ route('password.resend') }}">
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

        <p class="fade-in d4" style="text-align:center;font-size:14px;color:rgba(255,255,255,0.4);margin-top:20px;">
            Salah email?
            <a href="{{ route('password.request') }}" style="color:#4ade80;font-weight:700;text-decoration:none;">Ulangi</a>
        </p>

        <p class="fade-in d5" style="text-align:center;font-size:11.5px;color:rgba(255,255,255,0.18);margin-top:28px;">
            &copy; {{ date('Y') }} BookLap Management System.
        </p>
    </div>

    <script>
        let sisa = 30;
        const btn = document.getElementById('resend-btn');
        const label = document.getElementById('resend-label');
        const countEl = document.getElementById('resend-countdown');
        const interval = setInterval(() => {
            sisa--;
            if (countEl) countEl.textContent = sisa;
            if (sisa <= 0) {
                clearInterval(interval);
                btn.disabled = false;
                btn.style.cursor = 'pointer';
                label.style.color = '#4ade80';
                label.innerHTML = 'Kirim ulang OTP';
            }
        }, 1000);
    </script>
</body>
</html>