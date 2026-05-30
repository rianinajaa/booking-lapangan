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
                fontFamily: { poppins: ['Poppins', 'sans-serif'] },
                colors: {
                    green:  '#34f5a1',
                    yellow: '#facc15',
                    red:    '#fb7185',
                    blue:   '#4ea8ff',
                    purple: '#a78bfa',
                }
            }
        }
    }
</script>

<div class="font-poppins flex flex-col gap-5">

    {{-- HEADER --}}
    <div class="flex justify-between items-start flex-wrap gap-3">
        <div>
            <h1 class="text-[36px] font-extrabold text-white leading-tight">
                Manajemen <span class="text-green">Booking</span>
            </h1>
            <p class="text-slate-400 text-sm mt-1">Kelola dan pantau seluruh data pemesanan fasilitas.</p>
        </div>
        <a href="{{ route('admin.booking.create') }}"
            class="h-11 px-5 bg-green text-[#0b1120] rounded-[14px] text-[13px] font-bold flex items-center gap-2 no-underline hover:opacity-90 transition">
            <i class="fa-solid fa-plus"></i> Tambah Booking
        </a>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="flex items-center gap-3 bg-green/10 border border-green/25 text-green rounded-2xl px-4 py-3 text-sm font-semibold">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    {{-- STAT CARDS --}}
    @php
        $totalBooking    = $bookings->total();
        $menungguCount   = \App\Models\Booking::where('status_booking','menunggu')->count();
        $konfirmasiCount = \App\Models\Booking::where('status_booking','dikonfirmasi')->count();
        $selesaiCount    = \App\Models\Booking::where('status_booking','selesai')->count();
    @endphp
    <div class="grid grid-cols-[repeat(auto-fit,minmax(180px,1fr))] gap-4">

        <div class="relative overflow-hidden bg-gradient-to-br from-[#141c2b] to-[#111827] border border-green/[0.15] rounded-[20px] p-5">
            <div class="absolute -top-8 -right-8 w-24 h-24 bg-green/10 rounded-full"></div>
            <div class="w-10 h-10 rounded-[12px] bg-green/[0.12] flex items-center justify-center mb-3">
                <i class="fa-solid fa-calendar-check text-green text-sm"></i>
            </div>
            <div class="text-[#7c879f] text-[11px] font-extrabold uppercase tracking-wider mb-1">Total Booking</div>
            <div class="text-white text-2xl font-extrabold">{{ $totalBooking }}</div>
        </div>

        <div class="relative overflow-hidden bg-gradient-to-br from-[#141c2b] to-[#111827] border border-yellow/[0.15] rounded-[20px] p-5">
            <div class="absolute -top-8 -right-8 w-24 h-24 bg-yellow/10 rounded-full"></div>
            <div class="w-10 h-10 rounded-[12px] bg-yellow/[0.12] flex items-center justify-center mb-3">
                <i class="fa-solid fa-clock text-yellow text-sm"></i>
            </div>
            <div class="text-[#7c879f] text-[11px] font-extrabold uppercase tracking-wider mb-1">Menunggu</div>
            <div class="text-yellow text-2xl font-extrabold">{{ $menungguCount }}</div>
        </div>

        <div class="relative overflow-hidden bg-gradient-to-br from-[#141c2b] to-[#111827] border border-green/[0.15] rounded-[20px] p-5">
            <div class="absolute -top-8 -right-8 w-24 h-24 bg-green/10 rounded-full"></div>
            <div class="w-10 h-10 rounded-[12px] bg-green/[0.12] flex items-center justify-center mb-3">
                <i class="fa-solid fa-circle-check text-green text-sm"></i>
            </div>
            <div class="text-[#7c879f] text-[11px] font-extrabold uppercase tracking-wider mb-1">Dikonfirmasi</div>
            <div class="text-green text-2xl font-extrabold">{{ $konfirmasiCount }}</div>
        </div>

        <div class="relative overflow-hidden bg-gradient-to-br from-[#141c2b] to-[#111827] border border-green/[0.15] rounded-[20px] p-5">
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
            style="background-color:#111827; color-scheme:dark;"
            class="h-9 border border-white/[0.08] rounded-xl px-3 text-[13px] text-white min-w-[160px] outline-none focus:border-green/40">
            <option value=""              style="background:#111827;">Semua Status</option>
            <option value="menunggu"      style="background:#111827; color:#facc15;" {{ request('status') === 'menunggu'      ? 'selected' : '' }}>Menunggu</option>
            <option value="dikonfirmasi"  style="background:#111827; color:#4ea8ff;" {{ request('status') === 'dikonfirmasi'  ? 'selected' : '' }}>Dikonfirmasi</option>
            <option value="selesai"       style="background:#111827; color:#34f5a1;" {{ request('status') === 'selesai'       ? 'selected' : '' }}>Selesai</option>
            <option value="dibatalkan"    style="background:#111827; color:#fb7185;" {{ request('status') === 'dibatalkan'    ? 'selected' : '' }}>Dibatalkan</option>
        </select>

        <button type="submit"
            class="h-9 px-5 bg-green text-[#0b1120] rounded-xl text-[13px] font-bold hover:opacity-90 transition">
            <i class="fa-solid fa-filter mr-1"></i> Filter
        </button>
        @if(request('search') || request('status'))
            <a href="{{ route('admin.booking.index') }}"
                class="h-9 px-4 bg-white/[0.05] border border-white/[0.08] rounded-xl text-[13px] text-slate-400 flex items-center hover:text-white transition no-underline">
                Reset
            </a>
        @endif
    </form>

    {{-- TABLE --}}
    <div class="bg-gradient-to-br from-[#141c2b] to-[#111827] border border-white/[0.06] rounded-[24px] overflow-hidden">

        <div class="overflow-x-auto">
            <table class="w-full border-collapse min-w-[800px]">
                <thead>
                    <tr>
                        <th class="text-left px-6 py-4 text-[11px] text-[#7c879f] font-extrabold uppercase tracking-wider border-b border-white/[0.05]">Customer / Kode</th>
                        <th class="text-left px-6 py-4 text-[11px] text-[#7c879f] font-extrabold uppercase tracking-wider border-b border-white/[0.05]">Fasilitas</th>
                        <th class="text-left px-6 py-4 text-[11px] text-[#7c879f] font-extrabold uppercase tracking-wider border-b border-white/[0.05]">Jadwal</th>
                        <th class="text-left px-6 py-4 text-[11px] text-[#7c879f] font-extrabold uppercase tracking-wider border-b border-white/[0.05]">Total</th>
                        <th class="text-left px-6 py-4 text-[11px] text-[#7c879f] font-extrabold uppercase tracking-wider border-b border-white/[0.05]">Status</th>
                        <th class="text-center px-6 py-4 text-[11px] text-[#7c879f] font-extrabold uppercase tracking-wider border-b border-white/[0.05]">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        @php
                            $detail = $booking->detailBooking?->first();
                            $statusConfig = match($booking->status_booking) {
                                'menunggu'    => ['bg-yellow/[0.12] text-yellow border-yellow/20',  '● Menunggu'],
                                'dikonfirmasi'=> ['bg-green/[0.12] text-green border-green/20',        '● Dikonfirmasi'],
                                'selesai'     => ['bg-green/[0.12] text-green border-green/20',     '● Selesai'],
                                'dibatalkan'  => ['bg-red/[0.12] text-red border-red/20',           '● Dibatalkan'],
                                default       => ['bg-white/[0.05] text-slate-400 border-white/10', $booking->status_booking],
                            };
                        @endphp
                        <tr class="group hover:bg-white/[0.02] transition-colors">

                            {{-- Customer / Kode --}}
                            <td class="px-6 py-4 border-b border-white/[0.04]">
                                <div class="text-green font-extrabold text-[12px] font-mono mb-0.5">
                                    #{{ strtoupper($booking->kode_booking) }}
                                </div>
                                <div class="text-white font-bold text-[14px]">{{ $booking->user?->name ?? 'Guest' }}</div>
                                <div class="text-slate-500 text-[11px]">{{ ucfirst($booking->role_booker ?? '') }}</div>
                            </td>

                            {{-- Fasilitas --}}
                            <td class="px-6 py-4 border-b border-white/[0.04]">
                                <div class="text-white font-semibold text-[13px]">
                                    {{ $detail?->fasilitas?->nama ?? '-' }}
                                </div>
                                @if($booking->detailBooking->count() > 1)
                                    <div class="text-slate-500 text-[11px]">+{{ $booking->detailBooking->count() - 1 }} lainnya</div>
                                @endif
                            </td>

                            {{-- Jadwal --}}
                            <td class="px-6 py-4 border-b border-white/[0.04]">
                                @if($detail)
                                    <div class="text-slate-300 text-[13px] font-medium">
                                        {{ $detail->tanggal instanceof \Carbon\Carbon ? $detail->tanggal->format('d M Y') : $detail->tanggal }}
                                    </div>
                                    <div class="text-yellow text-[12px] font-bold mt-0.5">
                                        <i class="fa-regular fa-clock mr-1"></i>
                                        {{ substr($detail->jam_mulai, 0, 5) }} – {{ substr($detail->jam_selesai, 0, 5) }} WIB
                                    </div>
                                @else
                                    <span class="text-slate-600">–</span>
                                @endif
                            </td>

                            {{-- Total --}}
                            <td class="px-6 py-4 border-b border-white/[0.04]">
                                <div class="text-green font-extrabold text-[15px]">
                                    Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                                </div>
                                @if($booking->diskon_persen > 0)
                                    <div class="text-slate-500 text-[11px]">Diskon {{ $booking->diskon_persen }}%</div>
                                @endif
                            </td>

                            {{-- Status --}}
                            <td class="px-6 py-4 border-b border-white/[0.04]">
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-[11px] font-bold border {{ $statusConfig[0] }}">
                                    {{ $statusConfig[1] }}
                                </span>
                            </td>

                            {{-- Aksi --}}
                            <td class="px-6 py-4 border-b border-white/[0.04]">
                                <div class="flex gap-2 justify-center">
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
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="w-[34px] h-[34px] rounded-[10px] bg-white/[0.05] border border-white/[0.08] text-slate-400 flex items-center justify-center cursor-pointer transition hover:bg-red/[0.15] hover:text-red hover:border-red/30"
                                            title="Hapus">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-16 text-slate-500">
                                <i class="fa-solid fa-calendar-xmark text-4xl opacity-30 block mb-3"></i>
                                Belum ada data booking
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($bookings->hasPages())
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
            onmouseover="this.style.background='#fb7185'"
            onmouseout="this.style.background='#1a2235'">
            &times;
        </button>
        <iframe id="invoiceFrame" style="width:100%; height:100%; border:none; background:transparent;" src=""></iframe>
    </div>
</div>

<script>
    function launchDetailPopup(url) {
        const overlay = document.getElementById('invoicePopupOverlay');
        const iframe  = document.getElementById('invoiceFrame');
        iframe.src = url;
        overlay.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
    function dismissDetailPopup() {
        const overlay = document.getElementById('invoicePopupOverlay');
        const iframe  = document.getElementById('invoiceFrame');
        overlay.style.display = 'none';
        iframe.src = '';
        document.body.style.overflow = 'auto';
    }
    document.addEventListener('keydown', e => { if (e.key === 'Escape') dismissDetailPopup(); });
</script>

@endsection