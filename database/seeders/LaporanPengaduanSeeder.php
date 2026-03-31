<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LaporanPengaduanSeeder extends Seeder
{
    private array $materi = [
        'Pelanggaran Terhadap Kode Etik Atau Pedoman Perilaku Hakim',
        'Penyalahgunaan Wewenang / Jabatan',
        'Pelanggaran Terhadap Disiplin PNS',
        'Perbuatan Tercela',
        'Pelanggaran Hukum Acara',
        'Kekeliruan Administrasi',
        'Pelayanan Publik Yang Tidak Memuaskan',
    ];

    public function run(): void
    {
        $now = \Carbon\Carbon::now();
        $currentYear = (int) $now->year;
        $currentMonth = (int) $now->month;

        foreach ([2025, 2024, 2023, 2022] as $tahun) {
            foreach ($this->materi as $materi) {
                $data = $this->buildData($tahun, $tahun < $currentYear, $currentYear, $currentMonth);
                $data['updated_at'] = $now;
                $data['created_at'] = $now;

                DB::table('laporan_pengaduan')->updateOrInsert(
                    ['tahun' => $tahun, 'materi_pengaduan' => $materi],
                    $data
                );
            }
        }

        $this->command->info("LaporanPengaduanSeeder: " . (4 * count($this->materi)) . " baris diproses.");
    }

    private function buildData(int $tahun, bool $isPastYear, int $currentYear, int $currentMonth): array
    {
        $bulan = ['jan','feb','mar','apr','mei','jun','jul','agu','sep','okt','nop','des'];

        $data = [];
        foreach ($bulan as $b) {
            $data[$b] = $isPastYear ? 0 : null;
        }
        $data['laporan_proses'] = $isPastYear ? 0 : null;
        $data['sisa'] = $isPastYear ? 0 : null;

        return $data;
    }
}
