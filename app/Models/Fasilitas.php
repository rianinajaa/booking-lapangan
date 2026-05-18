<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fasilitas extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | TABLE
    |--------------------------------------------------------------------------
    */

    protected $table = 'fasilitas';

    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'nama',
        'jenis',
        'deskripsi',
        'foto',
        'harga_per_jam',
        'kapasitas',
        'status',

    ];

    /*
    |--------------------------------------------------------------------------
    | ATTRIBUTE CASTING
    |--------------------------------------------------------------------------
    */

    protected $casts = [

        'harga_per_jam' => 'integer',
        'kapasitas' => 'integer',

    ];

    /*
    |--------------------------------------------------------------------------
    | APPEND ATTRIBUTE
    |--------------------------------------------------------------------------
    */

    protected $appends = [

        'foto_url',
        'status_operasional',

    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    /**
     * Satu fasilitas punya satu jadwal
     */
    public function jadwal()
    {
        return $this->hasOne(Jadwal::class);
    }

    /**
     * Satu fasilitas punya banyak detail booking
     */
    public function detailBookings()
    {
        return $this->hasMany(DetailBooking::class);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSOR
    |--------------------------------------------------------------------------
    */

    /**
     * URL FOTO
     */
    public function getFotoUrlAttribute()
    {
        if ($this->foto) {

            return asset('storage/' . $this->foto);

        }

        return asset('images/no-image.png');
    }

    /**
     * STATUS OPERASIONAL REALTIME
     */
    public function getStatusOperasionalAttribute()
    {
        if (!$this->jadwal) {
            return 'tidak_ada_jadwal';
        }

        if ($this->jadwal->is_libur) {
            return 'tutup';
        }

        $now = now('Asia/Jakarta')->format('H:i:s');

        $jamBuka = $this->jadwal->jam_buka;
        $jamTutup = $this->jadwal->jam_tutup;

        /*
        |--------------------------------------------------------------------------
        | JADWAL NORMAL
        |--------------------------------------------------------------------------
        */

        if ($jamBuka < $jamTutup) {

            return ($now >= $jamBuka && $now <= $jamTutup)
                ? 'buka'
                : 'tutup';

        }

        /*
        |--------------------------------------------------------------------------
        | LEWAT TENGAH MALAM
        |--------------------------------------------------------------------------
        */

        return ($now >= $jamBuka || $now <= $jamTutup)
            ? 'buka'
            : 'tutup';
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER
    |--------------------------------------------------------------------------
    */

    /**
     * Badge warna status
     */
    public function getStatusColorAttribute()
    {
        return $this->status === 'aktif'
            ? '#00d98b'
            : '#6b7280';
    }

    /**
     * Icon jenis fasilitas
     */
    public function getJenisIconAttribute()
    {
        return match ($this->jenis) {

            'lapangan' => 'fa-futbol',

            'ruang_multimedia' => 'fa-tv',

            'lab' => 'fa-flask',

            default => 'fa-building',
        };
    }
}
