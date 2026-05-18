@extends('layouts.admin')

@section('title', 'Manajemen Users')
@section('page-title', 'Users')

@section('breadcrumb')
    <span class="current">Manajemen Users</span>
@endsection

@section('content')
<style>
    :root {
        --accent: #00d98b;
        --accent-glow: rgba(0, 217, 139, 0.3);
        --glass-border: rgba(255, 255, 255, 0.08);
    }

    @keyframes revealScale {
        0% { opacity: 0; transform: scale(0.95); filter: blur(10px); }
        100% { opacity: 1; transform: scale(1); filter: blur(0); }
    }

    .animate-reveal {
        animation: revealScale 0.5s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
    }

    .user-card-premium {
        background: linear-gradient(145deg, rgba(18, 25, 45, 0.8), rgba(10, 15, 26, 0.95)) !important;
        border: 1px solid var(--glass-border) !important;
        backdrop-filter: blur(15px);
        border-radius: 28px !important;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .user-card-premium:hover {
        transform: translateY(-10px);
        border-color: var(--accent) !important;
        box-shadow: 0 20px 40px rgba(0,0,0,0.4), 0 0 20px rgba(0, 217, 139, 0.1);
    }

    .avatar-ring {
        position: relative;
        padding: 5px;
        border-radius: 50%;
        background: linear-gradient(45deg, var(--accent), transparent);
    }

    .glass-input-user {
        background: rgba(0,0,0,0.2) !important;
        border: 1px solid var(--glass-border) !important;
        color: white !important;
        border-radius: 14px !important;
        transition: 0.3s;
    }

    .glass-input-user:focus {
        border-color: var(--accent) !important;
        box-shadow: 0 0 15px var(--accent-glow) !important;
    }

    .stat-pill {
        background: rgba(0,0,0,0.3);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 16px;
        padding: 10px;
        transition: 0.3s;
    }

    .stat-pill:hover {
        background: rgba(255,255,255,0.05);
    }
</style>

{{-- Header Section --}}
<div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:32px; gap:20px; flex-wrap:wrap;">
    <div class="animate-reveal">
        <div style="display:flex; align-items:center; gap:12px; margin-bottom:8px;">
            <div style="width:4px; height:24px; background:var(--accent); border-radius:4px;"></div>
            <span style="text-transform:uppercase; letter-spacing:3px; font-size:11px; font-weight:700; color:var(--accent);">Member Database</span>
        </div>
        <h1 style="font-size:42px; font-weight:900; color:white; margin:0; line-height:1; letter-spacing:-1.5px;">
            Manajemen <span style="color:var(--accent)">Users</span>
        </h1>
    </div>

    <a href="{{ route('admin.users.create') }}" class="btn animate-reveal"
       style="padding:14px 28px; border-radius:18px; font-weight:700; background: var(--accent); color: #000; border:none; box-shadow: 0 10px 20px var(--accent-glow);">
        <i class="fa-solid fa-user-plus me-2"></i> Tambah User
    </a>
</div>

{{-- Search & Filter --}}
<div class="animate-reveal" style="margin-bottom:30px;">
    <form method="GET" action="{{ route('admin.users.index') }}" style="display:flex; gap:12px; flex-wrap:wrap;">
        <div style="flex:1; min-width:280px; position:relative;">
            <i class="fa-solid fa-magnifying-glass" style="position:absolute; left:16px; top:50%; transform:translateY(-50%); color:var(--accent); opacity:0.6;"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berdasarkan nama atau email..." class="glass-input-user" style="width:100%; padding:14px 14px 14px 45px;">
        </div>
        <button type="submit" class="btn" style="border-radius:14px; background:rgba(255,255,255,0.05); color:white; border:1px solid var(--glass-border); padding:0 25px;">
            Cari Pengguna
        </button>
        @if(request('search'))
            <a href="{{ route('admin.users.index') }}" class="btn" style="border-radius:14px; border:1px solid rgba(239,68,68,0.2); color:#f87171;">
                <i class="fa-solid fa-rotate-right"></i>
            </a>
        @endif
    </form>
</div>

{{-- Grid Cards --}}
<div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(320px, 1fr)); gap:25px;" class="animate-reveal">
    @forelse($users as $user)
        @php
            $firstLetter = strtolower(substr($user->name, 0, 1));
            $avatarColors = [
                'a' => '#8b5cf6', 'b' => '#10b981', 'c' => '#3b82f6',
                'd' => '#f59e0b', 'e' => '#ef4444', 'g' => '#ec4899',
                'm' => '#06b6d4', 'r' => '#3b82f6', 's' => '#f43f5e'
            ];
            $avatarBg = $avatarColors[$firstLetter] ?? '#64748b';
            $isActive = ($user->bookings_count > 0 || $user->role === 'admin');
        @endphp

        <div class="user-card-premium" style="padding:30px;">
            {{-- Role Badge --}}
            <div style="position:absolute; top:20px; right:20px;">
                <span style="font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:1px; background:{{ $user->role === 'admin' ? 'var(--accent)' : 'rgba(255,255,255,0.1)' }}; color:{{ $user->role === 'admin' ? '#000' : 'rgba(255,255,255,0.6)' }}; padding:4px 12px; border-radius:8px;">
                    {{ $user->role }}
                </span>
            </div>

            {{-- Avatar & Identity --}}
            <div style="text-align:center; margin-bottom:25px;">
                <div style="display:inline-block; margin-bottom:15px;">
                    <div class="avatar-ring">
                        <div style="width: 70px; height: 70px; background: {{ $avatarBg }}; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 28px; font-weight: 900; color: #fff; border: 4px solid #0f172a;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    </div>
                </div>
                <h3 style="color:white; font-size:20px; font-weight:800; margin-bottom:4px; letter-spacing:-0.5px;">{{ $user->name }}</h3>
                <p style="color:rgba(255,255,255,0.4); font-size:13px; margin:0;">{{ $user->email }}</p>
            </div>

            {{-- Activity Stats --}}
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:25px;">
                <div class="stat-pill" style="text-align:center;">
                    <span style="display:block; font-size:18px; font-weight:900; color:var(--accent);">{{ $user->bookings_count ?? 0 }}</span>
                    <small style="font-size:9px; color:rgba(255,255,255,0.3); font-weight:700; text-transform:uppercase;">Bookings</small>
                </div>
                <div class="stat-pill" style="text-align:center;">
                    <span style="display:block; font-size:18px; font-weight:900; color:var(--accent);">
                        {{ number_format(($user->bookings_sum_total_harga ?? 0) / 1000, 0) }}K
                    </span>
                    <small style="font-size:9px; color:rgba(255,255,255,0.3); font-weight:700; text-transform:uppercase;">Spending</small>
                </div>
            </div>

            {{-- Actions --}}
            <div style="display:flex; gap:10px;">
                <a href="{{ route('admin.users.edit', $user->id) }}" style="flex:1; background:rgba(255,255,255,0.03); border:1px solid var(--glass-border); border-radius:14px; padding:12px; color:white; font-size:13px; font-weight:700; text-align:center; text-decoration:none; transition:0.2s;">
                    <i class="fa-solid fa-user-gear me-2"></i> Edit
                </a>

                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="flex:1;" onsubmit="return confirm('Hapus pengguna ini permanen?')">
                    @csrf @method('DELETE')
                    <button type="submit" style="width:100%; background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.2); border-radius:14px; padding:12px; color:#f87171; font-size:13px; font-weight:700; cursor:pointer; transition:0.2s;">
                        <i class="fa-solid fa-trash-can me-2"></i> Hapus
                    </button>
                </form>
            </div>

            {{-- Status Dot --}}
            <div style="margin-top:15px; text-align:center;">
                <span style="font-size:10px; color:{{ $isActive ? 'var(--accent)' : 'rgba(255,255,255,0.2)' }}; font-weight:700; text-transform:uppercase; letter-spacing:1px;">
                    ● {{ $isActive ? 'Active Member' : 'Idle' }}
                </span>
            </div>
        </div>
    @empty
        <div style="grid-column: 1/-1; text-align:center; padding:100px 0;">
            <i class="fa-solid fa-users-slash" style="font-size:50px; color:rgba(255,255,255,0.1); margin-bottom:20px;"></i>
            <h3 style="color:white; opacity:0.5;">Tidak ada pengguna ditemukan</h3>
        </div>
    @endforelse
</div>
@endsection
