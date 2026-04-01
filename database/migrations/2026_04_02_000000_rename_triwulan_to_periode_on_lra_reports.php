<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lra_reports', function (Blueprint $table) {
            $table->dropUnique(['tahun', 'jenis_dipa', 'triwulan']);
        });

        Schema::table('lra_reports', function (Blueprint $table) {
            $table->renameColumn('triwulan', 'periode');
        });

        Schema::table('lra_reports', function (Blueprint $table) {
            $table->string('periode', 20)->change();
        });

        DB::table('lra_reports')->where('periode', '1')->update(['periode' => 'semester_1']);
        DB::table('lra_reports')->where('periode', '2')->update(['periode' => 'semester_2']);
        DB::table('lra_reports')->where('periode', '3')->update(['periode' => 'unaudited']);
        DB::table('lra_reports')->where('periode', '4')->update(['periode' => 'audited']);

        Schema::table('lra_reports', function (Blueprint $table) {
            $table->unique(['tahun', 'jenis_dipa', 'periode']);
        });
    }

    public function down(): void
    {
        Schema::table('lra_reports', function (Blueprint $table) {
            $table->dropUnique(['tahun', 'jenis_dipa', 'periode']);
        });

        DB::table('lra_reports')->where('periode', 'semester_1')->update(['periode' => '1']);
        DB::table('lra_reports')->where('periode', 'semester_2')->update(['periode' => '2']);
        DB::table('lra_reports')->where('periode', 'unaudited')->update(['periode' => '3']);
        DB::table('lra_reports')->where('periode', 'audited')->update(['periode' => '4']);

        Schema::table('lra_reports', function (Blueprint $table) {
            $table->renameColumn('periode', 'triwulan');
        });

        Schema::table('lra_reports', function (Blueprint $table) {
            $table->integer('triwulan')->change();
        });

        Schema::table('lra_reports', function (Blueprint $table) {
            $table->unique(['tahun', 'jenis_dipa', 'triwulan']);
        });
    }
};
