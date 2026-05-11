<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
    'name',
    'email',
    'password',
    'role',
    'google_id',
    'avatar',
    'nis',                 // ← tambah
    'kelas',               // ← tambah
    'asal_sekolah',        // ← tambah
    'foto_kartu_pelajar',  // ← tambah
];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // Relasi: user punya banyak booking
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Relasi: user sebagai verifikator dp
    public function verifikasiDp()
    {
        return $this->hasMany(Pembayaran::class, 'verifikator_dp');
    }

    // Relasi: user sebagai verifikator lunas
    public function verifikasiLunas()
    {
        return $this->hasMany(Pembayaran::class, 'verifikator_lunas');
    }
}
