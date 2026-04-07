<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SkInovasi;
use Carbon\Carbon;

class SkInovasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skInovasi = [
            [
                'tahun' => 2026,
                'nomor_sk' => '1297/KPA.W17-A8/OT1.6/XII/2025',
                'tentang' => 'Penetapan Inovasi Pelayanan Pengadilan Agama Penajam',
                'file_url' => 'https://drive.google.com/file/d/1Ns03mLpAqrOZEoXRxnGT20EKK5w7L9gf/view?usp=sharing',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($skInovasi as $sk) {
            SkInovasi::create($sk);
        }

        $this->command->info('SK Inovasi seeded successfully!');
    }
}
