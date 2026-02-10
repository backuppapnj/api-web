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
        Schema::create('realisasi_anggaran', function (Blueprint $table) {
            $table->id();
            $table->string('dipa')->index(); // DIPA 01, DIPA 04
            $table->string('kategori'); // Belanja Barang, Belanja Modal, POSBAKUM, etc.
            $table->decimal('pagu', 20, 2)->default(0);
            $table->decimal('realisasi', 20, 2)->default(0);
            $table->decimal('sisa', 20, 2)->default(0);
            $table->decimal('persentase', 5, 2)->default(0);
            $table->year('tahun');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('realisasi_anggaran');
    }
};
