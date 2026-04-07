<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inovasi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_inovasi', 255);
            $table->text('deskripsi');
            $table->string('kategori', 100);
            $table->string('link_dokumen', 500)->nullable();
            $table->integer('urutan')->default(0);
            $table->timestamps();

            $table->index('kategori');
            $table->unique(['nama_inovasi', 'kategori']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inovasi');
    }
};
