@extends('layouts.admin')

@section('title', 'Data Booking')
@section('page-title', 'Booking')

@section('breadcrumb')
    <span class="current">Bookings</span>
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
        /* CSS untuk Light Mode - Booking Page */
        
        /* Background utama saat light mode */
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
        
        /* Semua card dan container */
        body.light-mode .relative.overflow-hidden.bg-gradient-to-br,
        body.light-mode .bg-gradient-to-br {
            background: #ffffff !important;
            border-color: #e2e8f0 !important;
        }
        
        body.light-mode .text-white {
            color: #1e293b !important;
        }
        
        body.light-mode .text-slate-400 {
            color: #64748b !important;
        }
        
        body.light-mode .text-slate-300 {
            color: #475569 !important;
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
        
        body.light-mode .border-white\/\[0\.05\] {
            border-color: #e2e8f0 !important;
        }
        
        body.light-mode .border-white\/\[0\.04\] {
            border-color: #f1f5f9 !important;
        }
        
        body.light-mode .border-white\/\[0\.08\] {
            border-color: #e2e8f0 !important;
        }
        
        body.light-mode .bg-white\/\[0\.05\] {
            background-color: #f8fafc !important;
        }
        
        body.light-mode .bg-white\/\[0\.03\] {
            background-color: #f1f5f9 !important;
        }
        
        body.light-mode .bg-green\/\[0\.12\] {
            background-color: rgba(5, 150, 105, 0.1) !important;
        }
        
        body.light-mode .bg-yellow\/\[0\.12\] {
            background-color: rgba(217, 119, 6, 0.1) !important;
        }
        
        body.light-mode .bg-blue\/\[0\.12\] {
            background-color: rgba(37, 99, 235, 0.1) !important;
        }
        
        body.light-mode .bg-purple\/\[0\.12\] {
            background-color: rgba(124, 58, 237, 0.1) !important;
        }
        
        body.light-mode .bg-red\/\[0\.12\] {
            background-color: rgba(220, 38, 38, 0.1) !important;
        }
        
        body.light-mode .text-green {
            color: #059669 !important;
        }
        
        body.light-mode .text-yellow {
            color: #d97706 !important;
        }
        
        body.light-mode .text-blue {
            color: #2563eb !important;
        }
        
        body.light-mode .text-purple {
            color: #7c3aed !important;
        }
        
        body.light-mode .text-red {
            color: #dc2626 !important;
        }
        
        body.light-mode .bg-green\/10 {
            background-color: rgba(5, 150, 105, 0.08) !important;
        }
        
        body.light-mode .bg-yellow\/10 {
            background-color: rgba(217, 119, 6, 0.08) !important;
        }
        
        body.light-mode .bg-blue\/10 {
            background-color: rgba(37, 99, 235, 0.08) !important;
        }
        
        body.light-mode .border-green\/\[0\.15\] {
            border-color: #e2e8f0 !important;
        }
        
        body.light-mode .border-yellow\/\[0\.15\] {
            border-color: #e2e8f0 !important;
        }
        
        body.light-mode .border-blue\/\[0\.15\] {
            border-color: #e2e8f0 !important;
        }
        
        body.light-mode .bg-green\/\[0\.1\] {
            background-color: rgba(5, 150, 105, 0.08) !important;
        }
        
        body.light-mode .border-green\/20 {
            border-color: #d1fae5 !important;
        }
        
        body.light-mode .bg-blue\/\[0\.1\] {
            background-color: rgba(37, 99, 235, 0.08) !important;
        }
        
        body.light-mode .border-blue\/20 {
            border-color: #dbeafe !important;
        }
        
        body.light-mode .hover\:bg-green\/20:hover {
            background-color: rgba(5, 150, 105, 0.15) !important;
        }
        
        body.light-mode .hover\:bg-blue\/20:hover {
            background-color: rgba(37, 99, 235, 0.15) !important;
        }
        
        body.light-mode .hover\:bg-yellow\/\[0\.15\]:hover {
            background-color: rgba(217, 119, 6, 0.1) !important;
        }
        
        body.light-mode .hover\:bg-red\/\[0\.15\]:hover {
            background-color: rgba(220, 38, 38, 0.1) !important;
        }
        
        body.light-mode .hover\:bg-green\/\[0\.15\]:hover {
            background-color: rgba(5, 150, 105, 0.1) !important;
        }
        
        body.light-mode .hover\:text-green:hover {
            color: #059669 !important;
        }
        
        body.light-mode .hover\:text-yellow:hover {
            color: #d97706 !important;
        }
        
        body.light-mode .hover\:text-red:hover {
            color: #dc2626 !important;
        }
        
        body.light-mode .focus\:border-green\/40:focus {
            border-color: #059669 !important;
        }
        
        /* Input dan select */
        body.light-mode input,
        body.light-mode select {
            background-color: #ffffff !important;
            color: #1e293b !important;
            border-color: #e2e8f0 !important;
        }
        
        body.light-mode select option {
            background-color: #ffffff !important;
            color: #1e293b !important;
        }
        
        body.light-mode input::placeholder {
            color: #94a3b8 !important;
        }
        
        /* Tabel row hover */
        body.light-mode .group:hover {
            background-color: rgba(0, 0, 0, 0.02) !important;
        }
        
        /* Border top untuk pagination */
        body.light-mode .border-t {
            border-color: #e2e8f0 !important;
        }
        
        /* Divider */
        body.light-mode .divide-white\/\[0\.04\] > :not([hidden]) ~ :not([hidden]) {
            border-color: #f1f5f9 !important;
        }
        
        /* Popup detail light mode */
        body.light-mode #invoicePopupOverlay div[style*="background:#0b0f1a"] {
            background: #ffffff !important;
            border-color: #e2e8f0 !important;
        }
        
        body.light-mode #invoicePopupOverlay button[style*="background:#1a2235"] {
            background: #f1f5f9 !important;
            color: #1e293b !important;
            border-color: #e2e8f0 !important;
        }
        
        body.light-mode #invoicePopupOverlay button[style*="background:#1a2235"]:hover {
            background: #fee2e2 !important;
            color: #dc2626 !important;
        }
        
        /* Badge border */
        body.light-mode .border-yellow\/20 {
            border-color: #fde68a !important;
        }
        
        body.light-mode .border-purple\/30 {
            border-color: #ddd6fe !important;
        }
        
        body.light-mode .border-green\/20 {
            border-color: #d1fae5 !important;
        }
        
        body.light-mode .border-blue\/20 {
            border-color: #dbeafe !important;
        }
        
        body.light-mode .border-red\/20 {
            border-color: #fecaca !important;
        }
        
        /* Animation pulse di light mode */
        body.light-mode .animate-pulse {
            animation: none !important;
        }
    </style>

    <div class="font-poppins flex flex-col gap-5">

        {{-- HEADER --}}
        <div class="flex justify-between items-start flex-wrap gap-3">
            <div>
                <h1 class="text-[36px] font-extrabold text-white leading-tight">
                    Manajemen <span class="text-green">Booking</span>
                </h1>
                <p class="text-slate-400 text-sm mt-1">Kelola dan pantau seluruh data pemesanan fasilitas.</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.booking.create') }}"
                    class="h-11 px-5 bg-green text-[#0b1120] rounded-[14px] text-[13px] font-bold flex items-center gap-2 no-underline hover:opacity-90 transition">
                    <i class="fa-solid fa-plus"></i> Tambah Booking
                </a>
            </div>
        </div>

        {{-- ALERT --}}
        @if (session('success'))
            <div
                class="flex items-center gap-3 bg-green/10 border border-green/25 text-green rounded-2xl px-4 py-3 text-sm font-semibold">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        {{-- STAT CARDS --}}
        @php
            $totalBooking = $bookings->total();
            $menungguCount = \App\Models\Booking::whereIn('status_booking', [
                'menunggu',
                'menunggu_verifikasi',
                'dp',
            ])->count();
            $konfirmasiCount = \App\Models\Booking::where('status_booking', 'dikonfirmasi')->count();
            $selesaiCount = \App\Models\Booking::where('status_booking', 'selesai')->count();
        @endphp
        <div class="grid grid-cols-[repeat(auto-fit,minmax(180px,1fr))] gap-4">

            <div
                class="relative overflow-hidden bg-gradient-to-br from-[#141c2b] to-[#111827] border border-green/[0.15] rounded-[20px] p-5">
                <div class="absolute -top-8 -right-8 w-24 h-24 bg-green/10 rounded-full"></div>
                <div class="w-10 h-10 rounded-[12px] bg-green/[0.12] flex items-center justify-center mb-3">
                    <i class="fa-solid fa-calendar-check text-green text-sm"></i>
                </div>
                <div class="text-[#7c879f] text-[11px] font-extrabold uppercase tracking-wider mb-1">Total Booking</div>
                <div class="text-white text-2xl font-extrabold">{{ $totalBooking }}</div>
            </div>

            <div
                class="relative overflow-hidden bg-gradient-to-br from-[#141c2b] to-[#111827] border border-yellow/[0.15] rounded-[20px] p-5">
                <div class="absolute -top-8 -right-8 w-24 h-24 bg-yellow/10 rounded-full"></div>
                <div class="w-10 h-10 rounded-[12px] bg-yellow/[0.12] flex items-center justify-center mb-3">
                    <i class="fa-solid fa-clock text-yellow text-sm"></i>
                </div>
                <div class="text-[#7c879f] text-[11px] font-extrabold uppercase tracking-wider mb-1">Perlu Diproses</div>
                <div class="text-yellow text-2xl font-extrabold">{{ $menungguCount }}</div>
            </div>

            <div
                class="relative overflow-hidden bg-gradient-to-br from-[#141c2b] to-[#111827] border border-blue/[0.15] rounded-[20px] p-5">
                <div class="absolute -top-8 -right-8 w-24 h-24 bg-blue/10 rounded-full"></div>
                <div class="w-10 h-10 rounded-[12px] bg-blue/[0.12] flex items-center justify-center mb-3">
                    <i class="fa-solid fa-circle-check text-blue text-sm"></i>
                </div>
                <div class="text-[#7c879f] text-[11px] font-extrabold uppercase tracking-wider mb-1">Dikonfirmasi</div>
                <div class="text-blue text-2xl font-extrabold">{{ $konfirmasiCount }}</div>
            </div>

            <div
                class="relative overflow-hidden bg-gradient-to-br from-[#141c2b] to-[#111827] border border-green/[0.15] rounded-[20px] p-5">
                <div class="absolute -top-8 -right-8 w-24 h-24 bg-green/10 rounded-full"></div>
                <div class="w-10 h-10 rounded-[12px] bg-green/[0.12] flex items-center justify-center mb-3">
                    <i class="fa-solid fa-flag-checkered text-green text-sm"></i>
                </div>
                <div class="text-[#7c879f] text-[11px] font-extrabold uppercase tracking-wider mb-1">Selesai</div>
                <div class="text-green text-2xl font-extrabold">{{ $selesaiCount }}</div>
            </div>

        </div>

        {{-- FILTER --}}
        <form method="GET" action="{{ route('admin.booking.index') }}"
            class="bg-gradient-to-br from-[#141c2b] to-[#111827] border border-white/[0.06] rounded-[20px] px-5 py-4 flex gap-3 flex-wrap items-center">

            <div class="relative flex-1 min-w-[200px]">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 text-xs"></i>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari kode booking atau nama user..."
                    class="w-full h-9 bg-white/[0.05] border border-white/[0.08] rounded-xl pl-9 pr-3 text-[13px] text-white placeholder-slate-500 outline-none focus:border-green/40">
            </div>

            <select name="status"
                class="h-9 border border-white/[0.08] rounded-xl px-3 text-[13px] text-white min-w-[160px] outline-none focus:border-green/40"
                style="background-color:#111827; color-scheme:dark;">
                <option value="">Semua Status</option>
                <option value="menunggu" {{ request('status') === 'menunggu' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                <option value="menunggu_verifikasi" {{ request('status') === 'menunggu_verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                <option value="dp" {{ request('status') === 'dp' ? 'selected' : '' }}>DP Aktif</option>
                <option value="dikonfirmasi" {{ request('status') === 'dikonfirmasi' ? 'selected' : '' }}>Dikonfirmasi</option>
                <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="dibatalkan" {{ request('status') === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
            </select>

            <button type="submit"
                class="h-9 px-5 bg-green text-[#0b1120] rounded-xl text-[13px] font-bold hover:opacity-90 transition">
                <i class="fa-solid fa-filter mr-1"></i> Filter
            </button>
            @if (request('search') || request('status'))
                <a href="{{ route('admin.booking.index') }}"
                    class="h-9 px-4 bg-white/[0.05] border border-white/[0.08] rounded-xl text-[13px] text-slate-400 flex items-center hover:text-white transition no-underline">
                    Reset
                </a>
            @endif
        </form>

        {{-- TABLE --}}
        <div
            class="bg-gradient-to-br from-[#141c2b] to-[#111827] border border-white/[0.06] rounded-[24px] overflow-hidden">

            <div class="overflow-x-auto">
                <table class="w-full border-collapse min-w-[800px]">
                    <thead>
                        <tr>
                            <th
                                class="text-left px-6 py-4 text-[11px] text-[#7c879f] font-extrabold uppercase tracking-wider border-b border-white/[0.05]">
                                Customer / Kode</th>
                            <th
                                class="text-left px-6 py-4 text-[11px] text-[#7c879f] font-extrabold uppercase tracking-wider border-b border-white/[0.05]">
                                Fasilitas</th>
                            <th
                                class="text-left px-6 py-4 text-[11px] text-[#7c879f] font-extrabold uppercase tracking-wider border-b border-white/[0.05]">
                                Jadwal</th>
                            <th
                                class="text-left px-6 py-4 text-[11px] text-[#7c879f] font-extrabold uppercase tracking-wider border-b border-white/[0.05]">
                                Total</th>
                            <th
                                class="text-left px-6 py-4 text-[11px] text-[#7c879f] font-extrabold uppercase tracking-wider border-b border-white/[0.05]">
                                Status</th>
                            <th
                                class="text-center px-6 py-4 text-[11px] text-[#7c879f] font-extrabold uppercase tracking-wider border-b border-white/[0.05]">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/[0.04]">
                        @forelse($bookings as $booking)
                            @php
                                $detail = $booking->detailBooking?->first();

                                $statusConfig = match ($booking->status_booking) {
                                    'menunggu' => [
                                        'bg-yellow/[0.12] text-yellow border-yellow/20',
                                        '● Menunggu Konfirmasi',
                                    ],
                                    'menunggu_verifikasi' => [
                                        'bg-purple/[0.12] text-purple border-purple/30',
                                        '● Perlu Verifikasi',
                                    ],
                                    'dp' => ['bg-yellow/[0.12] text-yellow border-yellow/30', '● DP Aktif'],
                                    'dikonfirmasi' => ['bg-blue/[0.12] text-blue border-blue/20', '● Dikonfirmasi'],
                                    'selesai' => ['bg-green/[0.12] text-green border-green/20', '● Selesai'],
                                    'dibatalkan' => ['bg-red/[0.12] text-red border-red/20', '● Dibatalkan'],
                                    default => [
                                        'bg-white/[0.05] text-slate-400 border-white/10',
                                        $booking->status_booking,
                                    ],
                                };
                            @endphp
                            <tr class="group hover:bg-white/[0.02] transition-colors">

                                <td class="px-6 py-4 border-b border-white/[0.04]">
                                    <div class="text-green font-extrabold text-[12px] font-mono mb-0.5">
                                        #{{ strtoupper($booking->kode_booking) }}
                                    </div>
                                    <div class="text-white font-bold text-[14px]">{{ $booking->user?->name ?? 'Guest' }}
                                    </div>
                                    <div class="text-slate-500 text-[11px]">{{ ucfirst($booking->role_booker ?? '') }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 border-b border-white/[0.04]">
                                    <div class="text-white font-semibold text-[13px]">
                                        {{ $detail?->fasilitas?->nama ?? '-' }}
                                    </div>
                                    @if ($booking->detailBooking->count() > 1)
                                        <div class="text-slate-500 text-[11px]">+{{ $booking->detailBooking->count() - 1 }}
                                            lainnya</div>
                                    @endif
                                </td>

                                <td class="px-6 py-4 border-b border-white/[0.04]">
                                    @if ($detail)
                                        <div class="text-slate-300 text-[13px] font-medium">
                                            {{ $detail->tanggal instanceof \Carbon\Carbon ? $detail->tanggal->format('d M Y') : $detail->tanggal }}
                                        </div>
                                        <div class="text-yellow text-[12px] font-bold mt-0.5">
                                            <i class="fa-regular fa-clock mr-1"></i>
                                            {{ substr($detail->jam_mulai, 0, 5) }} –
                                            {{ substr($detail->jam_selesai, 0, 5) }} WIB
                                        </div>
                                    @else
                                        <span class="text-slate-600">–</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 border-b border-white/[0.04]">
                                    <div class="text-green font-extrabold text-[15px]">
                                        Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 border-b border-white/[0.04]">
                                    <span
                                        class="inline-flex items-center px-3 py-1.5 rounded-full text-[11px] font-bold border {{ $statusConfig[0] }}">
                                        {{ $statusConfig[1] }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 border-b border-white/[0.04]">
                                    <div class="flex gap-2 justify-center items-center">

                                        @if ($booking->status_booking === 'menunggu')
                                            <form action="{{ route('admin.booking.konfirmasi', $booking->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="w-[34px] h-[34px] rounded-[10px] bg-green/[0.1] border border-green/20 text-green flex items-center justify-center cursor-pointer transition hover:bg-green/20"
                                                    title="Konfirmasi Booking"
                                                    onclick="return confirm('Konfirmasi booking #{{ $booking->kode_booking }} sekarang?')">
                                                    <i class="fa-solid fa-check text-xs"></i>
                                                </button>
                                            </form>
                                        @endif

                                        @if ($booking->status_booking === 'dikonfirmasi')
                                            <form action="{{ route('admin.booking.updateStatus', $booking->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="selesai">
                                                <button type="submit"
                                                    class="w-[34px] h-[34px] rounded-[10px] bg-blue/[0.1] border border-blue/20 text-blue flex items-center justify-center cursor-pointer transition hover:bg-blue/20 hover:border-blue/40"
                                                    title="Tandai Main Selesai"
                                                    onclick="return confirm('User telah selesai bermain? Selesaikan transaksi booking #{{ $booking->kode_booking }}?')">
                                                    <i class="fa-solid fa-flag-checkered text-xs"></i>
                                                </button>
                                            </form>
                                        @endif

                                        <button type="button"
                                            onclick="launchDetailPopup('{{ route('admin.booking.show', $booking->id) }}')"
                                            class="w-[34px] h-[34px] rounded-[10px] bg-white/[0.05] border border-white/[0.08] text-slate-400 flex items-center justify-center cursor-pointer transition hover:bg-green/[0.15] hover:text-green hover:border-green/30"
                                            title="Detail">
                                            <i class="fa-solid fa-eye text-xs"></i>
                                        </button>

                                        <a href="{{ route('admin.booking.edit', $booking->id) }}"
                                            class="w-[34px] h-[34px] rounded-[10px] bg-white/[0.05] border border-white/[0.08] text-slate-400 flex items-center justify-center transition hover:bg-yellow/[0.15] hover:text-yellow hover:border-yellow/30"
                                            title="Edit">
                                            <i class="fa-solid fa-pen text-xs"></i>
                                        </a>

                                        <form action="{{ route('admin.booking.destroy', $booking->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin hapus booking {{ $booking->kode_booking }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-[34px] h-[34px] rounded-[10px] bg-white/[0.05] border border-white/[0.08] text-slate-400 flex items-center justify-center cursor-pointer transition hover:bg-red/[0.15] hover:text-red hover:border-red/30"
                                                title="Hapus">
                                                <i class="fa-solid fa-trash text-xs"></i>
                                            </button>
                                        </form>

                                    </div>
                                <td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-slate-500 text-[13px]">
                                    Tidak ada data booking yang tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($bookings->hasPages())
                <div class="flex justify-between items-center px-6 py-4 border-t border-white/[0.05]">
                    <span class="text-slate-500 text-xs">
                        Menampilkan {{ $bookings->firstItem() }}–{{ $bookings->lastItem() }}
                        dari {{ $bookings->total() }} data
                    </span>
                    {{ $bookings->appends(request()->query())->links() }}
                </div>
            @endif
        </div>

    </div>

    {{-- POPUP DETAIL --}}
    <div id="invoicePopupOverlay" onclick="dismissDetailPopup()"
        style="display:none; position:fixed; inset:0; background:rgba(5,9,20,0.88); backdrop-filter:blur(10px); z-index:999999; align-items:center; justify-content:center; padding:20px;">
        <div onclick="event.stopPropagation()"
            style="width:100%; max-width:900px; height:85vh; background:#0b0f1a; border-radius:24px; border:1px solid rgba(255,255,255,0.1); overflow:hidden; position:relative; display:flex; flex-direction:column; box-shadow:0 25px 50px -12px rgba(0,0,0,0.7);">
            <button onclick="dismissDetailPopup()"
                style="position:absolute; top:15px; right:20px; background:#1a2235; border:1px solid rgba(255,255,255,0.1); color:#fff; font-size:24px; width:40px; height:40px; border-radius:50%; cursor:pointer; display:flex; align-items:center; justify-content:center; z-index:10; transition:0.2s;"
                onmouseover="this.style.background='#fb7185'" onmouseout="this.style.background='#1a2235'">
                &times;
            </button>
            <iframe id="invoiceFrame" style="width:100%; height:100%; border:none; background:transparent;"
                src=""></iframe>
        </div>
    </div>

    <script>
        function launchDetailPopup(url) {
            const overlay = document.getElementById('invoicePopupOverlay');
            const iframe = document.getElementById('invoiceFrame');
            iframe.src = url;
            overlay.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function dismissDetailPopup() {
            const overlay = document.getElementById('invoicePopupOverlay');
            const iframe = document.getElementById('invoiceFrame');
            overlay.style.display = 'none';
            iframe.src = '';
            document.body.style.overflow = 'auto';
        }
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') dismissDetailPopup();
        });
    </script>

@endsection