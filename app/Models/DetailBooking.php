<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailBooking extends Model
{
    protected $table = 'detail_bookings';

    protected $fillable = [
        'booking_id',
        'jadwal_id',
        'durasi_jam',
        'subtotal',
    ];

    // Relasi: detail booking milik satu booking
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // Relasi: detail booking mengacu ke satu jadwal
    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }
}