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
        'jam_buka' => 'datetime:H:i',
        'jam_tutup' => 'datetime:H:i',
    ];

    public function fasilitas()
    {
        return $this->belongsTo(Fasilitas::class);
    }

    /*
    |--------------------------------------------------------------------------
    | STATUS OPERASIONAL REALTIME
    |--------------------------------------------------------------------------
    */

    public function getStatusOperasionalAttribute()
    {
        if ($this->is_libur) {
            return 'libur';
        }

        $now = now('Asia/Jakarta')->format('H:i:s');

        $jamBuka = $this->jam_buka->format('H:i:s');
        $jamTutup = $this->jam_tutup->format('H:i:s');

        /*
        |--------------------------------------------------------------------------
        | OVERNIGHT SCHEDULE
        |--------------------------------------------------------------------------
        */

        if ($jamBuka > $jamTutup) {

            return (
                $now >= $jamBuka ||
                $now <= $jamTutup
            )
                ? 'buka'
                : 'tutup';
        }

        /*
        |--------------------------------------------------------------------------
        | NORMAL SCHEDULE
        |--------------------------------------------------------------------------
        */

        return (
            $now >= $jamBuka &&
            $now <= $jamTutup
        )
            ? 'buka'
            : 'tutup';
    }

    /*
    |--------------------------------------------------------------------------
    | STATUS LABEL
    |--------------------------------------------------------------------------
    */

    public function getStatusLabelAttribute()
    {
        if ($this->is_libur) {
            return 'HOLIDAY';
        }

        if ($this->status_operasional === 'buka') {
            return 'OPEN NOW';
        }

        return 'CLOSED';
    }

    /*
    |--------------------------------------------------------------------------
    | STATUS COLOR
    |--------------------------------------------------------------------------
    */

    public function getStatusColorAttribute()
    {
        if ($this->is_libur) {
            return '#ff4757';
        }

        if ($this->status_operasional === 'buka') {
            return '#00d98b';
        }

        return '#ffa502';
    }
}
