@extends('layouts.admin')

@section('title', 'Pembayaran')
@section('page-title', 'Pembayaran')

@section('breadcrumb')
    <span class="current">Pembayaran</span>
@endsection

@section('content')
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        poppins: ['Poppins', 'sans-serif']
                    },
                    colors: {
                        green: '#34f5a1',
                        yellow: '#facc15',
                        red: '#fb7185',
                        blue: '#4ea8ff',
                        purple: '#a78bfa',
                    }
                }
            }
        }
    </script>

    <style>
        /* ========== LIGHT MODE STYLES ========== */
        body.light-mode .main {
            background-color: #f1f5f9 !important;
        }

        body.light-mode .bg-gradient-to-br.from-\[\#141c2b\] {
            background: #ffffff !important;
            border-color: #e2e8f0 !important;
        }

        body.light-mode .to-\[\#111827\] {
            background: #ffffff !important;
        }

        body.light-mode .text-white {
            color: #1e293b !important;
        }

        body.light-mode .text-slate-400 {
            color: #64748b !important;
        }

        body.light-mode .text-slate-500 {
            color: #64748b !important;
        }

        body.light-mode .text-\[\#7c879f\] {
            color: #64748b !important;
        }

        body.light-mode .border-white\/\[0\.06\] {
            border-color: #e2e8f0 !important;
        }

        body.light-mode .border-white\/\[0\.08\] {
            border-color: #e2e8f0 !important;
        }

        body.light-mode .bg-white\/\[0\.05\] {
            background-color: #f8fafc !important;
        }

        body.light-mode .bg-green\/\[0\.12\] {
            background-color: rgba(5, 150, 105, 0.1) !important;
        }

        body.light-mode .bg-yellow\/\[0\.12\] {
            background-color: rgba(217, 119, 6, 0.1) !important;
        }

        body.light-mode .bg-red\/\[0\.12\] {
            background-color: rgba(220, 38, 38, 0.1) !important;
        }

        body.light-mode .bg-purple\/\[0\.12\] {
            background-color: rgba(124, 58, 237, 0.1) !important;
        }

        body.light-mode .text-green {
            color: #059669 !important;
        }

        body.light-mode .text-yellow {
            color: #d97706 !important;
        }

        body.light-mode .text-red {
            color: #dc2626 !important;
        }

        body.light-mode .text-purple {
            color: #7c3aed !important;
        }

        body.light-mode .bg-green\/10 {
            background-color: rgba(5, 150, 105, 0.08) !important;
        }

        body.light-mode .bg-red\/10 {
            background-color: rgba(220, 38, 38, 0.08) !important;
        }

        body.light-mode .border-green\/25 {
            border-color: #d1fae5 !important;
        }

        body.light-mode .border-red\/25 {
            border-color: #fecaca !important;
        }

        /* Input dan select light mode */
        body.light-mode input,
        body.light-mode select {
            background-color: #ffffff !important;
            color: #1e293b !important;
            border-color: #e2e8f0 !important;
        }

        body.light-mode input::placeholder {
            color: #94a3b8 !important;
        }

        body.light-mode select option {
            background-color: #ffffff !important;
            color: #1e293b !important;
        }

        /* Button light mode */
        body.light-mode button[style*="background-color:#111827"] {
            background-color: #ffffff !important;
            border-color: #e2e8f0 !important;
            color: #1e293b !important;
        }

        body.light-mode .bg-yellow\/\[0\.12\] {
            background-color: rgba(217, 119, 6, 0.1) !important;
        }

        body.light-mode .bg-green\/\[0\.12\] {
            background-color: rgba(5, 150, 105, 0.1) !important;
        }

        body.light-mode .bg-red\/\[0\.12\] {
            background-color: rgba(220, 38, 38, 0.1) !important;
        }

        body.light-mode .bg-white\/\[0\.04\] {
            background-color: #f1f5f9 !important;
        }

        body.light-mode .bg-blue\/\[0\.1\] {
            background-color: rgba(37, 99, 235, 0.1) !important;
        }

        body.light-mode .text-blue {
            color: #2563eb !important;
        }

        body.light-mode .border-blue\/20 {
            border-color: #dbeafe !important;
        }

        body.light-mode .bg-white\/\[0\.02\] {
            background-color: #f8fafc !important;
        }

        body.light-mode .border-white\/\[0\.05\] {
            border-color: #e2e8f0 !important;
        }

        body.light-mode .text-slate-700 {
            color: #cbd5e1 !important;
        }

        /* Hover effects light mode */
        body.light-mode .hover\:border-green\/30:hover {
            border-color: #059669 !important;
        }

        body.light-mode .hover\:border-yellow\/30:hover {
            border-color: #d97706 !important;
        }

        body.light-mode .hover\:border-purple\/30:hover {
            border-color: #7c3aed !important;
        }

        body.light-mode .hover\:border-red\/30:hover {
            border-color: #dc2626 !important;
        }

        body.light-mode .hover\:bg-yellow\/20:hover {
            background-color: rgba(217, 119, 6, 0.15) !important;
        }

        body.light-mode .hover\:bg-green\/20:hover {
            background-color: rgba(5, 150, 105, 0.15) !important;
        }

        body.light-mode .hover\:bg-red\/20:hover {
            background-color: rgba(220, 38, 38, 0.15) !important;
        }

        body.light-mode .hover\:text-white:hover {
            color: #1e293b !important;
        }

        /* Animation pulse light mode */
        body.light-mode .animate-pulse {
            animation: none !important;
        }

        /* Link light mode */
        body.light-mode a.text-blue {
            color: #2563eb !important;
        }

        /* Empty state light mode */
        body.light-mode .text-slate-700 {
            color: #94a3b8 !important;
        }
    </style>

    <div class="font-poppins flex flex-col gap-5">

        {{-- HEADER --}}
        <div class="flex justify-between items-start flex-wrap gap-3">
            <div>
                <h1 class="text-[36px] font-extrabold text-white leading-tight">
                    Manajemen <span class="text-green">Pembayaran</span>
                </h1>
                <p class="text-slate-400 text-sm mt-1">Verifikasi dan pantau seluruh transaksi pembayaran.</p>
            </div>
        </div>

        {{-- ALERT --}}
        @if (session('success'))
            <div
                class="flex items-center gap-3 bg-green/10 border border-green/25 text-green rounded-2xl px-4 py-3 text-sm font-semibold">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div
                class="flex items-center gap-3 bg-red/10 border border-red/25 text-red rounded-2xl px-4 py-3 text-sm font-semibold">
                <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
            </div>
        @endif

        {{-- STAT CARDS --}}
        <div class="grid grid-cols-[repeat(auto-fit,minmax(200px,1fr))] gap-4">

            {{-- Total Tagihan --}}
            <div
                class="relative overflow-hidden bg-gradient-to-br from-[#141c2b] to-[#111827] border border-green/[0.15] rounded-[20px] p-5">
                <div class="absolute -top-8 -right-8 w-24 h-24 bg-green/10 rounded-full"></div>
                <div class="w-10 h-10 rounded-[12px] bg-green/[0.12] flex items-center justify-center mb-4">
                    <i class="fa-solid fa-sack-dollar text-green text-sm"></i>
                </div>
                <div class="text-[#7c879f] text-[11px] font-extrabold uppercase tracking-wider mb-1">Total Tagihan</div>
                <div class="text-white text-2xl font-extrabold leading-none">
                    Rp {{ number_format($totalTagihan, 0, ',', '.') }}
                </div>
                <div class="text-slate-500 text-xs mt-2">Semua transaksi</div>
            </div>

            {{-- Sudah Lunas --}}
            <div
                class="relative overflow-hidden bg-gradient-to-br from-[#141c2b] to-[#111827] border border-green/[0.15] rounded-[20px] p-5">
                <div class="absolute -top-8 -right-8 w-24 h-24 bg-green/10 rounded-full"></div>
                <div class="w-10 h-10 rounded-[12px] bg-green/[0.12] flex items-center justify-center mb-4">
                    <i class="fa-solid fa-circle-check text-green text-sm"></i>
                </div>
                <div class="text-[#7c879f] text-[11px] font-extrabold uppercase tracking-wider mb-1">Sudah Lunas</div>
                <div class="text-green text-2xl font-extrabold leading-none">
                    Rp {{ number_format($totalLunas, 0, ',', '.') }}
                </div>
                <div class="text-slate-500 text-xs mt-2">Pembayaran selesai</div>
            </div>

            {{-- DP Masuk --}}
            <div
                class="relative overflow-hidden bg-gradient-to-br from-[#141c2b] to-[#111827] border border-green/[0.15] rounded-[20px] p-5">
                <div class="absolute -top-8 -right-8 w-24 h-24 bg-yellow/10 rounded-full"></div>
                <div class="w-10 h-10 rounded-[12px] bg-yellow/[0.12] flex items-center justify-center mb-4">
                    <i class="fa-solid fa-clock text-yellow text-sm"></i>
                </div>
                <div class="text-[#7c879f] text-[11px] font-extrabold uppercase tracking-wider mb-1">DP Masuk</div>
                <div class="text-yellow text-2xl font-extrabold leading-none">
                    Rp {{ number_format($totalDp, 0, ',', '.') }}
                </div>
                <div class="text-slate-500 text-xs mt-2">{{ $countPending }} menunggu verifikasi DP</div>
            </div>

            {{-- Belum Bayar / Perlu Verifikasi --}}
            <div
                class="relative overflow-hidden bg-gradient-to-br from-[#141c2b] to-[#111827] border border-green/[0.15] rounded-[20px] p-5">
                <div class="absolute -top-8 -right-8 w-24 h-24 bg-purple/10 rounded-full"></div>
                <div class="w-10 h-10 rounded-[12px] bg-purple/[0.12] flex items-center justify-center mb-4">
                    <i class="fa-solid fa-receipt text-purple text-sm"></i>
                </div>
                <div class="text-[#7c879f] text-[11px] font-extrabold uppercase tracking-wider mb-1">Perlu Verif Lunas</div>
                <div class="text-purple text-2xl font-extrabold leading-none">{{ $countMenungguLunas }}</div>
                <div class="text-slate-500 text-xs mt-2">Menunggu verifikasi lunas</div>
            </div>

        </div>

        {{-- FILTER --}}
        <form method="GET" action="{{ route('admin.pembayaran.index') }}"
            class="bg-gradient-to-br from-[#141c2b] to-[#111827] border border-white/[0.06] rounded-[20px] px-5 py-4 flex gap-3 flex-wrap items-center">

            <div class="relative flex-1 min-w-[200px]">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 text-xs"></i>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari kode booking atau nama user..."
                    class="w-full h-9 bg-white/[0.05] border border-white/[0.08] rounded-xl pl-9 pr-3 text-[13px] text-white placeholder-slate-500 outline-none focus:border-green/40">
            </div>

            <select name="status"
                class="h-9 border border-white/[0.08] rounded-xl px-3 text-[13px] text-white min-w-[150px] outline-none focus:border-green/40"
                style="background-color:#111827; color-scheme:dark;">
                <option value="">Semua Status</option>
                <option value="belum_bayar" {{ request('status') === 'belum_bayar' ? 'selected' : '' }}>Belum Bayar</option>
                <option value="menunggu_verifikasi_dp" {{ request('status') === 'menunggu_verifikasi_dp' ? 'selected' : '' }}>Menunggu Verif DP</option>
                <option value="dp" {{ request('status') === 'dp' ? 'selected' : '' }}>DP Aktif</option>
                <option value="menunggu_verifikasi" {{ request('status') === 'menunggu_verifikasi' ? 'selected' : '' }}>Menunggu Verif Lunas</option>
                <option value="lunas" {{ request('status') === 'lunas' ? 'selected' : '' }}>Lunas</option>
            </select>

            <select name="metode"
                class="h-9 border border-white/[0.08] rounded-xl px-3 text-[13px] text-white min-w-[140px] outline-none focus:border-green/40"
                style="background-color:#111827; color-scheme:dark;">
                <option value="">Semua Metode</option>
                <option value="transfer" {{ request('metode') === 'transfer' ? 'selected' : '' }}>Transfer</option>
                <option value="cash" {{ request('metode') === 'cash' ? 'selected' : '' }}>Cash</option>
            </select>

            <button type="submit"
                class="h-9 px-5 bg-green text-[#08130f] rounded-xl text-[13px] font-bold hover:opacity-90 transition">
                Terapkan
            </button>
            @if (request('search') || request('status') || request('metode'))
                <a href="{{ route('admin.pembayaran.index') }}"
                    class="h-9 px-4 bg-white/[0.05] border border-white/[0.08] rounded-xl text-[13px] text-slate-400 flex items-center hover:text-white transition">
                    Reset
                </a>
            @endif
        </form>

        {{-- TRANSACTION LIST --}}
        <div class="flex flex-col gap-3">

            @forelse($pembayarans as $p)
                @php
                    $booking = $p->booking;
                    $user = $booking?->user;
                    $fasilitas = $booking?->detailBooking->first()?->fasilitas;

                    // Konfigurasi dinamis untuk mendukung status baru dari user form
                    $statusConfig = match ($p->status_bayar) {
                        'lunas' => ['bg-green/[0.12] text-green border-green/20', 'fa-circle-check', 'Lunas'],
                        'dp' => ['bg-yellow/[0.12] text-yellow border-yellow/20', 'fa-clock', 'DP Aktif'],
                        'menunggu_verifikasi_dp' => [
                            'bg-yellow/[0.12] text-yellow border-yellow/30',
                            'fa-circle-dot',
                            'Verif DP',
                        ],
                        'menunggu_verifikasi', 'menunggu_verifikasi_lunas' => [
                            'bg-purple/[0.12] text-purple border-purple/30',
                            'fa-circle-dot',
                            'Verif Lunas',
                        ],
                        'belum_bayar' => [
                            'bg-red/[0.12] text-red border-red/20',
                            'fa-triangle-exclamation',
                            'Belum Bayar',
                        ],
                        default => ['bg-white/[0.05] text-slate-400 border-white/10', 'fa-question', $p->status_bayar],
                    };

                    $borderGlow = match ($p->status_bayar) {
                        'lunas' => 'hover:border-green/30',
                        'dp',
                        'menunggu_verifikasi_dp' => 'hover:border-yellow/30',
                        'menunggu_verifikasi',
                        'menunggu_verifikasi_lunas' => 'hover:border-purple/30',
                        'belum_bayar' => 'hover:border-red/30',
                        default => 'hover:border-white/10',
                    };

                    // Cari file bukti yang tersedia
                    $fileBukti = $p->bukti_lunas ?? $p->bukti_dp;
                @endphp

                <div
                    class="bg-gradient-to-br from-[#141c2b] to-[#111827] border border-white/[0.06] rounded-[20px] px-6 py-5 flex items-center gap-5 transition-all duration-300 {{ $borderGlow }} flex-wrap">

                    {{-- Kiri: Icon status --}}
                    <div
                        class="w-12 h-12 rounded-[14px] {{ explode(' ', $statusConfig[0])[0] }} border {{ explode(' ', $statusConfig[0])[2] }} flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid {{ $statusConfig[1] }} {{ explode(' ', $statusConfig[0])[1] }} text-base"></i>
                    </div>

                    {{-- Info booking --}}
                    <div class="flex-1 min-w-[160px]">
                        <div class="text-green font-extrabold text-[13px] font-mono mb-0.5">
                            #{{ strtoupper(substr($booking?->kode_booking ?? '', -6)) }}
                        </div>
                        <div class="text-white font-bold text-[14px]">{{ $user?->name ?? '-' }}</div>
                        <div class="text-slate-500 text-[12px]">{{ $fasilitas?->nama ?? '-' }}</div>
                    </div>

                    {{-- Metode & Bukti Transfer --}}
                    <div class="text-center min-w-[100px]">
                        <div class="text-[#7c879f] text-[10px] font-bold uppercase tracking-wider mb-1">Metode</div>
                        <div class="text-white text-[13px] font-semibold capitalize mb-1">{{ $p->metode }}</div>
                        @if ($p->metode === 'transfer' && $fileBukti)
                            <a href="{{ asset('storage/' . $fileBukti) }}" target="_blank"
                                class="inline-flex items-center gap-1 text-[11px] text-blue-400 hover:underline font-medium">
                                <i class="fa-solid fa-image"></i> Cek Bukti
                            </a>
                        @endif
                    </div>

                    {{-- Nominal DP --}}
                    <div class="text-center min-w-[120px]">
                        <div class="text-[#7c879f] text-[10px] font-bold uppercase tracking-wider mb-1">DP</div>
                        <div class="text-yellow text-[14px] font-bold">
                            Rp {{ number_format($p->nominal_dp, 0, ',', '.') }}
                        </div>
                        @if ($p->waktu_dp)
                            <div class="text-slate-500 text-[11px]">
                                {{ \Carbon\Carbon::parse($p->waktu_dp)->format('d M Y') }}
                            </div>
                        @endif
                    </div>

                    {{-- Total Tagihan --}}
                    <div class="text-center min-w-[140px]">
                        <div class="text-[#7c879f] text-[10px] font-bold uppercase tracking-wider mb-1">Total Tagihan</div>
                        <div class="text-white text-[20px] font-extrabold leading-none">
                            Rp {{ number_format($p->total_tagihan, 0, ',', '.') }}
                        </div>
                        @if ($p->waktu_lunas)
                            <div class="text-slate-500 text-[11px] mt-0.5">
                                Lunas {{ \Carbon\Carbon::parse($p->waktu_lunas)->format('d M Y') }}
                            </div>
                        @endif
                    </div>

                    {{-- Status badge --}}
                    <div class="min-w-[110px] flex justify-center">
                        <span
                            class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-[12px] font-bold border {{ $statusConfig[0] }}">
                            <i class="fa-solid {{ $statusConfig[1] }} text-[10px]"></i>
                            {{ $statusConfig[2] }}
                        </span>
                    </div>

                    {{-- Aksi Verifikasi Dinamis --}}
                    <div class="flex gap-2 flex-shrink-0 items-center">
                        @if ($p->status_bayar === 'menunggu_verifikasi_dp')
                            {{-- Tombol Setujui DP --}}
                            <form action="{{ route('admin.pembayaran.verifikasi-dp', $p->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="h-9 px-4 bg-yellow/[0.12] border border-yellow/20 text-yellow rounded-xl text-[12px] font-bold hover:bg-yellow/20 transition"
                                    onclick="return confirm('Verifikasi pembayaran DP untuk booking ini?')">
                                    <i class="fa-solid fa-check mr-1"></i> Setujui DP
                                </button>
                            </form>
                            <button type="button"
                                class="h-9 px-3 bg-red/[0.12] border border-red/20 text-red rounded-xl text-[12px] font-bold hover:bg-red/20 transition"
                                onclick="handleTolak('{{ $p->id }}', 'dp')">Tolak</button>
                        @elseif(
                            $p->status_bayar === 'menunggu_verifikasi' ||
                                $p->status_bayar === 'menunggu_verifikasi_lunas' ||
                                ($p->status_bayar === 'belum_bayar' && $p->booking?->status_booking === 'dikonfirmasi'))
                            <form action="{{ route('admin.pembayaran.verifikasi-lunas', $p->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="h-9 px-4 bg-green/[0.12] border border-green/20 text-green rounded-xl text-[12px] font-bold hover:bg-green/20 transition"
                                    onclick="return confirm('Terima pembayaran cash dan tandai transaksi ini sebagai Lunas?')">
                                    <i class="fa-solid fa-money-bill-wave mr-1"></i> Setujui Lunas
                                </button>
                            </form>
                        @elseif($p->status_bayar === 'belum_bayar' && $p->booking?->status_booking === 'menunggu')
                            {{-- Jika masih menunggu konfirmasi admin di menu booking --}}
                            <div
                                class="h-9 px-4 bg-white/[0.02] border border-white/[0.05] text-slate-500 rounded-xl text-[12px] font-semibold flex items-center">
                                <i class="fa-solid fa-hourglass mr-1"></i> Menunggu Konfirmasi
                            </div>
                        @else
                            @if ($p->status_bayar === 'lunas')
                                @if ($p->booking?->status_booking === 'selesai')
                                    <div
                                        class="h-9 px-4 bg-white/[0.04] border border-white/[0.08] text-slate-400 rounded-xl text-[12px] font-bold flex items-center">
                                        <i class="fa-solid fa-circle-check mr-1.5 text-green"></i> Selesai
                                    </div>
                                @else
                                    <div
                                        class="h-9 px-4 bg-blue/[0.1] border border-blue/20 text-blue rounded-xl text-[12px] font-bold flex items-center">
                                        <i class="fa-solid fa-calendar-check mr-1.5"></i> Aktif (Akan Main)
                                    </div>
                                @endif
                            @else
                                <div
                                    class="h-9 px-4 bg-white/[0.03] border border-white/[0.06] text-slate-500 rounded-xl text-[12px] font-bold flex items-center">
                                    <i class="fa-solid fa-check mr-1.5"></i> Terverifikasi
                                </div>
                            @endif
                        @endif
                    </div>

                </div>
            @empty
                <div
                    class="bg-gradient-to-br from-[#141c2b] to-[#111827] border border-white/[0.06] rounded-[20px] py-16 text-center">
                    <i class="fa-solid fa-receipt text-4xl text-slate-700 mb-4 block"></i>
                    <div class="text-slate-400 text-sm">Belum ada data pembayaran</div>
                </div>
            @endforelse

        </div>

        {{-- PAGINATION --}}
        @if ($pembayarans->hasPages())
            <div class="flex justify-between items-center px-1 flex-wrap gap-3">
                <span class="text-slate-500 text-xs">
                    Menampilkan {{ $pembayarans->firstItem() }}–{{ $pembayarans->lastItem() }}
                    dari {{ $pembayarans->total() }} transaksi
                </span>
                {{ $pembayarans->withQueryString()->links() }}
            </div>
        @endif

    </div>

    {{-- Form Hidden untuk Aksi Tolak Pembayaran --}}
    <form id="form-tolak-pembayaran" action="" method="POST" style="display: none;">
        @csrf
        @method('PATCH')
        <input type="hidden" name="jenis_tolak" id="input-jenis-tolak">
        <input type="hidden" name="alasan" id="input-alasan-tolak">
    </form>

    <script>
        function handleTolak(id, jenis) {
            let alasan = prompt("Masukkan alasan penolakan bukti pembayaran ini:");
            if (alasan === null) return;

            if (alasan.trim() === "") {
                alert("Alasan penolakan wajib diisi!");
                return;
            }

            let form = document.getElementById('form-tolak-pembayaran');
            let url = "{{ route('admin.pembayaran.tolak', ':id') }}";

            form.action = url.replace(':id', id);
            document.getElementById('input-jenis-tolak').value = jenis;
            document.getElementById('input-alasan-tolak').value = alasan;

            form.submit();
        }
    </script>
@endsection