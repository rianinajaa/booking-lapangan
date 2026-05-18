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

<style>

    *{
        font-family:'Poppins',sans-serif;
    }

    :root{
        --bg:#0b1120;
        --card:#111827;
        --card2:#1a2235;
        --border:rgba(255,255,255,.06);
        --text:#f8fafc;
        --text2:#cbd5e1;
        --text3:#94a3b8;
        --green:#34f5a1;
        --blue:#4ea8ff;
        --yellow:#facc15;
        --red:#fb7185;
        --purple:#a78bfa;
    }

    .dashboard-wrap{
        display:flex;
        flex-direction:column;
        gap:18px;
    }

    .topbar-dashboard{
        display:flex;
        justify-content:space-between;
        align-items:flex-start;
        gap:20px;
        flex-wrap:wrap;
    }

    .dashboard-title{
        font-size:42px;
        font-weight:800;
        color:var(--text);
        line-height:1.1;
        margin-bottom:8px;
    }

    .dashboard-subtitle{
        font-size:14px;
        color:var(--text3);
    }

    .dashboard-actions{
        display:flex;
        gap:12px;
        flex-wrap:wrap;
    }

    .glass-btn{
        height:44px;
        padding:0 18px;
        border-radius:14px;
        border:1px solid var(--border);
        background:rgba(255,255,255,.03);
        color:var(--text);
        display:flex;
        align-items:center;
        gap:10px;
        font-size:13px;
        font-weight:700;
        text-decoration:none;
        transition:.25s;
    }

    .glass-btn:hover{
        transform:translateY(-2px);
        border-color:rgba(52,245,161,.4);
        color:white;
    }

    .glass-btn.green{
        background:var(--green);
        color:#08130f;
        border:none;
    }

    .stats-grid{
        display:grid;
        grid-template-columns:repeat(auto-fit,minmax(240px,1fr));
        gap:18px;
    }

    .analytics-card{
        position:relative;
        overflow:hidden;
        background:linear-gradient(145deg,#141c2b,#111827);
        border:1px solid rgba(52,245,161,.15);
        border-radius:22px;
        padding:22px;
        min-height:180px;
    }

    .analytics-card::before{
        content:'';
        position:absolute;
        top:-40px;
        right:-40px;
        width:110px;
        height:110px;
        background:rgba(52,245,161,.10);
        border-radius:50%;
    }

    .icon-box{
        width:42px;
        height:42px;
        border-radius:14px;
        background:rgba(52,245,161,.12);
        display:flex;
        align-items:center;
        justify-content:center;
        margin-bottom:18px;
    }

    .icon-box i{
        color:var(--green);
        font-size:16px;
    }

    .analytics-label{
        color:#7c879f;
        font-size:12px;
        font-weight:800;
        text-transform:uppercase;
        letter-spacing:.08em;
        margin-bottom:8px;
    }

    .analytics-value{
        color:white;
        font-size:32px; /* Disesuaikan sedikit agar nominal rupiah ribuan panjang tidak overflow */
        font-weight:800;
        line-height:1;
        margin-bottom:12px;
    }

    .analytics-growth{
        color:var(--green);
        font-size:14px;
        font-weight:700;
    }

    .analytics-growth.red{
        color:var(--red);
    }

    .progress-modern{
        width:100%;
        height:5px;
        background:rgba(255,255,255,.06);
        border-radius:999px;
        overflow:hidden;
        margin-top:18px;
    }

    .progress-modern div{
        height:100%;
        border-radius:999px;
        background:var(--green);
    }

    .content-grid{
        display:grid;
        grid-template-columns:1.5fr .8fr;
        gap:18px;
    }

    .modern-card{
        background:linear-gradient(145deg,#141c2b,#111827);
        border:1px solid var(--border);
        border-radius:24px;
        padding:22px;
    }

    /* HILANGKAN BACKGROUND / SHADOW SVG APEX */
    .apexcharts-canvas,
    .apexcharts-svg,
    .apexcharts-inner,
    .apexcharts-graphical,
    .apexcharts-datalabels-group,
    .apexcharts-legend{
        background:transparent !important;
    }

    /* DONUT CLEAN */
    #facilityChart{
        display:flex;
        align-items:center;
        justify-content:center;
    }

    #facilityChart .apexcharts-canvas{
        margin:auto;
    }

    /* HAPUS BORDER / SHADOW */
    .apexcharts-tooltip,
    .apexcharts-xaxistooltip,
    .apexcharts-yaxistooltip{
        background:#111827 !important;
        border:none !important;
        box-shadow:none !important;
    }

    .modern-header{
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom:18px;
    }

    .modern-title{
        color:white;
        font-size:28px;
        font-weight:800;
    }

    .modern-sub{
        color:var(--text3);
        font-size:13px;
        margin-top:4px;
    }

    .booking-table{
        width:100%;
        border-collapse:collapse;
    }

    .booking-table th{
        text-align:left;
        padding:14px;
        font-size:12px;
        color:#7c879f;
        text-transform:uppercase;
        border-bottom:1px solid rgba(255,255,255,.05);
    }

    .booking-table td{
        padding:16px 14px;
        border-bottom:1px solid rgba(255,255,255,.04);
        color:var(--text2);
        font-size:14px;
    }

    .booking-id{
        color:var(--green);
        font-weight:800;
        margin-bottom:4px;
    }

    .booking-user{
        color:white;
        font-weight:700;
    }

    .badge-modern{
        display:inline-flex;
        align-items:center;
        gap:6px;
        padding:7px 12px;
        border-radius:999px;
        font-size:12px;
        font-weight:700;
    }

    .badge-green{
        background:rgba(52,245,161,.15);
        color:var(--green);
    }

    .badge-yellow{
        background:rgba(250,204,21,.12);
        color:var(--yellow);
    }

    .badge-blue{
        background:rgba(78,168,255,.12);
        color:var(--blue);
    }

    .badge-red{
        background:rgba(251,113,133,.12);
        color:var(--red);
    }

    .action-group{
        display:flex;
        gap:8px;
    }

    .action-btn{
        width:34px;
        height:34px;
        border:none;
        border-radius:10px;
        background:rgba(255,255,255,.05);
        color:#dbeafe;
        display:flex;
        align-items:center;
        justify-content:center;
        cursor:pointer;
        transition:.25s;
    }

    .action-btn:hover{
        background:rgba(52,245,161,.15);
        color:var(--green);
    }

    @media(max-width:1100px){
        .content-grid{
            grid-template-columns:1fr;
        }
    }

    @media(max-width:768px){
        .dashboard-title{
            font-size:32px;
        }

        .analytics-value{
            font-size:34px;
        }

        .booking-table{
            min-width:760px;
        }

        .table-scroll{
            overflow:auto;
        }
    }

