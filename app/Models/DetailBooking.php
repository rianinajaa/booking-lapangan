<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailBooking extends Model
{
    protected $table = 'detail_bookings';

    protected $fillable = [
        'booking_id',
        'fasilitas_id',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'durasi_jam',
        'subtotal',
    ];

    protected $casts = [
        'tanggal'   => 'date',
        'durasi_jam'=> 'decimal:1',
    ];

    // Relasi: detail booking milik satu booking
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // Relasi: detail booking mengacu ke satu fasilitas
    public function fasilitas()
    {
        return $this->belongsTo(Fasilitas::class);
    }
}
