<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    protected $table = 'fasilitas';

    protected $fillable = [
        'nama',
        'jenis',
        'deskripsi',
        'foto',
        'harga_per_jam',
        'status',
    ];

    // Relasi: fasilitas punya satu jadwal operasional
    public function jadwal()
    {
        return $this->hasOne(Jadwal::class);
    }

    // Relasi: fasilitas punya banyak detail booking
    public function detailBookings()
    {
        return $this->hasMany(DetailBooking::class);
    }
}