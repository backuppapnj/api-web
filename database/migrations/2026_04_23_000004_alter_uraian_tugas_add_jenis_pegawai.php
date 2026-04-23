<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUraianTugasAddJenisPegawai extends Migration
{
    public function up(): void
    {
        Schema::table('uraian_tugas', function (Blueprint $table) {
            // Hapus kolom lama status_kepegawaian jika masih ada
            if (Schema::hasColumn('uraian_tugas', 'status_kepegawaian')) {
                $table->dropColumn('status_kepegawaian');
            }

            // Tambah kolom FK jenis_pegawai_id jika belum ada
            if (!Schema::hasColumn('uraian_tugas', 'jenis_pegawai_id')) {
                $table->unsignedBigInteger('jenis_pegawai_id')->nullable()->after('nip');
                $table->foreign('jenis_pegawai_id')
                      ->references('id')
                      ->on('jenis_pegawai')
                      ->onDelete('set null');
                $table->index('jenis_pegawai_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('uraian_tugas', function (Blueprint $table) {
            if (Schema::hasColumn('uraian_tugas', 'jenis_pegawai_id')) {
                $table->dropForeign(['jenis_pegawai_id']);
                $table->dropIndex(['jenis_pegawai_id']);
                $table->dropColumn('jenis_pegawai_id');
            }

            if (!Schema::hasColumn('uraian_tugas', 'status_kepegawaian')) {
                $table->enum('status_kepegawaian', ['PNS', 'PPNPN', 'CASN'])->nullable()->after('nip');
            }
        });
    }
}
