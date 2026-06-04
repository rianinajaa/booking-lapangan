<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement("ALTER TABLE pembayaran MODIFY COLUMN status_bayar ENUM('belum_bayar', 'dp', 'lunas', 'menunggu_verifikasi', 'menunggu_verifikasi_dp', 'menunggu_verifikasi_lunas', 'dibatalkan') DEFAULT 'belum_bayar'");
    }

    public function down()
    {
        DB::statement("ALTER TABLE pembayaran MODIFY COLUMN status_bayar ENUM('belum_bayar', 'dp', 'lunas') DEFAULT 'belum_bayar'");
    }
};