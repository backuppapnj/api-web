<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update data lama: 'SPT Tahunan' menjadi 'LHKASN'
        DB::table('lhkpn_reports')->where('jenis_laporan', 'SPT Tahunan')->update(['jenis_laporan' => 'LHKASN']);

        // Ubah definisi ENUM
        DB::statement("ALTER TABLE lhkpn_reports MODIFY COLUMN jenis_laporan ENUM('LHKPN', 'LHKASN') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE lhkpn_reports MODIFY COLUMN jenis_laporan ENUM('LHKPN', 'SPT Tahunan') NOT NULL");
        DB::table('lhkpn_reports')->where('jenis_laporan', 'LHKASN')->update(['jenis_laporan' => 'SPT Tahunan']);
    }
};