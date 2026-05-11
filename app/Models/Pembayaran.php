<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';

    protected $fillable = [
        'booking_id',
        'metode',
        'nominal_dp',
        'nominal_lunas',
        'total_tagihan',
        'status_bayar',
        'bukti_dp',
        'bukti_lunas',
        'waktu_dp',
        'waktu_lunas',
        'verifikator_dp',
        'verifikator_lunas',
    ];

    protected $casts = [
        'waktu_dp'    => 'datetime',
        'waktu_lunas' => 'datetime',
    ];

    // Relasi: pembayaran milik satu booking
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // Relasi: admin yang verifikasi DP
    public function verifikatorDp()
    {
        return $this->belongsTo(User::class, 'verifikator_dp');
    }

    // Relasi: admin yang verifikasi lunas
    public function verifikatorLunas()
    {
        return $this->belongsTo(User::class, 'verifikator_lunas');
    }
}