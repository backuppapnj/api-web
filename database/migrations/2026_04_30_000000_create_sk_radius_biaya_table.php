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
        Schema::create('sk_radius_biaya', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            $table->string('nomor_sk');
            $table->string('tentang');
            $table->string('file_path')->nullable();
            $table->string('file_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->longText('metadata_json')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sk_radius_biaya');
    }
};
