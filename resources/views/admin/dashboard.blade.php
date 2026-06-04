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
    /* CSS Khusus untuk Dashboard - Dark & Light Mode */
    
    /* Background utama */
    body.light-mode .main {
        background-color: #f1f5f9 !important;
    }
    
    /* Dark mode background (default) */
    .main {
        background-color: #0f172a;
    }
    
    /* Dark mode untuk stat cards */
    .bg-gradient-to-br.from-\[\#141c2b\] {
        background: linear-gradient(135deg, #1e293b, #0f172a) !important;
        border-color: rgba(255, 255, 255, 0.08) !important;
    }
    
    /* Light mode untuk stat cards */
    body.light-mode .bg-gradient-to-br.from-\[\#141c2b\] {
        background: #ffffff !important;
        border-color: #e2e8f0 !important;
    }
    
    body.light-mode .to-\[\#111827\] {
        background: #ffffff !important;
    }
    
    body.light-mode .relative.overflow-hidden.bg-gradient-to-br {
        background: #ffffff !important;
    }
    
    /* Text colors - Dark mode (default) */
    .text-white {
        color: #ffffff !important;
    }
    
    .text-slate-400 {
        color: #94a3b8 !important;
    }
    
    .text-slate-300 {
        color: #cbd5e1 !important;
    }
    
    .text-\[\#7c879f\] {
        color: #94a3b8 !important;
    }
    
    .text-slate-500 {
        color: #64748b !important;
    }
    
    /* Text colors - Light mode */
    body.light-mode .text-white {
        color: #1e293b !important;
    }
    
    body.light-mode .text-slate-400 {
        color: #64748b !important;
    }
    
    body.light-mode .text-slate-300 {
        color: #475569 !important;
    }
    
    body.light-mode .text-\[\#7c879f\] {
        color: #64748b !important;
    }
    
    body.light-mode .text-slate-500 {
        color: #64748b !important;
    }
    
    /* Border colors - Dark mode (default) */
    .border-white\/\[0\.06\] {
        border-color: rgba(255, 255, 255, 0.06) !important;
    }
    
    .border-white\/\[0\.05\] {
        border-color: rgba(255, 255, 255, 0.05) !important;
    }
    
    .border-white\/\[0\.04\] {
        border-color: rgba(255, 255, 255, 0.04) !important;
    }
    
    .border-t.border-white\/\[0\.06\] {
        border-color: rgba(255, 255, 255, 0.06) !important;
    }
    
    /* Border colors - Light mode */
    body.light-mode .border-white\/\[0\.06\] {
        border-color: #e2e8f0 !important;
    }
    
    body.light-mode .border-white\/\[0\.05\] {
        border-color: #e2e8f0 !important;
    }
    
    body.light-mode .border-white\/\[0\.04\] {
        border-color: #f1f5f9 !important;
    }
    
    body.light-mode .border-t.border-white\/\[0\.06\] {
        border-color: #e2e8f0 !important;
    }
    
    /* Background colors - Dark mode (default) */
    .bg-white\/\[0\.03\] {
        background-color: rgba(255, 255, 255, 0.03) !important;
    }
    
    .bg-white\/\[0\.05\] {
        background-color: rgba(255, 255, 255, 0.05) !important;
    }
    
    .bg-white\/\[0\.06\] {
        background-color: rgba(255, 255, 255, 0.06) !important;
    }
    
    .bg-green\/\[0\.12\] {
        background-color: rgba(52, 245, 161, 0.12) !important;
    }
    
    .bg-yellow\/\[0\.12\] {
        background-color: rgba(250, 204, 21, 0.12) !important;
    }
    
    .bg-red\/\[0\.12\] {
        background-color: rgba(251, 113, 133, 0.12) !important;
    }
    
    .bg-blue\/\[0\.12\] {
        background-color: rgba(78, 168, 255, 0.12) !important;
    }
    
    .bg-green\/10 {
        background-color: rgba(52, 245, 161, 0.1) !important;
    }
    
    .bg-yellow\/10 {
        background-color: rgba(250, 204, 21, 0.1) !important;
    }
    
    .bg-purple\/10 {
        background-color: rgba(167, 139, 250, 0.1) !important;
    }
    
    /* Background colors - Light mode */
    body.light-mode .bg-white\/\[0\.03\] {
        background-color: #f1f5f9 !important;
    }
    
    body.light-mode .bg-white\/\[0\.05\] {
        background-color: #f8fafc !important;
    }
    
    body.light-mode .bg-white\/\[0\.06\] {
        background-color: #f1f5f9 !important;
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
    
    body.light-mode .bg-blue\/\[0\.12\] {
        background-color: rgba(37, 99, 235, 0.1) !important;
    }
    
    body.light-mode .bg-green\/10 {
        background-color: rgba(5, 150, 105, 0.08) !important;
    }
    
    /* Text accent colors - Dark mode (default) */
    .text-green {
        color: #34f5a1 !important;
    }
    
    .text-yellow {
        color: #facc15 !important;
    }
    
    .text-red {
        color: #fb7185 !important;
    }
    
    .text-blue {
        color: #4ea8ff !important;
    }
    
    .text-purple {
        color: #a78bfa !important;
    }
    
    .text-blue-200 {
        color: #93c5fd !important;
    }
    
    /* Text accent colors - Light mode */
    body.light-mode .text-green {
        color: #059669 !important;
    }
    
    body.light-mode .text-yellow {
        color: #d97706 !important;
    }
    
    body.light-mode .text-red {
        color: #dc2626 !important;
    }
    
    body.light-mode .text-blue {
        color: #2563eb !important;
    }
    
    body.light-mode .text-purple {
        color: #7c3aed !important;
    }
    
    body.light-mode .text-blue-200 {
        color: #475569 !important;
    }
    
    /* Border accent colors - Dark mode (default) */
    .border-green\/\[0\.15\] {
        border-color: rgba(52, 245, 161, 0.15) !important;
    }
    
    .border-green\/20 {
        border-color: rgba(52, 245, 161, 0.2) !important;
    }
    
    .border-yellow\/20 {
        border-color: rgba(250, 204, 21, 0.2) !important;
    }
    
    .border-red\/20 {
        border-color: rgba(251, 113, 133, 0.2) !important;
    }
    
    .border-blue\/20 {
        border-color: rgba(78, 168, 255, 0.2) !important;
    }
    
    /* Border accent colors - Light mode */
    body.light-mode .border-green\/\[0\.15\] {
        border-color: #e2e8f0 !important;
    }
    
    body.light-mode .border-green\/20 {
        border-color: #d1fae5 !important;
    }
    
    body.light-mode .border-yellow\/20 {
        border-color: #fde68a !important;
    }
    
    body.light-mode .border-red\/20 {
        border-color: #fecaca !important;
    }
    
    body.light-mode .border-blue\/20 {
        border-color: #dbeafe !important;
    }
    
    /* Progress bar - Dark mode (default) */
    .bg-white\/\[0\.06\] {
        background-color: rgba(255, 255, 255, 0.06) !important;
    }
    
    /* Progress bar - Light mode */
    body.light-mode .bg-white\/\[0\.06\] {
        background-color: #e2e8f0 !important;
    }
    
    /* Table row border - Dark mode (default) */
    td {
        border-bottom-color: rgba(255, 255, 255, 0.04) !important;
    }
    
    /* Table row border - Light mode */
    body.light-mode td {
        border-bottom-color: #f1f5f9 !important;
    }
    
    body.light-mode .border-b.border-white\/\[0\.04\] {
        border-bottom-color: #f1f5f9 !important;
    }
    
    /* Border top - Light mode */
    body.light-mode .border-t {
        border-color: #e2e8f0 !important;
    }
    
    /* Button hover - Dark mode (default) */
    .hover\:border-green\/40:hover {
        border-color: rgba(52, 245, 161, 0.4) !important;
    }
    
    /* Button hover - Light mode */
    body.light-mode .hover\:border-green\/40:hover {
        border-color: #059669 !important;
    }
    
    /* Table row hover - Dark mode (default) */
    .group:hover {
        background-color: rgba(255, 255, 255, 0.02) !important;
    }
    
    /* Table row hover - Light mode */
    body.light-mode .group:hover {
        background-color: rgba(0, 0, 0, 0.02) !important;
    }
    
    /* Button icon hover - Dark mode (default) */
    .hover\:bg-green\/\[0\.15\]:hover {
        background-color: rgba(52, 245, 161, 0.15) !important;
    }
    
    .hover\:text-green:hover {
        color: #34f5a1 !important;
    }
    
    /* Button icon hover - Light mode */
    body.light-mode .hover\:bg-green\/\[0\.15\]:hover {
        background-color: rgba(5, 150, 105, 0.1) !important;
    }
    
    body.light-mode .hover\:text-green:hover {
        color: #059669 !important;
    }
    
    /* Chart container - Dark mode (default) */
    .bg-gradient-to-br.from-\[\#141c2b\].to-\[\#111827\] {
        background: linear-gradient(135deg, #1e293b, #0f172a) !important;
        border-color: rgba(255, 255, 255, 0.06) !important;
    }
    
    /* Chart container - Light mode */
    body.light-mode .bg-gradient-to-br.from-\[\#141c2b\].to-\[\#111827\] {
        background: #ffffff !important;
        border-color: #e2e8f0 !important;
    }
    
    /* ApexCharts - Dark mode (default) */
    .apexcharts-theme-dark .apexcharts-text {
        fill: #e2e8f0 !important;
    }
    
    .apexcharts-theme-dark .apexcharts-grid line {
        stroke: rgba(255, 255, 255, 0.08) !important;
    }
    
    .apexcharts-theme-dark .apexcharts-legend-text {
        color: #94a3b8 !important;
    }
    
    .apexcharts-theme-dark .apexcharts-tooltip {
        background: #1e293b !important;
        border-color: rgba(255, 255, 255, 0.1) !important;
        color: #f1f5f9 !important;
    }
    
    .apexcharts-theme-dark .apexcharts-tooltip-title {
        background: #0f172a !important;
        border-color: rgba(255, 255, 255, 0.1) !important;
        color: #f1f5f9 !important;
    }
    
    /* ApexCharts - Light mode */
    body.light-mode .apexcharts-theme-dark .apexcharts-text {
        fill: #1e293b !important;
    }
    
    body.light-mode .apexcharts-theme-dark .apexcharts-grid line {
        stroke: #e2e8f0 !important;
    }
    
    body.light-mode .apexcharts-theme-dark .apexcharts-legend-text {
        color: #475569 !important;
    }
    
    body.light-mode .apexcharts-theme-dark .apexcharts-tooltip {
        background: #ffffff !important;
        border-color: #e2e8f0 !important;
        color: #1e293b !important;
    }
    
    body.light-mode .apexcharts-theme-dark .apexcharts-tooltip-title {
        background: #f8fafc !important;
        border-color: #e2e8f0 !important;
        color: #1e293b !important;
    }
    
    body.light-mode .apexcharts-theme-dark .apexcharts-tooltip-text-y-label {
        color: #64748b !important;
    }
    
    body.light-mode .apexcharts-theme-dark .apexcharts-tooltip-text-y-value {
        color: #1e293b !important;
    }
    
    /* Badge status - Dark mode (default) */
    .bg-yellow\/\[0\.12\] {
        background-color: rgba(250, 204, 21, 0.12) !important;
    }
    
    .bg-green\/\[0\.15\] {
        background-color: rgba(52, 245, 161, 0.15) !important;
    }
    
    .bg-red\/\[0\.12\] {
        background-color: rgba(251, 113, 133, 0.12) !important;
    }
    
    .bg-blue\/\[0\.12\] {
        background-color: rgba(78, 168, 255, 0.12) !important;
    }
    
    /* Badge status - Light mode */
    body.light-mode .bg-yellow\/\[0\.12\] {
        background-color: rgba(217, 119, 6, 0.1) !important;
    }
    
    body.light-mode .bg-green\/\[0\.15\] {
        background-color: rgba(5, 150, 105, 0.1) !important;
    }
    
    body.light-mode .bg-red\/\[0\.12\] {
        background-color: rgba(220, 38, 38, 0.1) !important;
    }
    
    body.light-mode .bg-blue\/\[0\.12\] {
        background-color: rgba(37, 99, 235, 0.1) !important;
    }

    /* Button Export Styles */
    .btn-export {
        border-color: rgba(255, 255, 255, 0.06);
        background-color: rgba(255, 255, 255, 0.03);
        color: #ffffff;
    }

    .btn-export:hover {
        border-color: rgba(52, 245, 161, 0.4);
        background-color: rgba(52, 245, 161, 0.1);
        color: #34f5a1;
        transform: translateY(-2px);
    }

    .btn-new-booking {
        background-color: #34f5a1;
        color: #08130f;
    }

    .btn-new-booking:hover {
        background-color: rgba(52, 245, 161, 0.9);
        color: #08130f;
        transform: translateY(-2px);
    }

    /* Light mode button styles */
    body.light-mode .btn-export {
        border-color: #cbd5e1;
        background-color: #f8fafc;
        color: #1e293b;
    }

    body.light-mode .btn-export:hover {
        border-color: #10b981;
        background-color: #ecfdf5;
        color: #059669;
    }

    body.light-mode .btn-new-booking {
        background-color: #059669;
        color: #ffffff;
    }

    body.light-mode .btn-new-booking:hover {
        background-color: #047857;
        color: #ffffff;
    }
</style>

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
                class="btn-export h-11 px-[18px] rounded-[14px] border flex items-center gap-2.5 text-[13px] font-bold no-underline transition-all duration-300">
                <i class="fa-regular fa-file-pdf"></i> Ekspor PDF
            </a>
            <a href="#"
                class="btn-export h-11 px-[18px] rounded-[14px] border flex items-center gap-2.5 text-[13px] font-bold no-underline transition-all duration-300">
                <i class="fa-regular fa-file-excel"></i> Ekspor Excel
            </a>
            <a href="{{ route('admin.booking.index') }}"
                class="btn-new-booking h-11 px-[18px] rounded-[14px] flex items-center gap-2.5 text-[13px] font-bold no-underline transition-all duration-300">
                <i class="fa-solid fa-plus"></i> + New Booking
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
                                        'menunggu_verifikasi' => 'bg-blue/[0.12] text-blue',
                                        'dikonfirmasi' => 'bg-green/[0.15] text-green',
                                        'dibatalkan'   => 'bg-red/[0.12] text-red',
                                        'selesai'      => 'bg-green/[0.15] text-green',
                                        default        => 'bg-blue/[0.12] text-blue',
                                    };
                                    $statusLabel = match($booking->status_booking){
                                        'menunggu'     => '● Menunggu',
                                        'menunggu_verifikasi' => '● Verifikasi',
                                        'dikonfirmasi' => '● Dikonfirmasi',
                                        'dibatalkan'   => '● Dibatalkan',
                                        'selesai'      => '● Selesai',
                                        default        => '● Active',
                                    };
                                @endphp
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[12px] font-bold {{ $statusClass }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>
                            <td class="px-3.5 py-4 border-b border-white/[0.04]">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.booking.edit', $booking->id) }}" 
                                        class="w-[34px] h-[34px] rounded-[10px] bg-white/[0.05] text-blue-200 flex items-center justify-center cursor-pointer transition-all duration-300 hover:bg-green/[0.15] hover:text-green">
                                        <i class="fa-solid fa-pen text-xs"></i>
                                    </a>
                                    <button onclick="launchDetailPopup('{{ route('admin.booking.show', $booking->id) }}')"
                                        class="w-[34px] h-[34px] rounded-[10px] bg-white/[0.05] text-blue-200 flex items-center justify-center cursor-pointer transition-all duration-300 hover:bg-green/[0.15] hover:text-green">
                                        <i class="fa-solid fa-eye text-xs"></i>
                                    </button>
                                    <form action="{{ route('admin.booking.destroy', $booking->id) }}" method="POST" 
                                        onsubmit="return confirm('Yakin hapus booking {{ $booking->kode_booking }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="w-[34px] h-[34px] rounded-[10px] bg-white/[0.05] text-blue-200 flex items-center justify-center cursor-pointer transition-all duration-300 hover:bg-red/[0.15] hover:text-red">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </form>
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

{{-- APEXCHARTS SCRIPT with Theme Support --}}
<script>
    const bookingData = @json($bookingChart);
    const incomeData  = @json($incomeChart);
    const facilityData = @json($facilityChart);

    const categories   = bookingData.map(item => item.tanggal);
    const bookingSeries = bookingData.map(item => item.total);
    const incomeSeries  = incomeData.map(item => parseFloat(item.total));

    // Fungsi untuk mendapatkan tema saat ini
    function getCurrentTheme() {
        return document.body.classList.contains('light-mode') ? 'light' : 'dark';
    }

    // Render Line Chart
    let realtimeChart = new ApexCharts(document.querySelector("#realtimeChart"), {
        chart: { type: 'area', height: 320, toolbar: { show: false }, background: 'transparent' },
        theme: { mode: getCurrentTheme() },
        colors: ['#34f5a1','#4ea8ff'],
        series: [
            { name: 'Pendapatan', data: incomeSeries },
            { name: 'Booking',    data: bookingSeries }
        ],
        stroke: { curve: 'smooth', width: 4 },
        fill: { type: 'gradient', gradient: { opacityFrom: 0.45, opacityTo: 0.05 } },
        dataLabels: { enabled: false },
        grid: { borderColor: getCurrentTheme() === 'light' ? '#e2e8f0' : 'rgba(255,255,255,.06)' },
        xaxis: { categories, labels: { style: { colors: getCurrentTheme() === 'light' ? '#475569' : '#94a3b8' } } },
        yaxis: {
            labels: {
                style: { colors: getCurrentTheme() === 'light' ? '#475569' : '#94a3b8' },
                formatter: v => "Rp " + v.toLocaleString('id-ID')
            }
        },
        tooltip: {
            theme: getCurrentTheme(),
            y: {
                formatter: (v, { seriesIndex }) =>
                    seriesIndex === 0
                        ? "Rp " + v.toLocaleString('id-ID')
                        : v + " Booking"
            }
        },
        legend: { labels: { colors: getCurrentTheme() === 'light' ? '#475569' : '#cbd5e1' } }
    });
    realtimeChart.render();

    // Render Donut Chart
    let facilityChart = new ApexCharts(document.querySelector("#facilityChart"), {
        chart: { type: 'donut', height: 320, background: 'transparent' },
        series: facilityData.map(i => i.total),
        labels:  facilityData.map(i => i.jenis),
        theme: { mode: getCurrentTheme() },
        colors: ['#34f5a1','#4ea8ff','#facc15','#a78bfa','#fb7185'],
        stroke: { width: 0 },
        plotOptions: { pie: { donut: { size: '72%' } } },
        legend: { position: 'bottom', fontSize: '13px', labels: { colors: getCurrentTheme() === 'light' ? '#475569' : '#cbd5e1' } },
        dataLabels: { enabled: false },
        tooltip: { theme: getCurrentTheme() }
    });
    facilityChart.render();

    // Update charts ketika tema berubah
    function updateChartsTheme() {
        const isLight = getCurrentTheme() === 'light';
        const config = {
            textColor: isLight ? '#475569' : '#94a3b8',
            legendColor: isLight ? '#475569' : '#cbd5e1',
            gridColor: isLight ? '#e2e8f0' : 'rgba(255,255,255,.06)',
            theme: isLight ? 'light' : 'dark'
        };
        
        if (realtimeChart) {
            realtimeChart.updateOptions({
                theme: { mode: config.theme },
                grid: { borderColor: config.gridColor },
                xaxis: { labels: { style: { colors: config.textColor } } },
                yaxis: { labels: { style: { colors: config.textColor } } },
                legend: { labels: { colors: config.legendColor } },
                tooltip: { theme: config.theme }
            });
        }
        
        if (facilityChart) {
            facilityChart.updateOptions({
                theme: { mode: config.theme },
                legend: { labels: { colors: config.legendColor } },
                tooltip: { theme: config.theme }
            });
        }
    }

    // Listen for body class changes
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.attributeName === 'class') {
                updateChartsTheme();
            }
        });
    });
    observer.observe(document.body, { attributes: true });

    // Popup Detail Functions
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

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

@endsection