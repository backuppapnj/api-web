<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lra_reports', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            $table->string('jenis_dipa', 10);
            $table->integer('triwulan');
            $table->string('judul', 255);
            $table->string('file_url', 500);
            $table->string('cover_url', 500)->nullable();
            $table->timestamps();

            $table->unique(['tahun', 'jenis_dipa', 'triwulan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lra_reports');
    }
};
