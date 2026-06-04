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
    <section
        class="relative flex flex-col items-center justify-center text-center min-h-[716px] gap-lg rounded-3xl overflow-hidden mt-md"
        id="home">
        <div class="absolute inset-0 z-[-1] opacity-30 bg-[url('{{ asset('images/bola.jpeg') }}')] bg-cover bg-center"></div>
        <div class="absolute inset-0 z-[-1] bg-gradient-to-b from-transparent via-void-base/20 to-void-base/60"></div>
        <div class="flex flex-col items-center gap-sm">
            <div class="glass-card px-md py-xs rounded-full border border-primary/30 flex items-center gap-xs mb-sm">
                <div class="w-2 h-2 bg-primary rounded-full animate-pulse"></div>
                <span class="font-label-bold text-[11px] text-primary uppercase tracking-widest">Booking Langsung Tersedia</span>
            </div>
            <h1 class="font-display-xl text-display-xl text-primary drop-shadow-[0_0_30px_rgba(5,150,105,0.6)]">Booking
                Ruangan<br />Gampang & Aman</h1>
            <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl">Cari dan booking fasilitas sekolah dengan mudah. Nggak perlu repot, langsung dapat tempat.</p>
        </div>
        <div
            class="glass-card p-md rounded-xl flex flex-col sm:flex-row gap-gutter items-center w-full max-w-3xl mt-margin">
            <div
                class="w-full max-w-4xl bg-surface-container-low/60 backdrop-blur-xl p-sm rounded-full border border-outline-variant/30 shadow-lg flex flex-col sm:flex-row gap-sm items-center">
                <div class="flex items-center gap-sm flex-1 w-full px-md">
                    <iconify-icon icon="lucide:search" class="text-xl text-on-surface-variant"></iconify-icon>
                    <input id="search-input"
                        class="bg-transparent border-none focus:ring-0 text-body-lg text-on-surface placeholder-on-surface-variant/50 w-full font-body"
                        placeholder="Cari fasilitas..." type="text" />
                </div>
                <a href="{{ route('user.booking.create') }}"
                    class="bg-emerald-pulse text-void-base font-label-bold text-label-bold px-xl py-md rounded-full neon-glow hover:scale-105 transition-transform duration-300 flex items-center gap-xs flex-shrink-0">
                    Mulai Booking <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </a>
            </div>
        </div>
        <div class="flex gap-lg mt-sm">
            <div class="flex flex-col items-center gap-xs"><span
                    class="material-symbols-outlined text-primary text-[20px]">stadium</span><span
                    class="font-headline-md text-on-surface">12+</span><span
                    class="font-label-bold text-[11px] text-on-surface-variant">Fasilitas</span></div>
            <div class="flex flex-col items-center gap-xs"><span
                    class="material-symbols-outlined text-primary text-[20px]">groups</span><span
                    class="font-headline-md text-on-surface">2.4K+</span><span
                    class="font-label-bold text-[11px] text-on-surface-variant">Pengguna Aktif</span></div>
            <div class="flex flex-col items-center gap-xs"><span
                    class="material-symbols-outlined text-primary text-[20px]">event_available</span><span
                    class="font-headline-md text-on-surface">98%</span><span
                    class="font-label-bold text-[11px] text-on-surface-variant">Kepuasan</span></div>
        </div>
    </section>

    <!-- FACILITIES CAROUSEL -->
    <section class="flex flex-col gap-lg" id="facilities">
        <div class="flex justify-between items-end">
            <h2 class="font-headline-lg text-headline-lg text-on-surface border-l-4 border-primary pl-md">Galeri
                Fasilitas</h2>
            <div class="flex items-center gap-md">
                <div class="flex gap-sm">
                    <button id="carousel-prev"
                        class="w-10 h-10 rounded-full border border-primary/30 flex items-center justify-center text-primary hover:bg-primary/20 transition-all active:scale-95">
                        <iconify-icon icon="lucide:chevron-left" class="text-xl"></iconify-icon>
                    </button>
                    <button id="carousel-next"
                        class="w-10 h-10 rounded-full border border-primary/30 flex items-center justify-center text-primary hover:bg-primary/20 transition-all active:scale-95">
                        <iconify-icon icon="lucide:chevron-right" class="text-xl"></iconify-icon>
                    </button>
                </div>
                <a class="text-primary font-label-bold flex items-center gap-xs hover:opacity-80 transition-opacity ml-base"
                    href="#">
                    Lihat Semua <iconify-icon icon="lucide:arrow-right" class="text-[18px]"></iconify-icon>
                </a>
            </div>
        </div>

        @php

        $imageMap = [
        'Lapangan Futsal Indoor' => 'futsal2.jpg',
        'Lapangan Basket' => 'basket.jpg',
        'Lapangan Voli' => 'voli.jpg',
        'Lab Komputer' => 'lab.jpg',
        'Lab Bahasa' => 'lab bahasa.jpg',
        'Ruang Multimedia' => 'multimedia.jpg',
        'Aula Sekolah' => 'aula.jpg',
        ];


        // Bagi fasilitas jadi chunks 3 per slide
        $chunks = $fasilitas->chunk(3);

        $jenisIcon = [
        'lapangan' => 'lucide:circle-dot',
        'ruang_multimedia' => 'lucide:monitor',
        'lab' => 'lucide:flask-conical',
        ];

        // true = libur (merah), false = buka (hijau)
        $statusBadge = [
        false => [
        'color' => 'text-primary',
        'dot' => 'bg-primary animate-pulse',
        'border' => 'border-primary/30',
        'label' => 'TERSEDIA',
        ],
        true => [
        'color' => 'text-red-400',
        'dot' => 'bg-red-400',
        'border' => 'border-red-400/30',
        'label' => 'LIBUR',
        ],
        ];
        @endphp

        <div class="relative overflow-hidden rounded-xl">
            <div class="carousel-track" id="facility-track">

                @forelse($chunks as $chunk)
                <div class="carousel-slide">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">

                        @foreach ($chunk as $f)
                        @php
                        $isLibur = $f->jadwal?->is_libur ?? false;
                        $badge = $statusBadge[$isLibur];
                        $icon = $jenisIcon[$f->jenis] ?? 'lucide:building-2';
                        $harga = 'Rp ' . number_format($f->harga_per_jam / 1000, 0) . 'rb/jam';
                        @endphp

                        <div class="carousel-card group flex flex-col h-full">

                            {{-- Gambar / Placeholder --}}
                            <div class="card-img-wrap h-56 relative">
                                @php
                                // Mapping nama fasilitas ke file gambar di public/images
                                $imageMap = [
                                'Lapangan Futsal Indoor' => 'futsal2.jpg',
                                'Lapangan Basket' => 'basket.jpg',
                                'Lapangan Voli' => 'voli.jpg',
                                'Lab Komputer' => 'lab.jpg',
                                'Lab Bahasa' => 'lab bahasa.jpg',
                                'Ruang Multimedia' => 'multimedia.jpg',
                                'Aula Sekolah' => 'aula.jpg',
                                ];
                                $fallback = $imageMap[$f->nama] ?? 'default.jpg';
                                @endphp

                                @if ($f->foto)
                                <img class="w-full h-full object-cover" src="{{ Storage::url($f->foto) }}" alt="{{ $f->nama }}" loading="lazy" />
                                @else
                                <img class="w-full h-full object-cover" src="{{ asset('images/' . $fallback) }}" alt="{{ $f->nama }}" loading="lazy" />
                                @endif

                                {{-- Status Badge --}}
                                <div class="absolute top-sm left-sm bg-surface-container/80 backdrop-blur-md px-sm py-xs rounded-full flex items-center gap-xs border {{ $badge['border'] }}">
                                    <div class="w-2 h-2 rounded-full {{ $badge['dot'] }}"></div>
                                    <span class="font-label-bold text-[10px] {{ $badge['color'] }}">{{ $badge['label'] }}</span>
                                </div>
                            </div>

                            {{-- Card Body --}}
                            <div class="card-body">
                                <h3
                                    class="facility-name font-headline-md text-headline-md text-on-surface group-hover:text-primary transition-colors">
                                    {{ $f->nama }}
                                </h3>
                                <p
                                    class="facility-desc font-body-md text-body-md text-on-surface-variant line-clamp-2 flex-1">
                                    {{ $f->deskripsi ?? 'Fasilitas ' . ucfirst(str_replace('_', ' ', $f->jenis)) . ' tersedia untuk booking.' }}
                                </p>

                                {{-- Jadwal --}}
                                @if ($f->jadwal)
                                <div class="flex items-center gap-xs text-[12px] text-on-surface-variant">
                                    <iconify-icon icon="lucide:clock"
                                        class="text-sm text-primary"></iconify-icon>
                                    {{ \Carbon\Carbon::parse($f->jadwal->jam_buka)->format('H:i') }}
                                    –
                                    {{ \Carbon\Carbon::parse($f->jadwal->jam_tutup)->format('H:i') }}
                                </div>
                                @endif

                                {{-- Rating placeholder --}}
                                <div class="flex items-center gap-xs">
                                    <span class="text-primary flex gap-0.5">
                                        @for ($i = 0; $i < 5; $i++)
                                            <iconify-icon icon="lucide:star"
                                            class="text-sm fill-current"></iconify-icon>
                                            @endfor
                                    </span>
                                    <span class="text-[12px] text-on-surface-variant ml-xs">(5.0)</span>
                                </div>

                                <div
                                    class="mt-sm flex justify-between items-center pt-sm border-t border-outline-variant/30">
                                    <span
                                        class="font-label-bold text-label-bold text-secondary">{{ $harga }}</span>
                                    <button
                                        onclick="showDetailModal({{ $f->id }}, '{{ addslashes($f->nama) }}', '{{ addslashes($f->deskripsi ?? 'Fasilitas ' . ucfirst(str_replace('_', ' ', $f->jenis)) . ' tersedia untuk booking.') }}', '{{ $f->foto ? Storage::url($f->foto) : '' }}', '{{ $f->jenis }}', '{{ $f->harga_per_jam }}', '{{ $f->jadwal ? \Carbon\Carbon::parse($f->jadwal->jam_buka)->format('H:i') : '-' }}', '{{ $f->jadwal ? \Carbon\Carbon::parse($f->jadwal->jam_tutup)->format('H:i') : '-' }}', '{{ $f->kapasitas ?? '-' }}', {{ $isLibur ? 'true' : 'false' }})"
                                        class="bg-transparent border border-primary text-primary font-label-bold text-[12px] px-sm py-xs rounded-full hover:bg-primary hover:text-void-base transition-colors duration-300 flex items-center gap-xs">
                                        <iconify-icon icon="lucide:eye"
                                            class="text-[14px]"></iconify-icon>Detail
                                    </button>
                                </div>
                            </div>

                        </div>
                        @endforeach

                        {{-- Padding kalau chunk < 3 item --}}
                        @for ($i = $chunk->count(); $i < 3; $i++)
                            <div class="carousel-card invisible">
                    </div>
                    @endfor

                </div>
            </div>
            @empty
            <div class="carousel-slide">
                <div class="text-center py-16 text-on-surface-variant">
                    <iconify-icon icon="lucide:building-2"
                        class="text-6xl opacity-20 block mb-4"></iconify-icon>
                    Belum ada fasilitas tersedia
                </div>
            </div>
            @endforelse

        </div>
        </div>

        {{-- Dots dinamis --}}
        <div class="flex justify-center gap-sm mt-md" id="carousel-dots">
            @foreach ($chunks as $i => $chunk)
            <div class="dot {{ $i === 0 ? 'active' : '' }}" data-index="{{ $i }}"></div>
            @endforeach
        </div>

    </section>

    <!-- MODAL DETAIL FASILITAS -->
    <div id="detailModal" class="fixed inset-0 z-[9999] hidden items-center justify-center p-4"
        style="background: rgba(0,0,0,0.8); backdrop-filter: blur(8px);">
        <div class="bg-surface rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto border border-primary/30 animate-fadeInUp"
            style="scrollbar-width: none; -ms-overflow-style: none;">

            <!-- Header -->
            <div class="sticky top-0 bg-surface border-b border-outline-variant/30 p-4 flex justify-between items-center">
                <h3 class="text-xl font-bold text-on-surface" id="modalTitle">Detail Fasilitas</h3>
                <button onclick="closeDetailModal()" class="text-on-surface-variant hover:text-primary transition">
                    <iconify-icon icon="lucide:x" class="text-2xl"></iconify-icon>
                </button>
            </div>

            <!-- Content -->
            <div class="p-6" id="modalContent">
                <!-- Konten akan diisi via JS -->
            </div>

            <!-- Footer -->
            <div class="sticky bottom-0 bg-surface border-t border-outline-variant/30 p-4 flex gap-3">
                <button onclick="closeDetailModal()"
                    class="flex-1 py-2 rounded-full border border-outline-variant/30 text-on-surface-variant hover:bg-surface-container transition">
                    Tutup
                </button>
                <a href="{{ route('user.booking.create', ['fasilitas_id' => $f->id]) }}" id="modalBookingLink"
                    class="flex-1 py-2 rounded-full bg-primary text-on-primary font-bold text-center hover:scale-105 transition">
                    Lanjutkan Booking
                </a>
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.3s ease-out;
        }

        #detailModal {
            transition: all 0.3s ease;
        }

        #detailModal .overflow-y-auto {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        #detailModal .overflow-y-auto::-webkit-scrollbar {
            display: none;
        }
    </style>

    <script>
        let currentFacility = null;


        function showDetailModal(id, nama, deskripsi, foto, jenis, harga, jamBuka, jamTutup, kapasitas, isLibur) {
            // Debug: cek nilai isLibur
            console.log('showDetailModal called with isLibur:', isLibur, 'type:', typeof isLibur);

            // Pastikan isLibur adalah boolean
            const isLiburBoolean = (isLibur === true || isLibur === 'true' || isLibur === 1);

            currentFacility = {
                id,
                nama,
                deskripsi,
                foto,
                jenis,
                harga,
                jamBuka,
                jamTutup,
                kapasitas,
                isLibur: isLiburBoolean
            };

            const formattedHarga = 'Rp ' + parseInt(harga).toLocaleString('id-ID') + '/jam';

            let jenisIcon = 'lucide:building-2';
            let jenisLabel = 'Fasilitas';
            switch (jenis) {
                case 'lapangan':
                    jenisIcon = 'lucide:circle-dot';
                    jenisLabel = 'Lapangan';
                    break;
                case 'ruang_multimedia':
                    jenisIcon = 'lucide:monitor';
                    jenisLabel = 'Ruang Multimedia';
                    break;
                case 'lab':
                    jenisIcon = 'lucide:flask-conical';
                    jenisLabel = 'Lab';
                    break;
            }

            const statusColor = isLiburBoolean ? 'text-red-400' : 'text-primary';
            const statusDot = isLiburBoolean ? 'bg-red-400' : 'bg-primary animate-pulse';
            const statusLabel = isLiburBoolean ? 'LIBUR' : 'TERSEDIA';

            const modalContent = `
            <div class="flex flex-col gap-5">
                <div class="rounded-xl overflow-hidden bg-surface-container h-56">
                    ${foto ? 
                        `<img src="${foto}" alt="${nama}" class="w-full h-full object-cover">` :
                        `<div class="w-full h-full flex items-center justify-center">
                            <iconify-icon icon="${jenisIcon}" class="text-6xl text-outline-variant"></iconify-icon>
                        </div>`
                    }
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full ${statusDot}"></div>
                        <span class="font-bold text-sm ${statusColor}">${statusLabel}</span>
                    </div>
                    <span class="text-on-surface-variant text-sm">${jenisLabel}</span>
                </div>
                
                <h2 class="text-2xl font-bold text-on-surface">${nama}</h2>
                <p class="text-on-surface-variant text-sm leading-relaxed">${deskripsi}</p>
                
                <div class="grid grid-cols-2 gap-4 pt-2">
                    <div class="bg-surface-container-low rounded-xl p-5">
                        <div class="text-on-surface-variant text-xs mb-2">Harga per Jam</div>
                        <div class="text-primary font-bold text-lg">${formattedHarga}</div>
                    </div>
                    <div class="bg-surface-container-low rounded-xl p-5">
                        <div class="text-on-surface-variant text-xs mb-2">Kapasitas</div>
                        <div class="text-on-surface font-bold text-lg">${kapasitas === '-' ? 'Tidak terbatas' : kapasitas + ' orang'}</div>
                    </div>
                    <div class="bg-surface-container-low rounded-xl p-5">
                        <div class="text-on-surface-variant text-xs mb-2">Jam Operasional</div>
                        <div class="text-on-surface font-bold">${jamBuka} - ${jamTutup}</div>
                    </div>
                    <div class="bg-surface-container-low rounded-xl p-5">
                        <div class="text-on-surface-variant text-xs mb-2">Kode Booking</div>
                        <div class="text-on-surface font-mono text-sm">#${Math.random().toString(36).substring(2, 8).toUpperCase()}</div>
                    </div>
                </div>
            </div>
        `;

            document.getElementById('modalContent').innerHTML = modalContent;
            document.getElementById('modalTitle').innerHTML = nama;

            // Set link booking berdasarkan status
            const bookingLink = document.getElementById('modalBookingLink');
            if (!isLiburBoolean) {
                // Fasilitas TERSEDIA - bisa booking
                bookingLink.href = "{{ route('user.booking.create') }}?fasilitas_id=" + id;
                bookingLink.classList.remove('opacity-50', 'pointer-events-none');
                bookingLink.style.opacity = '1';
                bookingLink.style.pointerEvents = 'auto';
                bookingLink.onclick = null;
                console.log('Booking link enabled untuk:', nama);
            } else {
                // Fasilitas LIBUR - tidak bisa booking
                bookingLink.href = "#";
                bookingLink.classList.add('opacity-50', 'pointer-events-none');
                bookingLink.style.opacity = '0.5';
                bookingLink.style.pointerEvents = 'none';
                bookingLink.onclick = (e) => {
                    e.preventDefault();
                    showToast('Fasilitas sedang libur, tidak bisa booking.', 'error');
                };
                console.log('Booking link disabled untuk:', nama, '(LIBUR)');
            }

            document.getElementById('detailModal').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeDetailModal() {
            document.getElementById('detailModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        document.getElementById('detailModal')?.addEventListener('click', function(e) {
            if (e.target === this) closeDetailModal();
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeDetailModal();
        });

        function showToast(msg, type = 'success') {
            const toast = document.getElementById('toast');
            if (!toast) return;
            document.getElementById('toast-msg').textContent = msg;
            document.getElementById('toast-icon').textContent = type === 'success' ? 'check_circle' : 'error';
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 3000);
        }
    </script>
    <!-- FAQ -->
    <section class="flex flex-col gap-lg" id="faq">
        <div class="text-center">
            <h2 class="font-headline-lg text-headline-lg text-on-surface mb-sm">Pertanyaan Umum</h2>
            <p class="font-body-md text-on-surface-variant">Semua yang perlu kamu tahu soal booking di SpaceGo.</p>
        </div>
        <div class="max-w-3xl mx-auto w-full flex flex-col gap-sm">
            <details class="glass-card rounded-xl group" name="faq">
                <summary
                    class="flex justify-between items-center p-md cursor-pointer font-headline-md text-[20px] text-on-surface list-none hover:text-primary transition-colors">
                    <span>Gimana cara booking fasilitas?</span><span
                        class="material-symbols-outlined text-primary transition-transform duration-300 group-open:rotate-180 flex-shrink-0 ml-md">expand_more</span>
                </summary>
                <div
                    class="px-md pb-md font-body-md text-on-surface-variant border-t border-outline-variant/20 pt-sm mt-xs">
                    Pilih fasilitas yang kamu mau, klik tombol "Detail", isi data (tanggal, jam), pilih durasi, lalu konfirmasi. Bukti booking langsung dikirim ke email kamu kok.</div>
            </details>
            <details class="glass-card rounded-xl group" name="faq">
                <summary
                    class="flex justify-between items-center p-md cursor-pointer font-headline-md text-[20px] text-on-surface list-none hover:text-primary transition-colors">
                    <span>Ada diskon nggak buat siswa?</span><span
                        class="material-symbols-outlined text-primary transition-transform duration-300 group-open:rotate-180 flex-shrink-0 ml-md">expand_more</span>
                </summary>
                <div
                    class="px-md pb-md font-body-md text-on-surface-variant border-t border-outline-variant/20 pt-sm mt-xs">
                    Ada! Khusus siswa yang udah verifikasi dapet potongan 20% untuk jam 08.00–15.00, Senin–Jumat. Upload kartu pelajar di profil kamu ya.</div>
            </details>
            <details class="glass-card rounded-xl group" name="faq">
                <summary
                    class="flex justify-between items-center p-md cursor-pointer font-headline-md text-[20px] text-on-surface list-none hover:text-primary transition-colors">
                    <span>Bayarnya pake apa aja?</span><span
                        class="material-symbols-outlined text-primary transition-transform duration-300 group-open:rotate-180 flex-shrink-0 ml-md">expand_more</span>
                </summary>
                <div
                    class="px-md pb-md font-body-md text-on-surface-variant border-t border-outline-variant/20 pt-sm mt-xs">
                    Bisa transfer bank, kartu kredit/debit, atau dompet digital kayak GoPay, OVO, Dana. Semua aman.</div>
            </details>
            <details class="glass-card rounded-xl group" name="faq">
                <summary
                    class="flex justify-between items-center p-md cursor-pointer font-headline-md text-[20px] text-on-surface list-none hover:text-primary transition-colors">
                    <span>Bisa batalkan atau ganti jadwal nggak?</span><span
                        class="material-symbols-outlined text-primary transition-transform duration-300 group-open:rotate-180 flex-shrink-0 ml-md">expand_more</span>
                </summary>
                <div
                    class="px-md pb-md font-body-md text-on-surface-variant border-t border-outline-variant/20 pt-sm mt-xs">
                    Bisa, maksimal 24 jam sebelum jadwal. Nanti refund dalam bentuk kredit SpaceGo buat booking berikutnya.</div>
            </details>
            <details class="glass-card rounded-xl group" name="faq">
                <summary
                    class="flex justify-between items-center p-md cursor-pointer font-headline-md text-[20px] text-on-surface list-none hover:text-primary transition-colors">
                    <span>Berapa lama konfirmasi booking?</span><span
                        class="material-symbols-outlined text-primary transition-transform duration-300 group-open:rotate-180 flex-shrink-0 ml-md">expand_more</span>
                </summary>
                <div
                    class="px-md pb-md font-body-md text-on-surface-variant border-t border-outline-variant/20 pt-sm mt-xs">
                    Kurang dari 1 menit setelah pembayaran berhasil, langsung dapet email konfirmasi.</div>
            </details>
        </div>
    </section>

    <!-- TESTIMONIALS -->
    <section class="flex flex-col gap-lg overflow-hidden pb-margin" id="testimonials">
        <div class="flex justify-between items-end">
            <h2 class="font-headline-lg text-headline-lg text-on-surface border-l-4 border-primary pl-md">Kata Mereka
            </h2>
            <div class="flex gap-sm">
                <button id="testi-prev"
                    class="w-10 h-10 rounded-full border border-outline-variant flex items-center justify-center hover:border-primary hover:text-primary transition-colors active:scale-95"><span
                        class="material-symbols-outlined">chevron_left</span></button>
                <button id="testi-next"
                    class="w-10 h-10 rounded-full border border-outline-variant flex items-center justify-center hover:border-primary hover:text-primary transition-colors active:scale-95"><span
                        class="material-symbols-outlined">chevron_right</span></button>
            </div>
        </div>
        <div class="flex overflow-x-auto gap-gutter pb-sm hide-scrollbar snap-x" id="testi-container">
            <div
                class="glass-card p-md rounded-xl min-w-[300px] md:min-w-[400px] snap-start flex flex-col gap-md hover:border-primary/40 transition-colors">
                <div class="flex gap-xs text-primary"><span class="material-symbols-outlined text-[18px]"
                        style="font-variation-settings:'FILL' 1">star</span><span
                        class="material-symbols-outlined text-[18px]"
                        style="font-variation-settings:'FILL' 1">star</span><span
                        class="material-symbols-outlined text-[18px]"
                        style="font-variation-settings:'FILL' 1">star</span><span
                        class="material-symbols-outlined text-[18px]"
                        style="font-variation-settings:'FILL' 1">star</span><span
                        class="material-symbols-outlined text-[18px]"
                        style="font-variation-settings:'FILL' 1">star</span></div>
                <p class="font-body-md text-on-surface-variant italic flex-1">"Aplikasi ini ngebantu banget buat ngatur jadwal lapangan olahraga. Nggak perlu ribet booking lewat kertas lagi."</p>
                <div class="flex items-center gap-sm mt-auto">
                    <div
                        class="w-12 h-12 bg-surface-container-high rounded-full overflow-hidden flex items-center justify-center border border-primary/20">
                        <span class="material-symbols-outlined text-on-surface-variant">sports</span>
                    </div>
                    <div>
                        <div class="font-label-bold text-on-surface">Syahrulroni</div>
                        <div class="text-[12px] text-primary">Guru PJOK</div>
                    </div>
                </div>
            </div>
            <div
                class="glass-card p-md rounded-xl min-w-[300px] md:min-w-[400px] snap-start flex flex-col gap-md hover:border-primary/40 transition-colors">
                <div class="flex gap-xs text-primary"><span class="material-symbols-outlined text-[18px]"
                        style="font-variation-settings:'FILL' 1">star</span><span
                        class="material-symbols-outlined text-[18px]"
                        style="font-variation-settings:'FILL' 1">star</span><span
                        class="material-symbols-outlined text-[18px]"
                        style="font-variation-settings:'FILL' 1">star</span><span
                        class="material-symbols-outlined text-[18px]"
                        style="font-variation-settings:'FILL' 1">star</span><span
                        class="material-symbols-outlined text-[18px]"
                        style="font-variation-settings:'FILL' 1">star_half</span></div>
                <p class="font-body-md text-on-surface-variant italic flex-1">"Saya siswa dari luar sekolah, tapi tetep bisa booking fasilitas. Prosesnya gampang banget!"</p>
                <div class="flex items-center gap-sm mt-auto">
                    <div
                        class="w-12 h-12 bg-surface-container-high rounded-full overflow-hidden flex items-center justify-center border border-primary/20">
                        <span class="material-symbols-outlined text-on-surface-variant">school</span>
                    </div>
                    <div>
                        <div class="font-label-bold text-on-surface">Nafis Ahmad Maruf</div>
                        <div class="text-[12px] text-primary">Siswa Eksternal</div>
                    </div>
                </div>
            </div>
            <div
                class="glass-card p-md rounded-xl min-w-[300px] md:min-w-[400px] snap-start flex flex-col gap-md hover:border-primary/40 transition-colors">
                <div class="flex gap-xs text-primary"><span class="material-symbols-outlined text-[18px]"
                        style="font-variation-settings:'FILL' 1">star</span><span
                        class="material-symbols-outlined text-[18px]"
                        style="font-variation-settings:'FILL' 1">star</span><span
                        class="material-symbols-outlined text-[18px]"
                        style="font-variation-settings:'FILL' 1">star</span><span
                        class="material-symbols-outlined text-[18px]"
                        style="font-variation-settings:'FILL' 1">star</span><span
                        class="material-symbols-outlined text-[18px]"
                        style="font-variation-settings:'FILL' 1">star</span></div>
                <p class="font-body-md text-on-surface-variant italic flex-1">"Enak banget booking lapangan futsal buat latihan ekstrakurikuler. Langsung dapet jadwal, nggak perlu rebutan."</p>
                <div class="flex items-center gap-sm mt-auto">
                    <div
                        class="w-12 h-12 bg-surface-container-high rounded-full overflow-hidden flex items-center justify-center border border-primary/20">
                        <span class="material-symbols-outlined text-on-surface-variant">sports_soccer</span>
                    </div>
                    <div>
                        <div class="font-label-bold text-on-surface">Abdul Mughni Nugraha</div>
                        <div class="text-[12px] text-primary">Siswa Internal</div>
                    </div>
                </div>
            </div>
            <div
                class="glass-card p-md rounded-xl min-w-[300px] md:min-w-[400px] snap-start flex flex-col gap-md hover:border-primary/40 transition-colors">
                <div class="flex gap-xs text-primary"><span class="material-symbols-outlined text-[18px]"
                        style="font-variation-settings:'FILL' 1">star</span><span
                        class="material-symbols-outlined text-[18px]"
                        style="font-variation-settings:'FILL' 1">star</span><span
                        class="material-symbols-outlined text-[18px]"
                        style="font-variation-settings:'FILL' 1">star</span><span
                        class="material-symbols-outlined text-[18px]"
                        style="font-variation-settings:'FILL' 1">star</span><span
                        class="material-symbols-outlined text-[18px]"
                        style="font-variation-settings:'FILL' 1">star</span></div>
                <p class="font-body-md text-on-surface-variant italic flex-1">"Booking lab sains jadi jauh lebih teratur. Tidak ada lagi bentrok jadwal. Sistem notifikasinya sangat membantu."</p>
                <div class="flex items-center gap-sm mt-auto">
                    <div
                        class="w-12 h-12 bg-surface-container-high rounded-full overflow-hidden flex items-center justify-center border border-primary/20">
                        <span class="material-symbols-outlined text-on-surface-variant">science</span>
                    </div>
                    <div>
                        <div class="font-label-bold text-on-surface">Bu Dewi</div>
                        <div class="text-[12px] text-primary">Guru Kimia</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA BANNER -->
    <section
        class="glass-card rounded-xl p-xl flex flex-col md:flex-row items-center justify-between gap-lg mb-xl relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-emerald-pulse/10 to-transparent pointer-events-none"></div>
        <div class="flex flex-col gap-sm">
            <h2 class="font-headline-lg text-headline-lg text-on-surface">Yuk, Booking Sekarang!</h2>
            <p class="font-body-md text-on-surface-variant max-w-md">Gabung sama ribuan siswa lain yang udah pakai SpaceGo. Daftar gratis, langsung bisa booking.</p>
        </div>
        <button onclick="document.getElementById('facilities').scrollIntoView({behavior:'smooth'})"
            class="bg-emerald-pulse text-void-base font-label-bold text-label-bold px-xl py-md rounded-full neon-glow hover:scale-105 transition-transform duration-300 flex items-center gap-xs flex-shrink-0">
            Mulai Booking <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
        </button>
    </section>

