<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUraianTugasAddUraianContent extends Migration
{
    public function up(): void
    {
        Schema::table('uraian_tugas', function (Blueprint $table) {
            if (!Schema::hasColumn('uraian_tugas', 'uraian_tugas')) {
                $table->longText('uraian_tugas')->nullable()->after('link_dokumen');
            }
        });
    }

    public function down(): void
    {
        Schema::table('uraian_tugas', function (Blueprint $table) {
            if (Schema::hasColumn('uraian_tugas', 'uraian_tugas')) {
                $table->dropColumn('uraian_tugas');
            }
        });
    }
}
