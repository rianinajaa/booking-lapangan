<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — SpaceGo Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:        #181a1f;
            --sidebar:   #20232b;
            --card:      #252525;
            --card2:     #2a2a2a;
            --border:    rgba(255,255,255,0.07);
            --green:     #00d98b;
            --green-dim: rgba(62,255,162,0.11);
            --text:      #ffffff;
            --text-2:    rgba(255,255,255,0.55);
            --text-3:    rgba(255,255,255,0.30);
            --danger:    #ef4444;
            --warning:   #f59e0b;
            --info:      #3b82f6;
            --sidebar-w: 220px;
            --topbar-h:  64px;
        }

        html, body { height: 100%; background: var(--bg); color: var(--text); }

        /* ── SIDEBAR ── */
        .sidebar {
            position: fixed; top: 0; left: 0; bottom: 0;
            width: var(--sidebar-w);
            background: var(--sidebar);
            border-right: 1px solid var(--border);
            display: flex; flex-direction: column;
            z-index: 50;
            transition: transform 0.3s;
        }

        .sidebar-logo {
            display: flex; align-items: center; gap: 10px;
            padding: 0 20px;
            height: var(--topbar-h);
            border-bottom: 1px solid var(--border);
            text-decoration: none;
        }
        .sidebar-logo .logo-icon {
            width: 32px; height: 32px;
            background: var(--green); border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
        }
        .sidebar-logo .logo-text {
            font-size: 20px; font-weight: 800;
            color: var(--text); letter-spacing: 0.04em;
        }

        .sidebar-section {
            padding: 20px 14px 8px;
            font-size: 10px; font-weight: 700;
            color: var(--text-3); text-transform: uppercase;
            letter-spacing: 0.12em;
        }

        .nav-item {
            display: flex; align-items: center; gap: 11px;
            padding: 10px 14px; margin: 2px 8px;
            border-radius: 10px;
            color: var(--text-2); font-size: 13.5px; font-weight: 500;
            text-decoration: none; transition: all 0.18s;
            cursor: pointer;
        }
        .nav-item:hover { background: rgba(255,255,255,0.06); color: var(--text); }
        .nav-item.active {
            background: var(--green);
            color: #0f1621;
            font-weight: 700;
        }
        .nav-item .nav-icon { width: 18px; text-align: center; font-size: 14px; }

        .sidebar-bottom {
            margin-top: auto;
            padding: 12px 8px;
            border-top: 1px solid var(--border);
        }

        /* ── TOPBAR ── */
        .topbar {
            position: fixed; top: 0;
            left: var(--sidebar-w); right: 0;
            height: var(--topbar-h);
            background: var(--sidebar);
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center;
            padding: 0 24px; gap: 14px;
            z-index: 40;
        }

        .search-box {
            flex: 1; max-width: 320px;
            display: flex; align-items: center; gap: 10px;
            background: rgba(255,255,255,0.06);
            border: 1px solid var(--border);
            border-radius: 10px; padding: 8px 14px;
        }
        .search-box input {
            background: none; border: none; outline: none;
            color: var(--text); font-size: 13px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            width: 100%;
        }
        .search-box input::placeholder { color: var(--text-3); }

        .topbar-right { display: flex; align-items: center; gap: 8px; margin-left: auto; }

        .icon-btn {
            width: 36px; height: 36px; border-radius: 9px;
            background: rgba(255,255,255,0.06);
            border: 1px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            color: var(--text-2); font-size: 15px; cursor: pointer;
            transition: all 0.18s; position: relative;
        }
        .icon-btn:hover { background: rgba(255,255,255,0.10); color: var(--text); }
        .icon-btn .dot {
            position: absolute; top: 7px; right: 7px;
            width: 7px; height: 7px; border-radius: 50%;
            background: var(--green); border: 1.5px solid var(--sidebar);
        }

        .avatar-btn {
            width: 36px; height: 36px; border-radius: 50%;
            background: var(--green);
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; font-weight: 800; color: #0f1621;
            cursor: pointer; border: 2px solid rgba(0,200,83,0.3);
            transition: all 0.18s;
        }
        .avatar-btn:hover { border-color: var(--green); }

        /* ── MAIN ── */
        .main {
            margin-left: var(--sidebar-w);
            margin-top: var(--topbar-h);
            padding: 28px;
            min-height: calc(100vh - var(--topbar-h));
        }

        /* ── CARD ── */
        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 14px;
        }
        .card-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
        }
        .card-title { font-size: 14px; font-weight: 700; color: var(--text); }
        .card-body { padding: 20px; }

        /* ── STAT CARD ── */
        .stat-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 20px;
        }
        .stat-label {
            font-size: 11px; font-weight: 700;
            color: var(--text-3); text-transform: uppercase;
            letter-spacing: 0.1em; margin-bottom: 12px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .stat-value {
            font-size: 28px; font-weight: 800; color: var(--text);
            line-height: 1; margin-bottom: 8px;
        }
        .stat-sub {
            font-size: 11.5px; color: var(--text-3);
        }
        .stat-change {
            font-size: 11.5px; font-weight: 600;
            display: inline-flex; align-items: center; gap: 3px;
        }
        .stat-change.up { color: var(--green); }
        .stat-change.down { color: var(--danger); }

        /* ── TABLE ── */
        .tbl-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        th {
            padding: 10px 16px; text-align: left;
            font-size: 11px; font-weight: 700;
            color: var(--text-3); text-transform: uppercase;
            letter-spacing: 0.08em;
            border-bottom: 1px solid var(--border);
        }
        td {
            padding: 13px 16px;
            font-size: 13px; color: var(--text-2);
            border-bottom: 1px solid rgba(255,255,255,0.04);
        }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: rgba(255,255,255,0.03); }

        /* ── BADGE ── */
        .badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 4px 10px; border-radius: 99px;
            font-size: 11.5px; font-weight: 600;
        }
        .badge-green  { background: rgba(0,200,83,0.15);  color: var(--green); }
        .badge-red    { background: rgba(239,68,68,0.15);  color: #f87171; }
        .badge-yellow { background: rgba(245,158,11,0.15); color: #fbbf24; }
        .badge-blue   { background: rgba(59,130,246,0.15); color: #60a5fa; }
        .badge-gray   { background: rgba(255,255,255,0.08); color: var(--text-2); }

        /* ── BTN ── */
        .btn {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 8px 16px; border-radius: 9px;
            font-size: 13px; font-weight: 600; border: none;
            cursor: pointer; text-decoration: none; transition: all 0.18s;
        }
        .btn-green { background: var(--green); color: #0f1621; }
        .btn-green:hover { background: #00a846; }
        .btn-outline {
            background: rgba(255,255,255,0.06);
            border: 1px solid var(--border);
            color: var(--text-2);
        }
        .btn-outline:hover { background: rgba(255,255,255,0.10); color: var(--text); }
        .btn-sm { padding: 6px 12px; font-size: 12px; border-radius: 7px; }
        .btn-icon {
            width: 30px; height: 30px; padding: 0;
            border-radius: 7px; justify-content: center;
        }

        /* ── ALERT ── */
        .alert {
            padding: 12px 16px; border-radius: 10px;
            font-size: 13px; font-weight: 500;
            display: flex; align-items: center; gap: 10px;
            margin-bottom: 16px;
        }
        .alert-success { background: rgba(0,200,83,0.12); color: var(--green); border: 1px solid rgba(0,200,83,0.2); }
        .alert-danger  { background: rgba(239,68,68,0.12); color: #f87171; border: 1px solid rgba(239,68,68,0.2); }

        /* ── BREADCRUMB ── */
        .breadcrumb {
            display: flex; align-items: center; gap: 6px;
            font-size: 12.5px; color: var(--text-3);
            margin-bottom: 20px;
        }
        .breadcrumb a { color: var(--text-3); text-decoration: none; }
        .breadcrumb a:hover { color: var(--green); }
        .breadcrumb .current { color: var(--text); font-weight: 600; }

        /* ── FORM ── */
        .form-group { margin-bottom: 18px; }
        .form-label {
            display: block; font-size: 12.5px; font-weight: 600;
            color: var(--text-2); margin-bottom: 7px;
        }
        .form-control {
            width: 100%; padding: 10px 14px;
            background: rgba(255,255,255,0.06);
            border: 1.5px solid var(--border);
            border-radius: 9px; font-size: 13.5px;
            color: var(--text); outline: none;
            transition: border-color 0.18s, box-shadow 0.18s;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .form-control:focus {
            border-color: var(--green);
            box-shadow: 0 0 0 3px rgba(0,200,83,0.10);
        }
        .form-control::placeholder { color: var(--text-3); }
        .form-control.is-invalid { border-color: var(--danger); }
        .invalid-feedback { font-size: 12px; color: #f87171; margin-top: 4px; display: block; }

        /* Progress bar */
        .progress { height: 4px; background: rgba(255,255,255,0.08); border-radius: 99px; overflow: hidden; }
        .progress-bar { height: 100%; background: var(--green); border-radius: 99px; transition: width 0.5s; }

        /* Mobile */
        .sidebar-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,0.6); z-index: 45;
        }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .sidebar-overlay.open { display: block; }
            .topbar { left: 0; }
            .main { margin-left: 0; }
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.10); border-radius: 99px; }
    </style>
    @stack('styles')
</head>
<body>

{{-- SIDEBAR --}}
<aside class="sidebar" id="sidebar">

    {{-- Logo --}}
    <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">
        <div class="logo-icon">
            <svg width="18" height="18" fill="none" stroke="#0f1621" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </div>
        <span class="logo-text">SpaceGo</span>
    </a>

    {{-- Nav --}}
    <div style="flex:1; overflow-y:auto; padding:8px 0;">

        <div class="sidebar-section">Panel Admin</div>

        <a href="{{ route('admin.dashboard') }}"
            class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-chart-pie"></i></span>
            Analytics
        </a>

        <a href="{{ route('admin.booking.index') }}"
            class="nav-item {{ request()->routeIs('admin.booking.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-calendar-check"></i></span>
            Bookings
            @php $pb = \App\Models\Booking::where('status_booking','menunggu')->count(); @endphp
            @if($pb > 0)
                <span style="margin-left:auto; background:var(--green); color:#0f1621; font-size:10px; font-weight:700; min-width:18px; height:18px; border-radius:99px; display:flex; align-items:center; justify-content:center; padding:0 5px;">{{ $pb }}</span>
            @endif
        </a>

        <a href="{{ route('admin.users.index') }}"
            class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-users"></i></span>
            Users
        </a>

        <a href="{{ route('admin.fasilitas.index') }}"
            class="nav-item {{ request()->routeIs('admin.fasilitas.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-building"></i></span>
            Facilities
        </a>

        <a href="{{ route('admin.jadwal.index') }}"
            class="nav-item {{ request()->routeIs('admin.jadwal.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-clock"></i></span>
            Schedules
        </a>

        <a href="{{ route('admin.pembayaran.index') }}"
            class="nav-item {{ request()->routeIs('admin.pembayaran.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-money-bill-wave"></i></span>
            Pembayaran
            @php $pp = \App\Models\Pembayaran::where('status_bayar','dp')->count(); @endphp
            @if($pp > 0)
                <span style="margin-left:auto; background:var(--danger); color:white; font-size:10px; font-weight:700; min-width:18px; height:18px; border-radius:99px; display:flex; align-items:center; justify-content:center; padding:0 5px;">{{ $pp }}</span>
            @endif
        </a>

        <a href="{{ route('admin.laporan.index') }}"
            class="nav-item {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-chart-bar"></i></span>
            Laporan
        </a>

    </div>

    {{-- Bottom logout --}}
    <div class="sidebar-bottom">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-item" style="width:100%; border:none; background:none; color:var(--text-2); cursor:pointer;">
                <span class="nav-icon"><i class="fa-solid fa-right-from-bracket"></i></span>
                Logout
            </button>
        </form>
    </div>

</aside>

{{-- OVERLAY MOBILE --}}
<div class="sidebar-overlay" id="overlay" onclick="closeSidebar()"></div>

{{-- TOPBAR --}}
<header class="topbar">

    {{-- Hamburger mobile --}}
    <button onclick="openSidebar()" style="display:none; background:none; border:none; color:var(--text-2); font-size:18px; cursor:pointer; margin-right:8px;" id="hamburger">
        <i class="fa-solid fa-bars"></i>
    </button>

    {{-- Search --}}
    <div class="search-box">
        <i class="fa-solid fa-search" style="color:var(--text-3); font-size:13px;"></i>
        <input type="text" placeholder="Cari data...">
    </div>

    {{-- Right --}}
    <div class="topbar-right">
        <div class="icon-btn">
            <i class="fa-regular fa-bell"></i>
            <span class="dot"></span>
        </div>
        <div class="icon-btn">
            <i class="fa-solid fa-gear"></i>
        </div>
        <div class="avatar-btn" title="{{ auth()->user()->name }}">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
    </div>

</header>

{{-- MAIN --}}
<main class="main">

    {{-- Breadcrumb --}}
    @hasSection('breadcrumb')
        <div class="breadcrumb">
            <a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-house" style="font-size:11px;"></i></a>
            <span><i class="fa-solid fa-chevron-right" style="font-size:9px;"></i></span>
            @yield('breadcrumb')
        </div>
    @endif

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            <i class="fa-solid fa-circle-xmark"></i> {{ session('error') }}
        </div>
    @endif

    @yield('content')

</main>

<script>
    function openSidebar() {
        document.getElementById('sidebar').classList.add('open');
        document.getElementById('overlay').classList.add('open');
    }
    function closeSidebar() {
        document.getElementById('sidebar').classList.remove('open');
        document.getElementById('overlay').classList.remove('open');
    }
    // Tampilkan hamburger di mobile
    function checkMobile() {
        const ham = document.getElementById('hamburger');
        if (window.innerWidth <= 768) ham.style.display = 'block';
        else ham.style.display = 'none';
    }
    checkMobile();
    window.addEventListener('resize', checkMobile);
</script>

@stack('scripts')
</body>
</html>