<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('keuangan_perkara', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('tahun');
            $table->tinyInteger('bulan'); // 1–12
            $table->bigInteger('saldo_awal')->nullable(); // carry-over tahun sebelumnya, diisi hanya bulan=1
            $table->bigInteger('penerimaan')->nullable();
            $table->bigInteger('pengeluaran')->nullable();
            $table->string('url_detail', 1000)->nullable();
            $table->timestamps();

            $table->unique(['tahun', 'bulan']);
            $table->index('tahun');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keuangan_perkara');
    }
};
