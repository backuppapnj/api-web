<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lhkpn_reports', function (Blueprint $table) {
            $table->id();
            $table->string('nip')->index();
            $table->string('nama');
            $table->string('jabatan');
            $table->year('tahun');
            $table->enum('jenis_laporan', ['LHKPN', 'SPT Tahunan']);
            $table->date('tanggal_lapor')->nullable();
            $table->text('link_tanda_terima')->nullable();
            $table->text('link_dokumen_pendukung')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lhkpn_reports');
    }
};
