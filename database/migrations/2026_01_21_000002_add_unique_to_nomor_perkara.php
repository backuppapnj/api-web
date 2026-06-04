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
        // 1. Hapus duplikat (simpan 1 dengan ID terbesar).
        //    Memakai subquery standar agar kompatibel dengan MySQL dan SQLite.
        DB::statement("
            DELETE FROM panggilan_ghaib
            WHERE id NOT IN (
                SELECT keep_id FROM (
                    SELECT MAX(id) AS keep_id
                    FROM panggilan_ghaib
                    GROUP BY nomor_perkara
                ) AS keep_rows
            )
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
