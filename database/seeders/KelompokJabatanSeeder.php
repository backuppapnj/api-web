<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelompokJabatanSeeder extends Seeder
{
    public function run(): void
    {
        $kelompok = [
            ['nama_kelompok' => 'Pimpinan', 'urutan' => 1],
            ['nama_kelompok' => 'Hakim', 'urutan' => 2],
            ['nama_kelompok' => 'Kepaniteraan', 'urutan' => 3],
            ['nama_kelompok' => 'Kesekretariatan', 'urutan' => 4],
            ['nama_kelompok' => 'PPNPN', 'urutan' => 5],
        ];

        foreach ($kelompok as $k) {
            DB::table('kelompok_jabatan')->insertOrIgnore($k);
        }

        $this->command->info('Kelompok jabatan berhasil di-seed! (' . count($kelompok) . ' records)');
    }
}