</main>

<!-- ==================== FOOTER ==================== -->
<footer class="mt-xl border-t border-outline-variant/30 bg-surface-container-low pt-xl pb-md">
    <div class="max-w-[1440px] mx-auto px-margin">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-lg mb-xl">
            <div class="flex flex-col gap-sm">
                <div class="font-display-xl-mobile text-[32px] font-extrabold text-primary tracking-tighter">SpaceGo
                </div>
                <p class="font-body-md text-on-surface-variant">Platform booking fasilitas sekolah yang cepet, gampang, dan terpercaya buat semua siswa.</p>
                <div class="flex gap-sm mt-sm">
                    <div class="glass-card px-sm py-xs rounded-full flex items-center gap-xs border border-primary/20">
                        <div class="w-2 h-2 bg-primary rounded-full animate-pulse"></div><span
                            class="font-label-bold text-[10px] text-primary">LIVE</span>
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-sm">
                <h4 class="font-headline-md text-[18px] text-on-surface mb-xs">Menu</h4>
                <a class="text-on-surface-variant hover:text-primary transition-colors font-body-md"
                    href="#home">Beranda</a>
                <a class="text-on-surface-variant hover:text-primary transition-colors font-body-md"
                    href="#facilities">Fasilitas</a>
                <a class="text-on-surface-variant hover:text-primary transition-colors font-body-md"
                    href="#">Harga</a>
                <a class="text-on-surface-variant hover:text-primary transition-colors font-body-md"
                    href="#faq">FAQ</a>
            </div>
            <div class="flex flex-col gap-sm">
                <h4 class="font-headline-md text-[18px] text-on-surface mb-xs">Bantuan</h4>
                <a class="text-on-surface-variant hover:text-primary transition-colors font-body-md"
                    href="#">Pusat Bantuan</a>
                <a class="text-on-surface-variant hover:text-primary transition-colors font-body-md"
                    href="#">Syarat & Ketentuan</a>
                <a class="text-on-surface-variant hover:text-primary transition-colors font-body-md"
                    href="#">Kebijakan Privasi</a>
                <a class="text-on-surface-variant hover:text-primary transition-colors font-body-md"
                    href="#">Kontak Kami</a>
            </div>
            <div class="flex flex-col gap-sm">
                <h4 class="font-headline-md text-[18px] text-on-surface mb-xs">Kontak</h4>
                <div class="flex gap-sm">
                    <a class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center text-on-surface-variant hover:bg-primary/20 hover:text-primary transition-all"
                        href="#"><span class="material-symbols-outlined">mail</span></a>
                    <a class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center text-on-surface-variant hover:bg-primary/20 hover:text-primary transition-all"
                        href="#"><span class="material-symbols-outlined">share</span></a>
                    <a class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center text-on-surface-variant hover:bg-primary/20 hover:text-primary transition-all"
                        href="#"><span class="material-symbols-outlined">chat</span></a>
                </div>
                <p class="font-body-md text-on-surface-variant mt-sm">hello@spacego.com<br />+62 812 3456 7890</p>
            </div>
        </div>
        <div
            class="border-t border-outline-variant/30 pt-md flex flex-col md:flex-row justify-between items-center gap-sm">
            <p class="text-on-surface-variant text-[14px]">© 2025 SpaceGo. Hak Cipta Dilindungi.</p>
            <div class="flex gap-md text-[14px] text-on-surface-variant"><span>Dibuat buat anak sekolah by anak sekolah 🚀</span></div>
        </div>
    </div>
