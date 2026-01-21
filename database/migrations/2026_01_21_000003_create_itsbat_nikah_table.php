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
        Schema::create('itsbat_nikah', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_perkara')->unique();
            $table->string('pemohon_1')->nullable();
            $table->string('pemohon_2')->nullable();
            $table->date('tanggal_pengumuman')->nullable();
            $table->date('tanggal_sidang')->nullable();
            $table->text('link_detail')->nullable(); // URL can be long
            $table->year('tahun_perkara')->nullable();
            $table->timestamps();

            // Indexes for faster searching
            $table->index('tahun_perkara');
            $table->index('pemohon_1');
            $table->index('pemohon_2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itsbat_nikah');
    }
};
