<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UraianTugasJsonSeeder extends Seeder
{
    public function run(): void
    {
        $jsonPath = base_path('docs/URAIAN_TUGAS_MEJAA.json');

        if (!file_exists($jsonPath)) {
            $this->command->error('File JSON tidak ditemukan: ' . $jsonPath);
            return;
        }

        $json = json_decode(file_get_contents($jsonPath), true);

        if (empty($json['pegawai'])) {
            $this->command->error('Data pegawai kosong dalam JSON.');
            return;
        }

        $kelompokMap = DB::table('kelompok_jabatan')->pluck('id', 'nama_kelompok');
        $jenisMap = DB::table('jenis_pegawai')->pluck('id', 'nama');

        $now = \Carbon\Carbon::now();
        $records = [];

        foreach ($json['pegawai'] as $index => $p) {
            $nama = $this->cleanNama($p['nama'] ?? null);
            $jabatan = $p['jabatan'] ?? null;
            $pangkat = $p['pangkat_golongan'] ?? '';

            $kelompokId = $this->mapKelompok($jabatan, $kelompokMap);
            $jenisId = $this->mapJenis($pangkat, $jenisMap);

            $html = $this->buildHtml($p);

            $records[] = [
                'nama'                => $nama,
                'jabatan'             => $jabatan,
                'kelompok_jabatan_id' => $kelompokId,
                'jenis_pegawai_id'    => $jenisId,
                'nip'                 => $p['nip'] ?? null,
                'foto_url'            => null,
                'link_dokumen'        => null,
                'uraian_tugas'        => $html,
                'urutan'              => $index,
                'created_at'          => $now,
                'updated_at'          => $now,
            ];
        }

        DB::table('uraian_tugas')->delete();
        DB::table('uraian_tugas')->insert($records);

        $this->command->info('Uraian tugas dari JSON berhasil di-seed! (' . count($records) . ' records)');
    }

    private function cleanNama(?string $nama): ?string
    {
        if ($nama === null) {
            return null;
        }
        // Fix typo dari JSON
        $nama = str_replace('NahdiyantiI', 'Nahdiyanti', $nama);
        $nama = str_replace('A.Md.Kom.', 'A.Md. Kom.', $nama);
        $nama = str_replace('A.Md.A.B.', 'A.Md. A.B.', $nama);
        return trim($nama);
    }

    private function mapKelompok(?string $jabatan, $kelompokMap): int
    {
        if ($jabatan === null) {
            return $kelompokMap['Kesekretariatan'] ?? 4;
        }

        $j = strtolower($jabatan);

        if (str_contains($j, 'ketua') && !str_contains($j, 'wakil')) {
            return $kelompokMap['Pimpinan'] ?? 1;
        }
        if (str_contains($j, 'wakil ketua')) {
            return $kelompokMap['Pimpinan'] ?? 1;
        }
        if (str_contains($j, 'hakim')) {
            return $kelompokMap['Hakim'] ?? 2;
        }
        if (str_contains($j, 'panitera') || str_contains($j, 'juru sita') || str_contains($j, 'jurusita')) {
            return $kelompokMap['Kepaniteraan'] ?? 3;
        }
        if (str_contains($j, 'klerek') || str_contains($j, 'dokumentalis') || str_contains($j, 'pengelola penanganan perkara')) {
            return $kelompokMap['Kepaniteraan'] ?? 3;
        }
        if (str_contains($j, 'sekretaris')) {
            return $kelompokMap['Kesekretariatan'] ?? 4;
        }
        if (str_contains($j, 'kasubag') || str_contains($j, 'pranata komputer') || str_contains($j, 'teknisi')) {
            return $kelompokMap['Kesekretariatan'] ?? 4;
        }
        if (str_contains($j, 'pengelola umum') || str_contains($j, 'operator')) {
            return $kelompokMap['Kesekretariatan'] ?? 4;
        }

        return $kelompokMap['Kesekretariatan'] ?? 4;
    }

    private function mapJenis(string $pangkat, $jenisMap): ?int
    {
        if (str_contains(strtolower($pangkat), 'pppk')) {
            return $jenisMap['PPNPN'] ?? null;
        }
        return $jenisMap['PNS'] ?? null;
    }

    private function buildHtml(array $p): string
    {
        $html = '<div class="ut-detail">';

        // Header meta
        $html .= '<div class="ut-meta">';
        if (!empty($p['nip'])) {
            $html .= '<p><strong>NIP:</strong> ' . e($p['nip']) . '</p>';
        }
        if (!empty($p['pangkat_golongan'])) {
            $html .= '<p><strong>Pangkat / Golongan:</strong> ' . e($p['pangkat_golongan']) . '</p>';
        }
        if (!empty($p['atasan_langsung'])) {
            $html .= '<p><strong>Atasan Langsung:</strong> ' . e($p['atasan_langsung']) . '</p>';
        }
        if (!empty($p['dasar_hukum'])) {
            $html .= '<p><strong>Dasar Hukum:</strong> ' . e($p['dasar_hukum']) . '</p>';
        }
        $html .= '</div>';

        // Deskripsi
        if (!empty($p['deskripsi_jabatan'])) {
            $html .= '<div class="ut-section">';
            $html .= '<h4>Deskripsi Jabatan</h4>';
            $html .= '<p>' . e($p['deskripsi_jabatan']) . '</p>';
            $html .= '</div>';
        }

        // Tugas pokok
        if (!empty($p['tugas']) && is_array($p['tugas'])) {
            $html .= '<div class="ut-section">';
            $html .= '<h4>Tugas Pokok</h4>';
            $html .= '<ol>';
            foreach ($p['tugas'] as $tugas) {
                $html .= '<li>' . e($tugas) . '</li>';
            }
            $html .= '</ol>';
            $html .= '</div>';
        }

        // Tugas tambahan
        if (!empty($p['tugas_tambahan'])) {
            $html .= $this->buildTugasTambahanHtml($p['tugas_tambahan']);
        }

        $html .= '</div>';

        return $html;
    }

    private function buildTugasTambahanHtml($tugasTambahan): string
    {
        $html = '';

        // Bisa object tunggal atau array of objects
        $items = isset($tugasTambahan[0]) ? $tugasTambahan : [$tugasTambahan];

        foreach ($items as $item) {
            if (empty($item['tugas']) || !is_array($item['tugas'])) {
                continue;
            }

            $fungsi = $item['fungsi'] ?? ($item['jabatan_plt'] ?? 'Tugas Tambahan');
            $dasar = $item['dasar_hukum'] ?? null;
            $deskripsi = $item['deskripsi'] ?? null;

            $html .= '<div class="ut-section ut-tambahan">';
            $html .= '<h4>Tugas Tambahan &mdash; ' . e($fungsi) . '</h4>';

            if ($dasar) {
                $html .= '<p class="ut-dasar"><strong>Dasar Hukum:</strong> ' . e($dasar) . '</p>';
            }
            if ($deskripsi) {
                $html .= '<p>' . e($deskripsi) . '</p>';
            }

            $html .= '<ol>';
            foreach ($item['tugas'] as $tugas) {
                $html .= '<li>' . e($tugas) . '</li>';
            }
            $html .= '</ol>';
            $html .= '</div>';
        }

        return $html;
    }
}
