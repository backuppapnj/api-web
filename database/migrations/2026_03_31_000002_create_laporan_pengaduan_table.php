<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_pengaduan', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            $table->string('materi_pengaduan', 150);
            $table->integer('jan')->nullable();
            $table->integer('feb')->nullable();
            $table->integer('mar')->nullable();
            $table->integer('apr')->nullable();
            $table->integer('mei')->nullable();
            $table->integer('jun')->nullable();
            $table->integer('jul')->nullable();
            $table->integer('agu')->nullable();
            $table->integer('sep')->nullable();
            $table->integer('okt')->nullable();
            $table->integer('nop')->nullable();
            $table->integer('des')->nullable();
            $table->integer('laporan_proses')->nullable();
            $table->integer('sisa')->nullable();
            $table->timestamps();

            $table->unique(['tahun', 'materi_pengaduan']);
            $table->index('tahun');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_pengaduan');
    }
};
