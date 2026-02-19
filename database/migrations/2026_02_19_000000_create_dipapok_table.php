<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dipapok', function (Blueprint $table) {
            $table->increments('id_dipa');
            $table->string('kode_dipa', 8);
            $table->string('jns_dipa', 255)->nullable();
            $table->year('thn_dipa')->nullable();
            $table->string('revisi_dipa', 40)->nullable();
            $table->date('tgl_dipa')->nullable();
            $table->bigInteger('alokasi_dipa')->unsigned()->nullable();
            $table->string('doc_dipa', 255)->nullable();
            $table->string('doc_pok', 255)->nullable();
            $table->timestamp('tgl_update')->useCurrent()->useCurrentOnUpdate();

            $table->index('thn_dipa');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dipapok');
    }
};
