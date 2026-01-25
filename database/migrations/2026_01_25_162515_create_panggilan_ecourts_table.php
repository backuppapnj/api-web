<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('panggilan_ecourts', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun_perkara')->index();
            $table->string('nomor_perkara');
            $table->string('nama_dipanggil');
            $table->text('alamat_asal');
            $table->date('panggilan_1')->nullable();
            $table->date('panggilan_2')->nullable();
            $table->date('panggilan_3')->nullable();
            $table->date('panggilan_ikrar')->nullable();
            $table->date('tanggal_sidang')->nullable();
            $table->string('pip')->nullable(); // Petugas Informasi Pengadilan
            $table->string('link_surat')->nullable(); // Link Google Drive
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('panggilan_ecourts');
    }
};
