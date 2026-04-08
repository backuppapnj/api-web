<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SkInovasiSeeder extends Seeder
{
    private array $data = [
        [
            'tahun' => 2026,
            'nomor_sk' => '1297/KPA.W17-A8/OT1.6/XII/2025',
            'tentang' => 'Penetapan Inovasi dan Aplikasi Tahun 2026 pada Pengadilan Agama Penajam',
            'file_url' => 'https://drive.google.com/file/d/1-Z-ncf0pIBs-yfxSCmrpQotKVaMLqn90/view?usp=drive_link',
            'is_active' => true,
        ],
    ];

    public function run(): void
    {
        // Truncate table untuk clean slate
        DB::table('sk_inovasi')->truncate();

        $now = Carbon::now();

        // Batch insert semua data
        $insertData = array_map(function ($row) use ($now) {
            return [
                'tahun' => $row['tahun'],
                'nomor_sk' => $row['nomor_sk'],
                'tentang' => $row['tentang'],
                'file_url' => $row['file_url'],
                'is_active' => $row['is_active'],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }, $this->data);

        DB::table('sk_inovasi')->insert($insertData);

        $this->command->info('SkInovasiSeeder: ' . count($this->data) . ' SK Inovasi diproses.');
    }
}