</footer>

<!-- ==================== MOBILE NAV ==================== -->
<nav
    class="md:hidden fixed bottom-0 w-full rounded-t-lg z-50 bg-surface-container/80 backdrop-blur-lg border-t border-outline-variant/30 shadow-[0_-4px_24px_rgba(0,0,0,0.5)] flex justify-around items-center h-20 px-gutter">
    <a class="flex flex-col items-center justify-center nav-active duration-300 ease-out" href="#home"><span
            class="material-symbols-outlined font-headline-md text-headline-md">sports_soccer</span><span
            class="font-label-bold text-[10px] mt-xs">Beranda</span></a>
    <a class="flex flex-col items-center justify-center text-on-surface-variant opacity-60 hover:opacity-100 transition-opacity"
        href="#facilities"><span
            class="material-symbols-outlined font-headline-md text-headline-md">stadium</span><span
            class="font-label-bold text-[10px] mt-xs">Fasilitas</span></a>
    <a class="flex flex-col items-center justify-center text-on-surface-variant opacity-60 hover:opacity-100 transition-opacity"
        href="{{ route('user.booking.index') }}"><span
            class="material-symbols-outlined font-headline-md text-headline-md">event_available</span><span
            class="font-label-bold text-[10px] mt-xs">Booking Saya</span></a>
    <a class="flex flex-col items-center justify-center text-on-surface-variant opacity-60 hover:opacity-100 transition-opacity"
        href="{{ route('profile') }}"><span
            class="material-symbols-outlined font-headline-md text-headline-md">account_circle</span><span
            class="font-label-bold text-[10px] mt-xs">Profil</span></a>
