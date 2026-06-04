<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Definisi enum periode yang valid (harus konsisten dengan create migration).
     *
     * @var array<int, string>
     */
    private array $periodeEnum = ['semester_1', 'semester_2', 'unaudited', 'audited'];

    /**
     * Fix kolom periode di tabel laporan_keuangan.
     * Migration ini akan add/recreate kolom dengan enum yang benar.
     *
     * Catatan: kolom periode ikut menjadi bagian dari unique index
     * (tahun, jenis_satker, periode). MySQL TIDAK mengizinkan drop kolom
     * yang masih dipakai index, sehingga index harus di-drop lebih dulu.
     */
    public function up(): void
    {
        $hasColumn = Schema::hasColumn('laporan_keuangan', 'periode');

        // Jika kolom belum ada, cukup tambahkan tanpa perlu drop apa pun.
        if (! $hasColumn) {
            Schema::table('laporan_keuangan', function (Blueprint $table) {
                $table->enum('periode', $this->periodeEnum)
                    ->after('jenis_satker')
                    ->comment('Periode laporan');
            });

            return;
        }

        // Kolom sudah ada: drop unique index yang memuat 'periode' terlebih dulu
        // agar kolom dapat di-drop, lalu recreate kolom + index.
        $this->dropPeriodeUniqueIndexIfExists();

        Schema::table('laporan_keuangan', function (Blueprint $table) {
            $table->dropColumn('periode');
        });

        Schema::table('laporan_keuangan', function (Blueprint $table) {
            $table->enum('periode', $this->periodeEnum)
                ->after('jenis_satker')
                ->comment('Periode laporan');
        });

        // Kembalikan unique constraint yang sempat di-drop.
        Schema::table('laporan_keuangan', function (Blueprint $table) {
            $table->unique(['tahun', 'jenis_satker', 'periode']);
        });
    }

    /**
     * Rollback dengan mengembalikan kolom periode ke state sebelumnya.
     */
    public function down(): void
    {
        if (! Schema::hasColumn('laporan_keuangan', 'periode')) {
            return;
        }

        // Drop index dulu sebelum drop kolom (alasan sama seperti di up()).
        $this->dropPeriodeUniqueIndexIfExists();

        Schema::table('laporan_keuangan', function (Blueprint $table) {
            $table->dropColumn('periode');
        });

        // Kembalikan kolom periode ke definisi lama (string) untuk kompatibilitas.
        Schema::table('laporan_keuangan', function (Blueprint $table) {
            $table->string('periode', 50)->after('jenis_satker');
        });
    }

    /**
     * Drop unique index (tahun, jenis_satker, periode) jika memang ada.
     * Menggunakan query ke information_schema agar aman tanpa doctrine/dbal.
     */
    private function dropPeriodeUniqueIndexIfExists(): void
    {
        $indexName = 'laporan_keuangan_tahun_jenis_satker_periode_unique';

        $exists = DB::table('information_schema.statistics')
            ->where('table_schema', DB::raw('DATABASE()'))
            ->where('table_name', 'laporan_keuangan')
            ->where('index_name', $indexName)
            ->exists();

        if ($exists) {
            Schema::table('laporan_keuangan', function (Blueprint $table) use ($indexName) {
                $table->dropUnique($indexName);
            });
        }
    }
};
