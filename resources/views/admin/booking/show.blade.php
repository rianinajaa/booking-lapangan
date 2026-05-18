<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Booking #{{ $booking->kode_booking }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #00d98b;
            --primary-glow: rgba(0, 217, 139, 0.15);
            --bg-dark: #0b0f1a;
            --card-bg: #111827;
            --card-nested: #1f2937;
            --border-glass: rgba(255, 255, 255, 0.08);
            --text-gray: #94a3b8;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-dark);
            color: white;
            margin: 0;
            padding: 15px;
            overflow-x: hidden;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--bg-dark); }
        ::-webkit-scrollbar-thumb { background: #1a2235; border-radius: 10px; }

        .detail-container { max-width: 800px; margin: 0 auto; }

        .receipt-card {
            background: var(--card-bg);
            border: 1px solid var(--border-glass);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.5);
            position: relative;
        }

        /* Punch-hole efek struk belanja */
        .receipt-card::before, .receipt-card::after {
            content: ''; position: absolute; width: 24px; height: 24px;
            background: var(--bg-dark); border-radius: 50%; top: 105px; z-index: 10;
        }
        .receipt-card::before { left: -12px; }
        .receipt-card::after { right: -12px; }

        .receipt-header {
            padding: 25px;
            background: linear-gradient(135deg, rgba(0, 217, 139, 0.08) 0%, transparent 100%);
            border-bottom: 2px dashed var(--border-glass);
            display: flex; justify-content: space-between; align-items: center;
        }

        .badge-status { padding: 6px 14px; border-radius: 10px; font-weight: 700; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; }
        .status-menunggu { background: rgba(245, 158, 11, 0.15); color: #fbbf24; }
        .status-dikonfirmasi { background: rgba(16, 185, 129, 0.15); color: #10b981; }
        .status-selesai { background: rgba(59, 130, 246, 0.15); color: #3b82f6; }
        .status-dibatalkan { background: rgba(239, 68, 68, 0.15); color: #ef4444; }

        .receipt-body { padding: 25px; }
        .info-label { color: var(--text-gray); font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 6px; }

        /* Grid System Baru biar gak tabrakan */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
            background: rgba(255, 255, 255, 0.02);
            padding: 20px;
            border-radius: 14px;
            border: 1px solid var(--border-glass);
        }

        .status-pembayaran-box {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            justify-content: center;
        }

        .detail-table { width: 100%; border-collapse: collapse; margin-top: 10px; margin-bottom: 25px; }
        .detail-table th { padding: 12px 10px; color: var(--text-gray); font-size: 11px; text-align: left; border-bottom: 1px solid var(--border-glass); text-transform: uppercase; }
        .detail-table td { padding: 16px 10px; border-bottom: 1px solid var(--border-glass); vertical-align: middle; }

        .total-box {
            padding: 20px;
            background: rgba(255,255,255,0.03);
            border-radius: 14px;
            border: 1px solid var(--border-glass);
            margin-top: 15px;
        }

        .btn-action {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 10px 20px; border-radius: 10px; font-weight: 700; font-size: 13px;
            text-decoration: none; transition: 0.3s; border: none; cursor: pointer;
        }
        .btn-print { background: var(--primary); color: #0b0f1a; box-shadow: 0 6px 12px var(--primary-glow); }
        .btn-close-pop { background: rgba(255,255,255,0.05); color: white; border: 1px solid var(--border-glass); }
        .btn-print:hover { opacity: 0.9; }
        .btn-close-pop:hover { background: rgba(255,255,255,0.1); }

        @media print {
            body { background: white !important; color: black !important; padding: 0; }
            .receipt-card { box-shadow: none !important; border: 1px solid #eee !important; width: 100% !important; }
            .btn-action, .receipt-card::before, .receipt-card::after { display: none !important; }
            .receipt-header { background: none !important; color: black !important; }
            .badge-status { border: 1px solid #ccc !important; color: black !important; }
            .total-box { background: #f9f9f9 !important; color: black !important; border: 1px solid #ddd !important; }
            .info-label, .detail-table th { color: #666 !important; }
            .detail-table td { border-bottom: 1px solid #eee !important; color: black !important; }
            .detail-table td div { color: black !important; }
            .info-grid { background: none !important; border: 1px solid #eee !important; }
        }
    </style>
</head>
<body>

<div class="detail-container">
    <div class="receipt-card">
        <div class="receipt-header">
            <div>
                <div class="info-label" style="margin-bottom: 3px;">INVOICE RESERVASI</div>
                <h4 style="margin:0; font-weight:800; font-size:22px; letter-spacing: -0.5px;">
                    <span style="color:var(--primary)">#{{ $booking->kode_booking }}</span>
                </h4>
                <p style="margin:4px 0 0; color:var(--text-gray); font-size:12px; font-weight: 600;">
                    <i class="fa-regular fa-calendar-check me-1"></i> {{ $booking->created_at->format('d F Y, H:i') }}
                </p>
            </div>
            <div>
                <span class="badge-status status-{{ $booking->status_booking }}">
                    <i class="fa-solid fa-circle me-1" style="font-size: 6px;"></i> {{ $booking->status_booking }}
                </span>
            </div>
        </div>

        <div class="receipt-body">
            <div class="info-grid">
                <div>
                    <div class="info-label">Penyewa / Booker</div>
                    <div style="font-size: 16px; font-weight: 800; color: white;">{{ $booking->user->name ?? 'Guest User' }}</div>
                    <div style="color: var(--text-gray); font-weight: 600; font-size: 13px; margin-top: 2px;">{{ $booking->user->email ?? '-' }}</div>
                    <div style="margin-top: 8px;">
                        <span style="font-size: 10px; background: rgba(255,255,255,0.06); padding: 4px 8px; border-radius: 6px; color: var(--primary); font-weight: 700;">
                            {{ str_replace('_', ' ', strtoupper($booking->role_booker ?? 'UMUM')) }}
                        </span>
                    </div>
                </div>

                <div class="status-pembayaran-box">
                    <div class="info-label">Status Pembayaran</div>
                    @if($booking->status_booking == 'selesai')
                        <div style="font-size: 16px; font-weight: 800; color: var(--primary);">LUNAS</div>
                        <div style="color: var(--text-gray); font-size: 11px; font-weight: 700; margin-bottom: 8px;">TRANSAKSI BERHASIL</div>
                        <i class="fa-solid fa-circle-check" style="font-size: 32px; color: var(--primary); opacity: 0.9;"></i>
                    @elseif($booking->status_booking == 'dibatalkan')
                        <div style="font-size: 16px; font-weight: 800; color: #ef4444;">DIBATALKAN</div>
                        <div style="color: var(--text-gray); font-size: 11px; font-weight: 700; margin-bottom: 8px;">VOID / REJECTED</div>
                        <i class="fa-solid fa-circle-xmark" style="font-size: 32px; color: #ef4444; opacity: 0.9;"></i>
                    @else
                        <div style="font-size: 16px; font-weight: 800; color: #fbbf24;">PENDING</div>
                        <div style="color: var(--text-gray); font-size: 11px; font-weight: 700; margin-bottom: 8px;">MENUNGGU KONFIRMASI</div>
                        <i class="fa-solid fa-clock-rotate-left" style="font-size: 32px; color: #fbbf24; opacity: 0.8;"></i>
                    @endif
                </div>
            </div>

            <div class="info-label">Ringkasan Pesanan</div>
            <div style="overflow-x: auto;">
                <table class="detail-table">
                    <thead>
                        <tr>
                            <th>Fasilitas</th>
                            <th>Jadwal</th>
                            <th style="text-align: center;">Durasi</th>
                            <th style="text-align: right;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($booking->detailBooking as $detail)
                        <tr>
                            <td style="width: 35%;">
                                <div style="font-weight:800; color: var(--primary); font-size: 14px;">{{ $detail->fasilitas->nama ?? 'Lapangan' }}</div>
                                <div style="font-size: 11px; color: var(--text-gray); text-transform: uppercase; margin-top: 2px;">{{ $detail->fasilitas->jenis ?? 'Sports Center' }}</div>
                            </td>
                            <td style="width: 35%;">
                                <div style="font-weight:700; font-size: 13px; color: #fff;">
                                    {{ $detail->tanggal ? \Carbon\Carbon::parse($detail->tanggal)->translatedFormat('d M Y') : '-' }}
                                </div>
                                <div style="font-size: 12px; color: var(--text-gray); margin-top: 2px;">
                                    <i class="fa-regular fa-clock me-1" style="color: var(--primary);"></i>
                                    {{ $detail->jam_mulai ? substr($detail->jam_mulai, 0, 5) : '--:--' }} - {{ $detail->jam_selesai ? substr($detail->jam_selesai, 0, 5) : '--:--' }} WIB
                                </div>
                            </td>
                            <td style="text-align: center; font-weight: 700; font-size: 13px;">
                                {{ floatval($detail->durasi_jam ?? 0) }} <span style="font-size: 10px; color: var(--text-gray);">HRS</span>
                            </td>
                            <td style="text-align: right; font-weight:800; font-size: 14px; color: #fff;">
                                Rp {{ number_format($detail->subtotal ?? 0, 0, ',', '.') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="text-align: center; color: var(--text-gray); padding: 20px 0;">Detail Rincian Tidak Ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="total-box">
                <div style="display:flex; justify-content:space-between; margin-bottom:10px; font-size: 13px;">
                    <span style="color:var(--text-gray); font-weight: 600;">Diskon Member ({{ $booking->diskon_persen ?? 0 }}%)</span>
                    @php
                        $subtotalSewa = $booking->detailBooking->sum('subtotal') ?? 0;
                        $nominalDiskon = (($booking->diskon_persen ?? 0) / 100) * $subtotalSewa;
                    @endphp
                    <span style="color:#ef4444; font-weight: 700;">- Rp {{ number_format($nominalDiskon, 0, ',', '.') }}</span>
                </div>
                <div style="height: 1px; background: var(--border-glass); margin: 12px 0;"></div>
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <div>
                        <span style="font-weight:800; font-size:12px; color: var(--text-gray); display: block; text-transform: uppercase; letter-spacing: 1px;">Total Bayar</span>
                        <span style="font-size: 10px; color: var(--text-gray);">Termasuk Pajak Sistem SpaceGo</span>
                    </div>
                    <span style="color:var(--primary); font-weight:800; font-size:24px; letter-spacing: -0.5px;">
                        Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            <div style="margin-top:30px; display:flex; gap:12px; justify-content:center;">
                <button type="button" class="btn-action btn-close-pop" onclick="window.parent.dismissDetailPopup()">
                    <i class="fa-solid fa-xmark"></i> Tutup Jendela
                </button>
                <button onclick="window.print()" class="btn-action btn-print">
                    <i class="fa-solid fa-print"></i> Cetak Struk
                </button>
            </div>
        </div>
    </div>
</div>

</body>
</html>
