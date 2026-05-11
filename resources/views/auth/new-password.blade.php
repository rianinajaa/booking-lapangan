<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Baru — SpaceGo</title>
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
                <span style="color:white;font-weight:900;font-size:18px;letter-spacing:0.15em;text-transform:uppercase;">SpaceGo</span>
            </div>
        </div>
        <div class="fade-in d2" style="padding-bottom:60px;">
            <p style="color:#4ade80;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.18em;margin-bottom:16px;display:flex;align-items:center;gap:8px;">
                <span style="width:8px;height:8px;background:#4ade80;border-radius:50%;display:inline-block;animation:pulse 2s infinite;"></span>
                Password Baru
            </p>
            <h1 style="color:white;font-size:clamp(2.2rem,3.5vw,3.2rem);font-weight:900;line-height:1.12;margin-bottom:20px;">
                Buat <span style="color:#4ade80;">Password</span><br>Yang Kuat.
            </h1>
            <p style="color:rgba(255,255,255,0.45);font-size:14px;line-height:1.75;max-width:360px;">
                Gunakan kombinasi huruf besar, huruf kecil, angka, dan simbol untuk password yang lebih aman.
            </p>
        </div>
    </div>

    <div class="panel-right">
        <div class="fade-in">
            <p style="color:rgba(255,255,255,0.35);font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.18em;margin-bottom:6px;">SpaceGo</p>
            <h2 style="color:white;font-size:24px;font-weight:800;line-height:1.25;">Buat Password Baru 🔑</h2>
            <p style="color:rgba(255,255,255,0.45);font-size:13px;margin-top:8px;margin-bottom:28px;line-height:1.6;">
                Masukkan password baru untuk akun <span style="color:#4ade80;font-weight:700;">{{ session('reset_email') }}</span>.
            </p>
        </div>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            {{-- Password Baru --}}
            <div class="fade-in d1" style="margin-bottom:16px;">
                <label>Password Baru</label>
                <div style="position:relative;">
                    <input type="password" name="password" id="pwd1"
                        class="input-glass {{ $errors->has('password') ? 'err' : '' }}"
                        style="padding-right:44px;" placeholder="Minimal 8 karakter" required/>
                    <button type="button" onclick="togglePwd('pwd1','es1','eh1')"
                        style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:rgba(255,255,255,0.35);display:flex;align-items:center;">
                        <svg id="es1" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <svg id="eh1" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:none;"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                    </button>
                </div>
                @error('password')
                    <p style="color:#f87171;font-size:12px;margin-top:5px;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div class="fade-in d2" style="margin-bottom:24px;">
                <label>Konfirmasi Password</label>
                <div style="position:relative;">
                    <input type="password" name="password_confirmation" id="pwd2"
                        class="input-glass"
                        style="padding-right:44px;" placeholder="Ulangi password baru" required/>
                    <button type="button" onclick="togglePwd('pwd2','es2','eh2')"
                        style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:rgba(255,255,255,0.35);display:flex;align-items:center;">
                        <svg id="es2" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <svg id="eh2" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:none;"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                    </button>
                </div>
            </div>

            <div class="fade-in d3">
                <button type="submit" class="btn-masuk">Simpan Password Baru →</button>
            </div>
        </form>

        <p class="fade-in d4" style="text-align:center;font-size:11.5px;color:rgba(255,255,255,0.18);margin-top:28px;">
            &copy; {{ date('Y') }} SpaceGo Management System.
        </p>
    </div>

    <script>
        function togglePwd(inp, showId, hideId) {
            const i = document.getElementById(inp);
            const s = document.getElementById(showId);
            const h = document.getElementById(hideId);
            const isPass = i.type === 'password';
            i.type = isPass ? 'text' : 'password';
            s.style.display = isPass ? 'none' : 'block';
            h.style.display = isPass ? 'block' : 'none';
        }
    </script>
</body>
</html>
