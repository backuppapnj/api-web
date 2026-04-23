<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kelompok_jabatan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_kelompok', 100)->unique();
            $table->integer('urutan')->default(0);
            $table->timestamps();

            $table->index('urutan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelompok_jabatan');
    }
};
