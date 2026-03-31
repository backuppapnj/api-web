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

        foreach ([2025, 2024, 2023, 2022] as $tahun) {
            foreach ($this->materi as $materi) {
                DB::table('laporan_pengaduan')->updateOrInsert(
                    ['tahun' => $tahun, 'materi_pengaduan' => $materi],
                    array_merge([
                        'jan' => 0, 'feb' => 0, 'mar' => 0,
                        'apr' => 0, 'mei' => 0, 'jun' => 0,
                        'jul' => 0, 'agu' => 0, 'sep' => 0,
                        'okt' => 0, 'nop' => 0, 'des' => 0,
                        'laporan_proses' => 0, 'sisa' => 0,
                        'updated_at' => $now, 'created_at' => $now,
                    ], $this->tahunData($tahun, $materi))
                );
            }
        }

        $total = 4 * count($this->materi);
        $this->command->info("LaporanPengaduanSeeder: {$total} baris diproses.");
    }

    private function tahunData(int $tahun, string $materi): array
    {
        return [];
    }
}
