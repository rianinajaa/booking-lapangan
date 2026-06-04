@extends('layouts.app')

@section('title', 'SpaceGo - Detail Booking')
@section('content')

    <!-- Ambient BG -->
    <div class="fixed inset-0 z-[-1] overflow-hidden pointer-events-none">
        <div class="absolute top-[-10%] right-[-10%] w-[50vw] h-[50vw] bg-emerald-pulse/20 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-[40vw] h-[40vw] bg-primary/10 rounded-full blur-[100px]"></div>
    </div>

    @include('layouts.components.navbar')

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
    </script>

    <main class="pt-24 px-margin md:px-xl max-w-[1000px] mx-auto">

        <!-- Back Button & Header -->
        <div class="mb-lg">
            <div class="flex items-center gap-2 mb-2">
                <a href="{{ route('user.booking.index') }}"
                    class="text-on-surface-variant hover:text-primary transition-colors flex items-center gap-1 text-sm">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                    Kembali
                </a>
            </div>
            <h1 class="font-headline-lg text-headline-lg text-on-surface">Detail Booking</h1>
            <p class="font-body-md text-body-md text-on-surface-variant">Informasi lengkap booking Anda.</p>
        </div>

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="mb-6 px-4 py-3 rounded-xl border border-green-500/30 bg-green-500/10 text-green-400 text-sm flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">check_circle</span>
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-6 px-4 py-3 rounded-xl border border-error/30 bg-error/10 text-error text-sm">
                {{ session('error') }}
            </div>
        @endif

        @php
            $detail = $booking->detailBooking->first();
            $pembayaran = $booking->pembayaran;
            
            // Status booking
            $statusMap = [
                'menunggu' => ['label' => 'Menunggu Konfirmasi', 'color' => 'text-amber-400', 'bg' => 'bg-amber-400/10', 'icon' => 'hourglass_empty'],
                'menunggu_pembayaran' => ['label' => 'Menunggu Pembayaran', 'color' => 'text-amber-400', 'bg' => 'bg-amber-400/10', 'icon' => 'payments'],
                'menunggu_verifikasi_dp' => ['label' => 'Menunggu Verifikasi DP', 'color' => 'text-amber-400', 'bg' => 'bg-amber-400/10', 'icon' => 'pending'],
                'menunggu_verifikasi_lunas' => ['label' => 'Menunggu Verifikasi Lunas', 'color' => 'text-amber-400', 'bg' => 'bg-amber-400/10', 'icon' => 'pending'],
                'dp' => ['label' => 'DP Dibayar', 'color' => 'text-blue-400', 'bg' => 'bg-blue-400/10', 'icon' => 'paid'],
                'dikonfirmasi' => ['label' => 'Booking Dikonfirmasi', 'color' => 'text-green-400', 'bg' => 'bg-green-400/10', 'icon' => 'check_circle'],
                'selesai' => ['label' => 'Selesai', 'color' => 'text-gray-400', 'bg' => 'bg-gray-400/10', 'icon' => 'done_all'],
                'dibatalkan' => ['label' => 'Dibatalkan', 'color' => 'text-red-400', 'bg' => 'bg-red-400/10', 'icon' => 'cancel'],
            ];
            $status = $statusMap[$booking->status_booking] ?? ['label' => ucfirst($booking->status_booking), 'color' => 'text-gray-400', 'bg' => 'bg-gray-400/10', 'icon' => 'info'];
            
            // Status bayar
            $paymentStatus = $pembayaran?->status_bayar ?? 'belum_bayar';
            $paymentMap = [
                'lunas' => ['label' => 'Lunas', 'color' => 'text-green-400', 'bg' => 'bg-green-400/10'],
                'dp' => ['label' => 'DP', 'color' => 'text-blue-400', 'bg' => 'bg-blue-400/10'],
                'belum_bayar' => ['label' => 'Belum Bayar', 'color' => 'text-red-400', 'bg' => 'bg-red-400/10'],
                'menunggu_verifikasi_dp' => ['label' => 'Menunggu Verifikasi DP', 'color' => 'text-amber-400', 'bg' => 'bg-amber-400/10'],
                'menunggu_verifikasi_lunas' => ['label' => 'Menunggu Verifikasi Lunas', 'color' => 'text-amber-400', 'bg' => 'bg-amber-400/10'],
            ];
            $payment = $paymentMap[$paymentStatus] ?? ['label' => ucfirst($paymentStatus), 'color' => 'text-gray-400', 'bg' => 'bg-gray-400/10'];
        @endphp

        <!-- Main Card -->
        <div class="bg-surface rounded-xl border border-outline-variant/30 glass-highlight overflow-hidden">
            
            <!-- Header Card with Status -->
            <div class="p-md border-b border-outline-variant/20 flex justify-between items-center flex-wrap gap-3">
                <div class="flex flex-wrap gap-2">
                    <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-sm font-medium {{ $status['bg'] }} {{ $status['color'] }}">
                        <span class="material-symbols-outlined text-[18px]">{{ $status['icon'] }}</span>
                        {{ $status['label'] }}
                    </span>
                    <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-sm font-medium {{ $payment['bg'] }} {{ $payment['color'] }}">
                        <span class="material-symbols-outlined text-[18px]">credit_card</span>
                        {{ $payment['label'] }}
                    </span>
                </div>
                <div class="text-right">
                    <div class="text-xs text-on-surface-variant">Kode Booking</div>
                    <div class="text-sm font-mono font-bold text-primary">{{ $booking->kode_booking }}</div>
                </div>
            </div>

            <!-- Body -->
            <div class="p-md">
                <!-- Informasi Fasilitas -->
                <div class="mb-lg">
                    <h2 class="text-lg font-bold text-on-surface mb-3">Informasi Fasilitas</h2>
                    <div class="bg-surface-container-low rounded-xl p-4 space-y-2">
                        <div class="flex justify-between flex-wrap">
                            <span class="text-on-surface-variant">Nama Fasilitas</span>
                            <span class="font-medium text-on-surface">{{ $detail?->fasilitas?->nama ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between flex-wrap">
                            <span class="text-on-surface-variant">Jenis Fasilitas</span>
                            <span class="font-medium text-on-surface">{{ ucfirst(str_replace('_', ' ', $detail?->fasilitas?->jenis ?? '-')) }}</span>
                        </div>
                        <div class="flex justify-between flex-wrap">
                            <span class="text-on-surface-variant">Harga per Jam</span>
                            <span class="font-medium text-on-surface">Rp{{ number_format($detail?->fasilitas?->harga_per_jam ?? 0, 0, ',', '.') }}</span>
                        </div>
                        @if($detail?->fasilitas?->kapasitas)
                        <div class="flex justify-between flex-wrap">
                            <span class="text-on-surface-variant">Kapasitas</span>
                            <span class="font-medium text-on-surface">{{ $detail->fasilitas->kapasitas }} orang</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Informasi Jadwal -->
                <div class="mb-lg">
                    <h2 class="text-lg font-bold text-on-surface mb-3">Informasi Jadwal</h2>
                    <div class="bg-surface-container-low rounded-xl p-4 space-y-2">
                        <div class="flex justify-between flex-wrap">
                            <span class="text-on-surface-variant">Tanggal</span>
                            <span class="font-medium text-on-surface">{{ \Carbon\Carbon::parse($detail->tanggal)->translatedFormat('l, d F Y') }}</span>
                        </div>
                        <div class="flex justify-between flex-wrap">
                            <span class="text-on-surface-variant">Waktu</span>
                            <span class="font-medium text-on-surface">{{ substr($detail->jam_mulai, 0, 5) }} - {{ substr($detail->jam_selesai, 0, 5) }}</span>
                        </div>
                        <div class="flex justify-between flex-wrap">
                            <span class="text-on-surface-variant">Durasi</span>
                            <span class="font-medium text-on-surface">{{ $detail->durasi_jam }} Jam</span>
                        </div>
                    </div>
                </div>

                <!-- Informasi Pembayaran -->
                <div class="mb-lg">
                    <h2 class="text-lg font-bold text-on-surface mb-3">Informasi Pembayaran</h2>
                    <div class="bg-surface-container-low rounded-xl p-4 space-y-2">
                        <div class="flex justify-between flex-wrap">
                            <span class="text-on-surface-variant">Metode Pembayaran</span>
                            <span class="font-medium text-on-surface">{{ $pembayaran?->metode === 'transfer' ? 'Transfer Bank' : 'Cash / Tunai' }}</span>
                        </div>
                        @if($pembayaran?->metode === 'transfer' && $pembayaran?->bank_tujuan)
                        <div class="flex justify-between flex-wrap">
                            <span class="text-on-surface-variant">Bank / E-Wallet Tujuan</span>
                            <span class="font-medium text-on-surface">{{ strtoupper($pembayaran->bank_tujuan) }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between flex-wrap">
                            <span class="text-on-surface-variant">Total Tagihan</span>
                            <span class="font-bold text-primary text-lg">Rp{{ number_format($booking->total_harga, 0, ',', '.') }}</span>
                        </div>
                        @if($booking->diskon_persen > 0)
                        <div class="flex justify-between flex-wrap">
                            <span class="text-on-surface-variant">Diskon</span>
                            <span class="font-medium text-secondary">{{ $booking->diskon_persen }}%</span>
                        </div>
                        @endif
                        @if($pembayaran?->nominal_dp > 0)
                        <div class="flex justify-between flex-wrap">
                            <span class="text-on-surface-variant">Nominal DP</span>
                            <span class="font-medium text-on-surface">Rp{{ number_format($pembayaran->nominal_dp, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between flex-wrap">
                            <span class="text-on-surface-variant">Sisa Tagihan</span>
                            <span class="font-medium text-amber-400">Rp{{ number_format($pembayaran->total_tagihan - $pembayaran->nominal_dp, 0, ',', '.') }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Informasi User -->
                <div class="mb-lg">
                    <h2 class="text-lg font-bold text-on-surface mb-3">Informasi Pemesan</h2>
                    <div class="bg-surface-container-low rounded-xl p-4 space-y-2">
                        <div class="flex justify-between flex-wrap">
                            <span class="text-on-surface-variant">Nama</span>
                            <span class="font-medium text-on-surface">{{ $booking->user->name }}</span>
                        </div>
                        <div class="flex justify-between flex-wrap">
                            <span class="text-on-surface-variant">Email</span>
                            <span class="font-medium text-on-surface">{{ $booking->user->email }}</span>
                        </div>
                        <div class="flex justify-between flex-wrap">
                            <span class="text-on-surface-variant">Role</span>
                            <span class="font-medium text-on-surface">{{ ucfirst($booking->user->role) }}</span>
                        </div>
                        <div class="flex justify-between flex-wrap">
                            <span class="text-on-surface-variant">Dibooking Pada</span>
                            <span class="font-medium text-on-surface">{{ $booking->created_at->translatedFormat('d F Y H:i') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Upload Bukti (khusus transfer & status belum bayar/menunggu) -->
                @if($pembayaran?->metode === 'transfer' && in_array($booking->status_booking, ['menunggu_pembayaran', 'menunggu_verifikasi_dp', 'dp']))
                <div class="mb-lg">
                    <h2 class="text-lg font-bold text-on-surface mb-3">Upload Bukti Pembayaran</h2>
                    <div class="bg-surface-container-low rounded-xl p-4">
                        <form action="{{ route('user.booking.upload-bukti', $booking->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            
                            @if($booking->status_booking == 'dp')
                                <div class="text-sm text-amber-400 mb-2">
                                    ⚠️ Anda sudah membayar DP. Silakan upload bukti pelunasan.
                                </div>
                                <input type="hidden" name="jenis_bukti" value="lunas">
                            @elseif($booking->status_booking == 'menunggu_pembayaran')
                                <div class="text-sm text-amber-400 mb-2">
                                    Silakan upload bukti pembayaran (DP atau Lunas)
                                </div>
                                <div class="flex gap-4 mb-3">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="jenis_bukti" value="dp" checked class="accent-primary">
                                        <span>Bukti DP (50%)</span>
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="jenis_bukti" value="lunas" class="accent-primary">
                                        <span>Bukti Lunas (Full)</span>
                                    </label>
                                </div>
                            @else
                                <input type="hidden" name="jenis_bukti" value="lunas">
                            @endif
                            
                            <div class="border-2 border-dashed border-outline-variant/50 rounded-xl p-4 text-center cursor-pointer hover:border-primary transition-all"
                                onclick="document.getElementById('bukti_file').click()">
                                <span class="material-symbols-outlined text-3xl text-primary">cloud_upload</span>
                                <p class="text-sm text-on-surface-variant mt-1">Klik untuk upload bukti transfer</p>
                                <p class="text-xs text-on-surface-variant">Format: JPG, PNG (max 2MB)</p>
                            </div>
                            <input type="file" name="bukti" id="bukti_file" class="hidden" accept="image/*" onchange="previewBukti(this)">
                            <div id="bukti-preview" class="mt-2 hidden">
                                <img id="bukti-img" class="w-full max-h-40 object-cover rounded-lg">
                            </div>
                            
                            <button type="submit" class="w-full bg-primary text-on-primary py-3 rounded-xl font-bold hover:scale-105 transition-all">
                                Upload Bukti
                            </button>
                        </form>
                    </div>
                </div>
                @endif

                <!-- Tombol Aksi -->
                <div class="flex gap-3 justify-end pt-3 border-t border-outline-variant/20">
                    @if(in_array($booking->status_booking, ['menunggu', 'menunggu_pembayaran']))
                        <form action="{{ route('user.booking.cancel', $booking->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    onclick="return confirm('Yakin ingin membatalkan booking ini?')"
                                    class="px-5 py-2 rounded-full text-sm border border-red-500/30 text-red-400 hover:bg-red-500/10 transition-all">
                                Batalkan Booking
                            </button>
                        </form>
                    @endif
                    
                    <a href="{{ route('user.booking.index') }}" 
                       class="px-5 py-2 rounded-full text-sm border border-outline-variant/30 text-on-surface-variant hover:border-primary/50 hover:text-primary transition-all">
                        Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>

    </main>

    <!-- Bottom Nav Mobile -->
    <nav class="md:hidden bg-surface-container/80 backdrop-blur-lg fixed bottom-0 w-full rounded-t-lg z-50 border-t border-outline-variant/30 shadow-[0_-4px_24px_rgba(0,0,0,0.5)] flex justify-around items-center h-20 px-gutter">
        <a class="flex flex-col items-center justify-center text-on-surface-variant opacity-60 hover:opacity-100 transition-opacity" href="{{ route('user.dashboard') }}">
            <span class="material-symbols-outlined mb-xs">sports_soccer</span>
            <span class="font-label-bold text-label-bold text-[10px]">Home</span>
        </a>
        <a class="flex flex-col items-center justify-center text-on-surface-variant opacity-60 hover:opacity-100 transition-opacity" href="{{ route('user.booking.index') }}">
            <span class="material-symbols-outlined mb-xs">event_available</span>
            <span class="font-label-bold text-label-bold text-[10px] text-center leading-tight">Booking Saya</span>
        </a>
        <a class="flex flex-col items-center justify-center text-on-surface-variant opacity-60 hover:opacity-100 transition-opacity" href="{{ route('profile') }}">
            <span class="material-symbols-outlined mb-xs">account_circle</span>
            <span class="font-label-bold text-label-bold text-[10px]">Profil</span>
        </a>
    </nav>

    <script>
        function previewBukti(input) {
            const preview = document.getElementById('bukti-preview');
            const img = document.getElementById('bukti-img');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                    preview.classList.remove('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

@endsection