</style>

<div class="dashboard-wrap">

    {{-- HEADER --}}
    <div class="topbar-dashboard">
        <div>
            <div class="dashboard-title">
                Dashboard Ringkasan
            </div>
            <div class="dashboard-subtitle">
                Selamat datang kembali,
                <strong style="color:white;">
                    {{ auth()->user()->name }}
                </strong>.
                Berikut statistik arena hari ini.
            </div>
        </div>

        <div class="dashboard-actions">
            <a href="#" class="glass-btn">
                <i class="fa-regular fa-file-pdf"></i>
                Ekspor PDF
            </a>
            <a href="#" class="glass-btn">
                <i class="fa-regular fa-file-excel"></i>
                Ekspor Excel
            </a>
            <a href="{{ route('admin.booking.index') }}" class="glass-btn green">
                + New Booking
            </a>
        </div>
    </div>

    {{-- CARD STATS --}}
    <div class="stats-grid">

        {{-- PENDAPATAN (FIX RUPIAH REAL) --}}
        <div class="analytics-card">
            <div class="icon-box">
                <i class="fa-solid fa-sack-dollar"></i>
            </div>
            <div class="analytics-label">
                Total Pendapatan
            </div>
            <div class="analytics-value">
                Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
            </div>
            <div class="analytics-growth">
                ↑ {{ number_format($persenPendapatan,1) }}% bulan ini
            </div>
            <div class="progress-modern">
                <div style="width:72%"></div>
            </div>
        </div>

        {{-- USER --}}
        <div class="analytics-card">
            <div class="icon-box">
                <i class="fa-solid fa-users"></i>
            </div>
            <div class="analytics-label">
                Pengguna Aktif
            </div>
            <div class="analytics-value">
                {{ $totalUsers }}
            </div>
            <div class="analytics-growth">
                User terdaftar aktif
            </div>
            <div class="progress-modern">
                <div style="width:82%"></div>
            </div>
        </div>

        {{-- BOOKING --}}
        <div class="analytics-card">
            <div class="icon-box">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            <div class="analytics-label">
                Total Booking
            </div>
            <div class="analytics-value">
                {{ $totalBooking }}
            </div>
            <div class="analytics-growth">
                ↑ {{ number_format($persenBooking,1) }}% bulan ini
            </div>
            <div class="progress-modern">
                <div style="width:58%"></div>
            </div>
        </div>

        {{-- OKUPANSI --}}
        <div class="analytics-card">
            <div class="icon-box">
                <i class="fa-solid fa-building"></i>
            </div>
            <div class="analytics-label">
                Okupansi Lapangan
            </div>
            <div class="analytics-value">
                {{ number_format($okupansi,0) }}%
            </div>
            <div class="analytics-growth red">
                {{ $pendingPembayaran }} pembayaran pending
            </div>
            <div class="progress-modern">
                <div style="width:{{ $okupansi }}%"></div>
            </div>
        </div>

    </div>

    {{-- CHART AREA --}}
    <div class="content-grid">

        {{-- LINE CHART --}}
        <div class="modern-card">
            <div class="modern-header">
                <div>
                    <div class="modern-title">
                        Tren Pendapatan & Booking
                    </div>
                    <div class="modern-sub">
                        7 hari terakhir
                    </div>
                </div>
            </div>
            <div id="realtimeChart" style="height:320px;"></div>
        </div>

        {{-- DONUT --}}
        <div class="modern-card">
            <div class="modern-header">
                <div>
                    <div class="modern-title" style="font-size:22px;">
                        Distribusi Fasilitas
                    </div>
                    <div class="modern-sub">
                        Berdasarkan jenis fasilitas
                    </div>
                </div>
            </div>
            <div id="facilityChart" style="height:320px;"></div>
        </div>

    </div>

    {{-- TABLE RECENT --}}
    <div class="modern-card">
        <div class="modern-header">
            <div>
                <div class="modern-title" style="font-size:28px;">
                    Booking Terbaru
                </div>
                <div class="modern-sub">
                    5 transaksi terakhir
                </div>
            </div>
            <a href="{{ route('admin.booking.index') }}" class="glass-btn">
                Lihat Semua →
            </a>
        </div>

        <div class="table-scroll">
            <table class="booking-table">
                <thead>
                    <tr>
                        <th>ID / Pemesan</th>
                        <th>Fasilitas</th>
                        <th>Jadwal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentBookings as $booking)
                        <tr>
                            <td>
                                <div class="booking-id">
                                    #{{ strtoupper(substr($booking->kode_booking,-6)) }}
                                </div>
                                <div class="booking-user">
                                    {{ $booking->user->name }}
                                </div>
                            </td>
                            <td>
                                {{ $booking->detailBooking->first()?->fasilitas?->nama ?? '-' }}
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($booking->created_at)->translatedFormat('d M Y, H:i') }}
                            </td>
                            <td>
                                @php
                                    $status = match($booking->status_booking){
                                        'menunggu' => 'badge-yellow',
                                        'dikonfirmasi' => 'badge-green',
                                        'dibatalkan' => 'badge-red',
                                        default => 'badge-blue'
                                    };
                                @endphp

                                <span class="badge-modern {{ $status }}">
                                    @if($booking->status_booking == 'menunggu')
                                        ● Pending
                                    @elseif($booking->status_booking == 'dikonfirmasi')
                                        ● Verified
                                    @elseif($booking->status_booking == 'dibatalkan')
                                        ● Cancelled
                                    @else
                                        ● Active
                                    @endif
                                </span>
                            </td>
                            <td>
                                <div class="action-group">
                                    <button class="action-btn">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                    <button class="action-btn">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                    <button class="action-btn">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align:center; padding:40px;">
                                Belum ada booking
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- CONFIGURATION SCRIPT APEXCHARTS --}}
<script>
    const bookingData = @json($bookingChart);
    const incomeData = @json($incomeChart);

    const categories = bookingData.map(item => item.tanggal);
    const bookingSeries = bookingData.map(item => item.total);

    // FIX: Parsing nominal integer murni tanpa pembulatan string area
    const incomeSeries = incomeData.map(item => parseFloat(item.total));

    /* LINE & AREA CHART CONFIG */
    const options = {
        chart: {
            type: 'area',
            height: 320,
            toolbar: { show: false },
            background: 'transparent'
        },
        theme: { mode: 'dark' },
        colors: ['#34f5a1','#4ea8ff'],
        series: [
            {
                name: 'Pendapatan',
                data: incomeSeries
            },
            {
                name: 'Booking',
                data: bookingSeries
            }
        ],
        stroke: { curve: 'smooth', width: 4 },
        fill: {
            type: 'gradient',
            gradient: {
                opacityFrom: 0.45,
                opacityTo: 0.05
            }
        },
        dataLabels: { enabled: false },
        grid: { borderColor: 'rgba(255,255,255,.06)' },
        xaxis: {
            categories: categories,
            labels: { style: { colors: '#94a3b8' } }
        },
        yaxis: {
            labels: {
                style: { colors: '#94a3b8' },
                // FIX: Menampilkan format rupiah dinamis pada sumbu Y grafik
                formatter: function (value) {
                    return "Rp " + value.toLocaleString('id-ID');
                }
            }
        },
        // FIX: Tooltip Pop-up memunculkan format rupiah asli saat kursor digeser
        tooltip: {
            theme: 'dark',
            y: {
                formatter: function(value, { seriesIndex }) {
                    if(seriesIndex === 0) {
                        return "Rp " + value.toLocaleString('id-ID');
                    }
                    return value + " Booking";
                }
            }
        },
        legend: { labels: { colors: '#cbd5e1' } }
    };

    new ApexCharts(document.querySelector("#realtimeChart"), options).render();

    /* DONUT CHART CONFIG */
    const facilityData = @json($facilityChart);
    const facilitySeries = facilityData.map(item => item.total);
    const facilityLabels = facilityData.map(item => item.jenis);

    const donutOptions = {
        chart: {
            type: 'donut',
            height: 320,
            background: 'transparent'
        },
        series: facilitySeries,
        labels: facilityLabels,
        theme: { mode: 'dark' },
        colors: ['#34f5a1', '#4ea8ff', '#facc15', '#a78bfa', '#fb7185'],
        stroke: { width: 0 },
        plotOptions: {
            pie: {
                donut: { size: '72%' }
            }
        },
        legend: {
            position: 'bottom',
            fontSize: '13px',
            labels: { colors: '#cbd5e1' }
        },
        dataLabels: { enabled: false },
        tooltip: { theme: 'dark' }
    };

    new ApexCharts(document.querySelector("#facilityChart"), donutOptions).render();
</script>

@endsection
