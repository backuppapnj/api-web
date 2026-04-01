<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mou', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('instansi');
            $table->text('tentang');
            $table->date('tanggal_berakhir')->nullable();
            $table->string('link_dokumen', 500)->nullable();
            $table->year('tahun');
            $table->timestamps();

            $table->index('tahun');
            $table->index('tanggal');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mou');
    }
};