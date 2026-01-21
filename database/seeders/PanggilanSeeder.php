<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PanggilanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Data awal dari panggilan_ghaib.html
     */
    public function run(): void
    {
        // Import data dari file SQL
        $sqlPath = database_path('seeders/data.sql');

        if (file_exists($sqlPath)) {
            $sql = file_get_contents($sqlPath);
            DB::unprepared($sql);
            $this->command->info('Data panggilan ghaib berhasil di-import! (193 records)');
        } else {
            $this->command->warn('File data.sql tidak ditemukan di: ' . $sqlPath);
        }
    }
}
