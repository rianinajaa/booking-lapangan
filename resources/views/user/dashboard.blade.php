{{-- resources/views/user/dashboard.blade.php --}}

@extends('layouts.app')

@section('title', 'Dashboard User')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>

    *{
        font-family:'Poppins',sans-serif;
    }

    body{
        background:#0b1120;
    }

    :root{
        --bg:#0b1120;
        --card:#111827;
        --border:rgba(255,255,255,.06);
        --text:#f8fafc;
        --text2:#cbd5e1;
        --text3:#94a3b8;
        --green:#34f5a1;
        --blue:#4ea8ff;
        --yellow:#facc15;
        --red:#fb7185;
    }

    .dashboard-wrap{
        padding:30px;
        display:flex;
        flex-direction:column;
        gap:20px;
    }

    .topbar{
        display:flex;
        justify-content:space-between;
        align-items:center;
        flex-wrap:wrap;
        gap:16px;
    }

    .title{
        font-size:38px;
        font-weight:800;
        color:white;
        line-height:1.1;
        margin-bottom:8px;
    }

    .subtitle{
        color:var(--text3);
        font-size:14px;
    }

    .logout-btn{
        height:46px;
        padding:0 18px;
        border:none;
        border-radius:14px;
        background:rgba(251,113,133,.12);
        color:var(--red);
        display:flex;
        align-items:center;
        gap:10px;
        font-size:13px;
        font-weight:700;
        cursor:pointer;
        transition:.25s;
    }

    .logout-btn:hover{
        background:rgba(251,113,133,.2);
        transform:translateY(-2px);
    }

    .stats-grid{
        display:grid;
        grid-template-columns:repeat(auto-fit,minmax(240px,1fr));
        gap:18px;
    }

    .card{
        background:linear-gradient(145deg,#141c2b,#111827);
        border:1px solid var(--border);
        border-radius:24px;
        padding:24px;
        overflow:hidden;
        position:relative;
    }

    .card::before{
        content:'';
        position:absolute;
        top:-30px;
        right:-30px;
        width:100px;
        height:100px;
        border-radius:50%;
        background:rgba(52,245,161,.08);
    }

    .icon{
        width:48px;
        height:48px;
        border-radius:14px;
        background:rgba(52,245,161,.12);
        display:flex;
        align-items:center;
        justify-content:center;
        margin-bottom:16px;
    }

    .icon i{
        color:var(--green);
        font-size:18px;
    }

    .label{
        color:var(--text3);
        font-size:12px;
        text-transform:uppercase;
        letter-spacing:.08em;
        font-weight:700;
        margin-bottom:8px;
    }

    .value{
        color:white;
        font-size:36px;
        font-weight:800;
        line-height:1;
        margin-bottom:8px;
    }

    .sub{
        color:var(--text3);
        font-size:13px;
    }

    .welcome-card{
        display:flex;
        justify-content:space-between;
        align-items:center;
        flex-wrap:wrap;
        gap:20px;
    }

    .welcome-text{
        max-width:600px;
    }

    .welcome-title{
        color:white;
        font-size:28px;
        font-weight:800;
        margin-bottom:10px;
    }

    .welcome-desc{
        color:var(--text3);
        line-height:1.7;
        font-size:14px;
    }

    .quick-actions{
        display:flex;
        gap:12px;
        flex-wrap:wrap;
        margin-top:10px;
    }

    .action-btn{
        height:44px;
        padding:0 18px;
        border-radius:14px;
        border:1px solid var(--border);
        background:rgba(255,255,255,.03);
        color:white;
        display:flex;
        align-items:center;
        gap:10px;
        text-decoration:none;
        font-size:13px;
        font-weight:700;
        transition:.25s;
    }

    .action-btn:hover{
        border-color:rgba(52,245,161,.4);
        transform:translateY(-2px);
    }

    .action-btn.green{
        background:var(--green);
        color:#08130f;
        border:none;
    }

    @media(max-width:768px){

        .dashboard-wrap{
            padding:20px;
        }

        .title{
            font-size:30px;
        }

        .value{
            font-size:30px;
        }
    }

</style>

<div class="dashboard-wrap">

    {{-- TOPBAR --}}
    <div class="topbar">

        <div>

            <div class="title">
                Dashboard User
            </div>

            <div class="subtitle">
                Selamat datang kembali,
                <strong style="color:white;">
                    {{ auth()->user()->name }}
                </strong>
            </div>

        </div>

        {{-- LOGOUT --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="logout-btn">
                <i class="fa-solid fa-right-from-bracket"></i>
                Logout
            </button>
        </form>

    </div>

    {{-- WELCOME --}}
    <div class="card welcome-card">

        <div class="welcome-text">

            <div class="welcome-title">
                Selamat Datang 👋
            </div>

            <div class="welcome-desc">
                Kelola booking fasilitas, lihat riwayat transaksi,
                dan pantau status pemesanan Anda secara realtime.
            </div>

            <div class="quick-actions">

                <a href="#" class="action-btn green">
                    <i class="fa-solid fa-plus"></i>
                    Booking Sekarang
                </a>

                <a href="#" class="action-btn">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                    Riwayat Booking
                </a>

            </div>

        </div>

    </div>

    {{-- STATISTIK --}}
    <div class="stats-grid">

        {{-- Total Booking --}}
        <div class="card">

            <div class="icon">
                <i class="fa-solid fa-calendar-check"></i>
            </div>

            <div class="label">
                Total Booking
            </div>

            <div class="value">
                12
            </div>

            <div class="sub">
                Booking yang telah dilakukan
            </div>

        </div>

        {{-- Booking Aktif --}}
        <div class="card">

            <div class="icon">
                <i class="fa-solid fa-bolt"></i>
            </div>

            <div class="label">
                Booking Aktif
            </div>

            <div class="value">
                3
            </div>

            <div class="sub">
                Sedang berlangsung saat ini
            </div>

        </div>

        {{-- Total Pembayaran --}}
        <div class="card">

            <div class="icon">
                <i class="fa-solid fa-wallet"></i>
            </div>

            <div class="label">
                Total Pembayaran
            </div>

            <div class="value">
                Rp 2.5M
            </div>

            <div class="sub">
                Akumulasi transaksi user
            </div>

        </div>

    </div>

</div>

@endsection
