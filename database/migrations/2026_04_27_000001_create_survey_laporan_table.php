<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('survey_laporan', function (Blueprint $table) {
            $table->id();
            // Kategori laporan: IKM, IPAK, atau TINDAK_LANJUT
            $table->string('kategori', 30);
            $table->integer('tahun');
            // Periode laporan, mis. "Triwulan I", "Triwulan II"
            $table->string('periode', 100);
            // Urutan tampilan dalam tahun (1..n)
            $table->integer('urutan')->default(1);
            // URL/path gambar label/thumbnail
            $table->string('gambar_url', 500)->nullable();
            // URL dokumen (Google Drive / file lokal)
            $table->string('link_dokumen', 500)->nullable();
            $table->timestamps();

            $table->index(['tahun', 'kategori']);
            $table->index('urutan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('survey_laporan');
    }
};
