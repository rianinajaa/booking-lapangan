<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; 

return new class extends Migration
{
    public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        // Ubah enum role dari 3 menjadi 5
        $table->enum('role', [
            'admin',
            'guru', 
            'siswa_internal',
            'siswa_luar',
            'umum'
        ])->default('umum')->change();

        // Tambah kolom profil
        $table->string('nis')->nullable()->after('role');
        $table->string('kelas')->nullable()->after('nis');
        $table->string('asal_sekolah')->nullable()->after('kelas');
        $table->string('foto_kartu_pelajar')->nullable()->after('asal_sekolah');
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->enum('role', ['admin', 'guru', 'user'])->default('user')->change();
        $table->dropColumn(['nis', 'kelas', 'asal_sekolah', 'foto_kartu_pelajar']);
    });
}
};
