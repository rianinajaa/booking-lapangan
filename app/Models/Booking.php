<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'bookings';

    protected $fillable = [
        'kode_booking',
        'user_id',
        'diskon_persen',
        'total_diskon',
        'total_harga',
        'status_booking',
        'role_booker',
    ];

    // Relasi: booking milik satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: booking punya banyak detail booking
    public function detailBooking()
    {
        return $this->hasMany(DetailBooking::class);
    }

    /**
     * RELASI TAMBAHAN:
     * Biar lo bisa panggil $booking->fasilitas langsung.
     * Ini akan mencari Fasilitas lewat tabel detail_bookings.
     */
    public function fasilitas()
    {
        return $this->hasManyThrough(
            Fasilitas::class,
            DetailBooking::class,
            'booking_id',    // Foreign key di tabel detail_bookings
            'id',            // Foreign key di tabel fasilitas
            'id',            // Local key di tabel bookings
            'fasilitas_id'   // Local key di tabel detail_bookings
        );
    }

    // Relasi: booking punya satu pembayaran
    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }
}
