<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DipaPok;
use Illuminate\Support\Facades\DB;

class DipaPokSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DipaPok::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = [
            [
                'thn_dipa' => 2026,
                'revisi_dipa' => 'DIPA Awal',
                'jns_dipa' => 'DIPA 01 - Belanja Pegawai',
                'tgl_dipa' => '2026-01-02',
                'alokasi_dipa' => 1500000000,
                'doc_dipa' => null,
                'doc_pok' => null,
            ],
            [
                'thn_dipa' => 2026,
                'revisi_dipa' => 'DIPA Awal',
                'jns_dipa' => 'DIPA 04 - Belanja Persidangan',
                'tgl_dipa' => '2026-01-02',
                'alokasi_dipa' => 250000000,
                'doc_dipa' => null,
                'doc_pok' => null,
            ],
            [
                'thn_dipa' => 2025,
                'revisi_dipa' => 'DIPA Pertama',
                'jns_dipa' => 'DIPA 01 - Belanja Pegawai',
                'tgl_dipa' => '2025-01-03',
                'alokasi_dipa' => 1450000000,
                'doc_dipa' => null,
                'doc_pok' => null,
            ],
            [
                'thn_dipa' => 2025,
                'revisi_dipa' => 'DIPA Pertama',
                'jns_dipa' => 'DIPA 04 - Belanja Persidangan',
                'tgl_dipa' => '2025-01-03',
                'alokasi_dipa' => 230000000,
                'doc_dipa' => null,
                'doc_pok' => null,
            ],
            [
                'thn_dipa' => 2025,
                'revisi_dipa' => 'DIPA Kedua',
                'jns_dipa' => 'DIPA 01 - Belanja Pegawai',
                'tgl_dipa' => '2025-07-15',
                'alokasi_dipa' => 1480000000,
                'doc_dipa' => null,
                'doc_pok' => null,
            ],
            [
                'thn_dipa' => 2025,
                'revisi_dipa' => 'DIPA Kedua',
                'jns_dipa' => 'DIPA 04 - Belanja Persidangan',
                'tgl_dipa' => '2025-07-15',
                'alokasi_dipa' => 245000000,
                'doc_dipa' => null,
                'doc_pok' => null,
            ],
            [
                'thn_dipa' => 2024,
                'revisi_dipa' => 'DIPA Awal',
                'jns_dipa' => 'DIPA 01 - Belanja Pegawai',
                'tgl_dipa' => '2024-01-02',
                'alokasi_dipa' => 1400000000,
                'doc_dipa' => null,
                'doc_pok' => null,
            ],
            [
                'thn_dipa' => 2024,
                'revisi_dipa' => 'DIPA Awal',
                'jns_dipa' => 'DIPA 04 - Belanja Persidangan',
                'tgl_dipa' => '2024-01-02',
                'alokasi_dipa' => 220000000,
                'doc_dipa' => null,
                'doc_pok' => null,
            ],
            [
                'thn_dipa' => 2024,
                'revisi_dipa' => 'DIPA Ketiga',
                'jns_dipa' => 'DIPA 01 - Belanja Pegawai',
                'tgl_dipa' => '2024-10-20',
                'alokasi_dipa' => 1420000000,
                'doc_dipa' => null,
                'doc_pok' => null,
            ],
            [
                'thn_dipa' => 2024,
                'revisi_dipa' => 'DIPA Ketiga',
                'jns_dipa' => 'DIPA 04 - Belanja Persidangan',
                'tgl_dipa' => '2024-10-20',
                'alokasi_dipa' => 235000000,
                'doc_dipa' => null,
                'doc_pok' => null,
            ],
            [
                'thn_dipa' => 2023,
                'revisi_dipa' => 'DIPA Awal',
                'jns_dipa' => 'DIPA 01 - Belanja Pegawai',
                'tgl_dipa' => '2023-01-03',
                'alokasi_dipa' => 1350000000,
                'doc_dipa' => null,
                'doc_pok' => null,
            ],
            [
                'thn_dipa' => 2023,
                'revisi_dipa' => 'DIPA Awal',
                'jns_dipa' => 'DIPA 04 - Belanja Persidangan',
                'tgl_dipa' => '2023-01-03',
                'alokasi_dipa' => 200000000,
                'doc_dipa' => null,
                'doc_pok' => null,
            ],
        ];

        foreach ($data as $item) {
            DipaPok::create($item);
        }

        $this->command->info('DipaPokSeeder: ' . count($data) . ' records inserted.');
    }
}
