<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dipapok', function (Blueprint $table) {
            $table->increments('kode_dipa');
            $table->year('thn_dipa')->index();
            $table->string('revisi_dipa', 100);
            $table->string('jns_dipa', 200);
            $table->date('tgl_dipa');
            $table->decimal('alokasi_dipa', 20, 2)->default(0);
            $table->string('doc_dipa', 500)->nullable();
            $table->string('doc_pok', 500)->nullable();
            $table->timestamps();

            $table->index(['thn_dipa', 'kode_dipa']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dipapok');
    }
};
