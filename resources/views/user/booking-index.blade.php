@extends('layouts.app')

@section('title', 'SpaceGo - Riwayat Booking Saya')

@section('content')

    <!-- Ambient BG -->
    <div class="fixed inset-0 z-[-1] overflow-hidden pointer-events-none">
        <div class="absolute top-[-10%] right-[-10%] w-[50vw] h-[50vw] bg-emerald-pulse/20 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-[40vw] h-[40vw] bg-primary/10 rounded-full blur-[100px]"></div>
    </div>

    <!-- Include Navbar -->
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

    <!-- ==================== MAIN ==================== -->
    <main class="pt-24 px-margin md:px-xl max-w-[1440px] mx-auto">

        <!-- Page Header -->
        <div class="mb-lg">
            <div class="flex items-center gap-2 mb-2">
                <a href="{{ route('user.dashboard') }}"
                    class="text-on-surface-variant hover:text-primary transition-colors flex items-center gap-1 text-sm">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                </a>
                <h1 class="font-headline-lg text-headline-lg text-on-surface">Riwayat Booking Saya</h1>
            </div>
            <p class="font-body-md text-body-md text-on-surface-variant">Kelola dan pantau status booking fasilitas Anda.</p>
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

        @if($bookings->isEmpty())
            <!-- Empty State -->
            <div class="text-center py-16 bg-surface rounded-2xl border border-outline-variant/30">
                <span class="material-symbols-outlined text-6xl text-on-surface-variant/50 mb-4">event_busy</span>
                <h3 class="text-xl font-bold text-on-surface mb-2">Belum Ada Booking</h3>
                <p class="text-on-surface-variant mb-6">Yuk booking fasilitas olahraga favoritmu!</p>
                <a href="{{ route('user.booking.create') }}" 
                   class="bg-primary text-on-primary px-6 py-3 rounded-full font-bold hover:scale-105 transition inline-flex items-center gap-2">
                    <span class="material-symbols-outlined">add</span>
                    Booking Sekarang
                </a>
            </div>
        @else
            <!-- List Booking -->
            <div class="flex flex-col gap-md">
                @foreach($bookings as $booking)
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
                            'dikonfirmasi' => ['label' => 'Dikonfirmasi', 'color' => 'text-green-400', 'bg' => 'bg-green-400/10', 'icon' => 'check_circle'],
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
                            'menunggu_verifikasi_dp' => ['label' => 'Verifikasi DP', 'color' => 'text-amber-400', 'bg' => 'bg-amber-400/10'],
                            'menunggu_verifikasi_lunas' => ['label' => 'Verifikasi Lunas', 'color' => 'text-amber-400', 'bg' => 'bg-amber-400/10'],
                        ];
                        $payment = $paymentMap[$paymentStatus] ?? ['label' => ucfirst($paymentStatus), 'color' => 'text-gray-400', 'bg' => 'bg-gray-400/10'];
                    @endphp
                    
                    <div class="bg-surface rounded-xl border border-outline-variant/30 glass-highlight hover:border-primary/50 transition-all duration-200 overflow-hidden">
                        <div class="p-md">
                            <!-- Baris 1: Header dengan status -->
                            <div class="flex justify-between items-start flex-wrap gap-2 mb-3">
                                <div class="flex flex-wrap gap-2">
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium {{ $status['bg'] }} {{ $status['color'] }}">
                                        <span class="material-symbols-outlined text-[14px]">{{ $status['icon'] }}</span>
                                        {{ $status['label'] }}
                                    </span>
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium {{ $payment['bg'] }} {{ $payment['color'] }}">
                                        <span class="material-symbols-outlined text-[14px]">credit_card</span>
                                        {{ $payment['label'] }}
                                    </span>
                                </div>
                                <div class="text-right">
                                    <div class="text-xl font-bold text-primary">
                                        Rp{{ number_format($booking->total_harga, 0, ',', '.') }}
                                    </div>
                                    @if($booking->diskon_persen > 0)
                                        <div class="text-xs text-secondary">Diskon {{ $booking->diskon_persen }}%</div>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Baris 2: Nama fasilitas -->
                            <h3 class="text-lg font-bold text-on-surface mb-2">
                                {{ $detail?->fasilitas?->nama ?? '-' }}
                            </h3>
                            
                            <!-- Baris 3: Detail tanggal, jam, durasi -->
                            <div class="flex flex-wrap gap-4 text-sm text-on-surface-variant mb-4">
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[18px]">event</span>
                                    <span>{{ \Carbon\Carbon::parse($detail->tanggal)->translatedFormat('l, d M Y') }}</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[18px]">schedule</span>
                                    <span>{{ substr($detail->jam_mulai, 0, 5) }} - {{ substr($detail->jam_selesai, 0, 5) }}</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[18px]">hourglass_top</span>
                                    <span>{{ $detail->durasi_jam }} Jam</span>
                                </div>
                                <div class="flex items-center gap-1 text-xs">
                                    <span class="material-symbols-outlined text-[16px]">receipt_long</span>
                                    <span>{{ $booking->kode_booking }}</span>
                                </div>
                            </div>
                            
                            <!-- Baris 4: Tombol aksi -->
                            <div class="flex justify-end gap-2 pt-3 border-t border-outline-variant/20">
                                <a href="{{ route('user.booking.show', $booking->id) }}" 
                                   class="inline-flex items-center gap-1 px-4 py-1.5 rounded-full text-sm border border-outline-variant/30 text-on-surface-variant hover:border-primary/50 hover:text-primary transition-all">
                                    <span class="material-symbols-outlined text-[16px]">visibility</span>
                                    Detail
                                </a>
                                
                                @if(in_array($booking->status_booking, ['menunggu', 'menunggu_pembayaran']))
                                    <form action="{{ route('user.booking.cancel', $booking->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                onclick="return confirm('Yakin ingin membatalkan booking ini?')"
                                                class="inline-flex items-center gap-1 px-4 py-1.5 rounded-full text-sm border border-red-500/30 text-red-400 hover:bg-red-500/10 transition-all">
                                            <span class="material-symbols-outlined text-[16px]">cancel</span>
                                            Batalkan
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-lg">
                {{ $bookings->links() }}
            </div>
        @endif

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

    <style>
        /* Toast bisa ditambahkan jika diperlukan */
    </style>

@endsection