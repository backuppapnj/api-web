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
            $table->integer('jan')->default(0);
            $table->integer('feb')->default(0);
            $table->integer('mar')->default(0);
            $table->integer('apr')->default(0);
            $table->integer('mei')->default(0);
            $table->integer('jun')->default(0);
            $table->integer('jul')->default(0);
            $table->integer('agu')->default(0);
            $table->integer('sep')->default(0);
            $table->integer('okt')->default(0);
            $table->integer('nop')->default(0);
            $table->integer('des')->default(0);
            $table->integer('laporan_proses')->default(0);
            $table->integer('sisa')->default(0);
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
