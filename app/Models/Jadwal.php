<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $table = 'jadwal';

    protected $fillable = [
        'fasilitas_id',
        'jam_buka',
        'jam_tutup',
        'is_libur',
    ];

    protected $casts = [
        'is_libur' => 'boolean',
    ];

    // Relasi: jadwal operasional milik satu fasilitas
    public function fasilitas()
    {
        return $this->belongsTo(Fasilitas::class);
    }
}