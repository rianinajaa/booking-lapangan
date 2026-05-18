@extends('layouts.admin')

@section('title', 'Jadwal Operasional')
@section('page-title', 'Jadwal')

@section('breadcrumb')
    <span class="current">Jadwal Operasional</span>
@endsection

@section('content')
    <style>
        :root {
            --accent: #00d98b;
            --accent-glow: rgba(0, 217, 139, 0.3);
            --card-bg: rgba(15, 23, 42, 0.6);
            --glass-border: rgba(255, 255, 255, 0.08);
        }

        @keyframes revealScale {
            0% { opacity: 0; transform: scale(0.95); filter: blur(10px); }
            100% { opacity: 1; transform: scale(1); filter: blur(0); }
        }

        .animate-reveal {
            animation: revealScale 0.5s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
        }

        .schedule-card {
            background: var(--card-bg) !important;
            border: 1px solid var(--glass-border) !important;
            backdrop-filter: blur(15px);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .schedule-card:hover {
            transform: translateY(-8px);
            border-color: rgba(0, 217, 139, 0.4) !important;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4), 0 0 20px rgba(0, 217, 139, 0.1);
        }

        .glass-input {
            background: rgba(0, 0, 0, 0.2) !important;
            border: 1px solid var(--glass-border) !important;
            color: white !important;
            transition: 0.3s !important;
        }

        .status-badge {
            position: relative;
            overflow: hidden;
        }

        .status-badge::after {
            content: "";
            position: absolute;
            top: -50%; left: -100%;
            width: 200%; height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transform: rotate(45deg);
            animation: shine 3s infinite;
        }

        @keyframes shine {
            0% { left: -100%; }
            20% { left: 100%; }
            100% { left: 100%; }
        }
    </style>

    {{-- Header --}}
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:32px; gap:20px; flex-wrap:wrap;">
        <div class="animate-reveal">
            <div style="display:flex; align-items:center; gap:12px; margin-bottom:8px;">
                <div style="width:4px; height:24px; background:var(--accent); border-radius:4px;"></div>
                <span style="text-transform:uppercase; letter-spacing:3px; font-size:11px; font-weight:700; color:var(--accent);">Operational Management</span>
            </div>
            <h1 style="font-size:42px; font-weight:900; color:white; margin:0; line-height:1; letter-spacing:-1px;">
                Jadwal <span style="color:var(--accent)">Fasilitas</span>
            </h1>
        </div>

        <a href="{{ route('admin.jadwal.create') }}" class="btn"
            style="padding:12px 24px; border-radius:16px; font-weight:700; background:var(--accent); color:#000; box-shadow: 0 10px 20px var(--accent-glow);">
            <i class="fa-solid fa-plus me-2"></i> Buat Jadwal Baru
        </a>
    </div>

    {{-- Search & Filter --}}
    <div class="card animate-reveal" style="background:rgba(255,255,255,0.03); border:1px solid var(--glass-border); border-radius:24px; padding:20px; margin-bottom:30px; backdrop-filter:blur(10px);">
        <form method="GET" action="{{ route('admin.jadwal.index') }}" style="display:flex; gap:15px; flex-wrap:wrap;">
            <div style="flex:1; min-width:250px; position:relative;">
                <i class="fa-solid fa-magnifying-glass" style="position:absolute; left:18px; top:50%; transform:translateY(-50%); color:var(--accent); opacity:0.6;"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama fasilitas..."
                    class="glass-input" style="width:100%; border-radius:16px; padding:14px 14px 14px 48px; font-size:14px;">
            </div>
            <button type="submit" class="btn" style="border-radius:16px; padding:0 25px; background:rgba(255,255,255,0.05); color:white; border:1px solid var(--glass-border);">
                Filter
            </button>
        </form>
    </div>

    {{-- Grid --}}
    <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(380px, 1fr)); gap:25px;" id="schedule-grid">
        @forelse($jadwals as $jadwal)
            @php
                $now = \Carbon\Carbon::now('Asia/Jakarta');
                $menitSekarang = ($now->hour * 60) + $now->minute;

                // Variabel jam untuk tampilan dan logika (SAMA NAMA)
                $buka  = \Carbon\Carbon::parse($jadwal->jam_buka);
                $tutup = \Carbon\Carbon::parse($jadwal->jam_tutup);

                $menitBuka  = ($buka->hour * 60) + $buka->minute;
                $menitTutup = ($tutup->hour * 60) + $tutup->minute;

                if ($menitBuka < $menitTutup) {
                    $isOpenTime = ($menitSekarang >= $menitBuka && $menitSekarang < $menitTutup);
                } else {
                    $isOpenTime = ($menitSekarang >= $menitBuka || $menitSekarang < $menitTutup);
                }

                $isHoliday = (bool)$jadwal->is_libur;
                $isActive = !$isHoliday && $isOpenTime;

                if ($isHoliday) {
                    $statusColor = '#ff4757'; $statusLabel = 'Holiday';
                } elseif ($isActive) {
                    $statusColor = '#00d98b'; $statusLabel = 'Open Now';
                } else {
                    $statusColor = '#ffa502'; $statusLabel = 'Closed';
                }
            @endphp

            <div class="schedule-card animate-reveal" style="border-radius:30px; padding:28px;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                    <span class="status-badge"
                        style="background:{{ $statusColor }}20; color:{{ $statusColor }}; padding:6px 14px; border-radius:12px; font-size:11px; font-weight:800; text-transform:uppercase; border:1px solid {{ $statusColor }}30; display:flex; align-items:center; gap:8px;">
                        <span style="width:6px; height:6px; background:{{ $statusColor }}; border-radius:50%;"></span>
                        {{ $statusLabel }}
                    </span>
                    <i class="fa-solid fa-clock" style="color:rgba(255,255,255,0.2);"></i>
                </div>

                <div style="margin-bottom:25px;">
                    <h3 style="color:white; font-size:24px; font-weight:800; margin-bottom:5px;">
                        {{ $jadwal->fasilitas->nama ?? 'Unnamed' }}
                    </h3>
                    <span style="color:rgba(255,255,255,0.4); font-size:13px;">
                        <i class="fa-solid fa-tag me-1"></i> {{ $jadwal->fasilitas->jenis ?? '-' }}
                    </span>
                </div>

                <div style="background:rgba(0,0,0,0.3); border-radius:24px; padding:20px; border:1px solid rgba(255,255,255,0.03); margin-bottom:25px;">
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <div>
                            <div style="font-size:10px; color:rgba(255,255,255,0.4); text-transform:uppercase;">Opening</div>
                            <div style="font-size:22px; font-weight:700; color:white;">{{ $buka->format('H:i') }}</div>
                        </div>
                        <div style="width:40px; height:2px; background:{{ $statusColor }}; opacity:0.3;"></div>
                        <div style="text-align:right;">
                            <div style="font-size:10px; color:rgba(255,255,255,0.4); text-transform:uppercase;">Closing</div>
                            <div style="font-size:22px; font-weight:700; color:white;">{{ $tutup->format('H:i') }}</div>
                        </div>
                    </div>
                </div>

                <div style="display:flex; gap:12px;">
                    <form action="{{ route('admin.jadwal.toggle', $jadwal->id) }}" method="POST" style="flex:1;">
                        @csrf @method('PATCH')
                        <button type="submit"
                            style="width:100%; padding:12px; border-radius:16px; border:none; font-weight:800; cursor:pointer; background:{{ $isHoliday ? 'var(--accent)' : 'rgba(255,71,87,0.1)' }}; color:{{ $isHoliday ? '#000' : '#ff4757' }};">
                            {{ $isHoliday ? 'Activate' : 'Set Holiday' }}
                        </button>
                    </form>
                    <a href="{{ route('admin.jadwal.edit', $jadwal->id) }}"
                        style="width:45px; height:45px; display:flex; align-items:center; justify-content:center; background:rgba(255,255,255,0.05); border-radius:16px; color:white;"><i
                            class="fa-solid fa-pen"></i></a>
                </div>
            </div>
        @empty
            <p style="color:white; grid-column:1/-1; text-align:center;">Data tidak ditemukan.</p>
        @endforelse
    </div>

    <script>
        // Efek Spotlight Mouse
        document.getElementById('schedule-grid').onmousemove = e => {
            for (const card of document.getElementsByClassName('schedule-card')) {
                const rect = card.getBoundingClientRect(),
                    x = e.clientX - rect.left,
                    y = e.clientY - rect.top;
                card.style.setProperty("--mouse-x", `${x}px`);
                card.style.setProperty("--mouse-y", `${y}px`);
            }
        }
    </script>
@endsection
