<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sakip', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            $table->string('jenis_dokumen', 100);
            $table->text('uraian')->nullable();
            $table->string('link_dokumen', 500)->nullable();
            $table->timestamps();

            $table->unique(['tahun', 'jenis_dokumen']);
            $table->index('tahun');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sakip');
    }
};
