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
                Manajemen <span class="text-green">Pembayaran</span>
            </h1>
            <p class="text-slate-400 text-sm mt-1">Verifikasi dan pantau seluruh transaksi pembayaran.</p>
        </div>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="flex items-center gap-3 bg-green/10 border border-green/25 text-green rounded-2xl px-4 py-3 text-sm font-semibold">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    {{-- STAT CARDS --}}
    <div class="grid grid-cols-[repeat(auto-fit,minmax(200px,1fr))] gap-4">

        {{-- Total Tagihan --}}
        <div class="relative overflow-hidden bg-gradient-to-br from-[#141c2b] to-[#111827] border border-green/[0.15] rounded-[20px] p-5">
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
        <div class="relative overflow-hidden bg-gradient-to-br from-[#141c2b] to-[#111827] border border-green/[0.15] rounded-[20px] p-5">
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
        <div class="relative overflow-hidden bg-gradient-to-br from-[#141c2b] to-[#111827] border border-green/[0.15] rounded-[20px] p-5">
            <div class="absolute -top-8 -right-8 w-24 h-24 bg-yellow/10 rounded-full"></div>
            <div class="w-10 h-10 rounded-[12px] bg-yellow/[0.12] flex items-center justify-center mb-4">
                <i class="fa-solid fa-clock text-yellow text-sm"></i>
            </div>
            <div class="text-[#7c879f] text-[11px] font-extrabold uppercase tracking-wider mb-1">DP Masuk</div>
            <div class="text-yellow text-2xl font-extrabold leading-none">
                Rp {{ number_format($totalDp, 0, ',', '.') }}
            </div>
            <div class="text-slate-500 text-xs mt-2">{{ $countPending }} menunggu verifikasi lunas</div>
        </div>

        {{-- Belum Bayar --}}
        <div class="relative overflow-hidden bg-gradient-to-br from-[#141c2b] to-[#111827] border border-green/[0.15] rounded-[20px] p-5">
            <div class="absolute -top-8 -right-8 w-24 h-24 bg-red/10 rounded-full"></div>
            <div class="w-10 h-10 rounded-[12px] bg-red/[0.12] flex items-center justify-center mb-4">
                <i class="fa-solid fa-triangle-exclamation text-red text-sm"></i>
            </div>
            <div class="text-[#7c879f] text-[11px] font-extrabold uppercase tracking-wider mb-1">Belum Bayar</div>
            <div class="text-red text-2xl font-extrabold leading-none">{{ $countBelum }}</div>
            <div class="text-slate-500 text-xs mt-2">Transaksi belum dibayar</div>
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
            style="background-color:#111827; color-scheme:dark;"
            class="h-9 border border-white/[0.08] rounded-xl px-3 text-[13px] text-white min-w-[150px] outline-none focus:border-green/40">
            <option value=""           style="background:#111827; color:#f8fafc;">Semua Status</option>
            <option value="belum_bayar" style="background:#111827; color:#fb7185;" {{ request('status') === 'belum_bayar' ? 'selected' : '' }}>Belum Bayar</option>
            <option value="dp"          style="background:#111827; color:#facc15;" {{ request('status') === 'dp'          ? 'selected' : '' }}>DP</option>
            <option value="lunas"       style="background:#111827; color:#34f5a1;" {{ request('status') === 'lunas'       ? 'selected' : '' }}>Lunas</option>
        </select>

        <select name="metode"
            style="background-color:#111827; color-scheme:dark;"
            class="h-9 border border-white/[0.08] rounded-xl px-3 text-[13px] text-white min-w-[140px] outline-none focus:border-green/40">
            <option value=""         style="background:#111827; color:#f8fafc;">Semua Metode</option>
            <option value="transfer" style="background:#111827; color:#f8fafc;" {{ request('metode') === 'transfer' ? 'selected' : '' }}>Transfer</option>
            <option value="cash"     style="background:#111827; color:#f8fafc;" {{ request('metode') === 'cash'     ? 'selected' : '' }}>Cash</option>
        </select>

        <button type="submit"
            class="h-9 px-5 bg-green text-[#08130f] rounded-xl text-[13px] font-bold hover:opacity-90 transition">
            Terapkan
        </button>
        @if(request('search') || request('status') || request('metode'))
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
                $booking  = $p->booking;
                $user     = $booking?->user;
                $fasilitas = $booking?->detailBooking->first()?->fasilitas;

                $statusConfig = match($p->status_bayar) {
                    'lunas'       => ['bg-green/[0.12] text-green border-green/20',   'fa-circle-check',        'Lunas'],
                    'dp'          => ['bg-yellow/[0.12] text-yellow border-yellow/20','fa-clock',               'DP'],
                    'belum_bayar' => ['bg-red/[0.12] text-red border-red/20',         'fa-triangle-exclamation','Belum Bayar'],
                    default       => ['bg-white/[0.05] text-slate-400 border-white/10','fa-question',           $p->status_bayar],
                };

                $borderGlow = match($p->status_bayar) {
                    'lunas'       => 'hover:border-green/30 hover:shadow-[0_0_20px_rgba(52,245,161,0.06)]',
                    'dp'          => 'hover:border-yellow/30 hover:shadow-[0_0_20px_rgba(250,204,21,0.06)]',
                    'belum_bayar' => 'hover:border-red/30 hover:shadow-[0_0_20px_rgba(251,113,133,0.06)]',
                    default       => 'hover:border-white/10',
                };
            @endphp

            <div class="bg-gradient-to-br from-[#141c2b] to-[#111827] border border-white/[0.06] rounded-[20px] px-6 py-5 flex items-center gap-5 transition-all duration-300 {{ $borderGlow }} flex-wrap">

                {{-- Kiri: Icon status --}}
                <div class="w-12 h-12 rounded-[14px] {{ explode(' ', $statusConfig[0])[0] }} border {{ explode(' ', $statusConfig[0])[2] }} flex items-center justify-center flex-shrink-0">
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

                {{-- Metode --}}
                <div class="text-center min-w-[80px]">
                    <div class="text-[#7c879f] text-[10px] font-bold uppercase tracking-wider mb-1">Metode</div>
                    <div class="text-white text-[13px] font-semibold capitalize">{{ $p->metode }}</div>
                </div>

                {{-- Nominal DP --}}
                <div class="text-center min-w-[120px]">
                    <div class="text-[#7c879f] text-[10px] font-bold uppercase tracking-wider mb-1">DP</div>
                    <div class="text-yellow text-[14px] font-bold">
                        Rp {{ number_format($p->nominal_dp, 0, ',', '.') }}
                    </div>
                    @if($p->waktu_dp)
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
                    @if($p->waktu_lunas)
                        <div class="text-slate-500 text-[11px] mt-0.5">
                            Lunas {{ \Carbon\Carbon::parse($p->waktu_lunas)->format('d M Y') }}
                        </div>
                    @endif
                </div>

                {{-- Status badge --}}
                <div class="min-w-[100px] flex justify-center">
                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-[12px] font-bold border {{ $statusConfig[0] }}">
                        <i class="fa-solid {{ $statusConfig[1] }} text-[10px]"></i>
                        {{ $statusConfig[2] }}
                    </span>
                </div>

                {{-- Aksi --}}
                <div class="flex gap-2 flex-shrink-0">
                    @if($p->status_bayar === 'belum_bayar')
                        <form action="{{ route('admin.pembayaran.verifikasi-dp', $p->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                class="h-9 px-4 bg-yellow/[0.12] border border-yellow/20 text-yellow rounded-xl text-[12px] font-bold hover:bg-yellow/20 transition"
                                onclick="return confirm('Verifikasi DP untuk booking ini?')">
                                <i class="fa-solid fa-check mr-1"></i> Verif DP
                            </button>
                        </form>
                    @elseif($p->status_bayar === 'dp')
                        <form action="{{ route('admin.pembayaran.verifikasi-lunas', $p->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                class="h-9 px-4 bg-green/[0.12] border border-green/20 text-green rounded-xl text-[12px] font-bold hover:bg-green/20 transition"
                                onclick="return confirm('Tandai pembayaran ini sebagai lunas?')">
                                <i class="fa-solid fa-check-double mr-1"></i> Verif Lunas
                            </button>
                        </form>
                    @else
                        <div class="h-9 px-4 bg-white/[0.03] border border-white/[0.06] text-slate-600 rounded-xl text-[12px] font-bold flex items-center">
                            <i class="fa-solid fa-lock mr-1"></i> Selesai
                        </div>
                    @endif
                </div>

            </div>
        @empty
            <div class="bg-gradient-to-br from-[#141c2b] to-[#111827] border border-white/[0.06] rounded-[20px] py-16 text-center">
                <i class="fa-solid fa-receipt text-4xl text-slate-700 mb-4 block"></i>
                <div class="text-slate-400 text-sm">Belum ada data pembayaran</div>
            </div>
        @endforelse

    </div>

    {{-- PAGINATION --}}
    @if($pembayarans->hasPages())
        <div class="flex justify-between items-center px-1">
            <span class="text-slate-500 text-xs">
                Menampilkan {{ $pembayarans->firstItem() }}–{{ $pembayarans->lastItem() }}
                dari {{ $pembayarans->total() }} transaksi
            </span>
            {{ $pembayarans->withQueryString()->links() }}
        </div>
    @endif

</div>
@endsection