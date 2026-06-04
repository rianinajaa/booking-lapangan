@extends('layouts.app')

@section('title', 'SpaceGo - Booking Fasilitas Sekolah')

@section('content')

    <!-- Ambient BG -->
    <div class="fixed inset-0 z-[-1] overflow-hidden pointer-events-none">
        <div class="absolute top-[-10%] right-[-10%] w-[50vw] h-[50vw] bg-emerald-pulse/20 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-[40vw] h-[40vw] bg-primary/10 rounded-full blur-[100px]"></div>
    </div>

    <!-- Include Navbar -->
    @include('layouts.components.navbar')

    <!-- ==================== MAIN ==================== -->
    <main class="pt-[100px] px-margin max-w-[1440px] mx-auto flex flex-col gap-xl pb-[100px] md:pb-0">

        <!-- HERO -->
        <section class="relative flex flex-col items-center justify-center text-center min-h-[716px] gap-lg rounded-3xl overflow-hidden mt-md" id="home">
            <div class="absolute inset-0 z-[-1] opacity-30 bg-[url('{{ asset('images/futsal3.jpeg') }}')] bg-cover bg-center"></div>
            <div class="absolute inset-0 z-[-1] bg-gradient-to-b from-transparent via-void-base/20 to-void-base/60"></div>
            <div class="flex flex-col items-center gap-sm">
                <div class="glass-card px-md py-xs rounded-full border border-primary/30 flex items-center gap-xs mb-sm">
                    <div class="w-2 h-2 bg-primary rounded-full animate-pulse"></div>
                    <span class="font-label-bold text-[11px] text-primary uppercase tracking-widest">Booking Langsung Tersedia</span>
                </div>
                <h1 class="font-display-xl text-display-xl text-primary drop-shadow-[0_0_30px_rgba(5,150,105,0.6)]">Booking Ruangan<br />Gampang & Aman</h1>
                <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl">Cari dan booking fasilitas sekolah dengan mudah. Nggak perlu repot, langsung dapat tempat.</p>
            </div>
            <div class="glass-card p-md rounded-xl flex flex-col sm:flex-row gap-gutter items-center w-full max-w-3xl mt-margin">
                <div class="w-full max-w-4xl bg-surface-container-low/60 backdrop-blur-xl p-sm rounded-full border border-outline-variant/30 shadow-lg flex flex-col sm:flex-row gap-sm items-center">
                    <div class="flex items-center gap-sm flex-1 w-full px-md">
                        <iconify-icon icon="lucide:search" class="text-xl text-on-surface-variant"></iconify-icon>
                        <input id="search-input" class="bg-transparent border-none focus:ring-0 text-body-lg text-on-surface placeholder-on-surface-variant/50 w-full font-body"
                            placeholder="Login untuk mencari fasilitas..." type="text" disabled />
                    </div>
                    <a href="javascript:void(0)" onclick="showToast('Silakan login terlebih dahulu untuk booking','account_circle')" class="bg-emerald-pulse text-void-base font-label-bold text-label-bold px-xl py-md rounded-full neon-glow hover:scale-105 transition-transform duration-300 w-full sm:w-auto flex items-center justify-center gap-xs">
                        Booking Sekarang <iconify-icon icon="lucide:arrow-right" class="text-[18px]"></iconify-icon>
                    </a>
                </div>
            </div>
            <div class="flex gap-lg mt-sm">
                <div class="flex flex-col items-center gap-xs"><span class="material-symbols-outlined text-primary text-[20px]">stadium</span><span class="font-headline-md text-on-surface">12+</span><span class="font-label-bold text-[11px] text-on-surface-variant">Fasilitas</span></div>
                <div class="flex flex-col items-center gap-xs"><span class="material-symbols-outlined text-primary text-[20px]">groups</span><span class="font-headline-md text-on-surface">2.4K+</span><span class="font-label-bold text-[11px] text-on-surface-variant">Pengguna Aktif</span></div>
                <div class="flex flex-col items-center gap-xs"><span class="material-symbols-outlined text-primary text-[20px]">event_available</span><span class="font-headline-md text-on-surface">98%</span><span class="font-label-bold text-[11px] text-on-surface-variant">Kepuasan</span></div>
            </div>
        </section>

        <!-- FACILITIES CAROUSEL -->
        <section class="flex flex-col gap-lg" id="facilities">
            <div class="flex justify-between items-end">
                <h2 class="font-headline-lg text-headline-lg text-on-surface border-l-4 border-primary pl-md">Galeri Fasilitas</h2>
                <div class="flex items-center gap-md">
                    <div class="flex gap-sm">
                        <button id="carousel-prev" class="w-10 h-10 rounded-full border border-primary/30 flex items-center justify-center text-primary hover:bg-primary/20 transition-all active:scale-95"><iconify-icon icon="lucide:chevron-left" class="text-xl"></iconify-icon></button>
                        <button id="carousel-next" class="w-10 h-10 rounded-full border border-primary/30 flex items-center justify-center text-primary hover:bg-primary/20 transition-all active:scale-95"><iconify-icon icon="lucide:chevron-right" class="text-xl"></iconify-icon></button>
                    </div>
                    <a class="text-primary font-label-bold flex items-center gap-xs hover:opacity-80 transition-opacity ml-base" href="#">Lihat Semua <iconify-icon icon="lucide:arrow-right" class="text-[18px]"></iconify-icon></a>
                </div>
            </div>

            <div class="relative overflow-visible rounded-xl">
                <div class="carousel-track overflow-visible" id="facility-track">

                    <!-- Slide 1 -->
                    <div class="carousel-slide">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
                            <!-- Lapangan Basket -->
                            <div class="carousel-card group flex flex-col h-full">
                                <div class="card-img-wrap h-56">
                                    <img class="w-full h-full object-cover" src="{{ asset('images/basket.jpg') }}" alt="Lapangan Basket" loading="lazy" />
                                    <div class="absolute top-sm left-sm bg-surface-container/80 backdrop-blur-md px-sm py-xs rounded-full flex items-center gap-xs border border-primary/30">
                                        <div class="w-2 h-2 bg-primary rounded-full animate-pulse"></div><span class="font-label-bold text-[10px] text-primary">SEDANG BERLANGSUNG</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h3 class="facility-name font-headline-md text-headline-md text-on-surface group-hover:text-primary transition-colors">Lapangan Basket</h3>
                                    <p class="facility-desc font-body-md text-body-md text-on-surface-variant line-clamp-2 flex-1">Lapangan indoor premium, cocok buat latihan atau turnamen. Lantainya empuk, netnya standar.</p>
                                    <div class="flex items-center gap-xs">
                                        <span class="text-primary flex gap-0.5"><iconify-icon icon="lucide:star" class="text-sm fill-current"></iconify-icon><iconify-icon icon="lucide:star" class="text-sm fill-current"></iconify-icon><iconify-icon icon="lucide:star" class="text-sm fill-current"></iconify-icon><iconify-icon icon="lucide:star" class="text-sm fill-current"></iconify-icon><iconify-icon icon="lucide:star" class="text-sm fill-current"></iconify-icon></span>
                                        <span class="text-[12px] text-on-surface-variant ml-xs">(4.8)</span>
                                    </div>
                                    <div class="mt-sm flex justify-between items-center pt-sm border-t border-outline-variant/30">
                                        <span class="font-label-bold text-label-bold text-secondary">Rp 150rb/jam</span>
                                        <a href="javascript:void(0)" onclick="showToast('Silakan login terlebih dahulu','account_circle')" class="bg-transparent border border-primary text-primary font-label-bold text-[12px] px-sm py-xs rounded-full hover:bg-primary hover:text-void-base transition-colors duration-300 flex items-center gap-xs">
                                            <iconify-icon icon="lucide:eye" class="text-[14px]"></iconify-icon>Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- Lapangan Voli -->
                            <div class="carousel-card group flex flex-col h-full">
                                <div class="card-img-wrap h-56">
                                    <img class="w-full h-full object-cover" src="{{ asset('images/voli.jpg') }}" alt="Lapangan Voli" loading="lazy" />
                                    <div class="absolute top-sm left-sm bg-surface-container/80 backdrop-blur-md px-sm py-xs rounded-full flex items-center gap-xs border border-outline-variant">
                                        <div class="w-2 h-2 bg-secondary rounded-full"></div><span class="font-label-bold text-[10px] text-secondary">TERSEDIA</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h3 class="facility-name font-headline-md text-headline-md text-on-surface group-hover:text-primary transition-colors">Lapangan Voli</h3>
                                    <p class="facility-desc font-body-md text-body-md text-on-surface-variant line-clamp-2 flex-1">Lapangan sintetis outdoor, nyaman dipakai untuk voli santai maupun kompetisi.</p>
                                    <div class="flex items-center gap-xs"><span class="text-primary flex gap-0.5"><iconify-icon icon="lucide:star" class="text-sm fill-current"></iconify-icon><iconify-icon icon="lucide:star" class="text-sm fill-current"></iconify-icon><iconify-icon icon="lucide:star" class="text-sm fill-current"></iconify-icon><iconify-icon icon="lucide:star" class="text-sm fill-current"></iconify-icon><iconify-icon icon="lucide:star" class="text-sm fill-current"></iconify-icon></span><span class="text-[12px] text-on-surface-variant ml-xs">(4.9)</span></div>
                                    <div class="mt-sm flex justify-between items-center pt-sm border-t border-outline-variant/30">
                                        <span class="font-label-bold text-label-bold text-secondary">Rp 100rb/jam</span>
                                        <a href="javascript:void(0)" onclick="showToast('Silakan login terlebih dahulu','account_circle')" class="bg-transparent border border-primary text-primary font-label-bold text-[12px] px-sm py-xs rounded-full hover:bg-primary hover:text-void-base transition-colors duration-300 flex items-center gap-xs">
                                            <iconify-icon icon="lucide:eye" class="text-[14px]"></iconify-icon>Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- Futsal Indoor -->
                            <div class="carousel-card group flex flex-col h-full">
                                <div class="card-img-wrap h-56">
                                    <img class="w-full h-full object-cover" src="{{ asset('images/futsal2.jpg') }}" alt="Futsal Indoor" loading="lazy" />
                                    <div class="absolute top-sm left-sm bg-surface-container/80 backdrop-blur-md px-sm py-xs rounded-full flex items-center gap-xs border border-primary/30">
                                        <div class="w-2 h-2 bg-primary rounded-full animate-pulse"></div><span class="font-label-bold text-[10px] text-primary">SEDANG BERLANGSUNG</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h3 class="facility-name font-headline-md text-headline-md text-on-surface group-hover:text-primary transition-colors">Futsal Indoor</h3>
                                    <p class="facility-desc font-body-md text-body-md text-on-surface-variant line-clamp-2 flex-1">Rumput sintetis, cocok buat futsal seru bareng teman-teman.</p>
                                    <div class="flex items-center gap-xs"><span class="text-primary flex gap-0.5"><iconify-icon icon="lucide:star" class="text-sm fill-current"></iconify-icon><iconify-icon icon="lucide:star" class="text-sm fill-current"></iconify-icon><iconify-icon icon="lucide:star" class="text-sm fill-current"></iconify-icon><iconify-icon icon="lucide:star" class="text-sm fill-current"></iconify-icon><iconify-icon icon="lucide:star" class="text-sm fill-current"></iconify-icon></span><span class="text-[12px] text-on-surface-variant ml-xs">(5.0)</span></div>
                                    <div class="mt-sm flex justify-between items-center pt-sm border-t border-outline-variant/30">
                                        <span class="font-label-bold text-label-bold text-secondary">Rp 200rb/jam</span>
                                        <a href="javascript:void(0)" onclick="showToast('Silakan login terlebih dahulu','account_circle')" class="bg-transparent border border-primary text-primary font-label-bold text-[12px] px-sm py-xs rounded-full hover:bg-primary hover:text-void-base transition-colors duration-300 flex items-center gap-xs">
                                            <iconify-icon icon="lucide:eye" class="text-[14px]"></iconify-icon>Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 2 -->
                    <div class="carousel-slide">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
                            <!-- Laboratorium Sains -->
                            <div class="carousel-card group flex flex-col h-full">
                                <div class="card-img-wrap h-56">
                                    <img class="w-full h-full object-cover" src="{{ asset('images/lab.jpg') }}" alt="Laboratorium Sains" loading="lazy" />
                                    <div class="absolute top-sm left-sm bg-surface-container/80 backdrop-blur-md px-sm py-xs rounded-full flex items-center gap-xs border border-outline-variant">
                                        <div class="w-2 h-2 bg-secondary rounded-full"></div><span class="font-label-bold text-[10px] text-secondary">TERSEDIA</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h3 class="facility-name font-headline-md text-headline-md text-on-surface group-hover:text-primary transition-colors">Laboratorium Sains</h3>
                                    <p class="facility-desc font-body-md text-body-md text-on-surface-variant line-clamp-2 flex-1">Lab lengkap dengan alat-alat modern, enak buat praktikum atau penelitian.</p>
                                    <div class="flex items-center gap-xs"><span class="text-primary flex gap-0.5"><iconify-icon icon="lucide:star" class="text-sm fill-current"></iconify-icon><iconify-icon icon="lucide:star" class="text-sm fill-current"></iconify-icon><iconify-icon icon="lucide:star" class="text-sm fill-current"></iconify-icon><iconify-icon icon="lucide:star" class="text-sm fill-current"></iconify-icon><iconify-icon icon="lucide:star" class="text-sm text-outline-variant"></iconify-icon></span><span class="text-[12px] text-on-surface-variant ml-xs">(4.2)</span></div>
                                    <div class="mt-sm flex justify-between items-center pt-sm border-t border-outline-variant/30">
                                        <span class="font-label-bold text-label-bold text-secondary">Rp 120rb/jam</span>
                                        <a href="javascript:void(0)" onclick="showToast('Silakan login terlebih dahulu','account_circle')" class="bg-transparent border border-primary text-primary font-label-bold text-[12px] px-sm py-xs rounded-full hover:bg-primary hover:text-void-base transition-colors duration-300 flex items-center gap-xs">
                                            <iconify-icon icon="lucide:eye" class="text-[14px]"></iconify-icon>Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- Ruang Multimedia -->
                            <div class="carousel-card group flex flex-col h-full">
                                <div class="card-img-wrap h-56">
                                    <img class="w-full h-full object-cover" src="{{ asset('images/multimedia.jpg') }}" alt="Ruang Multimedia" loading="lazy" />
                                    <div class="absolute top-sm left-sm bg-surface-container/80 backdrop-blur-md px-sm py-xs rounded-full flex items-center gap-xs border border-outline-variant">
                                        <div class="w-2 h-2 bg-secondary rounded-full"></div><span class="font-label-bold text-[10px] text-secondary">TERSEDIA</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h3 class="facility-name font-headline-md text-headline-md text-on-surface group-hover:text-primary transition-colors">Ruang Multimedia</h3>
                                    <p class="facility-desc font-body-md text-body-md text-on-surface-variant line-clamp-2 flex-1">Komputer canggih, bisa buat desain, edit video, atau coding. Asik!</p>
                                    <div class="flex items-center gap-xs"><span class="text-primary flex gap-0.5"><iconify-icon icon="lucide:star" class="text-sm fill-current"></iconify-icon><iconify-icon icon="lucide:star" class="text-sm fill-current"></iconify-icon><iconify-icon icon="lucide:star" class="text-sm fill-current"></iconify-icon><iconify-icon icon="lucide:star" class="text-sm fill-current"></iconify-icon><iconify-icon icon="lucide:star" class="text-sm fill-current"></iconify-icon></span><span class="text-[12px] text-on-surface-variant ml-xs">(4.7)</span></div>
                                    <div class="mt-sm flex justify-between items-center pt-sm border-t border-outline-variant/30">
                                        <span class="font-label-bold text-label-bold text-secondary">Rp 180rb/jam</span>
                                        <a href="javascript:void(0)" onclick="showToast('Silakan login terlebih dahulu','account_circle')" class="bg-transparent border border-primary text-primary font-label-bold text-[12px] px-sm py-xs rounded-full hover:bg-primary hover:text-void-base transition-colors duration-300 flex items-center gap-xs">
                                            <iconify-icon icon="lucide:eye" class="text-[14px]"></iconify-icon>Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- Aula Utama -->
                            <div class="carousel-card group flex flex-col h-full">
                                <div class="card-img-wrap h-56">
                                    <img class="w-full h-full object-cover" src="{{ asset('images/aula.jpg') }}" alt="Aula Utama" loading="lazy" />
                                    <div class="absolute top-sm left-sm bg-surface-container/80 backdrop-blur-md px-sm py-xs rounded-full flex items-center gap-xs border border-primary/30">
                                        <div class="w-2 h-2 bg-primary rounded-full animate-pulse"></div><span class="font-label-bold text-[10px] text-primary">SEDANG BERLANGSUNG</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h3 class="facility-name font-headline-md text-headline-md text-on-surface group-hover:text-primary transition-colors">Aula Utama</h3>
                                    <p class="facility-desc font-body-md text-body-md text-on-surface-variant line-clamp-2 flex-1">Aula luas kapasitas besar, cocok buat seminar, ujian, atau acara sekolah.</p>
                                    <div class="flex items-center gap-xs"><span class="text-primary flex gap-0.5"><iconify-icon icon="lucide:star" class="text-sm fill-current"></iconify-icon><iconify-icon icon="lucide:star" class="text-sm fill-current"></iconify-icon><iconify-icon icon="lucide:star" class="text-sm fill-current"></iconify-icon><iconify-icon icon="lucide:star" class="text-sm fill-current"></iconify-icon><iconify-icon icon="lucide:star" class="text-sm text-outline-variant"></iconify-icon></span><span class="text-[12px] text-on-surface-variant ml-xs">(4.3)</span></div>
                                    <div class="mt-sm flex justify-between items-center pt-sm border-t border-outline-variant/30">
                                        <span class="font-label-bold text-label-bold text-secondary">Rp 500rb/jam</span>
                                        <a href="javascript:void(0)" onclick="showToast('Silakan login terlebih dahulu','account_circle')" class="bg-transparent border border-primary text-primary font-label-bold text-[12px] px-sm py-xs rounded-full hover:bg-primary hover:text-void-base transition-colors duration-300 flex items-center gap-xs">
                                            <iconify-icon icon="lucide:eye" class="text-[14px]"></iconify-icon>Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="flex justify-center gap-sm mt-md" id="carousel-dots">
                <div class="dot active" data-index="0"></div>
                <div class="dot" data-index="1"></div>
                <div class="dot" data-index="2"></div>
            </div>
        </section>

        <!-- FAQ -->
        <section class="flex flex-col gap-lg" id="faq">
            <div class="text-center">
                <h2 class="font-headline-lg text-headline-lg text-on-surface mb-sm">Pertanyaan Umum</h2>
                <p class="font-body-md text-on-surface-variant">Semua yang perlu kamu tahu soal booking di SpaceGo.</p>
            </div>
            <div class="max-w-3xl mx-auto w-full flex flex-col gap-sm">
                <details class="glass-card rounded-xl group" name="faq">
                    <summary class="flex justify-between items-center p-md cursor-pointer font-headline-md text-[20px] text-on-surface list-none hover:text-primary transition-colors"><span>Gimana cara booking fasilitas?</span><span class="material-symbols-outlined text-primary transition-transform duration-300 group-open:rotate-180 flex-shrink-0 ml-md">expand_more</span></summary>
                    <div class="px-md pb-md font-body-md text-on-surface-variant border-t border-outline-variant/20 pt-sm mt-xs">Pilih fasilitas yang kamu mau, klik tombol "Detail", nanti kamu bakal diarahkan login dulu (kalo belum). Isi data, pilih tanggal dan jam, terus konfirm. Bukti booking langsung dikirim ke email kamu kok.</div>
                </details>
                <details class="glass-card rounded-xl group" name="faq">
                    <summary class="flex justify-between items-center p-md cursor-pointer font-headline-md text-[20px] text-on-surface list-none hover:text-primary transition-colors"><span>Ada diskon nggak buat siswa?</span><span class="material-symbols-outlined text-primary transition-transform duration-300 group-open:rotate-180 flex-shrink-0 ml-md">expand_more</span></summary>
                    <div class="px-md pb-md font-body-md text-on-surface-variant border-t border-outline-variant/20 pt-sm mt-xs">Ada! Khusus siswa yang udah verifikasi bakal dapet potongan 20% untuk jam 08.00–15.00, Senin–Jumat. Upload kartu pelajar di profil kamu ya.</div>
                </details>
                <details class="glass-card rounded-xl group" name="faq">
                    <summary class="flex justify-between items-center p-md cursor-pointer font-headline-md text-[20px] text-on-surface list-none hover:text-primary transition-colors"><span>Bayarnya pake apa aja?</span><span class="material-symbols-outlined text-primary transition-transform duration-300 group-open:rotate-180 flex-shrink-0 ml-md">expand_more</span></summary>
                    <div class="px-md pb-md font-body-md text-on-surface-variant border-t border-outline-variant/20 pt-sm mt-xs">Bisa transfer bank, kartu kredit/debit, atau dompet digital kayak GoPay, OVO, Dana. Semua transaksi aman dan terenkripsi.</div>
                </details>
                <details class="glass-card rounded-xl group" name="faq">
                    <summary class="flex justify-between items-center p-md cursor-pointer font-headline-md text-[20px] text-on-surface list-none hover:text-primary transition-colors"><span>Bisa batalkan atau ganti jadwal nggak?</span><span class="material-symbols-outlined text-primary transition-transform duration-300 group-open:rotate-180 flex-shrink-0 ml-md">expand_more</span></summary>
                    <div class="px-md pb-md font-body-md text-on-surface-variant border-t border-outline-variant/20 pt-sm mt-xs">Bisa, maksimal 24 jam sebelum jadwal. Nanti refund-nya dikembalikan dalam bentuk kredit SpaceGo buat booking berikutnya.</div>
                </details>
                <details class="glass-card rounded-xl group" name="faq">
                    <summary class="flex justify-between items-center p-md cursor-pointer font-headline-md text-[20px] text-on-surface list-none hover:text-primary transition-colors"><span>Berapa lama konfirmasi booking?</span><span class="material-symbols-outlined text-primary transition-transform duration-300 group-open:rotate-180 flex-shrink-0 ml-md">expand_more</span></summary>
                    <div class="px-md pb-md font-body-md text-on-surface-variant border-t border-outline-variant/20 pt-sm mt-xs">Kurang dari 1 menit setelah pembayaran berhasil, langsung dapet email konfirmasi.</div>
                </details>
            </div>
        </section>

        <!-- TESTIMONIALS -->
        <section class="flex flex-col gap-lg overflow-hidden pb-margin" id="testimonials">
            <div class="flex justify-between items-end">
                <h2 class="font-headline-lg text-headline-lg text-on-surface border-l-4 border-primary pl-md">Kata Mereka</h2>
                <div class="flex gap-sm">
                    <button id="testi-prev" class="w-10 h-10 rounded-full border border-outline-variant flex items-center justify-center hover:border-primary hover:text-primary transition-colors active:scale-95"><span class="material-symbols-outlined">chevron_left</span></button>
                    <button id="testi-next" class="w-10 h-10 rounded-full border border-outline-variant flex items-center justify-center hover:border-primary hover:text-primary transition-colors active:scale-95"><span class="material-symbols-outlined">chevron_right</span></button>
                </div>
            </div>
            <div class="flex overflow-x-auto gap-gutter pb-sm hide-scrollbar snap-x" id="testi-container">
                <div class="glass-card p-md rounded-xl min-w-[300px] md:min-w-[400px] snap-start flex flex-col gap-md hover:border-primary/40 transition-colors">
                    <div class="flex gap-xs text-primary"><span class="material-symbols-outlined text-[18px]" style="font-variation-settings:'FILL' 1">star</span><span class="material-symbols-outlined text-[18px]" style="font-variation-settings:'FILL' 1">star</span><span class="material-symbols-outlined text-[18px]" style="font-variation-settings:'FILL' 1">star</span><span class="material-symbols-outlined text-[18px]" style="font-variation-settings:'FILL' 1">star</span><span class="material-symbols-outlined text-[18px]" style="font-variation-settings:'FILL' 1">star</span></div>
                    <p class="font-body-md text-on-surface-variant italic flex-1">"Aplikasi ini ngebantu banget buat ngatur jadwal lapangan olahraga. Nggak perlu ribet booking lewat kertas lagi."</p>
                    <div class="flex items-center gap-sm mt-auto">
                        <div class="w-12 h-12 bg-surface-container-high rounded-full overflow-hidden flex items-center justify-center border border-primary/20"><span class="material-symbols-outlined text-on-surface-variant">sports</span></div>
                        <div>
                            <div class="font-label-bold text-on-surface">Syahrulroni</div>
                            <div class="text-[12px] text-primary">Guru PJOK</div>
                        </div>
                    </div>
                </div>
                <div class="glass-card p-md rounded-xl min-w-[300px] md:min-w-[400px] snap-start flex flex-col gap-md hover:border-primary/40 transition-colors">
                    <div class="flex gap-xs text-primary"><span class="material-symbols-outlined text-[18px]" style="font-variation-settings:'FILL' 1">star</span><span class="material-symbols-outlined text-[18px]" style="font-variation-settings:'FILL' 1">star</span><span class="material-symbols-outlined text-[18px]" style="font-variation-settings:'FILL' 1">star</span><span class="material-symbols-outlined text-[18px]" style="font-variation-settings:'FILL' 1">star</span><span class="material-symbols-outlined text-[18px]" style="font-variation-settings:'FILL' 1">star_half</span></div>
                    <p class="font-body-md text-on-surface-variant italic flex-1">"Saya siswa dari luar sekolah, tapi tetep bisa booking fasilitas. Prosesnya gampang banget!"</p>
                    <div class="flex items-center gap-sm mt-auto">
                        <div class="w-12 h-12 bg-surface-container-high rounded-full overflow-hidden flex items-center justify-center border border-primary/20"><span class="material-symbols-outlined text-on-surface-variant">school</span></div>
                        <div>
                            <div class="font-label-bold text-on-surface">Nafis Ahmad Maruf</div>
                            <div class="text-[12px] text-primary">Siswa Eksternal</div>
                        </div>
                    </div>
                </div>
                <div class="glass-card p-md rounded-xl min-w-[300px] md:min-w-[400px] snap-start flex flex-col gap-md hover:border-primary/40 transition-colors">
                    <div class="flex gap-xs text-primary"><span class="material-symbols-outlined text-[18px]" style="font-variation-settings:'FILL' 1">star</span><span class="material-symbols-outlined text-[18px]" style="font-variation-settings:'FILL' 1">star</span><span class="material-symbols-outlined text-[18px]" style="font-variation-settings:'FILL' 1">star</span><span class="material-symbols-outlined text-[18px]" style="font-variation-settings:'FILL' 1">star</span><span class="material-symbols-outlined text-[18px]" style="font-variation-settings:'FILL' 1">star</span></div>
                    <p class="font-body-md text-on-surface-variant italic flex-1">"Enak banget booking lapangan futsal buat latihan ekstrakurikuler. Langsung dapet jadwal, nggak perlu rebutan."</p>
                    <div class="flex items-center gap-sm mt-auto">
                        <div class="w-12 h-12 bg-surface-container-high rounded-full overflow-hidden flex items-center justify-center border border-primary/20"><span class="material-symbols-outlined text-on-surface-variant">sports_soccer</span></div>
                        <div>
                            <div class="font-label-bold text-on-surface">Abdul Mughni Nugraha</div>
                            <div class="text-[12px] text-primary">Siswa Internal</div>
                        </div>
                    </div>
                </div>
                <!-- tambahkan testimonial keempat jika perlu, atau biarkan 3 saja sesuai permintaan -->
            </div>
        </section>

        <!-- CTA BANNER -->
        <section class="glass-card rounded-xl p-xl flex flex-col md:flex-row items-center justify-between gap-lg mb-xl relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-emerald-pulse/10 to-transparent pointer-events-none"></div>
            <div class="flex flex-col gap-sm">
                <h2 class="font-headline-lg text-headline-lg text-on-surface">Yuk, Booking Sekarang!</h2>
                <p class="font-body-md text-on-surface-variant max-w-md">Gabung sama ribuan siswa lain yang udah pakai SpaceGo. Daftar gratis, langsung bisa booking.</p>
            </div>
            <button onclick="document.getElementById('facilities').scrollIntoView({behavior:'smooth'})" class="bg-emerald-pulse text-void-base font-label-bold text-label-bold px-xl py-md rounded-full neon-glow hover:scale-105 transition-transform duration-300 flex items-center gap-xs flex-shrink-0">
                Mulai Booking <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
            </button>
        </section>

    </main>

    <!-- ==================== FOOTER ==================== -->
    <footer class="mt-xl border-t border-outline-variant/30 bg-surface-container-low pt-xl pb-md">
        <div class="max-w-[1440px] mx-auto px-margin">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-lg mb-xl">
                <div class="flex flex-col gap-sm">
                    <div class="font-display-xl-mobile text-[32px] font-extrabold text-primary tracking-tighter">SpaceGo</div>
                    <p class="font-body-md text-on-surface-variant">Platform booking fasilitas sekolah yang cepet, gampang, dan terpercaya buat semua siswa.</p>
                    <div class="flex gap-sm mt-sm">
                        <div class="glass-card px-sm py-xs rounded-full flex items-center gap-xs border border-primary/20">
                            <div class="w-2 h-2 bg-primary rounded-full animate-pulse"></div><span class="font-label-bold text-[10px] text-primary">LIVE</span>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col gap-sm">
                    <h4 class="font-headline-md text-[18px] text-on-surface mb-xs">Menu</h4>
                    <a class="text-on-surface-variant hover:text-primary transition-colors font-body-md" href="#home">Beranda</a>
                    <a class="text-on-surface-variant hover:text-primary transition-colors font-body-md" href="#facilities">Fasilitas</a>
                    <a class="text-on-surface-variant hover:text-primary transition-colors font-body-md" href="#">Harga</a>
                    <a class="text-on-surface-variant hover:text-primary transition-colors font-body-md" href="#faq">FAQ</a>
                </div>
                <div class="flex flex-col gap-sm">
                    <h4 class="font-headline-md text-[18px] text-on-surface mb-xs">Bantuan</h4>
                    <a class="text-on-surface-variant hover:text-primary transition-colors font-body-md" href="#">Pusat Bantuan</a>
                    <a class="text-on-surface-variant hover:text-primary transition-colors font-body-md" href="#">Syarat & Ketentuan</a>
                    <a class="text-on-surface-variant hover:text-primary transition-colors font-body-md" href="#">Kebijakan Privasi</a>
                    <a class="text-on-surface-variant hover:text-primary transition-colors font-body-md" href="#">Kontak Kami</a>
                </div>
                <div class="flex flex-col gap-sm">
                    <h4 class="font-headline-md text-[18px] text-on-surface mb-xs">Kontak</h4>
                    <div class="flex gap-sm">
                        <a class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center text-on-surface-variant hover:bg-primary/20 hover:text-primary transition-all" href="#"><span class="material-symbols-outlined">mail</span></a>
                        <a class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center text-on-surface-variant hover:bg-primary/20 hover:text-primary transition-all" href="#"><span class="material-symbols-outlined">share</span></a>
                        <a class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center text-on-surface-variant hover:bg-primary/20 hover:text-primary transition-all" href="#"><span class="material-symbols-outlined">chat</span></a>
                    </div>
                    <p class="font-body-md text-on-surface-variant mt-sm">hello@spacego.com<br />+62 812 3456 7890</p>
                </div>
            </div>
            <div class="border-t border-outline-variant/30 pt-md flex flex-col md:flex-row justify-between items-center gap-sm">
                <p class="text-on-surface-variant text-[14px]">© 2025 SpaceGo. Hak Cipta Dilindungi.</p>
                <div class="flex gap-md text-[14px] text-on-surface-variant"><span>Dibuat buat anak sekolah by anak sekolah 🚀</span></div>
            </div>
        </div>
    </footer>

    <!-- ==================== MOBILE NAV ==================== -->
    <nav class="md:hidden fixed bottom-0 w-full rounded-t-lg z-50 bg-surface-container/80 backdrop-blur-lg border-t border-outline-variant/30 shadow-[0_-4px_24px_rgba(0,0,0,0.5)] flex justify-around items-center h-20 px-gutter">
        <a class="flex flex-col items-center justify-center nav-active duration-300 ease-out" href="#home"><span class="material-symbols-outlined font-headline-md text-headline-md">sports_soccer</span><span class="font-label-bold text-[10px] mt-xs">Beranda</span></a>
        <a class="flex flex-col items-center justify-center text-on-surface-variant opacity-60 hover:opacity-100 transition-opacity" href="#facilities"><span class="material-symbols-outlined font-headline-md text-headline-md">stadium</span><span class="font-label-bold text-[10px] mt-xs">Fasilitas</span></a>
        <a class="flex flex-col items-center justify-center text-on-surface-variant opacity-60 hover:opacity-100 transition-opacity" href="#"><span class="material-symbols-outlined font-headline-md text-headline-md">event_available</span><span class="font-label-bold text-[10px] mt-xs">Booking Saya</span></a>
        <a class="flex flex-col items-center justify-center text-on-surface-variant opacity-60 hover:opacity-100 transition-opacity" href="#"><span class="material-symbols-outlined font-headline-md text-headline-md">account_circle</span><span class="font-label-bold text-[10px] mt-xs">Profil</span></a>
    </nav>

    <!-- ==================== BOOKING MODAL (tetap ada tapi tidak digunakan) ==================== -->
    <div id="booking-modal" class="fixed inset-0 z-[999] bg-void-base/80 backdrop-blur-md flex items-center justify-center p-margin hidden">
        <div id="modal-content" class="glass-card rounded-xl w-full max-w-lg p-lg relative max-h-[90vh] overflow-y-auto">
            <button onclick="closeBookingModal()" class="absolute top-md right-md text-on-surface-variant hover:text-primary transition-colors"><span class="material-symbols-outlined">close</span></button>
            <h2 class="font-headline-lg text-headline-lg text-on-surface mb-xs">Form Booking</h2>
            <p class="text-on-surface-variant font-body-md mb-lg">Isi detail booking fasilitas kamu di bawah ini.</p>
            <div class="bg-surface-container rounded-xl p-sm mb-lg flex items-center gap-sm border border-primary/20">
                <span class="material-symbols-outlined text-primary">stadium</span>
                <div>
                    <div class="font-label-bold text-on-surface" id="modal-facility-name">Lapangan Basket</div>
                    <div class="text-primary font-label-bold text-[12px]" id="modal-price">Rp 150rb/jam</div>
                </div>
            </div>
            <form id="booking-form" class="flex flex-col gap-md">
                <div class="flex flex-col gap-xs">
                    <label class="font-label-bold text-label-bold text-on-surface-variant uppercase tracking-wider">Nama Lengkap</label>
                    <div class="bg-surface-container-high rounded-full px-margin py-sm border border-outline-variant focus-within:border-primary transition-colors flex items-center gap-sm"><span class="material-symbols-outlined text-on-surface-variant text-[18px]">person</span><input required type="text" placeholder="Masukkan nama lengkap" class="bg-transparent border-none outline-none text-on-surface w-full font-body-md placeholder:text-on-surface-variant" /></div>
                </div>
                <div class="flex flex-col gap-xs">
                    <label class="font-label-bold text-label-bold text-on-surface-variant uppercase tracking-wider">Nomor HP / WhatsApp</label>
                    <div class="bg-surface-container-high rounded-full px-margin py-sm border border-outline-variant focus-within:border-primary transition-colors flex items-center gap-sm"><span class="material-symbols-outlined text-on-surface-variant text-[18px]">smartphone</span><input required type="tel" placeholder="08xx-xxxx-xxxx" class="bg-transparent border-none outline-none text-on-surface w-full font-body-md placeholder:text-on-surface-variant" /></div>
                </div>
                <div class="grid grid-cols-2 gap-md">
                    <div class="flex flex-col gap-xs">
                        <label class="font-label-bold text-label-bold text-on-surface-variant uppercase tracking-wider">Tanggal</label>
                        <div class="bg-surface-container-high rounded-xl px-md py-sm border border-outline-variant focus-within:border-primary transition-colors flex items-center gap-sm"><span class="material-symbols-outlined text-on-surface-variant text-[18px]">calendar_today</span><input required type="date" class="bg-transparent border-none outline-none text-on-surface w-full font-body-md [color-scheme:dark]" /></div>
                    </div>
                    <div class="flex flex-col gap-xs">
                        <label class="font-label-bold text-label-bold text-on-surface-variant uppercase tracking-wider">Jam Mulai</label>
                        <div class="bg-surface-container-high rounded-xl px-md py-sm border border-outline-variant focus-within:border-primary transition-colors flex items-center gap-sm"><span class="material-symbols-outlined text-on-surface-variant text-[18px]">schedule</span>
                            <select required class="bg-transparent border-none outline-none text-on-surface w-full font-body-md [color-scheme:dark] cursor-pointer">
                                <option value="">Pilih jam</option>
                                <option>07:00</option>
                                <option>08:00</option>
                                <option>09:00</option>
                                <option>10:00</option>
                                <option>11:00</option>
                                <option>12:00</option>
                                <option>13:00</option>
                                <option>14:00</option>
                                <option>15:00</option>
                                <option>16:00</option>
                                <option>17:00</option>
                                <option>18:00</option>
                                <option>19:00</option>
                                <option>20:00</option>
                                <option>21:00</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col gap-xs">
                    <label class="font-label-bold text-label-bold text-on-surface-variant uppercase tracking-wider">Durasi</label>
                    <div class="flex gap-sm">
                        <label class="flex-1 cursor-pointer"><input type="radio" name="duration" value="1" class="sr-only peer" checked>
                            <div class="text-center py-sm rounded-xl border border-outline-variant peer-checked:border-primary peer-checked:bg-primary/10 peer-checked:text-primary text-on-surface-variant font-label-bold text-label-bold transition-all">1 Jam</div>
                        </label>
                        <label class="flex-1 cursor-pointer"><input type="radio" name="duration" value="2" class="sr-only peer">
                            <div class="text-center py-sm rounded-xl border border-outline-variant peer-checked:border-primary peer-checked:bg-primary/10 peer-checked:text-primary text-on-surface-variant font-label-bold text-label-bold transition-all">2 Jam</div>
                        </label>
                        <label class="flex-1 cursor-pointer"><input type="radio" name="duration" value="3" class="sr-only peer">
                            <div class="text-center py-sm rounded-xl border border-outline-variant peer-checked:border-primary peer-checked:bg-primary/10 peer-checked:text-primary text-on-surface-variant font-label-bold text-label-bold transition-all">3 Jam</div>
                        </label>
                        <label class="flex-1 cursor-pointer"><input type="radio" name="duration" value="4" class="sr-only peer">
                            <div class="text-center py-sm rounded-xl border border-outline-variant peer-checked:border-primary peer-checked:bg-primary/10 peer-checked:text-primary text-on-surface-variant font-label-bold text-label-bold transition-all">4 Jam</div>
                        </label>
                    </div>
                </div>
                <div class="flex flex-col gap-xs">
                    <label class="font-label-bold text-label-bold text-on-surface-variant uppercase tracking-wider">Catatan (Opsional)</label>
                    <div class="bg-surface-container-high rounded-xl px-margin py-sm border border-outline-variant focus-within:border-primary transition-colors"><textarea rows="2" placeholder="Keperluan, jumlah orang, dll." class="bg-transparent border-none outline-none text-on-surface w-full font-body-md placeholder:text-on-surface-variant resize-none"></textarea></div>
                </div>
                <div class="bg-surface-container rounded-xl p-sm border border-outline-variant/30 flex justify-between items-center">
                    <span class="text-on-surface-variant font-body-md">Estimasi Biaya</span>
                    <span class="text-primary font-headline-md" id="modal-total">Rp 150.000</span>
                </div>
                <button id="submit-booking-btn" type="submit" class="bg-emerald-pulse text-void-base font-label-bold text-label-bold px-xl py-md rounded-full neon-glow hover:scale-105 transition-transform duration-300 flex items-center justify-center gap-xs">
                    Konfirmasi Booking <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </button>
            </form>
        </div>
    </div>

    <!-- TOAST -->
    <div id="toast" class="fixed bottom-24 md:bottom-8 left-1/2 -translate-x-1/2 z-[9999] glass-card px-gutter py-sm rounded-full flex items-center gap-sm border border-primary/40 hidden opacity-0 transition-all duration-300">
        <span class="material-symbols-outlined text-primary text-[20px]" id="toast-icon">check_circle</span>
        <span class="font-label-bold text-on-surface" id="toast-msg">Berhasil!</span>
    </div>

    <style>
        /* ===== HANYA PERBAIKAN BORDER CAROUSEL ===== */
        .relative.overflow-hidden.rounded-xl {
            overflow: visible !important;
        }
        
        .carousel-track {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }
        
        .carousel-slide {
            flex: 0 0 100%;
            min-width: 0;
        }
        
        .carousel-card {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .carousel-card:hover {
            transform: translateY(-5px);
            z-index: 10;
        }
        
        .card-img-wrap {
            position: relative;
            overflow: hidden;
        }
        
        .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--outline-variant);
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .dot.active {
            width: 24px;
            border-radius: 4px;
            background: var(--primary);
        }
        
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        
        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        
        #booking-modal:not(.hidden) {
            display: flex !important;
        }
        
        #toast.show {
            display: flex !important;
            opacity: 1 !important;
        }
    </style>

    <script>
        // ===== NAVBAR SCROLL EFFECT =====
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('main-navbar');

            if (window.scrollY > 20) {
                navbar.classList.add('bg-glass-overlay', 'backdrop-blur-xl', 'shadow-[0_0_20px_rgba(5,150,105,0.15)]');
            } else {
                navbar.classList.remove('bg-glass-overlay', 'backdrop-blur-xl', 'shadow-[0_0_20px_rgba(5,150,105,0.15)]');
            }
        });
        
        // ===== TOAST =====
        function showToast(msg, icon = 'check_circle') {
            const t = document.getElementById('toast');
            document.getElementById('toast-msg').textContent = msg;
            document.getElementById('toast-icon').textContent = icon;
            t.classList.add('show');
            t.classList.remove('hidden');
            setTimeout(() => t.classList.remove('show'), 3000);
        }

        // ===== MODAL (tidak digunakan untuk guest, tapi tetap ada) =====
        function openBookingModal(name, price) {
            document.getElementById('modal-facility-name').textContent = name;
            document.getElementById('modal-price').textContent = price;
            document.getElementById('booking-modal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeBookingModal() {
            document.getElementById('booking-modal').classList.add('hidden');
            document.body.style.overflow = '';
        }
        document.getElementById('booking-modal').addEventListener('click', function(e) {
            if (e.target === this) closeBookingModal();
        });

        // ===== BOOKING SUBMIT (tidak digunakan) =====
        document.getElementById('booking-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = document.getElementById('submit-booking-btn');
            btn.disabled = true;
            btn.innerHTML = '<span class="material-symbols-outlined text-[18px]">progress_activity</span> Memproses...';
            setTimeout(() => {
                closeBookingModal();
                showToast('Booking berhasil! Cek email kamu.', 'check_circle');
                btn.disabled = false;
                btn.innerHTML = 'Konfirmasi Booking <span class="material-symbols-outlined text-[18px]">arrow_forward</span>';
                this.reset();
            }, 1500);
        });

        // ===== FACILITY CAROUSEL =====
        const track = document.getElementById('facility-track');
        const slides = track.querySelectorAll('.carousel-slide');
        const dots = document.querySelectorAll('#carousel-dots .dot');
        const btnPrev = document.getElementById('carousel-prev');
        const btnNext = document.getElementById('carousel-next');
        let current = 0,
            autoTimer;

        function goToSlide(idx) {
            current = (idx + slides.length) % slides.length;
            track.style.transform = `translateX(-${current * 100}%)`;
            dots.forEach((d, i) => d.classList.toggle('active', i === current));
        }

        function startAuto() {
            autoTimer = setInterval(() => goToSlide(current + 1), 5000);
        }

        function stopAuto() {
            clearInterval(autoTimer);
        }

        btnNext.addEventListener('click', () => {
            stopAuto();
            goToSlide(current + 1);
            startAuto();
        });
        btnPrev.addEventListener('click', () => {
            stopAuto();
            goToSlide(current - 1);
            startAuto();
        });
        dots.forEach(d => d.addEventListener('click', () => {
            stopAuto();
            goToSlide(+d.dataset.index);
            startAuto();
        }));

        let tx = 0;
        track.addEventListener('touchstart', e => {
            tx = e.touches[0].clientX;
            stopAuto();
        });
        track.addEventListener('touchend', e => {
            const d = tx - e.changedTouches[0].clientX;
            if (Math.abs(d) > 50) goToSlide(d > 0 ? current + 1 : current - 1);
            startAuto();
        });

        startAuto();

        // ===== TESTIMONIALS =====
        const tc = document.getElementById('testi-container');
        document.getElementById('testi-prev').addEventListener('click', () => tc.scrollBy({
            left: -420,
            behavior: 'smooth'
        }));
        document.getElementById('testi-next').addEventListener('click', () => tc.scrollBy({
            left: 420,
            behavior: 'smooth'
        }));

        // ===== SEARCH =====
        const searchInput = document.getElementById('search-input');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                // Logika dimatikan karena input di-disabled dari HTML
            });
        }

        // ===== SMOOTH SCROLL =====
        document.querySelectorAll('a[href^="#"]').forEach(a => {
            a.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href.length > 1) {
                    e.preventDefault();
                    document.querySelector(href)?.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
@endsection