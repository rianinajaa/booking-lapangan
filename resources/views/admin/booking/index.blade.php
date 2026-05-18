@extends('layouts.admin')

@section('title', 'Data Booking Lapangan')
@section('page-title', 'Management Booking')

@section('breadcrumb')
    <span class="current">Bookings</span>
@endsection

@section('content')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    * {
        font-family: 'Poppins', sans-serif;
        box-sizing: border-box;
    }

    :root {
        --bg: #0b1120;
        --card: #111827;
        --card2: #1a2235;
        --border: rgba(255, 255, 255, .06);
        --text: #f8fafc;
        --text2: #cbd5e1;
        --text3: #94a3b8;
        --green: #34f5a1;
        --blue: #4ea8ff;
        --cyan: #06b6d4;
        --yellow: #facc15;
        --red: #fb7185;
    }

    .booking-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    /* Top Actions & Filters */
    .table-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        background: var(--card);
        padding: 16px 20px;
        border-radius: 12px;
        border: 1px solid var(--border);
    }

    .search-filter-form {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .search-box {
        position: relative;
    }

    .search-box i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text3);
    }

    .search-box input {
        background: var(--bg);
        border: 1px solid var(--border);
        color: var(--text);
        padding: 8px 12px 8px 35px;
        border-radius: 8px;
        font-size: 14px;
        outline: none;
        width: 240px;
        transition: 0.3s;
    }

    .search-box input:focus { border-color: var(--blue); }

    .filter-select {
        background: var(--bg);
        border: 1px solid var(--border);
        color: var(--text2);
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 14px;
        outline: none;
        cursor: pointer;
    }

    .btn-filter-submit {
        background: var(--card2);
        color: var(--text);
        border: 1px solid var(--border);
        padding: 8px 16px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 500;
        transition: 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-filter-submit:hover { background: var(--blue); color: #0b1120; }

    .btn-add-booking {
        background: linear-gradient(135deg, var(--blue), #2563eb);
        color: #fff;
        padding: 9px 18px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 500;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 12px rgba(78, 168, 255, 0.2);
    }

    /* Table Dashboard Admin */
    .table-responsive-wrap {
        background: var(--card);
        border-radius: 14px;
        border: 1px solid var(--border);
        overflow: hidden;
    }

    .modern-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .modern-table th {
        background: var(--card2);
        color: var(--text3);
        padding: 16px 20px;
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        border-bottom: 1px solid var(--border);
    }

    .modern-table td {
        padding: 16px 20px;
        border-bottom: 1px solid var(--border);
        color: var(--text2);
        font-size: 14px;
        vertical-align: middle;
    }

    .booking-id { color: var(--blue); font-weight: 600; }
    .booking-user { color: var(--text); font-weight: 500; }

    .badge-modern {
        display: inline-flex;
        align-items: center;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    .badge-yellow { background: rgba(250, 204, 21, 0.1); color: var(--yellow); }
    .badge-green { background: rgba(52, 245, 161, 0.1); color: var(--green); }
    .badge-red { background: rgba(251, 113, 133, 0.1); color: var(--red); }
    .badge-blue { background: rgba(78, 168, 255, 0.1); color: var(--blue); }

    .action-group { display: flex; gap: 8px; }

    .action-btn {
        background: var(--card2);
        border: 1px solid var(--border);
        color: var(--text2);
        width: 34px;
        height: 34px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: 0.2s;
        text-decoration: none;
    }
    .action-btn.view:hover { background: var(--cyan); color: #fff; border-color: var(--cyan); }
    .action-btn.edit:hover { background: var(--yellow); color: #0b1120; border-color: var(--yellow); }
    .action-btn.delete:hover { background: var(--red); color: #fff; border-color: var(--red); }

    /* Isolated Pop-up Overlay */
    .detail-popup-overlay {
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(5, 9, 20, 0.88);
        backdrop-filter: blur(10px);
        z-index: 999999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .detail-popup-container {
        width: 100%;
        max-width: 900px;
        height: 85vh;
        background: #0b0f1a;
        border-radius: 24px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        overflow: hidden;
        position: relative;
        display: flex;
        flex-direction: column;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7);
    }

    .detail-popup-close {
        position: absolute;
        top: 15px; right: 20px;
        background: #1a2235;
        border: 1px solid rgba(255,255,255,0.1);
        color: #fff;
        font-size: 24px; width: 40px; height: 40px;
        border-radius: 50%; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        z-index: 10; transition: 0.2s;
    }
    .detail-popup-close:hover { background: var(--red); color: white; transform: rotate(90deg); }

    .detail-iframe {
        width: 100%;
        height: 100%;
        border: none;
        background: transparent;
    }

    .pagination-container {
        padding: 15px 20px;
        background: var(--card);
        border-top: 1px solid var(--border);
    }
</style>

<div class="booking-container">
    @if(session('success'))
        <div style="background: rgba(52, 245, 161, 0.1); border: 1px solid var(--green); color: var(--green); padding: 12px 20px; border-radius: 8px; font-size: 14px;">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="table-actions">
        <form action="{{ route('admin.booking.index') }}" method="GET" class="search-filter-form">
            <div class="search-box">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" name="search" placeholder="Cari Kode / Nama..." value="{{ request('search') }}">
            </div>
            <select name="status" class="filter-select">
                <option value="">-- Semua Status --</option>
                <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Pending</option>
                <option value="dikonfirmasi" {{ request('status') == 'dikonfirmasi' ? 'selected' : '' }}>Verified</option>
                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Done</option>
                <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Cancelled</option>
            </select>
            <button type="submit" class="btn-filter-submit"><i class="fa-solid fa-filter"></i> Filter</button>
        </form>
        <a href="{{ route('admin.booking.create') }}" class="btn-add-booking"><i class="fa-solid fa-plus"></i> Tambah Booking</a>
    </div>

    <div class="table-responsive-wrap">
        <table class="modern-table">
            <thead>
                <tr>
                    <th>Customer / Code</th>
                    <th>Fasilitas Lapangan</th>
                    <th>Jadwal Sewa</th>
                    <th>Total Pembayaran</th>
                    <th>Status</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($bookings as $booking)
                @php
                    // Mengambil data detail pertama dengan aman
                    $detail = $booking->detailBooking ? $booking->detailBooking->first() : null;
                @endphp
                <tr>
                    <td>
                        <div class="booking-id">#{{ strtoupper($booking->kode_booking) }}</div>
                        <div class="booking-user">{{ $booking->user->name ?? 'Guest' }}</div>
                    </td>
                    <td>
                        <span style="color:#fff; font-weight:600;">
                            @if($detail && $detail->fasilitas)
                                {{-- 1. Mencoba mengambil nama_fasilitas --}}
                                {{-- 2. Jika nama_fasilitas kosong/null, coba ambil kolom 'nama' --}}
                                {{-- 3. Jika keduanya kosong, berikan info teks peringatan warna kuning --}}
                                {!! !empty($detail->fasilitas->nama_fasilitas) ? e($detail->fasilitas->nama_fasilitas) : (!empty($detail->fasilitas->nama) ? e($detail->fasilitas->nama) : '<span style="color:var(--yellow);">[Kolom DB Kosong]</span>') !!}
                            @else
                                <span style="color:var(--red); font-size:13px;">Tidak Ada Relasi</span>
                            @endif
                        </span>
                    </td>
                    <td>
                        <div style="font-weight:500;">{{ ($detail && $detail->tanggal) ? (method_exists($detail->tanggal, 'format') ? $detail->tanggal->format('d M Y') : $detail->tanggal) : '-' }}</div>
                        <small style="color:var(--yellow); font-weight:600;">
                            <i class="fa-regular fa-clock me-1"></i>{{ $detail ? substr($detail->jam_mulai, 0, 5).' - '.substr($detail->jam_selesai, 0, 5) : '--:--' }} WIB
                        </small>
                    </td>
                    <td><span style="color:var(--green); font-weight:600;">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</span></td>
                    <td>
                        @php
                            $statusClass = match($booking->status_booking){
                                'menunggu' => 'badge-yellow',
                                'dikonfirmasi' => 'badge-green',
                                'dibatalkan' => 'badge-red',
                                'selesai' => 'badge-blue',
                                default => 'badge-blue'
                            };
                        @endphp
                        <span class="badge-modern {{ $statusClass }}">● {{ strtoupper($booking->status_booking) }}</span>
                    </td>
                    <td style="text-align: center;">
                        <div class="action-group" style="justify-content: center;">
                            <button type="button" class="action-btn view" title="Lihat Struk" onclick="launchDetailPopup('{{ route('admin.booking.show', $booking->id) }}')">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            <a href="{{ route('admin.booking.edit', $booking->id) }}" class="action-btn edit"><i class="fa-solid fa-pen"></i></a>
                            <form action="{{ route('admin.booking.destroy', $booking->id) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="action-btn delete" onclick="return confirm('Hapus data cok?');"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" style="text-align:center; padding:40px;">Tidak Ada Data...</td></tr>
            @endforelse
            </tbody>
        </table>

        <div class="pagination-container">
            {{ $bookings->appends(request()->query())->links() }}
        </div>
    </div>
</div>

<div class="detail-popup-overlay" id="invoicePopupOverlay" onclick="dismissDetailPopup()">
    <div class="detail-popup-container" onclick="event.stopPropagation()">
        <button type="button" class="detail-popup-close" onclick="dismissDetailPopup()">&times;</button>
        <iframe class="detail-iframe" id="invoiceFrame" src=""></iframe>
    </div>
</div>

<script>
    function launchDetailPopup(url) {
        const overlay = document.getElementById('invoicePopupOverlay');
        const iframe = document.getElementById('invoiceFrame');
        if(overlay && iframe) {
            iframe.src = url;
            overlay.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
    }

    function dismissDetailPopup() {
        const overlay = document.getElementById('invoicePopupOverlay');
        const iframe = document.getElementById('invoiceFrame');
        if(overlay && iframe) {
            overlay.style.display = 'none';
            iframe.src = '';
            document.body.style.overflow = 'auto';
        }
    }
</script>
@endsection
