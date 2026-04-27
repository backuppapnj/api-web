<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tambah field skor & detail ke survey_laporan agar UI publik
 * bisa render data tanpa bergantung pada gambar.
 *
 * - nilai_indeks: skor laporan (mis. IKM 86.45, IPAK 3.65)
 * - kategori_mutu: A/B/C/D atau "Sangat Baik" dst.
 * - jumlah_responden: total responden
 * - unsur_terendah / unsur_tertinggi: highlight unsur pelayanan
 * - kesimpulan: ringkasan eksekutif
 * - rekomendasi: action items
 *
 * Untuk kategori TINDAK_LANJUT, field skor boleh NULL —
 * UI akan adaptif menampilkan kartu sederhana.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('survey_laporan', function (Blueprint $table) {
            $table->decimal('nilai_indeks', 6, 2)->nullable()->after('urutan');
            $table->string('kategori_mutu', 30)->nullable()->after('nilai_indeks');
            $table->integer('jumlah_responden')->nullable()->after('kategori_mutu');
            $table->string('unsur_terendah', 255)->nullable()->after('jumlah_responden');
            $table->string('unsur_tertinggi', 255)->nullable()->after('unsur_terendah');
            $table->text('kesimpulan')->nullable()->after('unsur_tertinggi');
            $table->text('rekomendasi')->nullable()->after('kesimpulan');
        });
    }

    public function down(): void
    {
        Schema::table('survey_laporan', function (Blueprint $table) {
            $table->dropColumn([
                'nilai_indeks',
                'kategori_mutu',
                'jumlah_responden',
                'unsur_terendah',
                'unsur_tertinggi',
                'kesimpulan',
                'rekomendasi',
            ]);
        });
    }
};
