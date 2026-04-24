<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisPegawaiSeeder extends Seeder
{
    public function run(): void
    {
        $jenis = [
            ['nama' => 'PNS', 'urutan' => 1],
            ['nama' => 'PPNPN', 'urutan' => 2],
            ['nama' => 'CASN', 'urutan' => 3],
        ];

        foreach ($jenis as $j) {
            DB::table('jenis_pegawai')->insertOrIgnore($j);
        }

        $this->command->info('Jenis pegawai berhasil di-seed! (' . count($jenis) . ' records)');
    }
}
