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
        Schema::create('mediator_banners', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 100);
            $table->string('image_url', 500);
            $table->enum('type', ['hakim', 'non-hakim']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mediator_banners');
    }
};
