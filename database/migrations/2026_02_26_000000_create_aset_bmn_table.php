<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('aset_bmn', function (Blueprint $table) {
            $table->id();
            $table->year('tahun')->index();
            $table->string('jenis_laporan');
            $table->text('link_dokumen')->nullable();
            $table->timestamps();

            $table->unique(['tahun', 'jenis_laporan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aset_bmn');
    }
};
