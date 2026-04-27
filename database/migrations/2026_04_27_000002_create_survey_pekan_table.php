<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('survey_pekan', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            // 3 indikator survey mingguan: IKM, IPKP, IPAK
            $table->string('gambar_ikm', 500)->nullable();
            $table->string('link_ikm', 500)->nullable();
            $table->string('gambar_ipkp', 500)->nullable();
            $table->string('link_ipkp', 500)->nullable();
            $table->string('gambar_ipak', 500)->nullable();
            $table->string('link_ipak', 500)->nullable();
            $table->timestamps();

            $table->index('tahun');
            $table->index('tanggal_mulai');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('survey_pekan');
    }
};
