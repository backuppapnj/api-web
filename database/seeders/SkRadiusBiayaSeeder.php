<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SkRadiusBiayaSeeder extends Seeder
{
    public function run(): void
    {
        // Read JSON file
        $jsonPath = base_path('docs/sk_panjar_biaya_perkara_pa_penajam.json');

        if (!file_exists($jsonPath)) {
            $this->command->warn('SkRadiusBiayaSeeder: JSON file not found at ' . $jsonPath);
            return;
        }

        $jsonContent = file_get_contents($jsonPath);
        $metadata = json_decode($jsonContent, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->command->error('SkRadiusBiayaSeeder: Failed to parse JSON file.');
            return;
        }

        $meta = $metadata['metadata'] ?? [];

        // Truncate table
        DB::table('sk_radius_biaya')->truncate();

        $now = Carbon::now();

        $insertData = [
            'tahun' => (int) date('Y', strtotime($meta['tanggal_ditetapkan'] ?? '2025-01-01')),
            'nomor_sk' => $meta['nomor_sk'] ?? '',
            'tentang' => $meta['tentang'] ?? '',
            'file_url' => null,
            'is_active' => true,
            'metadata_json' => $jsonContent,
            'created_at' => $now,
            'updated_at' => $now,
        ];

        DB::table('sk_radius_biaya')->insert($insertData);

        $this->command->info('SkRadiusBiayaSeeder: 1 SK Radius Biaya inserted.');
    }
}
