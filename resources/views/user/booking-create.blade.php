<!DOCTYPE html>
<html class="dark" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Booking Fasilitas — SpaceGo</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />

    <!-- Iconify -->
    <script src="https://code.iconify.design/iconify-icon/1.0.8/iconify-icon.min.js"></script>

    <style>
        .material-symbols-outlined {
            font-family: 'Material Symbols Outlined';
            font-weight: normal;
            font-style: normal;
            font-size: 24px;
            line-height: 1;
            letter-spacing: normal;
            text-transform: none;
            display: inline-block;
            white-space: nowrap;
            word-wrap: normal;
            direction: ltr;
            -webkit-font-feature-settings: 'liga';
            -webkit-font-smoothing: antialiased;
        }
    </style>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "emerald-pulse": "#059669",
                        "surface-container-low": "#1c1b1b",
                        "surface": "#131313",
                        "void-base": "#0e0e0e",
                        "primary-container": "#67dba8",
                        "on-primary-container": "#005e41",
                        "on-primary": "#003825",
                        "primary-fixed-dim": "#68dba9",
                        "on-surface": "#e5e2e1",
                        "on-surface-variant": "#bccac0",
                        "surface-container": "#201f1f",
                        "surface-container-high": "#2a2a2a",
                        "surface-container-highest": "#353534",
                        "glass-overlay": "rgba(5, 150, 105, 0.15)",
                        "primary": "#85f8c3",
                        "secondary": "#4edea3",
                        "outline-variant": "#3d4a42",
                        "outline": "#87948b",
                        "error": "#ffb4ab",
                    },
                    borderRadius: {
                        "DEFAULT": "1rem",
                        "lg": "2rem",
                        "xl": "3rem",
                        "full": "9999px"
                    },
                    spacing: {
                        "lg": "48px",
                        "sm": "12px",
                        "md": "24px",
                        "base": "8px",
                        "xs": "4px",
                        "margin": "32px",
                        "xl": "80px",
                        "gutter": "24px"
                    },
                    fontFamily: {
                        "headline-lg": ["Plus Jakarta Sans"],
                        "body-lg": ["Plus Jakarta Sans"],
                        "label-bold": ["Plus Jakarta Sans"],
                        "headline-md": ["Plus Jakarta Sans"],
                        "display-xl-mobile": ["Plus Jakarta Sans"],
                        "body-md": ["Plus Jakarta Sans"],
                        "display-xl": ["Plus Jakarta Sans"]
                    },
                    fontSize: {
                        "headline-lg": ["32px", {
                            "lineHeight": "1.2",
                            "letterSpacing": "-0.02em",
                            "fontWeight": "700"
                        }],
                        "body-lg": ["18px", {
                            "lineHeight": "1.6",
                            "fontWeight": "500"
                        }],
                        "label-bold": ["14px", {
                            "lineHeight": "1",
                            "letterSpacing": "0.1em",
                            "fontWeight": "700"
                        }],
                        "headline-md": ["24px", {
                            "lineHeight": "1.3",
                            "fontWeight": "700"
                        }],
                        "display-xl-mobile": ["40px", {
                            "lineHeight": "1.1",
                            "letterSpacing": "-0.04em",
                            "fontWeight": "800"
                        }],
                        "body-md": ["16px", {
                            "lineHeight": "1.6",
                            "fontWeight": "400"
                        }],
                        "display-xl": ["64px", {
                            "lineHeight": "1.1",
                            "letterSpacing": "-0.04em",
                            "fontWeight": "800"
                        }]
                    }
                }
            }
        }
    </script>

    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .glass-highlight::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at top left, rgba(255, 255, 255, 0.05) 0%, transparent 40%);
            pointer-events: none;
            border-radius: inherit;
        }

        /* Navbar scroll */
        #main-navbar {
            transition: background .3s, backdrop-filter .3s, border-color .3s;
        }

        /* Slot selected state */
        .slot-selected {
            background: #85f8c3;
            color: #003825;
            font-weight: bold;
            box-shadow: 0 0 15px rgba(133, 248, 195, 0.4);
            ring: 1px solid #85f8c3;
        }

        .slot-duration {
            background: #67dba8;
            color: #005e41;
            font-weight: bold;
            border-color: rgba(133, 248, 195, 0.5);
        }

        .slot-taken {
            background: #2a2a2a;
            color: #87948b;
            opacity: 0.5;
            cursor: not-allowed;
            text-decoration: line-through;
        }

        /* Facility card selected */
        .facility-selected {
            border-color: #85f8c3 !important;
            box-shadow: 0 0 20px rgba(133, 248, 195, 0.15);
            ring: 1px solid #85f8c3;
        }

        .facility-selected h3 {
            color: #85f8c3;
        }

        /* Pulse dot */
        @keyframes pulse {

            0%,
            100% {
                opacity: 1
            }

            50% {
                opacity: .5
            }
        }

        .pulse-dot {
            animation: pulse 2s infinite;
        }

        /* Toast */
        #toast {
            transform: translateY(80px);
            opacity: 0;
            transition: all .4s cubic-bezier(.4, 0, .2, 1);
        }

        #toast.show {
            transform: translateY(0);
            opacity: 1;
        }
    </style>
