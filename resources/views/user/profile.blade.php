@extends('layouts.app')

@section('title', 'SpaceGo - Profil Saya')

@section('content')

    <!-- Ambient BG -->
    <div class="fixed inset-0 z-[-1] overflow-hidden pointer-events-none">
        <div class="absolute top-[-10%] right-[-10%] w-[50vw] h-[50vw] bg-emerald-pulse/20 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-[40vw] h-[40vw] bg-primary/10 rounded-full blur-[100px]"></div>
    </div>

    @include('layouts.components.navbar')

    <main class="pt-[100px] px-margin max-w-[1440px] mx-auto flex flex-col gap-gutter pb-[100px] md:pb-xl">

        <!-- PAGE HEADER -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-sm pt-md">
            <div>
                <h1 class="font-headline-lg text-headline-lg text-on-surface border-l-4 border-primary pl-md">Profil Saya</h1>
                <p class="font-body-md text-on-surface-variant mt-xs pl-md">Kelola informasi akun dan riwayat booking kamu.</p>
            </div>
            <a href="#" class="self-start sm:self-auto bg-emerald-pulse text-void-base font-label-bold text-label-bold px-lg py-sm rounded-full neon-glow hover:scale-105 transition-transform duration-300 flex items-center gap-xs">
                <span class="material-symbols-outlined text-[18px]">add_circle</span>
                Booking Baru
            </a>
        </div>

        <!-- TOP GRID: Profile Card + Stats -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter">

            <!-- LEFT: Profile Card -->
            <div class="lg:col-span-4 flex flex-col gap-gutter">

                <!-- Identity Card -->
                <div class="glass-card rounded-xl p-lg flex flex-col items-center text-center relative overflow-hidden">
                    <div class="absolute top-md right-md bg-primary/20 text-primary px-sm py-xs rounded-full text-[10px] font-bold tracking-widest uppercase border border-primary/30 flex items-center gap-xs">
                        <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                        Aktif
                    </div>

                    <!-- Avatar -->
                    <div class="relative w-28 h-28 mb-md">
                        <div class="status-ring w-full h-full">
                            <div class="avatar-container w-full h-full">
                                <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuDKSCvJa-nf-9QTZEbLlrnTVZi0SEDerOD4yddJZv_EozbPE05ajcLn_OEWyMXwGmcemAy3qt8AuwDMp8uGNr78SKG79q5KwWO38OVeAobrpf7f5PSj9Te5HaWqTdr9wuEdzDnH114oYp04HghRehnQuPzrFOBcsiblRMaEOMDjEcJsDJDLa8X19H8pwzZFHM8dOz2gepgAYQmto0NIZn4Fa2s7p9BGCEGY28iqMYPK3CsvGwjCXBP-7v9zCxAh11uETypbJQ6yiSY"
                                    alt="Budi" class="w-full h-full object-cover" />
                            </div>
                        </div>
                        <button class="absolute bottom-1 right-1 bg-surface-container-high text-primary p-1.5 rounded-full border border-primary/50 hover:bg-primary hover:text-void-base transition-colors shadow-[0_0_15px_rgba(133,248,195,0.3)] z-10">
                            <span class="material-symbols-outlined text-[16px]">photo_camera</span>
                        </button>
                    </div>

                    <h2 class="font-headline-md text-headline-md text-on-surface font-bold">Budi Sudarsono</h2>
                    <p class="font-body-md text-on-surface-variant mt-xs">budi.sudarsono@example.com</p>

                    <div class="flex items-center gap-xs mt-sm px-sm py-xs bg-surface-container/50 rounded-full border border-outline-variant/30">
                        <span class="material-symbols-outlined text-[14px] text-primary">verified</span>
                        <span class="font-label-bold text-[11px] text-on-surface-variant">Siswa Terverifikasi</span>
                    </div>

                    <!-- Info rows -->
                    <div class="w-full mt-lg flex flex-col gap-sm border-t border-outline-variant/20 pt-md">
                        <div class="flex items-center gap-sm text-sm">
                            <span class="material-symbols-outlined text-primary text-[18px]">school</span>
                            <span class="text-on-surface-variant">SMAN 1 Cirebon</span>
                        </div>
                        <div class="flex items-center gap-sm text-sm">
                            <span class="material-symbols-outlined text-primary text-[18px]">badge</span>
                            <span class="text-on-surface-variant">XII IPA 3 · NIS: 2024001</span>
                        </div>
                        <div class="flex items-center gap-sm text-sm">
                            <span class="material-symbols-outlined text-primary text-[18px]">calendar_today</span>
                            <span class="text-on-surface-variant">Bergabung Jan 2023</span>
                        </div>
                        <div class="flex items-center gap-sm text-sm">
                            <span class="material-symbols-outlined text-primary text-[18px]">smartphone</span>
                            <span class="text-on-surface-variant">0812-3456-7890</span>
                        </div>
                    </div>

                    <a href="#edit-profil" class="mt-lg w-full bg-transparent border border-primary text-primary font-label-bold text-label-bold py-sm rounded-full hover:bg-primary hover:text-void-base transition-colors flex items-center justify-center gap-xs">
                        <span class="material-symbols-outlined text-[18px]">edit</span>
                        Edit Profil
                    </a>
                </div>

                <!-- Booking Stats -->
                <div class="glass-card rounded-xl p-md">
                    <h3 class="font-label-bold text-[11px] uppercase tracking-widest text-on-surface-variant mb-md flex items-center gap-xs">
                        <span class="material-symbols-outlined text-[16px] text-secondary">bar_chart</span>
                        Statistik Booking
                    </h3>
                    <div class="grid grid-cols-2 gap-sm">
                        <div class="bg-surface-container-low rounded-xl p-sm border border-outline-variant/10 text-center">
                            <p class="font-headline-md text-headline-md text-primary font-extrabold">24</p>
                            <p class="font-label-bold text-[11px] text-on-surface-variant uppercase mt-xs">Total Booking</p>
                        </div>
                        <div class="bg-surface-container-low rounded-xl p-sm border border-outline-variant/10 text-center">
                            <p class="font-headline-md text-headline-md text-secondary font-extrabold">18</p>
                            <p class="font-label-bold text-[11px] text-on-surface-variant uppercase mt-xs">Selesai</p>
                        </div>
                        <div class="bg-surface-container-low rounded-xl p-sm border border-outline-variant/10 text-center">
                            <p class="font-headline-md text-headline-md text-on-surface font-extrabold">3</p>
                            <p class="font-label-bold text-[11px] text-on-surface-variant uppercase mt-xs">Aktif</p>
                        </div>
                        <div class="bg-surface-container-low rounded-xl p-sm border border-outline-variant/10 text-center">
                            <p class="font-headline-md text-headline-md text-error font-extrabold">3</p>
                            <p class="font-label-bold text-[11px] text-on-surface-variant uppercase mt-xs">Dibatalkan</p>
                        </div>
                    </div>
                    <!-- Fasilitas Favorit -->
                    <div class="mt-md border-t border-outline-variant/20 pt-md">
                        <p class="font-label-bold text-[11px] uppercase tracking-widest text-on-surface-variant mb-sm">Fasilitas Favorit</p>
                        <div class="flex flex-col gap-xs">
                            <div class="flex justify-between items-center text-sm">
                                <div class="flex items-center gap-xs">
                                    <span class="material-symbols-outlined text-primary text-[16px]">sports_basketball</span>
                                    <span class="text-on-surface">Lapangan Basket</span>
                                </div>
                                <span class="font-mono text-primary text-xs">9x</span>
                            </div>
                            <div class="w-full bg-surface-container rounded-full h-1.5">
                                <div class="bg-primary h-1.5 rounded-full neon-glow" style="width:75%"></div>
                            </div>
                            <div class="flex justify-between items-center text-sm mt-xs">
                                <div class="flex items-center gap-xs">
                                    <span class="material-symbols-outlined text-secondary text-[16px]">sports_soccer</span>
                                    <span class="text-on-surface">Futsal Indoor</span>
                                </div>
                                <span class="font-mono text-secondary text-xs">6x</span>
                            </div>
                            <div class="w-full bg-surface-container rounded-full h-1.5">
                                <div class="bg-secondary h-1.5 rounded-full" style="width:50%"></div>
                            </div>
                            <div class="flex justify-between items-center text-sm mt-xs">
                                <div class="flex items-center gap-xs">
                                    <span class="material-symbols-outlined text-on-surface-variant text-[16px]">monitor</span>
                                    <span class="text-on-surface">Ruang Multimedia</span>
                                </div>
                                <span class="font-mono text-on-surface-variant text-xs">3x</span>
                            </div>
                            <div class="w-full bg-surface-container rounded-full h-1.5">
                                <div class="bg-on-surface-variant h-1.5 rounded-full" style="width:25%"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- RIGHT: Booking Content -->
            <div class="lg:col-span-8 flex flex-col gap-gutter">

                <!-- BOOKING AKTIF -->
                <section class="glass-card rounded-xl p-lg">
                    <div class="flex items-center justify-between mb-lg">
                        <h2 class="font-headline-md text-headline-md text-on-surface flex items-center gap-sm">
                            <span class="material-symbols-outlined text-primary text-[28px]">event_available</span>
                            Booking Aktif
                        </h2>
                        <span class="bg-primary/20 text-primary text-[11px] font-bold px-sm py-xs rounded-full border border-primary/30">3 Aktif</span>
                    </div>

                    <div class="flex flex-col gap-sm">

                        <!-- Booking Item 1: Upcoming -->
                        <div class="bg-surface-container-low rounded-xl p-md border border-primary/20 hover:border-primary/40 transition-colors">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-md">
                                <div class="flex items-center gap-md">
                                    <div class="w-14 h-14 rounded-xl bg-primary/10 border border-primary/30 flex items-center justify-center flex-shrink-0">
                                        <span class="material-symbols-outlined text-primary text-[28px]">sports_basketball</span>
                                    </div>
                                    <div>
                                        <p class="font-headline-md text-[18px] text-on-surface font-bold">Lapangan Basket</p>
                                        <div class="flex flex-wrap gap-sm mt-xs">
                                            <span class="flex items-center gap-xs text-on-surface-variant text-xs">
                                                <span class="material-symbols-outlined text-[14px]">calendar_today</span>
                                                Sabtu, 7 Jun 2025
                                            </span>
                                            <span class="flex items-center gap-xs text-on-surface-variant text-xs">
                                                <span class="material-symbols-outlined text-[14px]">schedule</span>
                                                14:00 – 16:00 (2 jam)
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col items-end gap-sm">
                                    <span class="bg-primary/20 text-primary text-[10px] font-bold px-sm py-xs rounded-full border border-primary/30 flex items-center gap-xs whitespace-nowrap">
                                        <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                                        Dikonfirmasi
                                    </span>
                                    <span class="font-label-bold text-secondary text-[14px]">Rp 300.000</span>
                                </div>
                            </div>
                            <div class="flex gap-sm mt-md pt-md border-t border-outline-variant/20">
                                <button class="flex-1 border border-outline-variant/50 text-on-surface-variant font-label-bold text-[12px] py-xs rounded-full hover:border-primary hover:text-primary transition-colors flex items-center justify-center gap-xs">
                                    <span class="material-symbols-outlined text-[14px]">receipt_long</span>
                                    Lihat Detail
                                </button>
                                <button class="flex-1 border border-error/50 text-error font-label-bold text-[12px] py-xs rounded-full hover:bg-error/10 transition-colors flex items-center justify-center gap-xs">
                                    <span class="material-symbols-outlined text-[14px]">cancel</span>
                                    Batalkan
                                </button>
                            </div>
                        </div>

                        <!-- Booking Item 2 -->
                        <div class="bg-surface-container-low rounded-xl p-md border border-secondary/20 hover:border-secondary/40 transition-colors">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-md">
                                <div class="flex items-center gap-md">
                                    <div class="w-14 h-14 rounded-xl bg-secondary/10 border border-secondary/30 flex items-center justify-center flex-shrink-0">
                                        <span class="material-symbols-outlined text-secondary text-[28px]">sports_soccer</span>
                                    </div>
                                    <div>
                                        <p class="font-headline-md text-[18px] text-on-surface font-bold">Futsal Indoor</p>
                                        <div class="flex flex-wrap gap-sm mt-xs">
                                            <span class="flex items-center gap-xs text-on-surface-variant text-xs">
                                                <span class="material-symbols-outlined text-[14px]">calendar_today</span>
                                                Minggu, 8 Jun 2025
                                            </span>
                                            <span class="flex items-center gap-xs text-on-surface-variant text-xs">
                                                <span class="material-symbols-outlined text-[14px]">schedule</span>
                                                09:00 – 10:00 (1 jam)
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col items-end gap-sm">
                                    <span class="bg-yellow-500/20 text-yellow-400 text-[10px] font-bold px-sm py-xs rounded-full border border-yellow-500/30 whitespace-nowrap">
                                        Menunggu Bayar
                                    </span>
                                    <span class="font-label-bold text-secondary text-[14px]">Rp 200.000</span>
                                </div>
                            </div>
                            <div class="flex gap-sm mt-md pt-md border-t border-outline-variant/20">
                                <button class="flex-1 bg-emerald-pulse text-void-base font-label-bold text-[12px] py-xs rounded-full hover:scale-[1.02] transition-transform neon-glow flex items-center justify-center gap-xs">
                                    <span class="material-symbols-outlined text-[14px]">payments</span>
                                    Bayar Sekarang
                                </button>
                                <button class="flex-1 border border-error/50 text-error font-label-bold text-[12px] py-xs rounded-full hover:bg-error/10 transition-colors flex items-center justify-center gap-xs">
                                    <span class="material-symbols-outlined text-[14px]">cancel</span>
                                    Batalkan
                                </button>
                            </div>
                        </div>

                        <!-- Booking Item 3 -->
                        <div class="bg-surface-container-low rounded-xl p-md border border-primary/20 hover:border-primary/40 transition-colors">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-md">
                                <div class="flex items-center gap-md">
                                    <div class="w-14 h-14 rounded-xl bg-primary/10 border border-primary/30 flex items-center justify-center flex-shrink-0">
                                        <span class="material-symbols-outlined text-primary text-[28px]">monitor</span>
                                    </div>
                                    <div>
                                        <p class="font-headline-md text-[18px] text-on-surface font-bold">Ruang Multimedia</p>
                                        <div class="flex flex-wrap gap-sm mt-xs">
                                            <span class="flex items-center gap-xs text-on-surface-variant text-xs">
                                                <span class="material-symbols-outlined text-[14px]">calendar_today</span>
                                                Senin, 9 Jun 2025
                                            </span>
                                            <span class="flex items-center gap-xs text-on-surface-variant text-xs">
                                                <span class="material-symbols-outlined text-[14px]">schedule</span>
                                                13:00 – 15:00 (2 jam)
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col items-end gap-sm">
                                    <span class="bg-primary/20 text-primary text-[10px] font-bold px-sm py-xs rounded-full border border-primary/30 flex items-center gap-xs whitespace-nowrap">
                                        <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                                        Dikonfirmasi
                                    </span>
                                    <span class="font-label-bold text-secondary text-[14px]">Rp 360.000</span>
                                </div>
                            </div>
                            <div class="flex gap-sm mt-md pt-md border-t border-outline-variant/20">
                                <button class="flex-1 border border-outline-variant/50 text-on-surface-variant font-label-bold text-[12px] py-xs rounded-full hover:border-primary hover:text-primary transition-colors flex items-center justify-center gap-xs">
                                    <span class="material-symbols-outlined text-[14px]">receipt_long</span>
                                    Lihat Detail
                                </button>
                                <button class="flex-1 border border-error/50 text-error font-label-bold text-[12px] py-xs rounded-full hover:bg-error/10 transition-colors flex items-center justify-center gap-xs">
                                    <span class="material-symbols-outlined text-[14px]">cancel</span>
                                    Batalkan
                                </button>
                            </div>
                        </div>

                    </div>
                </section>

                <!-- RIWAYAT BOOKING -->
                <section class="glass-card rounded-xl p-lg">
                    <div class="flex items-center justify-between mb-lg">
                        <h2 class="font-headline-md text-headline-md text-on-surface flex items-center gap-sm">
                            <span class="material-symbols-outlined text-secondary text-[28px]">history</span>
                            Riwayat Booking
                        </h2>
                        <a href="#" class="text-primary font-label-bold text-[12px] flex items-center gap-xs hover:opacity-80 transition-opacity">
                            Lihat Semua <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                        </a>
                    </div>

                    <!-- Filter tabs -->
                    <div class="flex gap-xs mb-md overflow-x-auto hide-scrollbar">
                        <button onclick="filterRiwayat('semua', this)" class="filter-btn active whitespace-nowrap px-md py-xs rounded-full bg-primary text-void-base font-label-bold text-[11px] uppercase transition-all">Semua</button>
                        <button onclick="filterRiwayat('selesai', this)" class="filter-btn whitespace-nowrap px-md py-xs rounded-full border border-outline-variant/40 text-on-surface-variant font-label-bold text-[11px] uppercase hover:border-primary hover:text-primary transition-all">Selesai</button>
                        <button onclick="filterRiwayat('dibatalkan', this)" class="filter-btn whitespace-nowrap px-md py-xs rounded-full border border-outline-variant/40 text-on-surface-variant font-label-bold text-[11px] uppercase hover:border-primary hover:text-primary transition-all">Dibatalkan</button>
                    </div>

                    <div class="flex flex-col gap-sm" id="riwayat-list">

                        <!-- Riwayat 1: Selesai -->
                        <div class="riwayat-item selesai flex items-center gap-md p-sm rounded-xl hover:bg-surface-container-low/60 transition-colors cursor-default border border-transparent hover:border-outline-variant/10">
                            <div class="w-12 h-12 rounded-xl bg-surface-container flex items-center justify-center flex-shrink-0">
                                <span class="material-symbols-outlined text-on-surface-variant text-[22px]">sports_basketball</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-on-surface text-sm">Lapangan Basket</p>
                                <p class="text-on-surface-variant text-xs mt-0.5">Sabtu, 24 Mei · 14:00–16:00 (2 jam)</p>
                            </div>
                            <div class="flex flex-col items-end gap-xs flex-shrink-0">
                                <span class="text-[10px] font-bold text-secondary bg-secondary/10 px-xs py-0.5 rounded-full border border-secondary/20">Selesai</span>
                                <span class="font-mono text-on-surface-variant text-xs">Rp 300rb</span>
                            </div>
                        </div>

                        <!-- Riwayat 2: Selesai -->
                        <div class="riwayat-item selesai flex items-center gap-md p-sm rounded-xl hover:bg-surface-container-low/60 transition-colors cursor-default border border-transparent hover:border-outline-variant/10">
                            <div class="w-12 h-12 rounded-xl bg-surface-container flex items-center justify-center flex-shrink-0">
                                <span class="material-symbols-outlined text-on-surface-variant text-[22px]">sports_soccer</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-on-surface text-sm">Futsal Indoor</p>
                                <p class="text-on-surface-variant text-xs mt-0.5">Minggu, 18 Mei · 09:00–10:00 (1 jam)</p>
                            </div>
                            <div class="flex flex-col items-end gap-xs flex-shrink-0">
                                <span class="text-[10px] font-bold text-secondary bg-secondary/10 px-xs py-0.5 rounded-full border border-secondary/20">Selesai</span>
                                <span class="font-mono text-on-surface-variant text-xs">Rp 200rb</span>
                            </div>
                        </div>

                        <!-- Riwayat 3: Dibatalkan -->
                        <div class="riwayat-item dibatalkan flex items-center gap-md p-sm rounded-xl hover:bg-surface-container-low/60 transition-colors cursor-default border border-transparent hover:border-outline-variant/10">
                            <div class="w-12 h-12 rounded-xl bg-surface-container flex items-center justify-center flex-shrink-0">
                                <span class="material-symbols-outlined text-on-surface-variant text-[22px]">science</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-on-surface text-sm">Laboratorium Sains</p>
                                <p class="text-on-surface-variant text-xs mt-0.5">Rabu, 14 Mei · 10:00–12:00 (2 jam)</p>
                            </div>
                            <div class="flex flex-col items-end gap-xs flex-shrink-0">
                                <span class="text-[10px] font-bold text-error bg-error/10 px-xs py-0.5 rounded-full border border-error/20">Dibatalkan</span>
                                <span class="font-mono text-on-surface-variant text-xs">Rp 240rb</span>
                            </div>
                        </div>

                        <!-- Riwayat 4: Selesai -->
                        <div class="riwayat-item selesai flex items-center gap-md p-sm rounded-xl hover:bg-surface-container-low/60 transition-colors cursor-default border border-transparent hover:border-outline-variant/10">
                            <div class="w-12 h-12 rounded-xl bg-surface-container flex items-center justify-center flex-shrink-0">
                                <span class="material-symbols-outlined text-on-surface-variant text-[22px]">music_note</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-on-surface text-sm">Studio Musik</p>
                                <p class="text-on-surface-variant text-xs mt-0.5">Sabtu, 10 Mei · 15:00–17:00 (2 jam)</p>
                            </div>
                            <div class="flex flex-col items-end gap-xs flex-shrink-0">
                                <span class="text-[10px] font-bold text-secondary bg-secondary/10 px-xs py-0.5 rounded-full border border-secondary/20">Selesai</span>
                                <span class="font-mono text-on-surface-variant text-xs">Rp 500rb</span>
                            </div>
                        </div>

                        <!-- Riwayat 5: Selesai -->
                        <div class="riwayat-item selesai flex items-center gap-md p-sm rounded-xl hover:bg-surface-container-low/60 transition-colors cursor-default border border-transparent hover:border-outline-variant/10">
                            <div class="w-12 h-12 rounded-xl bg-surface-container flex items-center justify-center flex-shrink-0">
                                <span class="material-symbols-outlined text-on-surface-variant text-[22px]">monitor</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-on-surface text-sm">Ruang Multimedia</p>
                                <p class="text-on-surface-variant text-xs mt-0.5">Senin, 5 Mei · 13:00–14:00 (1 jam)</p>
                            </div>
                            <div class="flex flex-col items-end gap-xs flex-shrink-0">
                                <span class="text-[10px] font-bold text-secondary bg-secondary/10 px-xs py-0.5 rounded-full border border-secondary/20">Selesai</span>
                                <span class="font-mono text-on-surface-variant text-xs">Rp 180rb</span>
                            </div>
                        </div>

                    </div>
                </section>

                <!-- EDIT PROFIL FORM -->
                <section class="glass-card rounded-xl p-lg" id="edit-profil">
                    <div class="mb-lg flex items-start gap-sm">
                        <span class="material-symbols-outlined text-primary text-[32px] mt-1">manage_accounts</span>
                        <div>
                            <h2 class="font-headline-md text-headline-md text-on-surface font-bold">Edit Informasi Profil</h2>
                            <p class="font-body-md text-on-surface-variant mt-xs">Pastikan data kamu selalu up-to-date.</p>
                        </div>
                    </div>

                    <div class="flex flex-col gap-md">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                            <div class="flex flex-col gap-xs">
                                <label class="font-label-bold text-label-bold text-on-surface-variant uppercase tracking-wider">Nama Lengkap</label>
                                <div class="bg-surface-container-high rounded-full px-margin py-sm border border-outline-variant focus-within:border-primary transition-colors flex items-center gap-sm">
                                    <span class="material-symbols-outlined text-on-surface-variant text-[18px]">person</span>
                                    <input type="text" value="Budi Sudarsono" class="bg-transparent border-none outline-none text-on-surface w-full font-body-md" />
                                </div>
                            </div>
                            <div class="flex flex-col gap-xs">
                                <label class="font-label-bold text-label-bold text-on-surface-variant uppercase tracking-wider">Email</label>
                                <div class="bg-surface-container-high rounded-full px-margin py-sm border border-outline-variant focus-within:border-primary transition-colors flex items-center gap-sm">
                                    <span class="material-symbols-outlined text-on-surface-variant text-[18px]">mail</span>
                                    <input type="email" value="budi.sudarsono@example.com" class="bg-transparent border-none outline-none text-on-surface w-full font-body-md" />
                                </div>
                            </div>
                            <div class="flex flex-col gap-xs">
                                <label class="font-label-bold text-label-bold text-on-surface-variant uppercase tracking-wider">No. WhatsApp</label>
                                <div class="bg-surface-container-high rounded-full px-margin py-sm border border-outline-variant focus-within:border-primary transition-colors flex items-center gap-sm">
                                    <span class="material-symbols-outlined text-on-surface-variant text-[18px]">smartphone</span>
                                    <input type="tel" value="0812-3456-7890" class="bg-transparent border-none outline-none text-on-surface w-full font-body-md" />
                                </div>
                            </div>
                            <div class="flex flex-col gap-xs">
                                <label class="font-label-bold text-label-bold text-on-surface-variant uppercase tracking-wider">Kelas</label>
                                <div class="bg-surface-container-high rounded-full px-margin py-sm border border-outline-variant focus-within:border-primary transition-colors flex items-center gap-sm">
                                    <span class="material-symbols-outlined text-on-surface-variant text-[18px]">school</span>
                                    <input type="text" value="XII IPA 3" class="bg-transparent border-none outline-none text-on-surface w-full font-body-md" />
                                </div>
                            </div>
                        </div>

                        <!-- Ganti Password -->
                        <div class="border-t border-outline-variant/20 pt-md mt-sm">
                            <p class="font-label-bold text-[11px] uppercase tracking-widest text-on-surface-variant mb-md">Ganti Kata Sandi</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                                <div class="flex flex-col gap-xs md:col-span-2">
                                    <label class="font-label-bold text-label-bold text-on-surface-variant uppercase tracking-wider">Kata Sandi Saat Ini</label>
                                    <div class="bg-surface-container-high rounded-full px-margin py-sm border border-outline-variant focus-within:border-primary transition-colors flex items-center gap-sm">
                                        <span class="material-symbols-outlined text-on-surface-variant text-[18px]">key</span>
                                        <input type="password" placeholder="••••••••" class="bg-transparent border-none outline-none text-on-surface w-full font-body-md placeholder:text-on-surface-variant" />
                                    </div>
                                </div>
                                <div class="flex flex-col gap-xs">
                                    <label class="font-label-bold text-label-bold text-on-surface-variant uppercase tracking-wider">Kata Sandi Baru</label>
                                    <div class="bg-surface-container-high rounded-full px-margin py-sm border border-outline-variant focus-within:border-primary transition-colors flex items-center gap-sm">
                                        <span class="material-symbols-outlined text-on-surface-variant text-[18px]">lock</span>
                                        <input type="password" placeholder="••••••••" class="bg-transparent border-none outline-none text-on-surface w-full font-body-md placeholder:text-on-surface-variant" />
                                    </div>
                                </div>
                                <div class="flex flex-col gap-xs">
                                    <label class="font-label-bold text-label-bold text-on-surface-variant uppercase tracking-wider">Konfirmasi Kata Sandi</label>
                                    <div class="bg-surface-container-high rounded-full px-margin py-sm border border-outline-variant focus-within:border-primary transition-colors flex items-center gap-sm">
                                        <span class="material-symbols-outlined text-on-surface-variant text-[18px]">check_circle</span>
                                        <input type="password" placeholder="••••••••" class="bg-transparent border-none outline-none text-on-surface w-full font-body-md placeholder:text-on-surface-variant" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end pt-sm">
                            <button type="button" class="bg-emerald-pulse text-void-base font-label-bold text-label-bold px-xl py-sm rounded-full neon-glow hover:scale-105 transition-transform duration-300 flex items-center gap-xs">
                                <span class="material-symbols-outlined text-[18px]">save</span>
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </section>

            </div>
        </div>

    </main>

    <!-- MOBILE NAV (sama seperti welcome) -->
    <nav class="md:hidden fixed bottom-0 w-full rounded-t-lg z-50 bg-surface-container/80 backdrop-blur-lg border-t border-outline-variant/30 shadow-[0_-4px_24px_rgba(0,0,0,0.5)] flex justify-around items-center h-20 px-gutter">
        <a class="flex flex-col items-center justify-center text-on-surface-variant opacity-60 hover:opacity-100 transition-opacity" href="#"><span class="material-symbols-outlined font-headline-md text-headline-md">sports_soccer</span><span class="font-label-bold text-[10px] mt-xs">Beranda</span></a>
        <a class="flex flex-col items-center justify-center text-on-surface-variant opacity-60 hover:opacity-100 transition-opacity" href="#"><span class="material-symbols-outlined font-headline-md text-headline-md">stadium</span><span class="font-label-bold text-[10px] mt-xs">Fasilitas</span></a>
        <a class="flex flex-col items-center justify-center text-on-surface-variant opacity-60 hover:opacity-100 transition-opacity" href="#"><span class="material-symbols-outlined font-headline-md text-headline-md">event_available</span><span class="font-label-bold text-[10px] mt-xs">Booking Saya</span></a>
        <a class="flex flex-col items-center justify-center nav-active duration-300 ease-out" href="#"><span class="material-symbols-outlined font-headline-md text-headline-md">account_circle</span><span class="font-label-bold text-[10px] mt-xs">Profil</span></a>
    </nav>

    <script>
        // Filter riwayat
        function filterRiwayat(type, btn) {
            document.querySelectorAll('.filter-btn').forEach(b => {
                b.classList.remove('bg-primary', 'text-void-base');
                b.classList.add('border', 'border-outline-variant/40', 'text-on-surface-variant');
            });
            btn.classList.add('bg-primary', 'text-void-base');
            btn.classList.remove('border', 'border-outline-variant/40', 'text-on-surface-variant');

            document.querySelectorAll('.riwayat-item').forEach(item => {
                if (type === 'semua') {
                    item.style.display = 'flex';
                } else {
                    item.style.display = item.classList.contains(type) ? 'flex' : 'none';
                }
            });
        }
    </script>

@endsection