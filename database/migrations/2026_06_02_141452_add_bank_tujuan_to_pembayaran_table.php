<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pembayaran', function (Blueprint $table) {
            $table->string('bank_tujuan')->nullable()->after('metode');
        });
    }

    public function down()
    {
        Schema::table('pembayaran', function (Blueprint $table) {
            $table->dropColumn('bank_tujuan');
        });
    }
};