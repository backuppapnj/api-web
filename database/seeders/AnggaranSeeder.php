<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaguAnggaran;
use App\Models\RealisasiAnggaran;
use Illuminate\Support\Facades\DB;

class AnggaranSeeder extends Seeder
{
    public function run()
    {
        // Truncate tables first to avoid duplicates
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        PaguAnggaran::truncate();
        RealisasiAnggaran::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $files = [
            2023 => 'Anggaran Belanja - 2023.csv',
            2024 => 'Anggaran Belanja 2024 - 2024.csv',
            2025 => 'Realisasi Anggaran 2025 - Sheet1.csv'
        ];

        foreach ($files as $tahun => $filename) {
            $path = base_path('docs/' . $filename);
            if (!file_exists($path)) continue;

            $handle = fopen($path, 'r');
            $currentDipa = '';
            $categories = [];
            $pagus = [];
            $isReadingMonths = false;
            $monthCount = 0;

            while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $firstCol = trim($row[0]);

                // Detect DIPA Section
                if (str_contains($firstCol, 'DIPA 01')) {
                    $currentDipa = 'DIPA 01';
                    $isReadingMonths = false;
                    // Extract Pagunya from line 2
                    $rowNext = fgetcsv($handle, 1000, ",");
                    $pagus = [
                        'Belanja Pegawai' => $this->parseMoney($rowNext[1]),
                        'Belanja Barang' => $this->parseMoney($rowNext[2]),
                        'Belanja Modal' => $this->parseMoney($rowNext[3])
                    ];
                    foreach ($pagus as $cat => $val) {
                        PaguAnggaran::updateOrCreate(
                            ['dipa' => $currentDipa, 'kategori' => $cat, 'tahun' => $tahun],
                            ['jumlah_pagu' => $val]
                        );
                    }
                    // Skip header row (TAHUN XXXX, Categories...)
                    fgetcsv($handle, 1000, ",");
                    $categories = ['Belanja Pegawai', 'Belanja Barang', 'Belanja Modal'];
                    $isReadingMonths = true;
                    $monthCount = 0;
                    continue;
                }

                if (str_contains($firstCol, 'DIPA 04')) {
                    $currentDipa = 'DIPA 04';
                    $isReadingMonths = false;
                    $rowNext = fgetcsv($handle, 1000, ",");
                    $pagus = [
                        'POSBAKUM' => $this->parseMoney($rowNext[1]),
                        'Pembebasan Biaya Perkara' => $this->parseMoney($rowNext[2]),
                        'Sidang Di Luar Gedung' => $this->parseMoney($rowNext[3])
                    ];
                    foreach ($pagus as $cat => $val) {
                        PaguAnggaran::updateOrCreate(
                            ['dipa' => $currentDipa, 'kategori' => $cat, 'tahun' => $tahun],
                            ['jumlah_pagu' => $val]
                        );
                    }
                    fgetcsv($handle, 1000, ",");
                    $categories = ['POSBAKUM', 'Pembebasan Biaya Perkara', 'Sidang Di Luar Gedung'];
                    $isReadingMonths = true;
                    $monthCount = 0;
                    continue;
                }

                // Parse Monthly Data
                if ($isReadingMonths && $monthCount < 12) {
                    $monthNames = ["JANUARI", "FEBRUARI", "MARET", "APRIL", "MEI", "JUNI", "JULI", "AGUSTUS", "SEPTEMBER", "OKTOBER", "NOVEMBER", "DESEMBER"];
                    if (in_array($firstCol, $monthNames)) {
                        $monthIdx = array_search($firstCol, $monthNames) + 1;
                        
                        foreach ($categories as $idx => $cat) {
                            $realisasi = $this->parseMoney($row[$idx + 1]);
                            $paguVal = $pagus[$cat] ?? 0;
                            
                            if ($realisasi > 0 || $tahun < 2025) { // Seed even if 0 for historical, but avoid empty 2025 months if needed
                                RealisasiAnggaran::create([
                                    'dipa' => $currentDipa,
                                    'kategori' => $cat,
                                    'bulan' => $monthIdx,
                                    'tahun' => $tahun,
                                    'pagu' => $paguVal,
                                    'realisasi' => $realisasi,
                                    'sisa' => $paguVal - $realisasi,
                                    'persentase' => $paguVal > 0 ? ($realisasi / $paguVal * 100) : 0,
                                    'link_dokumen' => ''
                                ]);
                            }
                        }
                        $monthCount++;
                    }
                }

                if ($firstCol == 'JUMLAH') {
                    $isReadingMonths = false;
                }
            }
            fclose($handle);
        }
    }

    private function parseMoney($val)
    {
        if (empty($val) || $val == '-' || trim($val) == 'Rp -') return 0;
        $clean = str_replace(['Rp', '.', ' ', ','], '', $val);
        return (float) $clean;
    }
}
