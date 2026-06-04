<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Fix kolom periode di tabel laporan_keuangan.
     * Migration ini akan drop dan recreate kolom dengan enum yang benar.
     */
    public function up(): void
    {
        // Drop kolom periode yang lama
        Schema::table('laporan_keuangan', function (Blueprint $table) {
            $table->dropColumn('periode');
        });

        // Tambah kolom periode dengan enum yang benar
        Schema::table('laporan_keuangan', function (Blueprint $table) {
            $table->enum('periode', ['semester_1', 'semester_2', 'unaudited', 'audited'])
                ->after('jenis_satker')
                ->comment('Periode laporan');
        });
    }

    /**
     * Rollback dengan mengembalikan kolom periode ke state sebelumnya.
     */
    public function down(): void
    {
        Schema::table('laporan_keuangan', function (Blueprint $table) {
            $table->dropColumn('periode');
        });

        // Kembalikan kolom periode ke definisi lama (jika ada)
        Schema::table('laporan_keuangan', function (Blueprint $table) {
            $table->string('periode', 50)->after('jenis_satker');
        });
    }
};