</nav>

<!-- ==================== BOOKING MODAL ==================== -->
<div id="booking-modal"
    class="fixed inset-0 z-[999] bg-void-base/80 backdrop-blur-md flex items-center justify-center p-margin hidden">
    <div id="modal-content" class="glass-card rounded-xl w-full max-w-lg p-lg relative max-h-[90vh] overflow-y-auto">
        <button onclick="closeBookingModal()"
            class="absolute top-md right-md text-on-surface-variant hover:text-primary transition-colors"><span
                class="material-symbols-outlined">close</span></button>
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
                <label class="font-label-bold text-label-bold text-on-surface-variant uppercase tracking-wider">Nama
                    Lengkap</label>
                <div
                    class="bg-surface-container-high rounded-full px-margin py-sm border border-outline-variant focus-within:border-primary transition-colors flex items-center gap-sm">
                    <span class="material-symbols-outlined text-on-surface-variant text-[18px]">person</span><input
                        required type="text" placeholder="Masukkan nama lengkap"
                        class="bg-transparent border-none outline-none text-on-surface w-full font-body-md placeholder:text-on-surface-variant" />
                </div>
            </div>
            <div class="flex flex-col gap-xs">
                <label class="font-label-bold text-label-bold text-on-surface-variant uppercase tracking-wider">Nomor
                    HP / WhatsApp</label>
                <div
                    class="bg-surface-container-high rounded-full px-margin py-sm border border-outline-variant focus-within:border-primary transition-colors flex items-center gap-sm">
                    <span class="material-symbols-outlined text-on-surface-variant text-[18px]">smartphone</span><input
                        required type="tel" placeholder="08xx-xxxx-xxxx"
                        class="bg-transparent border-none outline-none text-on-surface w-full font-body-md placeholder:text-on-surface-variant" />
                </div>
            </div>
            <div class="grid grid-cols-2 gap-md">
                <div class="flex flex-col gap-xs">
                    <label
                        class="font-label-bold text-label-bold text-on-surface-variant uppercase tracking-wider">Tanggal</label>
                    <div
                        class="bg-surface-container-high rounded-xl px-md py-sm border border-outline-variant focus-within:border-primary transition-colors flex items-center gap-sm">
                        <span
                            class="material-symbols-outlined text-on-surface-variant text-[18px]">calendar_today</span><input
                            required type="date"
                            class="bg-transparent border-none outline-none text-on-surface w-full font-body-md [color-scheme:dark]" />
                    </div>
                </div>
                <div class="flex flex-col gap-xs">
                    <label class="font-label-bold text-label-bold text-on-surface-variant uppercase tracking-wider">Jam
                        Mulai</label>
                    <div
                        class="bg-surface-container-high rounded-xl px-md py-sm border border-outline-variant focus-within:border-primary transition-colors flex items-center gap-sm">
                        <span class="material-symbols-outlined text-on-surface-variant text-[18px]">schedule</span>
                        <select required
                            class="bg-transparent border-none outline-none text-on-surface w-full font-body-md [color-scheme:dark] cursor-pointer">
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
                <label
                    class="font-label-bold text-label-bold text-on-surface-variant uppercase tracking-wider">Durasi</label>
                <div class="flex gap-sm">
                    <label class="flex-1 cursor-pointer"><input type="radio" name="duration" value="1"
                            class="sr-only peer" checked>
                        <div
                            class="text-center py-sm rounded-xl border border-outline-variant peer-checked:border-primary peer-checked:bg-primary/10 peer-checked:text-primary text-on-surface-variant font-label-bold text-label-bold transition-all">
                            1 Jam</div>
                    </label>
                    <label class="flex-1 cursor-pointer"><input type="radio" name="duration" value="2"
                            class="sr-only peer">
                        <div
                            class="text-center py-sm rounded-xl border border-outline-variant peer-checked:border-primary peer-checked:bg-primary/10 peer-checked:text-primary text-on-surface-variant font-label-bold text-label-bold transition-all">
                            2 Jam</div>
                    </label>
                    <label class="flex-1 cursor-pointer"><input type="radio" name="duration" value="3"
                            class="sr-only peer">
                        <div
                            class="text-center py-sm rounded-xl border border-outline-variant peer-checked:border-primary peer-checked:bg-primary/10 peer-checked:text-primary text-on-surface-variant font-label-bold text-label-bold transition-all">
                            3 Jam</div>
                    </label>
                    <label class="flex-1 cursor-pointer"><input type="radio" name="duration" value="4"
                            class="sr-only peer">
                        <div
                            class="text-center py-sm rounded-xl border border-outline-variant peer-checked:border-primary peer-checked:bg-primary/10 peer-checked:text-primary text-on-surface-variant font-label-bold text-label-bold transition-all">
                            4 Jam</div>
                    </label>
                </div>
            </div>
            <div class="flex flex-col gap-xs">
                <label class="font-label-bold text-label-bold text-on-surface-variant uppercase tracking-wider">Catatan
                    (Opsional)</label>
                <div
                    class="bg-surface-container-high rounded-xl px-margin py-sm border border-outline-variant focus-within:border-primary transition-colors">
                    <textarea rows="2" placeholder="Keperluan, jumlah orang, dll."
                        class="bg-transparent border-none outline-none text-on-surface w-full font-body-md placeholder:text-on-surface-variant resize-none"></textarea>
                </div>
            </div>
            <div
                class="bg-surface-container rounded-xl p-sm border border-outline-variant/30 flex justify-between items-center">
                <span class="text-on-surface-variant font-body-md">Estimasi Biaya</span>
                <span class="text-primary font-headline-md" id="modal-total">Rp 150.000</span>
            </div>
            <button id="submit-booking-btn" type="submit"
                class="bg-emerald-pulse text-void-base font-label-bold text-label-bold px-xl py-md rounded-full neon-glow hover:scale-105 transition-transform duration-300 flex items-center justify-center gap-xs">
                Konfirmasi Booking <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
            </button>
        </form>
    </div>
