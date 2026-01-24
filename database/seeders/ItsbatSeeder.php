<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ItsbatNikah;

class ItsbatSeeder extends Seeder
{
    public function run()
    {
        $jsonFile = __DIR__ . '/data_itsbat.json';

        if (!file_exists($jsonFile)) {
            $this->command->error("File JSON not found at: $jsonFile");
            return;
        }

        $json = file_get_contents($jsonFile);
        $data = json_decode($json, true);

        if (!$data) {
            $this->command->error("Error decoding JSON file");
            return;
        }

        $count = 0;
        foreach ($data as $item) {
            try {
                ItsbatNikah::updateOrCreate(
                    ['nomor_perkara' => $item['nomor_perkara']],
                    [
                        'pemohon_1' => $item['pemohon_1'],
                        'pemohon_2' => $item['pemohon_2'],
                        'tanggal_pengumuman' => $item['tanggal_pengumuman'],
                        'tanggal_sidang' => $item['tanggal_sidang'],
                        'link_detail' => $item['link_detail'],
                        'tahun_perkara' => $item['tahun_perkara']
                    ]
                );
                $count++;
            } catch (\Exception $e) {
                $this->command->warn("Skipped {$item['nomor_perkara']}: " . $e->getMessage());
            }
        }

        $this->command->info("Seeded $count Itsbat Nikah records from JSON.");
    }
}
