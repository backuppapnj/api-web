<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Hapus duplikat (simpan 1 dengan ID terbesar)
        DB::statement("
            DELETE t1 FROM panggilan_ghaib t1
            INNER JOIN panggilan_ghaib t2 
            WHERE t1.id < t2.id AND t1.nomor_perkara = t2.nomor_perkara
        ");

        // 2. Tambahkan UNIQUE constraint
        Schema::table('panggilan_ghaib', function (Blueprint $table) {
            $table->unique('nomor_perkara');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('panggilan_ghaib', function (Blueprint $table) {
            $table->dropUnique(['nomor_perkara']);
        });
    }
};
