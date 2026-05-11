<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User</title>
</head>
<body>
    <h1>Dashboard User</h1>
    <p>Selamat datang, {{ auth()->user()->name }}!</p>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>

    {{-- Popup Email Terverifikasi --}}
@if(session('verified'))
<div id="verified-popup"
    style="position:fixed;inset:0;z-index:9999;display:flex;align-items:center;justify-content:center;padding:20px;">

    {{-- Backdrop --}}
    <div style="position:absolute;inset:0;background:rgba(0,0,0,0.55);backdrop-filter:blur(6px);"
        onclick="closePopup()"></div>

    {{-- Card --}}
    <div style="position:relative;z-index:1;background:rgba(8,12,22,0.85);border:1px solid rgba(74,222,128,0.25);
                border-radius:20px;padding:44px 40px;max-width:420px;width:100%;text-align:center;
                box-shadow:0 24px 64px rgba(0,0,0,0.5);
                animation:popIn 0.4s cubic-bezier(.22,.68,0,1.2) both;">

        {{-- Icon --}}
        <div style="width:72px;height:72px;background:rgba(74,222,128,0.12);border:2px solid rgba(74,222,128,0.35);
                    border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;">
            <svg width="34" height="34" fill="none" stroke="#4ade80" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
        </div>

        {{-- Text --}}
        <p style="color:rgba(255,255,255,0.35);font-size:11px;font-weight:700;text-transform:uppercase;
                  letter-spacing:0.18em;margin-bottom:8px;">SpaceGo</p>
        <h2 style="color:white;font-size:22px;font-weight:800;line-height:1.3;margin-bottom:10px;">
            Email Terverifikasi! 🎉
        </h2>
        <p style="color:rgba(255,255,255,0.5);font-size:13.5px;line-height:1.7;margin-bottom:28px;">
            Selamat datang di SpaceGo! Akun kamu berhasil dibuat dan email kamu telah terverifikasi.
        </p>

        {{-- Button --}}
        <button onclick="closePopup()"
            style="width:100%;background:#ffffff;color:#08090f;padding:13px;border-radius:10px;
                   font-weight:800;font-size:14px;border:none;cursor:pointer;letter-spacing:0.02em;
                   transition:background 0.2s,box-shadow 0.2s;">
            Mulai Booking →
        </button>
    </div>
</div>

<style>
    @keyframes popIn {
        from { opacity:0; transform:scale(0.88) translateY(20px); }
        to   { opacity:1; transform:scale(1) translateY(0); }
    }
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
    #verified-popup * { font-family: 'Plus Jakarta Sans', sans-serif; box-sizing: border-box; }
</style>

<script>
    function closePopup() {
        const popup = document.getElementById('verified-popup');
        popup.style.transition = 'opacity 0.25s';
        popup.style.opacity = '0';
        setTimeout(() => popup.remove(), 250);
    }

    // Auto close setelah 4 detik
    setTimeout(closePopup, 4000);
</script>
@endif
</body>
</html>
