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
        Schema::table('lhkpn_reports', function (Blueprint $table) {
            $table->text('link_pengumuman')->nullable()->after('link_tanda_terima');
            $table->text('link_spt')->nullable()->after('link_pengumuman');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lhkpn_reports', function (Blueprint $table) {
            $table->dropColumn(['link_pengumuman', 'link_spt']);
        });
    }
};
