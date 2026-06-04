<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';

    protected $fillable = [
        'booking_id',
        'metode',
        'bank_tujuan',
        'nominal_dp',
        'nominal_lunas',
        'total_tagihan',
        'status_bayar',
        'bukti_dp',
        'bukti_lunas',
        'waktu_dp',
        'waktu_lunas',
        'verifikator_dp',
        'verifikator_lunas',
    ];

    protected $casts = [
        'nominal_dp' => 'decimal:2',
        'nominal_lunas' => 'decimal:2',
        'total_tagihan' => 'decimal:2',
        'waktu_dp' => 'datetime',
        'waktu_lunas' => 'datetime',
    ];

    // ==================== RELASI ====================
    
    // Relasi: pembayaran milik satu booking
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // Relasi: admin yang verifikasi DP
    public function verifikatorDp()
    {
        return $this->belongsTo(User::class, 'verifikator_dp');
    }

    // Relasi: admin yang verifikasi lunas
    public function verifikatorLunas()
    {
        return $this->belongsTo(User::class, 'verifikator_lunas');
    }

    // ==================== ACCESSORS (Helper) ====================
    
    /**
     * Get jenis pembayaran (full / dp)
     */
    public function getJenisPembayaranAttribute()
    {
        if ($this->nominal_dp > 0 && $this->nominal_lunas == 0) {
            return 'dp';
        }
        return 'full';
    }
    
    /**
     * Get sisa tagihan (untuk DP)
     */
    public function getSisaTagihanAttribute()
    {
        if ($this->nominal_dp > 0 && $this->nominal_lunas == 0) {
            return $this->total_tagihan - $this->nominal_dp;
        }
        return 0;
    }
    
    /**
     * Get nominal yang sudah dibayar
     */
    public function getSudahDibayarAttribute()
    {
        return $this->nominal_dp + $this->nominal_lunas;
    }
    
    /**
     * Get persentase pembayaran
     */
    public function getPersentaseBayarAttribute()
    {
        if ($this->total_tagihan <= 0) return 0;
        return round(($this->sudah_dibayar / $this->total_tagihan) * 100);
    }

    // ==================== STATUS CHECKERS ====================
    
    /**
     * Cek apakah sudah lunas
     */
    public function isLunas()
    {
        return $this->status_bayar === 'lunas';
    }
    
    /**
     * Cek apakah DP
     */
    public function isDP()
    {
        return $this->status_bayar === 'dp';
    }
    
    /**
     * Cek apakah belum bayar sama sekali
     */
    public function isBelumBayar()
    {
        return $this->status_bayar === 'belum_bayar';
    }
    
    /**
     * Cek apakah menunggu verifikasi DP
     */
    public function isMenungguVerifikasiDp()
    {
        return $this->status_bayar === 'menunggu_verifikasi_dp';
    }
    
    /**
     * Cek apakah menunggu verifikasi lunas
     */
    public function isMenungguVerifikasiLunas()
    {
        return $this->status_bayar === 'menunggu_verifikasi_lunas';
    }
    
    /**
     * Cek apakah pembayaran full (bukan DP)
     */
    public function isFullPayment()
    {
        return $this->jenis_pembayaran === 'full';
    }
    
    /**
     * Cek apakah sudah upload bukti DP
     */
    public function hasUploadedDp()
    {
        return !is_null($this->bukti_dp);
    }
    
    /**
     * Cek apakah sudah upload bukti lunas
     */
    public function hasUploadedLunas()
    {
        return !is_null($this->bukti_lunas);
    }

    // ==================== METHODS ====================
    
    /**
     * Proses pembayaran DP
     */
    public function bayarDp($buktiPath, $verifikatorId = null)
    {
        $this->update([
            'bukti_dp' => $buktiPath,
            'waktu_dp' => now(),
            'status_bayar' => 'menunggu_verifikasi_dp',
            'verifikator_dp' => $verifikatorId,
        ]);
        
        // Update status booking
        $this->booking?->update(['status_booking' => 'menunggu_verifikasi_dp']);
    }
    
    /**
     * Proses pelunasan (setelah DP)
     */
    public function lunasi($buktiPath, $verifikatorId = null)
    {
        $this->update([
            'bukti_lunas' => $buktiPath,
            'waktu_lunas' => now(),
            'status_bayar' => 'menunggu_verifikasi_lunas',
            'verifikator_lunas' => $verifikatorId,
        ]);
        
        // Update status booking
        $this->booking?->update(['status_booking' => 'menunggu_verifikasi_lunas']);
    }
    
    /**
     * Verifikasi pembayaran DP oleh admin
     */
    public function verifikasiDp($adminId)
    {
        $this->update([
            'status_bayar' => 'dp',
            'verifikator_dp' => $adminId,
        ]);
        
        // Update status booking
        $this->booking?->update(['status_booking' => 'dp']);
    }
    
    /**
     * Verifikasi pembayaran lunas oleh admin
     */
    public function verifikasiLunas($adminId)
    {
        $this->update([
            'status_bayar' => 'lunas',
            'verifikator_lunas' => $adminId,
        ]);
        
        // Update status booking
        $this->booking?->update(['status_booking' => 'dikonfirmasi']);
    }
    
    /**
     * Tolak bukti pembayaran
     */
    public function tolakPembayaran($alasan = null)
    {
        $this->update([
            'status_bayar' => 'belum_bayar',
            'bukti_dp' => null,
            'bukti_lunas' => null,
        ]);
        
        // Update status booking
        $this->booking?->update(['status_booking' => 'menunggu_pembayaran']);
    }
}