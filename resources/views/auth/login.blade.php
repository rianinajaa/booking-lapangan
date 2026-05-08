<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Booking Lapangan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap"
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
        }

        /* ===================== SHARED BG ===================== */
        .bg-lapangan {
            background-image: url('https://images.unsplash.com/photo-1574629810360-7efbbe195018?w=1600&auto=format&fit=crop&q=85');
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

        /* ===================== DESKTOP ===================== */
        .panel-right {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            width: 420px;
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

        label.lbl {
            display: block;
            color: rgba(255, 255, 255, 0.65);
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .btn-masuk-desktop {
            width: 100%;
            background: #fff;
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

        .btn-masuk-desktop:hover {
            background: #dcfce7;
            box-shadow: 0 6px 24px rgba(74, 222, 128, 0.22);
        }

        .btn-masuk-desktop:active {
            transform: scale(0.99);
        }

        .divider-d {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .divider-d::before,
        .divider-d::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(255, 255, 255, 0.10);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateX(18px)
            }

            to {
                opacity: 1;
                transform: translateX(0)
            }
        }

        .fade-in {
            animation: fadeIn 0.5s cubic-bezier(.22, .68, 0, 1.1) both;
        }

        .d1 {
            animation-delay: .05s
        }

        .d2 {
            animation-delay: .10s
        }

        .d3 {
            animation-delay: .15s
        }

        .d4 {
            animation-delay: .20s
        }

        .d5 {
            animation-delay: .25s
        }

        .d6 {
            animation-delay: .30s
        }

        .d7 {
            animation-delay: .35s
        }

        .d8 {
            animation-delay: .40s
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1
            }

            50% {
                opacity: 0.4
            }
        }

        /* ===================== MOBILE ===================== */
        @media (max-width: 640px) {

            html,
            body {
                height: 100%;
                overflow: hidden;
            }

            .panel-left,
            .panel-right,
            .bg-overlay {
                display: none !important;
            }

            /* Hero foto: 35% layar */
            .mobile-hero {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                height: 35vh;
                background-image: url('https://images.unsplash.com/photo-1574629810360-7efbbe195018?w=900&auto=format&fit=crop&q=85');
                background-size: cover;
                background-position: center top;
                z-index: 2;
            }

            .mobile-hero-overlay {
                position: absolute;
                inset: 0;
                background: linear-gradient(to bottom, rgba(0, 0, 0, 0.28) 0%, rgba(0, 0, 0, 0.05) 60%, transparent 100%);
            }

            .mobile-hero-text {
                position: absolute;
                bottom: 14px;
                left: 18px;
                right: 18px;
            }

            /* Form sheet dari bawah, overlap ke hero */
            .mobile-form-sheet {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                top: 29vh;
                background: rgba(8, 12, 22, 0.80);
                backdrop-filter: blur(24px);
                -webkit-backdrop-filter: blur(24px);
                border-top-left-radius: 22px;
                border-top-right-radius: 22px;
                border-top: 1px solid rgba(255, 255, 255, 0.10);
                z-index: 10;
                overflow-y: auto;
                padding: 14px 20px 24px;
            }

            /* Handle bar */
            .mobile-handle {
                width: 36px;
                height: 3.5px;
                background: rgba(255, 255, 255, 0.18);
                border-radius: 99px;
                margin: 0 auto 14px;
            }

            /* Input mobile lebih kecil */
            .input-mobile {
                width: 100%;
                padding: 9px 13px;
                background: rgba(255, 255, 255, 0.07);
                border: 1px solid rgba(255, 255, 255, 0.15);
                border-radius: 9px;
                font-size: 13px;
                color: #fff;
                outline: none;
                transition: all 0.2s;
            }

            .input-mobile:focus {
                border-color: rgba(74, 222, 128, 0.55);
                background: rgba(255, 255, 255, 0.10);
                box-shadow: 0 0 0 2px rgba(74, 222, 128, 0.10);
            }

            .input-mobile::placeholder {
                color: rgba(255, 255, 255, 0.28);
            }

            .input-mobile.err {
                border-color: rgba(248, 113, 113, 0.55);
            }

            label.lbl-m {
                display: block;
                color: rgba(255, 255, 255, 0.58);
                font-size: 11.5px;
                font-weight: 600;
                margin-bottom: 5px;
            }

            .btn-masuk-mobile {
                width: 100%;
                background: #fff;
                color: #08090f;
                padding: 11px;
                border-radius: 10px;
                font-weight: 800;
                font-size: 13.5px;
                letter-spacing: 0.02em;
                border: none;
                cursor: pointer;
                transition: background 0.2s, transform 0.1s;
            }

            .btn-masuk-mobile:active {
                transform: scale(0.98);
            }

            @keyframes slideUp {
                from {
                    opacity: 0;
                    transform: translateY(28px)
                }

                to {
                    opacity: 1;
                    transform: translateY(0)
                }
            }

            .mobile-form-sheet {
                animation: slideUp 0.4s cubic-bezier(.22, .68, 0, 1.1) both;
            }

            @keyframes fadeDown {
                from {
                    opacity: 0;
                    transform: translateY(-10px)
                }

                to {
                    opacity: 1;
                    transform: translateY(0)
                }
            }

            .mobile-hero-text {
                animation: fadeDown 0.45s ease both;
                animation-delay: 0.1s;
            }
        }

        /* Sembunyikan mobile di desktop */
        @media (min-width: 641px) {

            .mobile-hero,
            .mobile-form-sheet {
                display: none !important;
            }
        }
    </style>
</head>

<body>

    <div class="bg-lapangan"></div>
    <div class="bg-overlay"></div>

    {{-- ===== MOBILE HERO ===== --}}
    <div class="mobile-hero">
        <div class="mobile-hero-overlay"></div>
        <div class="mobile-hero-text">
            <p
                style="color:#4ade80;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.18em;margin-bottom:5px;display:flex;align-items:center;gap:5px;">
                <span
                    style="width:5px;height:5px;background:#4ade80;border-radius:50%;display:inline-block;animation:pulse 2s infinite;"></span>
                Booking Lapangan
            </p>
            <h1 style="color:white;font-size:1.65rem;font-weight:900;line-height:1.15;">
                Elevate Your <span style="color:#4ade80;">Arena.</span>
            </h1>
        </div>
    </div>

    {{-- ===== MOBILE FORM SHEET ===== --}}
    <div class="mobile-form-sheet">
        <div class="mobile-handle"></div>

        {{-- Header --}}
        <div style="margin-bottom:12px;">
            <p
                style="color:rgba(255,255,255,0.32);font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.16em;margin-bottom:3px;">
                SpaceG</p>
            <h2 style="color:white;font-size:18px;font-weight:800;line-height:1.2;">Selamat Datang Kembali 👋</h2>
            <p style="color:rgba(255,255,255,0.42);font-size:12px;margin-top:4px;">Masuk untuk mengelola jadwal kamu.
            </p>
        </div>

        @if ($errors->any())
            <div
                style="margin-bottom:10px;padding:9px 12px;background:rgba(248,113,113,0.12);border:1px solid rgba(248,113,113,0.25);border-radius:9px;color:#fca5a5;font-size:12px;">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- Email --}}
            <div style="margin-bottom:10px;">
                <label class="lbl-m">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="input-mobile {{ $errors->has('email') ? 'err' : '' }}" placeholder="nama@perusahaan.com"
                    required autofocus />
                @error('email')
                    <p style="color:#f87171;font-size:11px;margin-top:4px;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div style="margin-bottom:10px;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:5px;">
                    <label class="lbl-m" style="margin-bottom:0;">Kata Sandi</label>
                    <a href="{{ route('password.request') }}"
                        style="color:#4ade80;font-size:11px;font-weight:600;text-decoration:none;">Lupa Password?</a>
                </div>
                <div style="position:relative;">
                    <input type="password" name="password" id="mpwd"
                        class="input-mobile {{ $errors->has('password') ? 'err' : '' }}" style="padding-right:38px;"
                        placeholder="••••••••" required />
                    <button type="button" onclick="togglePwd('mpwd','mes','meh')"
                        style="position:absolute;right:11px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:rgba(255,255,255,0.38);display:flex;align-items:center;">
                        <svg id="mes" width="15" height="15" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg id="meh" width="15" height="15" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24" style="display:none;">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p style="color:#f87171;font-size:11px;margin-top:4px;">{{ $message }}</p>
                @enderror
            </div>


            {{-- Remember --}}
            <div style="display:flex;align-items:center;gap:7px;margin-bottom:14px;">
                <input type="checkbox" name="remember" id="mrem"
                    style="width:13px;height:13px;accent-color:#4ade80;">
                <label for="mrem"
                    style="color:rgba(255,255,255,0.50);font-size:12px;font-weight:400;cursor:pointer;margin:0;">Ingat
                    saya selama 30 hari</label>
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn-masuk-mobile">Masuk →</button>
        </form>

        {{-- Divider --}}
        <div style="display:flex;align-items:center;gap:10px;margin:12px 0;">
            <div style="flex:1;height:1px;background:rgba(255,255,255,0.09);"></div>
            <span
                style="color:rgba(255,255,255,0.25);font-size:10px;font-weight:600;text-transform:uppercase;letter-spacing:0.1em;">atau</span>
            <div style="flex:1;height:1px;background:rgba(255,255,255,0.09);"></div>
        </div>

        {{-- Register --}}
        <p style="text-align:center;font-size:12.5px;color:rgba(255,255,255,0.38);">
            Belum punya akun?
            <a href="{{ route('register') }}" style="color:#4ade80;font-weight:700;text-decoration:none;">Daftar
                sekarang</a>
        </p>

        <p style="text-align:center;font-size:10px;color:rgba(255,255,255,0.15);margin-top:12px;">
            &copy; {{ date('Y') }} SpaceGo Management System.
        </p>
    </div>

    {{-- ===== DESKTOP: Branding kiri ===== --}}
    <div class="panel-left">
        <div class="fade-in">
            <div style="display:flex;align-items:center;margin-top:-74px;margin-left:-34px;">
                <img src="{{ asset('images/spacego_logo.png') }}" alt="SpaceGo"
                    style="height:190px;width:auto;object-fit:contain;">
            </div>
        </div>
        <div class="fade-in d2" style="padding-bottom:60px;">
            <p
                style="color:#4ade80;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.18em;margin-bottom:16px;display:flex;align-items:center;gap:8px;">
                <span
                    style="width:8px;height:8px;background:#4ade80;border-radius:50%;display:inline-block;animation:pulse 2s infinite;"></span>
                Sistem Booking Online
            </p>
            <h1
                style="color:white;font-size:clamp(2.2rem,3.5vw,3.2rem);font-weight:900;line-height:1.12;margin-bottom:20px;">
                Elevate Your<br><span style="color:#4ade80;">Arena</span> Management.
            </h1>
            <p style="color:rgba(255,255,255,0.45);font-size:14px;line-height:1.75;max-width:360px;">
                Seamless scheduling and premium facility coordination for elite sports venues — in one platform.
            </p>
        </div>
    </div>

    {{-- ===== DESKTOP: Panel kanan ===== --}}
    <div class="panel-right">
        <div class="fade-in">
            <p
                style="color:rgba(255,255,255,0.35);font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.18em;margin-bottom:6px;">
                SpaceGo</p>
            <h2 style="color:white;font-size:26px;font-weight:800;line-height:1.25;">Selamat Datang<br>Kembali 👋</h2>
            <p
                style="color:rgba(255,255,255,0.45);font-size:13.5px;margin-top:8px;margin-bottom:28px;line-height:1.6;">
                Silakan masuk ke akun Anda untuk mengelola jadwal.
            </p>
        </div>

        @if ($errors->any())
            <div class="fade-in d1"
                style="margin-bottom:16px;padding:12px 14px;background:rgba(248,113,113,0.12);border:1px solid rgba(248,113,113,0.25);border-radius:10px;color:#fca5a5;font-size:13px;">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="fade-in d2" style="margin-bottom:16px;">
                <label class="lbl">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="input-glass {{ $errors->has('email') ? 'err' : '' }}" placeholder="nama@perusahaan.com"
                    required autofocus />
                @error('email')
                    <p style="color:#f87171;font-size:12px;margin-top:6px;">{{ $message }}</p>
                @enderror
            </div>

            <div class="fade-in d3" style="margin-bottom:16px;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;">
                    <label class="lbl" style="margin-bottom:0;">Kata Sandi</label>
                    <a href="{{ route('password.request') }}"
                        style="color:#4ade80;font-size:11px;font-weight:600;text-decoration:none;">Lupa Password?</a>
                </div>
                <div style="position:relative;">
                    <input type="password" name="password" id="dpwd"
                        class="input-glass {{ $errors->has('password') ? 'err' : '' }}" style="padding-right:44px;"
                        placeholder="••••••••" required />
                    <button type="button" onclick="togglePwd('dpwd','des','deh')"
                        style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:rgba(255,255,255,0.35);display:flex;align-items:center;">
                        <svg id="des" width="17" height="17" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg id="deh" width="17" height="17" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24" style="display:none;">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p style="color:#f87171;font-size:12px;margin-top:6px;">{{ $message }}</p>
                @enderror
            </div>

            <div class="fade-in d4" style="display:flex;align-items:center;gap:8px;margin-bottom:22px;">
                <input type="checkbox" name="remember" id="drem"
                    style="width:15px;height:15px;accent-color:#4ade80;">
                <label for="drem" class="lbl"
                    style="margin-bottom:0;font-weight:400;font-size:13.5px;cursor:pointer;">Ingat saya selama 30
                    hari</label>
            </div>

            <div class="fade-in d5">
                <button type="submit" class="btn-masuk-desktop">Masuk →</button>
            </div>

            {{-- Divider --}}
            <div class="fade-in d5" style="display:flex;align-items:center;gap:10px;margin:18px 0 0 0;">
                <div style="flex:1;height:1px;background:rgba(255,255,255,0.12);"></div>
                <span
                    style="color:rgba(255,255,255,0.35);font-size:11px;font-weight:600;letter-spacing:1px;">ATAU</span>
                <div style="flex:1;height:1px;background:rgba(255,255,255,0.12);"></div>
            </div>

            {{-- Error Google --}}
            @if (session('error'))
                <p style="color:#f87171;font-size:12px;text-align:center;margin-top:10px;">
                    {{ session('error') }}
                </p>
            @endif

            {{-- Tombol Google --}}
            <div class="fade-in d5" style="margin-top:12px;">
                <a href="{{ route('auth.google') }}"
                    style="display:flex;align-items:center;justify-content:center;gap:10px;
                   width:100%;padding:12px 0;border-radius:10px;
                   background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.12);
                   color:rgba(255,255,255,0.85);font-size:13.5px;font-weight:600;
                   text-decoration:none;transition:background 0.2s;"
                    onmouseover="this.style.background='rgba(255,255,255,0.13)'"
                    onmouseout="this.style.background='rgba(255,255,255,0.07)'">
                    <svg width="18" height="18" viewBox="0 0 48 48">
                        <path fill="#EA4335"
                            d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z" />
                        <path fill="#4285F4"
                            d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z" />
                        <path fill="#FBBC05"
                            d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z" />
                        <path fill="#34A853"
                            d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.18 1.48-4.97 2.31-8.16 2.31-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z" />
                    </svg>
                    Masuk dengan Google
                </a>
            </div>

        </form>

        <p class="fade-in d7" style="text-align:center;font-size:14px;color:rgba(255,255,255,0.4);">
            Belum punya akun?
            <a href="{{ route('register') }}" style="color:#4ade80;font-weight:700;text-decoration:none;">Daftar
                sekarang</a>
        </p>

        <p class="fade-in d8"
            style="text-align:center;font-size:11.5px;color:rgba(255,255,255,0.18);margin-top:32px;">
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
