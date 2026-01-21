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
        Schema::create('panggilan_ghaib', function (Blueprint $table) {
            $table->id();
            $table->year('tahun_perkara');
            $table->string('nomor_perkara', 50);
            $table->string('nama_dipanggil', 255);
            $table->text('alamat_asal')->nullable();
            $table->date('panggilan_1')->nullable();
            $table->date('panggilan_2')->nullable();
            $table->date('panggilan_ikrar')->nullable();
            $table->date('tanggal_sidang')->nullable();
            $table->string('pip', 100)->nullable();
            $table->string('link_surat', 500)->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('tahun_perkara');
            $table->index('nomor_perkara');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('panggilan_ghaib');
    }
};
