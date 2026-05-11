<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Berhasil — SpaceGo</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            height: 100%;
            background: #08090f;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .bg-lapangan {
            background-image: url('https://images.unsplash.com/photo-1574629810360-7efbbe195018?w=1600&auto=format&fit=crop&q=85');
            background-size: cover;
            background-position: center;
            position: fixed;
            inset: 0;
            z-index: 0;
            filter: brightness(0.25);
        }

        .card {
            position: relative;
            z-index: 10;
            text-align: center;
            padding: 56px 48px;
            max-width: 440px;
            width: 90%;
            animation: popIn 0.5s cubic-bezier(.22,.68,0,1.2) both;
        }

        @keyframes popIn {
            from { opacity: 0; transform: scale(0.85) translateY(24px); }
            to   { opacity: 1; transform: scale(1) translateY(0); }
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; box-shadow: 0 0 0 0 rgba(74,222,128,0.4); }
            50%       { opacity: 0.85; box-shadow: 0 0 0 12px rgba(74,222,128,0); }
        }

        @keyframes checkDraw {
            from { stroke-dashoffset: 50; }
            to   { stroke-dashoffset: 0; }
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .icon-wrap {
            width: 88px;
            height: 88px;
            border-radius: 50%;
            border: 2px solid rgba(74,222,128,0.4);
            background: rgba(74,222,128,0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 28px;
            animation: pulse 2s infinite;
        }

        .check-svg {
            stroke-dasharray: 50;
            stroke-dashoffset: 50;
            animation: checkDraw 0.5s ease 0.3s forwards;
        }

        .label {
            color: #4ade80;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.18em;
            margin-bottom: 12px;
            animation: fadeUp 0.4s ease 0.4s both;
        }

        .title {
            color: #ffffff;
            font-size: 28px;
            font-weight: 900;
            line-height: 1.2;
            margin-bottom: 14px;
            animation: fadeUp 0.4s ease 0.5s both;
        }

        .title span { color: #4ade80; }

        .desc {
            color: rgba(255,255,255,0.45);
            font-size: 13.5px;
            line-height: 1.75;
            margin-bottom: 36px;
            animation: fadeUp 0.4s ease 0.6s both;
        }

        .btn {
            display: inline-block;
            width: 100%;
            background: #4ade80;
            color: #08090f;
            padding: 14px;
            border-radius: 12px;
            font-weight: 800;
            font-size: 14.5px;
            letter-spacing: 0.02em;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.2s, box-shadow 0.2s, transform 0.1s;
            animation: fadeUp 0.4s ease 0.7s both;
        }
        .btn:hover {
            background: #86efac;
            box-shadow: 0 8px 28px rgba(74,222,128,0.35);
        }
        .btn:active { transform: scale(0.99); }

        .progress-bar {
            position: fixed;
            bottom: 0; left: 0;
            height: 3px;
            background: #4ade80;
            width: 100%;
            transform-origin: left;
            animation: shrink 4s linear 0.8s forwards;
            z-index: 20;
        }

        @keyframes shrink {
            from { transform: scaleX(1); }
            to   { transform: scaleX(0); }
        }
    </style>
</head>
<body>

    <div class="bg-lapangan"></div>

    {{-- Progress bar --}}
    <div class="progress-bar"></div>

    <div class="card">

        {{-- Icon --}}
        <div class="icon-wrap">
            <svg width="38" height="38" fill="none" stroke="#4ade80" stroke-width="2.8" viewBox="0 0 24 24">
                <path class="check-svg" stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
        </div>

        {{-- Label --}}
        <p class="label">✦ SpaceGo</p>

        {{-- Title --}}
        <h1 class="title">Email <span>Terverifikasi</span><br>Berhasil! 🎉</h1>

        {{-- Desc --}}
        <p class="desc">
            Selamat datang di SpaceGo!<br>
            Akun kamu sudah aktif dan siap digunakan<br>
            untuk booking lapangan favoritmu.
        </p>

        {{-- Button --}}
        <a href="{{ route('user.dashboard') }}" class="btn">
            Mulai Booking →
        </a>

    </div>

    <script>
        // Auto redirect ke dashboard setelah 4.8 detik
        setTimeout(() => {
            window.location.href = "{{ route('user.dashboard') }}";
        }, 4800);
    </script>

</body>
</html>
