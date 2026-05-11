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

    // Relasi: fasilitas punya banyak jadwal
    public function jadwal()
    {
        return $this->hasMany(Jadwal::class);
    }
}