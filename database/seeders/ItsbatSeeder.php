<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ItsbatNikah;
use DOMDocument;
use DOMXPath;

class ItsbatSeeder extends Seeder
{
    public function run()
    {
        $htmlFile = base_path('../../itsbat_nikah.html'); // Adjust path to project root
        if (!file_exists($htmlFile)) {
            $this->command->error("File HTML not found at: $htmlFile");
            return;
        }

        $html = file_get_contents($htmlFile);
        $dom = new DOMDocument();
        @$dom->loadHTML($html);
        $xpath = new DOMXPath($dom);

        // Find all rows in tables
        $rows = $xpath->query('//table/tbody/tr');

        $count = 0;
        foreach ($rows as $row) {
            $cols = $xpath->query('td', $row);

            // Skip header rows (usually have 'Nomor Perkara')
            if ($cols->length > 0 && stripos($cols->item(0)->textContent, 'Nomor Perkara') !== false) {
                continue;
            }

            if ($cols->length >= 6) {
                $nomorPerkara = trim($cols->item(0)->textContent);

                // Skip empty rows
                if (empty($nomorPerkara))
                    continue;

                $pemohon1 = trim($cols->item(2)->textContent);
                $pemohon2 = trim($cols->item(3)->textContent);

                // Parse Dates (Indonesia format DD Month YYYY or DD-MM-YYYY)
                $tglUmumRaw = trim($cols->item(4)->textContent);
                $tglSidangRaw = trim($cols->item(5)->textContent);

                $tglUmum = $this->parseDate($tglUmumRaw);
                $tglSidang = $this->parseDate($tglSidangRaw);

                // Extract Link
                $link = null;
                $anchors = $xpath->query('.//a', $cols->item(6));
                if ($anchors->length > 0) {
                    $link = $anchors->item(0)->getAttribute('href');
                }

                // Extract Year from Nomor Perkara (e.g., .../2025/...)
                preg_match('/\/(\d{4})\//', $nomorPerkara, $matches);
                $tahun = $matches[1] ?? date('Y');

                try {
                    ItsbatNikah::updateOrCreate(
                        ['nomor_perkara' => $nomorPerkara],
                        [
                            'pemohon_1' => $pemohon1,
                            'pemohon_2' => $pemohon2,
                            'tanggal_pengumuman' => $tglUmum,
                            'tanggal_sidang' => $tglSidang,
                            'link_detail' => $link,
                            'tahun_perkara' => $tahun
                        ]
                    );
                    $count++;
                } catch (\Exception $e) {
                    $this->command->warn("Skipped $nomorPerkara: " . $e->getMessage());
                }
            }
        }

        $this->command->info("Seeded $count Itsbat Nikah records.");
    }

    private function parseDate($dateStr)
    {
        // Simple parser for Indonesian dates
        // Maps Indonesian months to English
        $months = [
            'Januari' => 'January',
            'Februari' => 'February',
            'Maret' => 'March',
            'April' => 'April',
            'Mei' => 'May',
            'Juni' => 'June',
            'Juli' => 'July',
            'Agustus' => 'August',
            'September' => 'September',
            'Oktober' => 'October',
            'November' => 'November',
            'Desember' => 'December',
            'Janurari' => 'January', // Typo handling
            'Septembe' => 'September', // Typo handling
        ];

        $dateStr = str_ireplace(array_keys($months), array_values($months), $dateStr);
        // Remove day names (Senin, Selasa, etc)
        $dateStr = preg_replace('/(Senin|Selasa|Rabu|Kamis|Jumat|Jum\'at|Sabtu|Minggu)[,\.]?\s*/i', '', $dateStr);
        // Replace - with spaces
        $dateStr = str_replace('-', ' ', $dateStr);

        try {
            return date('Y-m-d', strtotime($dateStr));
        } catch (\Exception $e) {
            return null;
        }
    }
}
