<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AsetBmnSeeder extends Seeder
{
    /**
     * Data dari aset-bmn.html (Joomla).
     * Catatan koreksi:
     *   - 2023 Tahunan: link asal typo "hhttps://" → digunakan link kedua yang benar.
     *   - 2022 Sem II: link pertama duplikat Sem I → digunakan link di anchor kedua.
     */
    private array $data = [
        // ── 2025 ──────────────────────────────────────────────────────────────
        ['tahun' => 2025, 'jenis_laporan' => 'Laporan Posisi BMN Di Neraca - Semester I',
            'link_dokumen' => 'https://drive.google.com/file/d/1pzVEUE2HtXQA0KqVLCMQXiia5g7D832n/view?usp=sharing'],
        ['tahun' => 2025, 'jenis_laporan' => 'Laporan Posisi BMN Di Neraca - Semester II',
            'link_dokumen' => null],
        ['tahun' => 2025, 'jenis_laporan' => 'Laporan Posisi BMN Di Neraca - Tahunan',
            'link_dokumen' => null],
        ['tahun' => 2025, 'jenis_laporan' => 'Laporan Barang Kuasa Pengguna - Persediaan - Semester I',
            'link_dokumen' => 'https://drive.google.com/file/d/1fCXYexN6ZYiq3Kdz3Fsv7E8TnhISyjq2/view?usp=sharing'],
        ['tahun' => 2025, 'jenis_laporan' => 'Laporan Barang Kuasa Pengguna - Persediaan - Semester II',
            'link_dokumen' => null],
        ['tahun' => 2025, 'jenis_laporan' => 'Laporan Kondisi Barang - Tahunan',
            'link_dokumen' => null],

        // ── 2024 ──────────────────────────────────────────────────────────────
        ['tahun' => 2024, 'jenis_laporan' => 'Laporan Posisi BMN Di Neraca - Semester I',
            'link_dokumen' => 'https://drive.google.com/file/d/1RA2fWEi9YF6nVh6WizAYgf2V50nzvAXi/view?usp=drive_link'],
        ['tahun' => 2024, 'jenis_laporan' => 'Laporan Posisi BMN Di Neraca - Semester II',
            'link_dokumen' => 'https://drive.google.com/file/d/1kRIdileTuU4Sk_ijlDZpsn49O8YPcYQq/view?usp=drive_link'],
        ['tahun' => 2024, 'jenis_laporan' => 'Laporan Posisi BMN Di Neraca - Tahunan',
            'link_dokumen' => 'https://drive.google.com/file/d/1SZ-d9mdFuPK-ksRSL2mXO_JcIQE_15eD/view?usp=drive_link'],
        ['tahun' => 2024, 'jenis_laporan' => 'Laporan Barang Kuasa Pengguna - Persediaan - Semester I',
            'link_dokumen' => 'https://drive.google.com/file/d/1LHujydX1yEtYaS5kddrDDoveanGh-5GW/view?usp=drive_link'],
        ['tahun' => 2024, 'jenis_laporan' => 'Laporan Barang Kuasa Pengguna - Persediaan - Semester II',
            'link_dokumen' => 'https://drive.google.com/file/d/1Gt_0gs2kt7z0qWQfsB9tynqhlsbU2oik/view?usp=drive_link'],
        ['tahun' => 2024, 'jenis_laporan' => 'Laporan Kondisi Barang - Tahunan',
            'link_dokumen' => 'https://drive.google.com/file/d/1SmR8aTgMyLZIDMIF7hHzDps4LJKnSSob/view?usp=drive_link'],

        // ── 2023 ──────────────────────────────────────────────────────────────
        ['tahun' => 2023, 'jenis_laporan' => 'Laporan Posisi BMN Di Neraca - Semester I',
            'link_dokumen' => 'https://drive.google.com/file/d/1FwiWJxz1dqNR-5tWWnMGrkXF-N42yyKg/view?usp=drive_link'],
        ['tahun' => 2023, 'jenis_laporan' => 'Laporan Posisi BMN Di Neraca - Semester II',
            'link_dokumen' => 'https://drive.google.com/file/d/1KremDjfECjzS7S19MhhfBfdX2LirUkvI/view?usp=drive_link'],
        // Catatan: link asal typo "hhttps://" → dipakai anchor ke-2 yang benar
        ['tahun' => 2023, 'jenis_laporan' => 'Laporan Posisi BMN Di Neraca - Tahunan',
            'link_dokumen' => 'https://drive.google.com/file/d/1jSCOcN5EjITf_Nk_j8aUWTC7HyVzjzuz/view?usp=drive_link'],
        ['tahun' => 2023, 'jenis_laporan' => 'Laporan Barang Kuasa Pengguna - Persediaan - Semester I',
            'link_dokumen' => 'https://drive.google.com/file/d/18PYvbI7tMi3L--7sAgrkyfne2O7tXEqN/view?usp=drive_link'],
        ['tahun' => 2023, 'jenis_laporan' => 'Laporan Barang Kuasa Pengguna - Persediaan - Semester II',
            'link_dokumen' => 'https://drive.google.com/file/d/1oobBbG-nT-8inA1Ntw8XJVF-aj3a-eF-/view?usp=drive_link'],
        ['tahun' => 2023, 'jenis_laporan' => 'Laporan Kondisi Barang - Tahunan',
            'link_dokumen' => 'https://drive.google.com/file/d/1SZ-d9mdFuPK-ksRSL2mXO_JcIQE_15eD/view?usp=drive_link'],

        // ── 2022 ──────────────────────────────────────────────────────────────
        ['tahun' => 2022, 'jenis_laporan' => 'Laporan Posisi BMN Di Neraca - Semester I',
            'link_dokumen' => 'https://drive.google.com/file/d/1eMLipwJGAEyBEV3Qo-DBRe4TYpAlkg5R/view?usp=drive_link'],
        ['tahun' => 2022, 'jenis_laporan' => 'Laporan Posisi BMN Di Neraca - Semester II',
            'link_dokumen' => 'https://drive.google.com/file/d/1ygyTgB07NqSGL8djq4fOw4ZXF5GBgJXi/view?usp=drive_link'],
        ['tahun' => 2022, 'jenis_laporan' => 'Laporan Posisi BMN Di Neraca - Tahunan',
            'link_dokumen' => 'https://drive.google.com/file/d/1kRIdileTuU4Sk_ijlDZpsn49O8YPcYQq/view?usp=drive_link'],
        ['tahun' => 2022, 'jenis_laporan' => 'Laporan Barang Kuasa Pengguna - Persediaan - Semester I',
            'link_dokumen' => 'https://drive.google.com/file/d/1FiUnhN0o9Xi1j3Skn4HJeEuF8FFDiOpD/view?usp=drive_link'],
        // Catatan: link pertama duplikat Sem I → digunakan link anchor ke-2 yang berbeda
        ['tahun' => 2022, 'jenis_laporan' => 'Laporan Barang Kuasa Pengguna - Persediaan - Semester II',
            'link_dokumen' => 'https://drive.google.com/file/d/17RhoYetMP_hJEmGiTk6nDLG9glW6_n_J/view?usp=drive_link'],
        ['tahun' => 2022, 'jenis_laporan' => 'Laporan Kondisi Barang - Tahunan',
            'link_dokumen' => 'https://drive.google.com/file/d/1j59odnfC1P0bi82pCcefHYWh10S3HKd8/view?usp=drive_link'],

        // ── 2021 ──────────────────────────────────────────────────────────────
        ['tahun' => 2021, 'jenis_laporan' => 'Laporan Posisi BMN Di Neraca - Semester I',
            'link_dokumen' => 'https://drive.google.com/file/d/1NYsCK33ZZWgPo9cs5HnxK4z46PldH_Ag/view?usp=sharing'],
        ['tahun' => 2021, 'jenis_laporan' => 'Laporan Posisi BMN Di Neraca - Semester II',
            'link_dokumen' => 'https://drive.google.com/file/d/14hbEF45mku9kjV3We3Imjnw0LsVq0voJ/view?usp=sharing'],
        ['tahun' => 2021, 'jenis_laporan' => 'Laporan Posisi BMN Di Neraca - Tahunan',
            'link_dokumen' => 'https://drive.google.com/file/d/1iD9t2Lfx4Dn2FkUkMmjmiHo5Uh8pc6cQ/view?usp=sharing'],
        ['tahun' => 2021, 'jenis_laporan' => 'Laporan Barang Kuasa Pengguna - Persediaan - Semester I',
            'link_dokumen' => 'https://drive.google.com/file/d/18J6FvxZhTfAySVL9zlDOr0w-Y2AUxKRg/view?usp=sharing'],
        ['tahun' => 2021, 'jenis_laporan' => 'Laporan Barang Kuasa Pengguna - Persediaan - Semester II',
            'link_dokumen' => 'https://drive.google.com/file/d/16Cq60c5Xwyyi2rbIlJUj-MqWHect97D-/view?usp=sharing'],
        ['tahun' => 2021, 'jenis_laporan' => 'Laporan Kondisi Barang - Tahunan',
            'link_dokumen' => 'https://drive.google.com/file/d/1IQwURAwTcBizVF4W6fhVwYQzwRySvayV/view?usp=sharing'],
    ];

    public function run(): void
    {
        $now = \Carbon\Carbon::now();

        foreach ($this->data as $row) {
            DB::table('aset_bmn')->updateOrInsert(
                [
                    'tahun'         => $row['tahun'],
                    'jenis_laporan' => $row['jenis_laporan'],
                ],
                [
                    'link_dokumen' => $row['link_dokumen'],
                    'updated_at'   => $now,
                    'created_at'   => $now,
                ]
            );
        }

        $this->command->info('AsetBmnSeeder: ' . count($this->data) . ' baris diproses.');
    }
}