</div>

<!-- TOAST -->
<div id="toast"
    class="fixed bottom-24 md:bottom-8 left-1/2 -translate-x-1/2 z-[9999] glass-card px-gutter py-sm rounded-full flex items-center gap-sm border border-primary/40 hidden opacity-0 transition-all duration-300">
    <span class="material-symbols-outlined text-primary text-[20px]" id="toast-icon">check_circle</span>
    <span class="font-label-bold text-on-surface" id="toast-msg">Berhasil!</span>
</div>

<script>
    // ===== NAVBAR SCROLL EFFECT =====
    window.addEventListener('scroll', function() {
        const navbar = document.getElementById('main-navbar');

        if (window.scrollY > 20) {
            // Aktif saat di-scroll ke bawah (Tanpa border-b)
            navbar.classList.add('bg-glass-overlay', 'backdrop-blur-xl',
                'shadow-[0_0_20px_rgba(5,150,105,0.15)]');
        } else {
            // Kembali transparan saat di atas
            navbar.classList.remove('bg-glass-overlay', 'backdrop-blur-xl',
                'shadow-[0_0_20px_rgba(5,150,105,0.15)]');
        }
    });
    // ===== TOAST =====
    function showToast(msg, icon = 'check_circle') {
        const t = document.getElementById('toast');
        document.getElementById('toast-msg').textContent = msg;
        document.getElementById('toast-icon').textContent = icon;
        t.classList.remove('hidden');
        t.classList.add('show');
        setTimeout(() => t.classList.remove('show'), 3000);
    }

    // ===== MODAL =====
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

    // ===== BOOKING SUBMIT =====
    document.getElementById('booking-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = document.getElementById('submit-booking-btn');
        btn.disabled = true;
        btn.innerHTML =
            '<span class="material-symbols-outlined text-[18px]">progress_activity</span> Memproses...';
        setTimeout(() => {
            closeBookingModal();
            showToast('Booking berhasil! Cek email kamu.', 'check_circle');
            btn.disabled = false;
            btn.innerHTML =
                'Konfirmasi Booking <span class="material-symbols-outlined text-[18px]">arrow_forward</span>';
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

    // ===== FITUR PENCARIAN FASILITAS (tanpa mengubah script lain) =====
    const searchInput = document.getElementById('search-input');
    if (searchInput) {
        let lastKeyword = '';

        function filterFacilities() {
            const keyword = searchInput.value.toLowerCase().trim();
            if (keyword === lastKeyword) return;
            lastKeyword = keyword;

            // Filter card berdasarkan nama
            document.querySelectorAll('.carousel-card').forEach(card => {
                const title = card.querySelector('.facility-name')?.innerText.toLowerCase() || '';
                card.style.display = (keyword === '' || title.includes(keyword)) ? '' : 'none';
            });

            // Sembunyikan slide yang tidak memiliki card visible
            const slides = document.querySelectorAll('.carousel-slide');
            let firstVisibleIndex = -1;
            slides.forEach((slide, idx) => {
                const hasVisible = slide.querySelectorAll('.carousel-card:not([style*="display: none"])').length > 0;
                slide.style.display = (hasVisible || keyword === '') ? '' : 'none';
                if (firstVisibleIndex === -1 && slide.style.display !== 'none') firstVisibleIndex = idx;
            });

            // Pindah ke slide pertama yang visible (jika ada)
            if (keyword !== '' && firstVisibleIndex !== -1 && typeof goToSlide === 'function') {
                goToSlide(firstVisibleIndex);
            } else if (keyword === '' && typeof goToSlide === 'function') {
                goToSlide(0);
            }

            // Restart auto slide (agar tetap berjalan)
            if (typeof stopAuto === 'function' && typeof startAuto === 'function') {
                stopAuto();
                startAuto();
            }
        }

        searchInput.addEventListener('keyup', filterFacilities);
        searchInput.addEventListener('search', filterFacilities);
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