<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSisaPanjarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sisa_panjar', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            $table->tinyInteger('bulan'); // 1-12 untuk Jan-Des
            $table->string('nomor_perkara', 100);
            $table->string('nama_penggugat_pemohon', 255);
            $table->decimal('jumlah_sisa_panjar', 15, 2);
            $table->enum('status', ['belum_diambil', 'disetor_kas_negara'])->default('belum_diambil');
            $table->date('tanggal_setor_kas_negara')->nullable();
            $table->timestamps();

            // Index untuk performa query
            $table->index(['tahun', 'bulan']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sisa_panjar');
    }
}
