<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tambah field skor mingguan ke survey_pekan agar bisa direnderkan
 * sebagai sparkline/chart tanpa bergantung pada gambar.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('survey_pekan', function (Blueprint $table) {
            $table->decimal('nilai_ikm', 6, 2)->nullable()->after('link_ikm');
            $table->decimal('nilai_ipkp', 6, 2)->nullable()->after('link_ipkp');
            $table->decimal('nilai_ipak', 6, 2)->nullable()->after('link_ipak');
            $table->integer('total_responden')->nullable()->after('nilai_ipak');
            $table->text('catatan')->nullable()->after('total_responden');
        });
    }

    public function down(): void
    {
        Schema::table('survey_pekan', function (Blueprint $table) {
            $table->dropColumn([
                'nilai_ikm',
                'nilai_ipkp',
                'nilai_ipak',
                'total_responden',
                'catatan',
            ]);
        });
    }
};
