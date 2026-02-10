<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Note: LHKASN sudah tidak berlaku lagi bagi ASN, diganti dengan SPT Tahunan
     * untuk laporan kekayaan. Migration ini memastikan enum dan data menggunakan
     * 'SPT Tahunan' bukan 'LHKASN'.
     */
    public function up(): void
    {
        DB::table('lhkpn_reports')->where('jenis_laporan', 'LHKASN')->update(['jenis_laporan' => 'SPT Tahunan']);
        DB::statement("ALTER TABLE lhkpn_reports MODIFY COLUMN jenis_laporan ENUM('LHKPN', 'SPT Tahunan') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE lhkpn_reports MODIFY COLUMN jenis_laporan ENUM('LHKPN', 'LHKASN') NOT NULL");
        DB::table('lhkpn_reports')->where('jenis_laporan', 'SPT Tahunan')->update(['jenis_laporan' => 'LHKASN']);
    }
};