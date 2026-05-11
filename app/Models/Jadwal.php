<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $table = 'jadwal';

    protected $fillable = [
        'fasilitas_id',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'status',
    ];

    // Relasi: jadwal milik satu fasilitas
    public function fasilitas()
    {
        return $this->belongsTo(Fasilitas::class);
    }

    // Relasi: jadwal punya banyak detail booking
    public function detailBooking()
    {
        return $this->hasMany(DetailBooking::class);
    }
}