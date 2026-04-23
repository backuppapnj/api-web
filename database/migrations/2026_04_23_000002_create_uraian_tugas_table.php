<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('uraian_tugas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama', 255)->nullable();
            $table->string('jabatan', 255);
            $table->unsignedBigInteger('kelompok_jabatan_id');
            $table->string('nip', 30)->nullable();
            $table->unsignedBigInteger('jenis_pegawai_id')->nullable();
            $table->string('foto_url', 500)->nullable();
            $table->string('link_dokumen', 500)->nullable();
            $table->integer('urutan')->default(0);
            $table->timestamps();

            $table->foreign('kelompok_jabatan_id')
                  ->references('id')
                  ->on('kelompok_jabatan')
                  ->onDelete('restrict');

            $table->foreign('jenis_pegawai_id')
                  ->references('id')
                  ->on('jenis_pegawai')
                  ->onDelete('set null');

            $table->index('kelompok_jabatan_id');
            $table->index('jenis_pegawai_id');
            $table->index('urutan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('uraian_tugas');
    }
};