</head>

<body class="bg-void-base text-on-surface font-body-md min-h-screen pb-32 md:pb-0">

    <!-- Ambient BG -->
    <div class="fixed inset-0 z-[-1] overflow-hidden pointer-events-none">
        <div class="absolute top-[-10%] right-[-10%] w-[50vw] h-[50vw] bg-emerald-pulse/20 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-[40vw] h-[40vw] bg-primary/10 rounded-full blur-[100px]"></div>
    </div>

    <!-- ==================== NAVBAR ==================== -->
    <nav id="main-navbar" class="hidden md:flex fixed top-0 w-full z-50 justify-between items-center px-margin h-20">
        <div class="font-display-xl-mobile text-display-xl-mobile font-extrabold text-primary tracking-tighter cursor-pointer hover:opacity-80 transition-all duration-300">SpaceGo</div>
        <div class="flex items-center gap-margin">
            <a class="text-on-surface-variant font-label-bold text-label-bold hover:text-primary transition-all duration-300"
                href="{{ route('user.dashboard') }}">Beranda</a>
            <a class="text-primary border-b-2 border-primary pb-1 font-label-bold text-label-bold"
                href="{{ route('user.fasilitas.index') }}">Jadwal</a>
            <a class="text-on-surface-variant font-label-bold text-label-bold hover:text-primary transition-all duration-300"
                href="{{ route('user.booking.index') }}">Booking Saya</a>
            <a class="text-on-surface-variant font-label-bold text-label-bold hover:text-primary transition-all duration-300"
                href="{{ route('profile') }}">Profil</a>
        </div>
        <div class="flex items-center gap-md text-primary">
            <button class="hover:opacity-70 transition-all duration-300 active:scale-95">
                <iconify-icon icon="solar:bell-bold" width="26" height="26"></iconify-icon>
            </button>
            <a href="{{ route('profile') }}" class="hover:opacity-70 transition-all duration-300 active:scale-95">
                <iconify-icon icon="solar:user-circle-bold" width="26" height="26"></iconify-icon>
            </a>
        </div>
    </nav>

    <script>
        (function() {
            var nav = document.getElementById('main-navbar');

            function upd() {
                if (window.scrollY > 10) {
                    nav.style.background = 'rgba(14,14,14,0.92)';
                    nav.style.backdropFilter = 'blur(20px)';
                    nav.style.borderBottom = '1px solid rgba(61,74,66,0.3)';
                } else {
                    nav.style.background = 'transparent';
                    nav.style.backdropFilter = 'none';
                    nav.style.borderBottom = 'none';
                }
            }
            upd();
            window.addEventListener('scroll', upd, {
                passive: true
            });
        })();
    </script>

    <!-- ==================== MAIN ==================== -->
    <main class="pt-24 px-margin md:px-xl max-w-[1440px] mx-auto">

        <!-- Flash Messages -->
        @if(session('success'))
        <div class="mb-6 px-4 py-3 rounded-xl border border-green-500/30 bg-green-500/10 text-green-400 text-sm flex items-center gap-2">
            <span class="material-symbols-outlined text-[18px]">check_circle</span>
            {{ session('success') }}
        </div>
        @endif
        @if($errors->any())
        <div class="mb-6 px-4 py-3 rounded-xl border border-error/30 bg-error/10 text-error text-sm">
            <div class="flex items-center gap-2 font-bold mb-1">
                <span class="material-symbols-outlined text-[18px]">error</span>Terdapat kesalahan:
            </div>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
        @endif

        <!-- Page Header -->
        <div class="mb-lg">
            <div class="flex items-center gap-2 mb-2">
                <a href="{{ route('user.dashboard') }}"
                    class="text-on-surface-variant hover:text-primary transition-colors flex items-center gap-1 text-sm">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                </a>
                <h1 class="font-headline-lg text-headline-lg text-on-surface">Reservasi Fasilitas</h1>
            </div>
            <p class="font-body-md text-body-md text-on-surface-variant">Pilih fasilitas, tentukan jadwal, dan selesaikan booking kamu.</p>

            {{-- Badge diskon siswa internal --}}
            @if(Auth::user()->role === 'siswa_internal')
            <div class="mt-3 inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-secondary/30 bg-secondary/10">
                <span class="material-symbols-outlined text-secondary text-[16px]">local_offer</span>
                <span class="text-secondary text-sm font-bold">Diskon 20% aktif untuk jam 08.00–15.00, Senin–Jumat</span>
            </div>
            @endif
        </div>

        <form method="POST" action="{{ route('user.booking.store') }}" id="booking-form">
            @csrf

            <div class="lg:grid lg:grid-cols-12 gap-xl items-start">

                <!-- ===================== LEFT COLUMN ===================== -->
                <div class="col-span-12 lg:col-span-8 flex flex-col gap-lg">

                    <!-- ===== STEP 1: Pilih Fasilitas ===== -->
                    <section>
                        <div class="flex items-center gap-sm mb-md">
                            <div class="w-8 h-8 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center font-label-bold text-label-bold">1</div>
                            <h2 class="font-headline-md text-headline-md text-on-surface">Pilih Fasilitas</h2>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-md" id="facility-grid">
                            @foreach($fasilitas as $f)
                            @php
                            $imgMap = [
                            'lapangan basket' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDNJpzQVFK10JoitqYur2pF5zZSYLmqokntLma3j23vnkgtNEjDyQpfFJIz3cX2qGVIVzq-r33xAjTQPDKlmjImtpOrY9xFAO79jpUNhtKeKry6HhKb9R_k-5zAGDl_03IdQhtdRet3Ke-IucMlkzUKnz9RAxjK8pLkIvGgyeBXgrk8t35unFBJ61swwRgzQs8m0QMGQruVS8FjSTEdvvpdsjY7ETspQpuyhjA8GvyKtTl91zhgi3UfCtBbqDuim3DrBha38PBVGeA',
                            'lapangan voli' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAaZ8iWdmGEFA7P7BmJCGt0-4brBKMODWhntpd3xpdUCZDMJfIJYryNP9U9qOBKBoh4bYOCxUzxt_Jw2px3gHDFM9qSR3h5SVVtSzyN01kHidWYW8q0O4InRPFgXNUJ-pJ6u4wlZOdqkm6BcCsx26vLpFJoaKSfB3-p5GrsGaYLqUzZe7_RmcXWNZ0e-IZZQIYoVgQeqROeRRETtHq1WdbY2XgAoGU7e6TbMtjTMac1UjMLPLMQgYuedofxG6YSd2jpyM7DZYBWXZs',
                            'futsal indoor' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCuypwVzw_jZ3uJil6R_Yu6JDbPxm5oQQuChKb2MFJMyhYR3ntLzswcPBZIWdHPpLQtrjsIH8WC6YDllHXaj8Nu4iziClPz1zbi1na601oeXtcJMzG7IpYwfkHZlFgatmxjOHOHNhRYaKU3zw00woYWYIvGhBuoSLoGOyw38aqVKbLCZ7YYVRJoxldF1fuz_PhhwgcityVelAQBBRc6V9l3sZTv-sJD5qGXOdKUsKq97vlMgWy3JAprVz5J65MQGuv7unrav6iw7AI',
                            'lapangan futsal' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCuypwVzw_jZ3uJil6R_Yu6JDbPxm5oQQuChKb2MFJMyhYR3ntLzswcPBZIWdHPpLQtrjsIH8WC6YDllHXaj8Nu4iziClPz1zbi1na601oeXtcJMzG7IpYwfkHZlFgatmxjOHOHNhRYaKU3zw00woYWYIvGhBuoSLoGOyw38aqVKbLCZ7YYVRJoxldF1fuz_PhhwgcityVelAQBBRc6V9l3sZTv-sJD5qGXOdKUsKq97vlMgWy3JAprVz5J65MQGuv7unrav6iw7AI',
                            'lab komputer' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCYDuyAr4wkLD5RDsdeC8LXx9YMN-2RTE2KHwE8lcnHKvacmNNFuXqFxVd69RhRqGm17CiETHUBzwVf-25iUr3FrourgilXcFqWuRn5Yr9xqYVhp_4ODQ2qWn-Pu8H2S5XFwQdVcoIB7xERMvVjzHRz4Hyq3CKv_0S69i5wxVjLKWLNmG0oEmM--z6GqbmvAbBqxODiG0rrUEciRVu9ItAZEiovR_8olj-4NP8QOAfACz3xqerxL1TeoYoW7qHkdpEuFbWi0kSC8_4',
                            'ruang multimedia' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDV44yuVCfqCMCXs5Dnm5XsjF6_HFSAfCsuYj_uRq88uIQpt2E7wdyJdmIEF8nsCPQoaGuJkzrHiIWmB1EJNOa_47a7PsHy_2nOPAs-jkTFo-xNv8LQsTOD981NN9gbIpWCRHq_RtXdh0M_yEk2KGlU-rnFoEBYkOjOsZgPuWpu88CThjuI2u1SZvX7z2wIWiMQFEcGvx3_SAVy8yD8XcDlmJ_xCW1v8o4_CWq0JfhQ-8ywl1YaHOO5apjRdjf0TkPFnqPIE7Z4ppo',
                            'aula utama' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDtKiVt1rOHdByKgAFEuPYl9ZOR3DfFmHpgR5o3igSx67EKu6qAeA0xgMIEu55eArBhBlrMGHVA3ZSnXnJBjxvC8_hQVN4OAiXW5t-U031JZKoTSa-gY5yRGpbG2I9UCvlTytnJHC3Fps4uI8k-Pqd5Ri6n0x-gjFGDc4PXQgvlj-RYW3TOdn1NhkpZsx8IYvB3qKkxZ4aUBEHgb_fK_H_mEhWj-NsmKHYODK1q5ZegGmHobXRbiRQ785KoMI9W8AVRdpiqniAmJnM',
                            'aula sekolah' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDtKiVt1rOHdByKgAFEuPYl9ZOR3DfFmHpgR5o3igSx67EKu6qAeA0xgMIEu55eArBhBlrMGHVA3ZSnXnJBjxvC8_hQVN4OAiXW5t-U031JZKoTSa-gY5yRGpbG2I9UCvlTytnJHC3Fps4uI8k-Pqd5Ri6n0x-gjFGDc4PXQgvlj-RYW3TOdn1NhkpZsx8IYvB3qKkxZ4aUBEHgb_fK_H_mEhWj-NsmKHYODK1q5ZegGmHobXRbiRQ785KoMI9W8AVRdpiqniAmJnM',
                            'lab bahasa' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?auto=format&fit=crop&w=800&q=80',
                            ];
                            $namaKey = strtolower($f->nama);
                            $imgUrl = $f->foto ? Storage::url($f->foto) : ($imgMap[$namaKey] ?? 'https://images.unsplash.com/photo-1575361204480-aadea25e6e68?auto=format&fit=crop&w=800&q=80');
                            $isPreselected = old('fasilitas_id', request('fasilitas_id')) == $f->id;
                            @endphp
                            <div class="facility-card relative bg-surface rounded-lg p-sm border {{ $isPreselected ? 'border-primary shadow-[0_0_20px_rgba(133,248,195,0.15)] ring-1 ring-primary' : 'border-outline-variant/30' }} glass-highlight cursor-pointer hover:border-primary/50 transition-all duration-200 group"
                                data-id="{{ $f->id }}"
                                data-harga="{{ $f->harga_per_jam }}"
                                data-nama="{{ $f->nama }}"
                                onclick="selectFacility(this)">
                                {{-- Active pulse dot kalau preselected --}}
                                @if($isPreselected)
                                <div class="absolute top-md right-md w-3 h-3 rounded-full bg-primary shadow-[0_0_10px_#85f8c3] z-10 pulse-dot"></div>
                                @else
                                <div class="facility-dot absolute top-md right-md w-3 h-3 rounded-full bg-primary shadow-[0_0_10px_#85f8c3] z-10 pulse-dot hidden"></div>
                                @endif

                                <div class="w-full h-32 rounded-DEFAULT overflow-hidden mb-sm bg-surface-container relative">
                                    <img src="{{ $imgUrl }}"
                                        alt="{{ $f->nama }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                        loading="lazy"
                                        onerror="this.src='https://images.unsplash.com/photo-1575361204480-aadea25e6e68?auto=format&fit=crop&w=800&q=80'">
                                </div>
                                <h3 class="font-body-lg text-body-lg {{ $isPreselected ? 'text-primary font-bold' : 'text-on-surface' }} transition-colors">
                                    {{ $f->nama }}
                                </h3>
                                <p class="font-body-md text-body-md text-on-surface-variant">
                                    Rp {{ number_format($f->harga_per_jam, 0, ',', '.') }}/jam
                                    @if($f->kapasitas) · {{ $f->kapasitas }} orang @endif
                                </p>
                            </div>
                            @endforeach
                        </div>

                        {{-- Hidden input --}}
                        <input type="hidden" name="fasilitas_id" id="fasilitas_id" value="{{ old('fasilitas_id', request('fasilitas_id')) }}">
                        @error('fasilitas_id')<p class="text-error text-sm mt-2">{{ $message }}</p>@enderror
                    </section>

                    <!-- ===== STEP 2: Pilih Jadwal ===== -->
                    <section>
                        <div class="flex items-center gap-sm mb-md">
                            <div class="w-8 h-8 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center font-label-bold text-label-bold">2</div>
                            <h2 class="font-headline-md text-headline-md text-on-surface">Pilih Jadwal</h2>
                        </div>

                        <div class="bg-surface border border-outline-variant/20 rounded-lg p-md glass-highlight">
                            {{-- Date Picker --}}
                            <div class="mb-md">
                                <label class="block font-label-bold text-label-bold text-on-surface-variant mb-sm uppercase tracking-wider">Pilih Tanggal</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-md flex items-center pointer-events-none text-primary">
                                        <span class="material-symbols-outlined">calendar_today</span>
                                    </div>
                                    <input type="date"
                                        id="booking-date"
                                        name="tanggal"
                                        value="{{ old('tanggal', date('Y-m-d')) }}"
                                        min="{{ date('Y-m-d') }}"
                                        class="block w-full pl-xl pr-md py-4 bg-surface-container-low border border-outline-variant/30 rounded-full text-on-surface font-body-lg focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-300 appearance-none cursor-pointer"
                                        style="color-scheme: dark;"
                                        required>
                                </div>
                            </div>

                            {{-- Slot Jam --}}
                            <h3 class="font-label-bold text-label-bold text-on-surface-variant mb-sm uppercase tracking-wider">Pilih Jam Mulai</h3>

                            {{-- Loading state --}}
                            <div id="slot-loading" class="hidden py-4 text-on-surface-variant text-sm flex items-center gap-2">
                                <span class="material-symbols-outlined text-[18px] animate-spin">progress_activity</span>
                                Memuat slot tersedia...
                            </div>
                            {{-- Info state --}}
                            <div id="slot-info" class="py-4 text-on-surface-variant text-sm">
                                ← Pilih fasilitas terlebih dahulu.
                            </div>
                            {{-- Libur state --}}
                            <div id="slot-libur" class="hidden py-3 text-amber-400 text-sm">
                                ⚠️ Fasilitas tutup / libur di tanggal ini.
                            </div>
                            {{-- Slot Grid --}}
                            <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-sm" id="slot-grid"></div>

                            {{-- Legend --}}
                            <div class="mt-sm flex items-center gap-base text-body-md font-body-md text-on-surface-variant text-sm flex-wrap">
                                <span class="w-3 h-3 rounded-full bg-error/50 inline-block"></span>
                                <span class="mr-md">Sudah di-booking</span>
                                <span class="w-3 h-3 rounded-full bg-primary inline-block"></span>
                                <span class="mr-md">Pilihan kamu</span>
                                <span class="w-3 h-3 rounded-full bg-primary-container inline-block"></span>
                                <span>Durasi</span>
                            </div>

                            <input type="hidden" name="jam_mulai" id="jam_mulai" value="{{ old('jam_mulai') }}">
                            @error('jam_mulai')<p class="text-error text-sm mt-2">{{ $message }}</p>@enderror
                        </div>
                    </section>

                    <!-- ===== STEP 3: Pilih Durasi ===== -->
                    <section>
                        <div class="flex items-center gap-sm mb-md">
                            <div class="w-8 h-8 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center font-label-bold text-label-bold">3</div>
                            <h2 class="font-headline-md text-headline-md text-on-surface">Pilih Durasi</h2>
                        </div>

                        <div class="flex flex-col md:flex-row items-start gap-md">
                            <div class="flex flex-col gap-sm w-full max-w-xs">
                                <label class="font-label-bold text-label-bold text-on-surface-variant uppercase tracking-wider">Jumlah Jam</label>
                                <div class="flex items-center bg-surface-container-low border border-outline-variant/30 rounded-full p-1 focus-within:ring-2 focus-within:ring-primary transition-all duration-300">
                                    <button type="button" id="dur-minus"
                                        class="w-12 h-12 flex items-center justify-center rounded-full text-primary hover:bg-primary/10 transition-colors">
                                        <span class="material-symbols-outlined">remove</span>
                                    </button>
                                    <input type="number" id="durasi-input" name="durasi_jam"
                                        min="1" max="8" value="{{ old('durasi_jam', 2) }}"
                                        class="bg-transparent border-none focus:ring-0 text-center font-headline-md text-on-surface w-full [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                    <span class="text-on-surface-variant font-body-md pr-4">Jam</span>
                                    <button type="button" id="dur-plus"
                                        class="w-12 h-12 flex items-center justify-center rounded-full text-primary hover:bg-primary/10 transition-colors">
                                        <span class="material-symbols-outlined">add</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @error('durasi_jam')<p class="text-error text-sm mt-2">{{ $message }}</p>@enderror
                    </section>

                    <!-- ===== STEP 4: Metode Pembayaran ===== -->
                    <section>
                        <div class="flex items-center gap-sm mb-md">
                            <div class="w-8 h-8 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center font-label-bold text-label-bold">4</div>
                            <h2 class="font-headline-md text-headline-md text-on-surface">Metode Pembayaran</h2>
                        </div>

                        <div class="grid grid-cols-2 gap-md">
                            <label class="cursor-pointer">
                                <input type="radio" name="metode_bayar" value="transfer" class="sr-only peer"
                                    {{ old('metode_bayar', 'transfer') === 'transfer' ? 'checked' : '' }}>
                                <div class="relative bg-surface rounded-lg p-md border border-outline-variant/30 glass-highlight
                                    peer-checked:border-primary peer-checked:shadow-[0_0_20px_rgba(133,248,195,0.15)] peer-checked:ring-1 peer-checked:ring-primary
                                    hover:border-primary/50 transition-all cursor-pointer flex items-center gap-sm">
                                    <div class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center flex-shrink-0">
                                        <span class="material-symbols-outlined text-primary text-[20px]">account_balance</span>
                                    </div>
                                    <div>
                                        <div class="font-body-lg text-on-surface font-bold">Transfer Bank</div>
                                        <div class="text-sm text-on-surface-variant">BCA, BNI, Mandiri</div>
                                    </div>
                                </div>
                            </label>

                            <label class="cursor-pointer">
                                <input type="radio" name="metode_bayar" value="cash" class="sr-only peer"
                                    {{ old('metode_bayar') === 'cash' ? 'checked' : '' }}>
                                <div class="relative bg-surface rounded-lg p-md border border-outline-variant/30 glass-highlight
                                    peer-checked:border-primary peer-checked:shadow-[0_0_20px_rgba(133,248,195,0.15)] peer-checked:ring-1 peer-checked:ring-primary
                                    hover:border-primary/50 transition-all cursor-pointer flex items-center gap-sm">
                                    <div class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center flex-shrink-0">
                                        <span class="material-symbols-outlined text-primary text-[20px]">payments</span>
                                    </div>
                                    <div>
                                        <div class="font-body-lg text-on-surface font-bold">Cash / Tunai</div>
                                        <div class="text-sm text-on-surface-variant">Bayar di tempat</div>
                                    </div>
                                </div>
                            </label>
                        </div>
                        @error('metode_bayar')<p class="text-error text-sm mt-2">{{ $message }}</p>@enderror
                    </section>

                </div>
                {{-- end left column --}}

                <!-- ===================== RIGHT COLUMN: Summary ===================== -->
                <div class="col-span-12 lg:col-span-4 mt-xl lg:mt-0 lg:sticky top-32 z-10">
                    <div class="bg-surface rounded-xl p-md border border-outline-variant/20 glass-highlight shadow-2xl relative overflow-hidden">
                        <div class="absolute -top-20 -right-20 w-40 h-40 bg-primary/10 rounded-full blur-3xl pointer-events-none"></div>

                        <h3 class="font-headline-md text-headline-md text-on-surface mb-md pb-sm border-b border-outline-variant/20">Ringkasan Booking</h3>

                        <div class="flex flex-col gap-sm mb-lg">
                            <div class="flex justify-between items-center">
                                <span class="font-body-md text-body-md text-on-surface-variant">Fasilitas</span>
                                <span class="font-body-md text-body-md text-on-surface font-bold text-right" id="sum-fasilitas">—</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="font-body-md text-body-md text-on-surface-variant">Tanggal</span>
                                <span class="font-body-md text-body-md text-on-surface font-bold text-right" id="sum-tanggal">—</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="font-body-md text-body-md text-on-surface-variant">Waktu</span>
                                <span class="font-body-md text-body-md text-on-surface font-bold text-right" id="sum-waktu">—</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="font-body-md text-body-md text-on-surface-variant">Durasi</span>
                                <span class="font-body-md text-body-md text-on-surface font-bold text-right" id="sum-durasi">—</span>
                            </div>
                        </div>

                        <div class="bg-surface-container-low rounded-lg p-sm mb-lg border border-outline-variant/10">
                            <div class="flex justify-between items-center mb-xs">
                                <span class="font-body-md text-body-md text-on-surface-variant">Subtotal</span>
                                <span class="font-body-md text-body-md text-on-surface" id="sum-subtotal">Rp 0</span>
                            </div>
                            <div class="flex justify-between items-center mb-sm text-secondary" id="diskon-row" style="display:none!important">
                                <span class="font-body-md text-body-md" id="diskon-label">Diskon 20%</span>
                                <span class="font-body-md text-body-md" id="sum-diskon">- Rp 0</span>
                            </div>
                            <div class="flex justify-between items-center pt-sm border-t border-outline-variant/20 mt-sm">
                                <span class="font-headline-md text-headline-md text-on-surface">Total Harga</span>
                                <span class="font-headline-lg text-headline-lg text-primary" id="sum-total">Rp 0</span>
                            </div>
                        </div>

                        <button type="submit" id="submit-btn"
                            class="w-full bg-primary text-on-primary rounded-full py-4 font-label-bold text-label-bold
                               hover:scale-105 hover:drop-shadow-[0_0_20px_rgba(133,248,195,0.6)] transition-all duration-300
                               uppercase tracking-widest flex items-center justify-center gap-xs
                               disabled:opacity-40 disabled:cursor-not-allowed disabled:scale-100">
                            Ajukan Booking
                            <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                        </button>

                        <p class="text-xs text-on-surface-variant text-center mt-3">
                            Booking menunggu konfirmasi admin setelah diajukan.
                        </p>
                    </div>
                </div>

            </div>
        </form>

    </main>

    <!-- ==================== BOTTOM NAV MOBILE ==================== -->
    <nav class="md:hidden bg-surface-container/80 backdrop-blur-lg fixed bottom-0 w-full rounded-t-lg z-50 border-t border-outline-variant/30 shadow-[0_-4px_24px_rgba(0,0,0,0.5)] flex justify-around items-center h-20 px-gutter">
        <a class="flex flex-col items-center justify-center text-on-surface-variant opacity-60 hover:opacity-100 transition-opacity"
            href="{{ route('user.dashboard') }}">
            <span class="material-symbols-outlined mb-xs">sports_soccer</span>
            <span class="font-label-bold text-label-bold text-[10px]">Home</span>
        </a>
        <a class="flex flex-col items-center justify-center text-primary drop-shadow-[0_0_10px_rgba(133,248,195,0.4)] scale-110 duration-300 ease-out"
            href="{{ route('user.fasilitas.index') }}">
            <span class="material-symbols-outlined mb-xs" style="font-variation-settings:'FILL' 1">stadium</span>
            <span class="font-label-bold text-label-bold text-[10px]">Fasilitas</span>
        </a>
        <a class="flex flex-col items-center justify-center text-on-surface-variant opacity-60 hover:opacity-100 transition-opacity"
            href="{{ route('user.booking.index') }}">
            <span class="material-symbols-outlined mb-xs">event_available</span>
            <span class="font-label-bold text-label-bold text-[10px] text-center leading-tight">Booking Saya</span>
        </a>
        <a class="flex flex-col items-center justify-center text-on-surface-variant opacity-60 hover:opacity-100 transition-opacity"
            href="{{ route('profile') }}">
            <span class="material-symbols-outlined mb-xs">account_circle</span>
            <span class="font-label-bold text-label-bold text-[10px]">Profil</span>
        </a>
    </nav>

    <!-- Toast -->
    <div id="toast" class="fixed bottom-24 md:bottom-8 left-1/2 -translate-x-1/2 z-[9999] bg-surface border border-primary/30 px-6 py-3 rounded-full flex items-center gap-2 shadow-[0_0_20px_rgba(133,248,195,0.2)]">
        <span class="material-symbols-outlined text-primary text-[20px]" id="toast-icon">check_circle</span>
        <span class="text-sm font-bold text-on-surface" id="toast-msg">Berhasil!</span>
    </div>

    <!-- ==================== SCRIPTS ==================== -->
    <script>
        const SLOTS_BASE = '{{ url("/user/fasilitas") }}';
        const HITUNG_BASE = '{{ url("/user/booking/hitung-harga") }}';
        const CSRF = '{{ csrf_token() }}';
        // const DISKON_PERSEN = {
        //     {
        //         Auth::user() - > role === 'siswa_internal' ? 20 : 0
        //     }
        // };

        // ─── State ───
        let selFasilitas = null; // { id, harga, nama }
        let selJam = null; // '08:00'
        let bookedSlots = [];

        // ─── Toast ───
        function showToast(msg, icon = 'check_circle') {
            const t = document.getElementById('toast');
            document.getElementById('toast-msg').textContent = msg;
            document.getElementById('toast-icon').textContent = icon;
            t.classList.add('show');
            setTimeout(() => t.classList.remove('show'), 3000);
        }

        // ─── Select Fasilitas ───
        function selectFacility(el) {
            // Reset semua card
            document.querySelectorAll('.facility-card').forEach(c => {
                c.classList.remove('border-primary', 'shadow-[0_0_20px_rgba(133,248,195,0.15)]', 'ring-1', 'ring-primary');
                c.classList.add('border-outline-variant/30');
                c.querySelector('h3').classList.remove('text-primary', 'font-bold');
                c.querySelector('h3').classList.add('text-on-surface');
                const dot = c.querySelector('.facility-dot');
                if (dot) dot.classList.add('hidden');
            });

            // Aktifkan card yang dipilih
            el.classList.add('border-primary', 'shadow-[0_0_20px_rgba(133,248,195,0.15)]', 'ring-1', 'ring-primary');
            el.classList.remove('border-outline-variant/30');
            el.querySelector('h3').classList.add('text-primary', 'font-bold');
            el.querySelector('h3').classList.remove('text-on-surface');
            const dot = el.querySelector('.facility-dot');
            if (dot) dot.classList.remove('hidden');

            selFasilitas = {
                id: el.dataset.id,
                harga: parseFloat(el.dataset.harga),
                nama: el.dataset.nama,
            };
            document.getElementById('fasilitas_id').value = selFasilitas.id;

            // Reset slot & update summary
            selJam = null;
            document.getElementById('jam_mulai').value = '';
            loadSlots();
            updateSummary();
        }

        // ─── Load Slots via AJAX ───
        async function loadSlots() {
            if (!selFasilitas) {
                setSlotState('info');
                return;
            }
            const tanggal = document.getElementById('booking-date').value;
            if (!tanggal) {
                setSlotState('info');
                return;
            }

            setSlotState('loading');
            try {
                const res = await fetch(`${SLOTS_BASE}/${selFasilitas.id}/slots?tanggal=${tanggal}`);
                const data = await res.json();

                if (data.libur) {
                    setSlotState('libur');
                    return;
                }

                bookedSlots = data.slots.filter(s => !s.available).map(s => s.jam);
                renderSlots(data.slots);
                setSlotState('grid');
            } catch (e) {
                setSlotState('info');
                showToast('Gagal memuat slot. Coba lagi.', 'error');
            }
        }

        function renderSlots(slots) {
            const grid = document.getElementById('slot-grid');
            const durasi = parseInt(document.getElementById('durasi-input').value) || 1;
            grid.innerHTML = '';

            slots.forEach(slot => {
                const div = document.createElement('div');
                div.dataset.jam = slot.jam;

                if (!slot.available) {
                    div.className = 'slot-taken py-sm text-center rounded-DEFAULT relative overflow-hidden';
                    div.innerHTML = `${slot.jam}<div class="absolute inset-0 bg-error/10"></div>`;
                } else {
                    const isSelected = selJam === slot.jam;
                    const isDuration = isDurationSlot(slot.jam, selJam, durasi, slots);

                    if (isSelected) {
                        div.className = 'slot-selected py-sm text-center rounded-DEFAULT cursor-pointer relative overflow-hidden group';
                        div.innerHTML = `<div class="absolute inset-0 w-full h-full bg-gradient-to-b from-white/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>${slot.jam}`;
                    } else if (isDuration) {
                        div.className = 'slot-duration py-sm text-center rounded-DEFAULT border border-primary/50 cursor-pointer';
                        div.textContent = slot.jam;
                    } else {
                        div.className = 'py-sm text-center rounded-DEFAULT border border-outline-variant/30 text-on-surface-variant cursor-pointer hover:border-primary/50 hover:text-primary transition-colors';
                        div.textContent = slot.jam;
                    }

                    div.addEventListener('click', () => {
                        selJam = slot.jam;
                        document.getElementById('jam_mulai').value = slot.jam;
                        renderSlots(slots); // re-render buat update duration highlight
                        updateSummary();
                    });
                }
                grid.appendChild(div);
            });
        }

        function isDurationSlot(jam, startJam, durasi, slots) {
            if (!startJam || durasi <= 1) return false;
            const allJams = slots.filter(s => s.available).map(s => s.jam);
            const startIndex = allJams.indexOf(startJam);
            const currentIdx = allJams.indexOf(jam);
            return currentIdx > startIndex && currentIdx < startIndex + durasi;
        }

        function setSlotState(state) {
            document.getElementById('slot-info').classList.toggle('hidden', state !== 'info');
            document.getElementById('slot-loading').classList.toggle('hidden', state !== 'loading');
            document.getElementById('slot-libur').classList.toggle('hidden', state !== 'libur');
            document.getElementById('slot-grid').classList.toggle('hidden', state !== 'grid');
        }

        // ─── Update Summary Panel ───
        function updateSummary() {
            const tanggal = document.getElementById('booking-date').value;
            const durasi = parseInt(document.getElementById('durasi-input').value) || 1;

            // Fasilitas
            document.getElementById('sum-fasilitas').textContent = selFasilitas ? selFasilitas.nama : '—';

            // Tanggal formatted
            if (tanggal) {
                const d = new Date(tanggal);
                const days = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
                const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                document.getElementById('sum-tanggal').textContent =
                    `${days[d.getDay()]}, ${d.getDate()} ${months[d.getMonth()]} ${d.getFullYear()}`;
            } else {
                document.getElementById('sum-tanggal').textContent = '—';
            }

            // Waktu
            if (selJam) {
                const [h, m] = selJam.split(':').map(Number);
                const endH = h + durasi;
                document.getElementById('sum-waktu').textContent = `${selJam} – ${String(endH).padStart(2,'0')}:${String(m).padStart(2,'0')}`;
            } else {
                document.getElementById('sum-waktu').textContent = '—';
            }

            // Durasi
            document.getElementById('sum-durasi').textContent = `${durasi} Jam`;

            // Harga
            if (selFasilitas) {
                const subtotal = selFasilitas.harga * durasi;
                const diskon = getDiskon(tanggal, selJam || '');
                const totalD = subtotal * diskon / 100;
                const total = subtotal - totalD;

                document.getElementById('sum-subtotal').textContent = fmt(subtotal);
                document.getElementById('sum-total').textContent = fmt(total);

                const diskonRow = document.getElementById('diskon-row');
                if (diskon > 0) {
                    diskonRow.style.removeProperty('display');
                    document.getElementById('diskon-label').textContent = `Diskon Siswa (${diskon}%)`;
                    document.getElementById('sum-diskon').textContent = `- ${fmt(totalD)}`;
                } else {
                    diskonRow.style.setProperty('display', 'none', 'important');
                }
            } else {
                document.getElementById('sum-subtotal').textContent = 'Rp 0';
                document.getElementById('sum-total').textContent = 'Rp 0';
            }
        }

        function getDiskon(tanggal, jam) {
            if (DISKON_PERSEN <= 0 || !tanggal || !jam) return 0;
            const d = new Date(tanggal);
            const h = parseInt(jam.split(':')[0]);
            // Senin–Jumat (1-5), jam 08-14
            return (d.getDay() >= 1 && d.getDay() <= 5 && h >= 8 && h < 15) ? DISKON_PERSEN : 0;
        }

        function fmt(n) {
            return 'Rp ' + Number(n).toLocaleString('id-ID');
        }

        // ─── Durasi Buttons ───
        document.getElementById('dur-minus').addEventListener('click', () => {
            const el = document.getElementById('durasi-input');
            if (parseInt(el.value) > 1) {
                el.value = parseInt(el.value) - 1;
                onDurasiChange();
            }
        });
        document.getElementById('dur-plus').addEventListener('click', () => {
            const el = document.getElementById('durasi-input');
            if (parseInt(el.value) < 8) {
                el.value = parseInt(el.value) + 1;
                onDurasiChange();
            }
        });
        document.getElementById('durasi-input').addEventListener('change', onDurasiChange);

        function onDurasiChange() {
            if (selJam) {
                // Re-render slot buat update duration highlight
                loadSlots();
            }
            updateSummary();
        }

        // ─── Tanggal berubah ───
        document.getElementById('booking-date').addEventListener('change', () => {
            selJam = null;
            document.getElementById('jam_mulai').value = '';
            loadSlots();
            updateSummary();
        });

        // ─── Form Submit Guard ───
        document.getElementById('booking-form').addEventListener('submit', function(e) {
            if (!selFasilitas) {
                e.preventDefault();
                showToast('Pilih fasilitas terlebih dahulu.', 'error');
                return;
            }
            if (!document.getElementById('jam_mulai').value) {
                e.preventDefault();
                showToast('Pilih jam mulai terlebih dahulu.', 'error');
                return;
            }
            const btn = document.getElementById('submit-btn');
            btn.disabled = true;
            btn.innerHTML = '<span class="material-symbols-outlined animate-spin text-[20px]">progress_activity</span> Memproses...';
        });

        // ─── Init: pre-selected fasilitas dari query param ───
        const preSelected = document.querySelector('.facility-card[data-id="{{ old("fasilitas_id", request("fasilitas_id")) }}"]');
        if (preSelected) {
            selectFacility(preSelected);
        }

        // Init summary
        updateSummary();
    </script>

</body>

</html>