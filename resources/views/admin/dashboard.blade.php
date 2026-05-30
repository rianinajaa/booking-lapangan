@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('breadcrumb')
    <span class="current">Analytics</span>
@endsection

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                fontFamily: { poppins: ['Poppins', 'sans-serif'] },
                colors: {
                    bg:     '#0b1120',
                    card:   '#111827',
                    card2:  '#1a2235',
                    green:  '#34f5a1',
                    blue:   '#4ea8ff',
                    yellow: '#facc15',
                    red:    '#fb7185',
                    purple: '#a78bfa',
                },
            }
        }
    }
</script>

<div class="font-poppins flex flex-col gap-[18px]">

    {{-- HEADER --}}
    <div class="flex justify-between items-start gap-5 flex-wrap">
        <div>
            <div class="text-[42px] font-extrabold text-white leading-tight mb-2">
                Dashboard Ringkasan
            </div>
            <div class="text-sm text-slate-400">
                Selamat datang kembali,
                <strong class="text-white">{{ auth()->user()->name }}</strong>.
                Berikut statistik arena hari ini.
            </div>
        </div>
        <div class="flex gap-3 flex-wrap">
            <a href="#"
                class="h-11 px-[18px] rounded-[14px] border border-white/[0.06] bg-white/[0.03] text-white flex items-center gap-2.5 text-[13px] font-bold no-underline transition-all duration-300 hover:-translate-y-0.5 hover:border-green/40">
                <i class="fa-regular fa-file-pdf"></i> Ekspor PDF
            </a>
            <a href="#"
                class="h-11 px-[18px] rounded-[14px] border border-white/[0.06] bg-white/[0.03] text-white flex items-center gap-2.5 text-[13px] font-bold no-underline transition-all duration-300 hover:-translate-y-0.5 hover:border-green/40">
                <i class="fa-regular fa-file-excel"></i> Ekspor Excel
            </a>
            <a href="{{ route('admin.booking.index') }}"
                class="h-11 px-[18px] rounded-[14px] bg-green text-[#08130f] flex items-center gap-2.5 text-[13px] font-bold no-underline transition-all duration-300 hover:-translate-y-0.5">
                + New Booking
            </a>
        </div>
    </div>

    {{-- STAT CARDS --}}
    <div class="grid grid-cols-[repeat(auto-fit,minmax(240px,1fr))] gap-[18px]">

        {{-- Pendapatan --}}
        <div class="relative overflow-hidden bg-gradient-to-br from-[#141c2b] to-[#111827] border border-green/[0.15] rounded-[22px] p-[22px] min-h-[180px]">
            <div class="absolute -top-10 -right-10 w-[110px] h-[110px] bg-green/10 rounded-full"></div>
            <div class="w-[42px] h-[42px] rounded-[14px] bg-green/[0.12] flex items-center justify-center mb-[18px]">
                <i class="fa-solid fa-sack-dollar text-green text-base"></i>
            </div>
            <div class="text-[#7c879f] text-[12px] font-extrabold uppercase tracking-[0.08em] mb-2">Total Pendapatan</div>
            <div class="text-white text-[32px] font-extrabold leading-none mb-3">
                Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
            </div>
            <div class="text-green text-sm font-bold">↑ {{ number_format($persenPendapatan,1) }}% bulan ini</div>
            <div class="w-full h-[5px] bg-white/[0.06] rounded-full overflow-hidden mt-[18px]">
                <div class="h-full rounded-full bg-green" style="width:72%"></div>
            </div>
        </div>

        {{-- Pengguna --}}
        <div class="relative overflow-hidden bg-gradient-to-br from-[#141c2b] to-[#111827] border border-green/[0.15] rounded-[22px] p-[22px] min-h-[180px]">
            <div class="absolute -top-10 -right-10 w-[110px] h-[110px] bg-green/10 rounded-full"></div>
            <div class="w-[42px] h-[42px] rounded-[14px] bg-green/[0.12] flex items-center justify-center mb-[18px]">
                <i class="fa-solid fa-users text-green text-base"></i>
            </div>
            <div class="text-[#7c879f] text-[12px] font-extrabold uppercase tracking-[0.08em] mb-2">Pengguna Aktif</div>
            <div class="text-white text-[32px] font-extrabold leading-none mb-3">{{ $totalUsers }}</div>
            <div class="text-green text-sm font-bold">User terdaftar aktif</div>
            <div class="w-full h-[5px] bg-white/[0.06] rounded-full overflow-hidden mt-[18px]">
                <div class="h-full rounded-full bg-green" style="width:82%"></div>
            </div>
        </div>

        {{-- Booking --}}
        <div class="relative overflow-hidden bg-gradient-to-br from-[#141c2b] to-[#111827] border border-green/[0.15] rounded-[22px] p-[22px] min-h-[180px]">
            <div class="absolute -top-10 -right-10 w-[110px] h-[110px] bg-green/10 rounded-full"></div>
            <div class="w-[42px] h-[42px] rounded-[14px] bg-green/[0.12] flex items-center justify-center mb-[18px]">
                <i class="fa-solid fa-calendar-check text-green text-base"></i>
            </div>
            <div class="text-[#7c879f] text-[12px] font-extrabold uppercase tracking-[0.08em] mb-2">Total Booking</div>
            <div class="text-white text-[32px] font-extrabold leading-none mb-3">{{ $totalBooking }}</div>
            <div class="text-green text-sm font-bold">↑ {{ number_format($persenBooking,1) }}% bulan ini</div>
            <div class="w-full h-[5px] bg-white/[0.06] rounded-full overflow-hidden mt-[18px]">
                <div class="h-full rounded-full bg-green" style="width:58%"></div>
            </div>
        </div>

        {{-- Okupansi + Perlu Tindakan --}}
        <div class="relative overflow-hidden bg-gradient-to-br from-[#141c2b] to-[#111827] border border-green/[0.15] rounded-[22px] p-[22px] min-h-[180px]">
            <div class="absolute -top-10 -right-10 w-[110px] h-[110px] bg-green/10 rounded-full"></div>

            {{-- Atas: Okupansi --}}
            <div class="w-[42px] h-[42px] rounded-[14px] bg-green/[0.12] flex items-center justify-center mb-[18px]">
                <i class="fa-solid fa-building text-green text-base"></i>
            </div>
            <div class="text-[#7c879f] text-[12px] font-extrabold uppercase tracking-[0.08em] mb-2">Okupansi Lapangan</div>
            <div class="text-white text-[32px] font-extrabold leading-none mb-2">
                {{ number_format($okupansi, 0) }}%
            </div>
            <div class="w-full h-[4px] bg-white/[0.06] rounded-full overflow-hidden mb-4">
                <div class="h-full rounded-full bg-green" style="width:{{ $okupansi }}%"></div>
            </div>

            {{-- Divider --}}
            <div class="border-t border-white/[0.06] mb-4"></div>

            {{-- Bawah: Data Pending --}}
            <div class="text-[#7c879f] text-[11px] font-extrabold uppercase tracking-[0.08em] mb-3">Data Pending</div>

            {{-- 2 angka kiri-kanan --}}
            <div class="grid grid-cols-2 gap-3 mb-3">
                <div>
                    <div class="text-[#7c879f] text-[10px] font-bold uppercase tracking-wider mb-1">Verif DP</div>
                    <div class="text-[22px] font-extrabold leading-none {{ $pendingPembayaran > 0 ? 'text-yellow' : 'text-green' }}">
                        {{ $pendingPembayaran }}
                    </div>
                </div>
                <div>
                    <div class="text-[#7c879f] text-[10px] font-bold uppercase tracking-wider mb-1">Booking Baru</div>
                    <div class="text-[22px] font-extrabold leading-none {{ $bookingMenunggu > 0 ? 'text-red' : 'text-green' }}">
                        {{ $bookingMenunggu }}
                    </div>
                </div>
            </div>

            {{-- 1 progress bar gabungan --}}
            @php
                $totalTindakan = $pendingPembayaran + $bookingMenunggu;
                $barColor = $totalTindakan === 0 ? 'bg-green' : ($pendingPembayaran > $bookingMenunggu ? 'bg-yellow' : 'bg-red');
                $barWidth = min($totalTindakan * 10, 100);
            @endphp
            <div class="w-full h-[4px] bg-white/[0.06] rounded-full overflow-hidden">
                <div class="h-full rounded-full {{ $barColor }}"
                    style="width:{{ $totalTindakan === 0 ? 10 : $barWidth }}%"></div>
            </div>
        </div>

    </div>

    {{-- CHART AREA --}}
    <div class="grid grid-cols-[1.5fr_0.8fr] gap-[18px] max-[1100px]:grid-cols-1">

        {{-- Line Chart --}}
        <div class="bg-gradient-to-br from-[#141c2b] to-[#111827] border border-white/[0.06] rounded-[24px] p-[22px]">
            <div class="flex justify-between items-center mb-[18px]">
                <div>
                    <div class="text-white text-[28px] font-extrabold">Tren Pendapatan & Booking</div>
                    <div class="text-slate-400 text-[13px] mt-1">7 hari terakhir</div>
                </div>
            </div>
            <div id="realtimeChart" style="height:320px;"></div>
        </div>

        {{-- Donut Chart --}}
        <div class="bg-gradient-to-br from-[#141c2b] to-[#111827] border border-white/[0.06] rounded-[24px] p-[22px]">
            <div class="flex justify-between items-center mb-[18px]">
                <div>
                    <div class="text-white text-[22px] font-extrabold">Distribusi Fasilitas</div>
                    <div class="text-slate-400 text-[13px] mt-1">Berdasarkan jenis fasilitas</div>
                </div>
            </div>
            <div id="facilityChart" class="flex items-center justify-center" style="height:320px;"></div>
        </div>

    </div>

    {{-- TABLE RECENT --}}
    <div class="bg-gradient-to-br from-[#141c2b] to-[#111827] border border-white/[0.06] rounded-[24px] p-[22px]">
        <div class="flex justify-between items-center mb-[18px]">
            <div>
                <div class="text-white text-[28px] font-extrabold">Booking Terbaru</div>
                <div class="text-slate-400 text-[13px] mt-1">5 transaksi terakhir</div>
            </div>
            <a href="{{ route('admin.booking.index') }}"
                class="h-11 px-[18px] rounded-[14px] border border-white/[0.06] bg-white/[0.03] text-white flex items-center gap-2.5 text-[13px] font-bold no-underline transition-all duration-300 hover:-translate-y-0.5 hover:border-green/40">
                Lihat Semua →
            </a>
        </div>

        <div class="overflow-auto">
            <table class="w-full border-collapse min-w-[760px]">
                <thead>
                    <tr>
                        <th class="text-left px-3.5 py-3.5 text-[12px] text-[#7c879f] uppercase border-b border-white/[0.05]">ID / Pemesan</th>
                        <th class="text-left px-3.5 py-3.5 text-[12px] text-[#7c879f] uppercase border-b border-white/[0.05]">Fasilitas</th>
                        <th class="text-left px-3.5 py-3.5 text-[12px] text-[#7c879f] uppercase border-b border-white/[0.05]">Jadwal</th>
                        <th class="text-left px-3.5 py-3.5 text-[12px] text-[#7c879f] uppercase border-b border-white/[0.05]">Status</th>
                        <th class="text-left px-3.5 py-3.5 text-[12px] text-[#7c879f] uppercase border-b border-white/[0.05]">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentBookings as $booking)
                        <tr>
                            <td class="px-3.5 py-4 border-b border-white/[0.04] text-slate-300 text-sm">
                                <div class="text-green font-extrabold mb-1">
                                    #{{ strtoupper(substr($booking->kode_booking,-6)) }}
                                </div>
                                <div class="text-white font-bold">{{ $booking->user->name }}</div>
                            </td>
                            <td class="px-3.5 py-4 border-b border-white/[0.04] text-slate-300 text-sm">
                                {{ $booking->detailBooking->first()?->fasilitas?->nama ?? '-' }}
                            </td>
                            <td class="px-3.5 py-4 border-b border-white/[0.04] text-slate-300 text-sm">
                                {{ \Carbon\Carbon::parse($booking->created_at)->translatedFormat('d M Y, H:i') }}
                            </td>
                            <td class="px-3.5 py-4 border-b border-white/[0.04]">
                                @php
                                    $statusClass = match($booking->status_booking){
                                        'menunggu'     => 'bg-yellow/[0.12] text-yellow',
                                        'dikonfirmasi' => 'bg-green/[0.15] text-green',
                                        'dibatalkan'   => 'bg-red/[0.12] text-red',
                                        default        => 'bg-blue/[0.12] text-blue',
                                    };
                                    $statusLabel = match($booking->status_booking){
                                        'menunggu'     => '● Pending',
                                        'dikonfirmasi' => '● Verified',
                                        'dibatalkan'   => '● Cancelled',
                                        default        => '● Active',
                                    };
                                @endphp
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[12px] font-bold {{ $statusClass }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>
                            <td class="px-3.5 py-4 border-b border-white/[0.04]">
                                <div class="flex gap-2">
                                    <button class="w-[34px] h-[34px] border-none rounded-[10px] bg-white/[0.05] text-blue-200 flex items-center justify-center cursor-pointer transition-all duration-300 hover:bg-green/[0.15] hover:text-green">
                                        <i class="fa-solid fa-pen text-xs"></i>
                                    </button>
                                    <button class="w-[34px] h-[34px] border-none rounded-[10px] bg-white/[0.05] text-blue-200 flex items-center justify-center cursor-pointer transition-all duration-300 hover:bg-green/[0.15] hover:text-green">
                                        <i class="fa-solid fa-eye text-xs"></i>
                                    </button>
                                    <button class="w-[34px] h-[34px] border-none rounded-[10px] bg-white/[0.05] text-blue-200 flex items-center justify-center cursor-pointer transition-all duration-300 hover:bg-green/[0.15] hover:text-green">
                                        <i class="fa-solid fa-trash text-xs"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-10 text-slate-400">
                                Belum ada booking
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- APEXCHARTS SCRIPT --}}
<script>
    const bookingData = @json($bookingChart);
    const incomeData  = @json($incomeChart);

    const categories   = bookingData.map(item => item.tanggal);
    const bookingSeries = bookingData.map(item => item.total);
    const incomeSeries  = incomeData.map(item => parseFloat(item.total));

    new ApexCharts(document.querySelector("#realtimeChart"), {
        chart: { type: 'area', height: 320, toolbar: { show: false }, background: 'transparent' },
        theme: { mode: 'dark' },
        colors: ['#34f5a1','#4ea8ff'],
        series: [
            { name: 'Pendapatan', data: incomeSeries },
            { name: 'Booking',    data: bookingSeries }
        ],
        stroke: { curve: 'smooth', width: 4 },
        fill: { type: 'gradient', gradient: { opacityFrom: 0.45, opacityTo: 0.05 } },
        dataLabels: { enabled: false },
        grid: { borderColor: 'rgba(255,255,255,.06)' },
        xaxis: { categories, labels: { style: { colors: '#94a3b8' } } },
        yaxis: {
            labels: {
                style: { colors: '#94a3b8' },
                formatter: v => "Rp " + v.toLocaleString('id-ID')
            }
        },
        tooltip: {
            theme: 'dark',
            y: {
                formatter: (v, { seriesIndex }) =>
                    seriesIndex === 0
                        ? "Rp " + v.toLocaleString('id-ID')
                        : v + " Booking"
            }
        },
        legend: { labels: { colors: '#cbd5e1' } }
    }).render();

    const facilityData = @json($facilityChart);
    new ApexCharts(document.querySelector("#facilityChart"), {
        chart: { type: 'donut', height: 320, background: 'transparent' },
        series: facilityData.map(i => i.total),
        labels:  facilityData.map(i => i.jenis),
        theme: { mode: 'dark' },
        colors: ['#34f5a1','#4ea8ff','#facc15','#a78bfa','#fb7185'],
        stroke: { width: 0 },
        plotOptions: { pie: { donut: { size: '72%' } } },
        legend: { position: 'bottom', fontSize: '13px', labels: { colors: '#cbd5e1' } },
        dataLabels: { enabled: false },
        tooltip: { theme: 'dark' }
    }).render();
</script>

@endsection