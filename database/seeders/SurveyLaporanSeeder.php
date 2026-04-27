<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SurveyLaporanSeeder extends Seeder
{
    /**
     * Base URL untuk gambar yang masih dihosting di situs Joomla lama.
     */
    private const IMG = 'https://pa-penajam.go.id/';

    /**
     * Data laporan survey diekstrak dari survey-page.html (Joomla lama).
     * Kategori: IKM (Survei Kepuasan Masyarakat), IPAK (Indeks Persepsi Anti Korupsi),
     * TINDAK_LANJUT (Tindak Lanjut Hasil Survei).
     */
    private array $data = [
        // ── IKM ─────────────────────────────────────────────────────────────
        // 2025
        ['kategori' => 'IKM', 'tahun' => 2025, 'periode' => 'Triwulan I',  'urutan' => 1, 'gambar_url' => self::IMG . 'images/gambar/1.png',    'link_dokumen' => 'https://drive.google.com/file/d/1GQXtCCFfZIKstT5wIk2iodJESJlzNCi9/view?usp=sharing'],
        ['kategori' => 'IKM', 'tahun' => 2025, 'periode' => 'Triwulan II', 'urutan' => 2, 'gambar_url' => self::IMG . 'images/gambar/2.png',    'link_dokumen' => 'https://drive.google.com/file/d/1U6GopgIG9PF_yHQauEviCVEaM1v_eIwB/view?usp=sharing'],
        ['kategori' => 'IKM', 'tahun' => 2025, 'periode' => 'Triwulan III','urutan' => 3, 'gambar_url' => self::IMG . 'images/gambar/3.png',    'link_dokumen' => 'https://drive.google.com/file/d/1ChGL2cjoH-55FYUxzDL5adUtAxIIESI4/view?usp=sharing'],
        ['kategori' => 'IKM', 'tahun' => 2025, 'periode' => 'Triwulan IV', 'urutan' => 4, 'gambar_url' => self::IMG . 'images/TW-IV.webp',      'link_dokumen' => 'https://drive.google.com/file/d/1xhsOFVtkKTGT1x5gHuofS6UnTC86U-xv/view?usp=sharing'],
        // 2024
        ['kategori' => 'IKM', 'tahun' => 2024, 'periode' => 'Triwulan I',  'urutan' => 1, 'gambar_url' => self::IMG . 'images/gambar/1.png',    'link_dokumen' => 'https://drive.google.com/file/d/1GMOebzNL5PVXx_57nFvTAphO7TNot8NH/view?usp=sharing'],
        ['kategori' => 'IKM', 'tahun' => 2024, 'periode' => 'Triwulan II', 'urutan' => 2, 'gambar_url' => self::IMG . 'images/gambar/2.png',    'link_dokumen' => 'https://drive.google.com/file/d/1U6GopgIG9PF_yHQauEviCVEaM1v_eIwB/view?usp=drive_link'],
        ['kategori' => 'IKM', 'tahun' => 2024, 'periode' => 'Triwulan III','urutan' => 3, 'gambar_url' => self::IMG . 'images/gambar/3.png',    'link_dokumen' => 'https://drive.google.com/file/d/1-VzY1kpZgz-a8dI4rPUfFX5G2-n_L2b9/view?usp=drive_link'],
        ['kategori' => 'IKM', 'tahun' => 2024, 'periode' => 'Triwulan IV', 'urutan' => 4, 'gambar_url' => self::IMG . 'images/gambar/4.png',    'link_dokumen' => 'https://drive.google.com/file/d/19A5SDFKkp2GOzVEBMhm8Mrn6-CYhbNL8/view?usp=sharing'],
        // 2023
        ['kategori' => 'IKM', 'tahun' => 2023, 'periode' => 'Triwulan I',  'urutan' => 1, 'gambar_url' => self::IMG . 'images/gambar/1.png',    'link_dokumen' => 'https://drive.google.com/file/d/1tMjRBk0e_m7XlDf6dEZUR1zH4IASNMf2/view?usp=drive_link'],
        ['kategori' => 'IKM', 'tahun' => 2023, 'periode' => 'Triwulan II', 'urutan' => 2, 'gambar_url' => self::IMG . 'images/gambar/2.png',    'link_dokumen' => 'https://drive.google.com/file/d/19EwxKR1GVzkG0Nr9CiWcXkQcB0GxGCxm/view?usp=drive_link'],
        ['kategori' => 'IKM', 'tahun' => 2023, 'periode' => 'Triwulan III','urutan' => 3, 'gambar_url' => self::IMG . 'images/gambar/3.png',    'link_dokumen' => 'https://drive.google.com/file/d/1Xj2eDuMMs7f1zecNibq9QHKYrV-St7qr/view?usp=drive_link'],
        ['kategori' => 'IKM', 'tahun' => 2023, 'periode' => 'Triwulan IV', 'urutan' => 4, 'gambar_url' => self::IMG . 'images/gambar/4.png',    'link_dokumen' => 'https://drive.google.com/file/d/1wM3HuietRtEPdgXHJGtvnw0OO3gtO2kJ/view?usp=drive_link'],
        // 2022
        ['kategori' => 'IKM', 'tahun' => 2022, 'periode' => 'Triwulan I',  'urutan' => 1, 'gambar_url' => self::IMG . 'images/gambar/1.png',    'link_dokumen' => 'https://drive.google.com/drive/folders/1dT67PyoIc3kLvJfBYidpW1XQuEH3yYLz?usp=sharing'],
        ['kategori' => 'IKM', 'tahun' => 2022, 'periode' => 'Triwulan II', 'urutan' => 2, 'gambar_url' => self::IMG . 'images/gambar/2.png',    'link_dokumen' => null],
        ['kategori' => 'IKM', 'tahun' => 2022, 'periode' => 'Triwulan III','urutan' => 3, 'gambar_url' => self::IMG . 'images/gambar/3.png',    'link_dokumen' => null],
        ['kategori' => 'IKM', 'tahun' => 2022, 'periode' => 'Triwulan IV', 'urutan' => 4, 'gambar_url' => self::IMG . 'images/gambar/4.png',    'link_dokumen' => null],
        // 2021
        ['kategori' => 'IKM', 'tahun' => 2021, 'periode' => 'Triwulan I',  'urutan' => 1, 'gambar_url' => self::IMG . 'images/picture/LAPORAN1.jpg', 'link_dokumen' => 'https://drive.google.com/file/d/1aZltxdOdQboPbBjbvqR6UrztYdwyWmZM/view?usp=sharing'],
        ['kategori' => 'IKM', 'tahun' => 2021, 'periode' => 'Triwulan II', 'urutan' => 2, 'gambar_url' => self::IMG . 'images/picture/LAPORAN2.jpg', 'link_dokumen' => 'https://drive.google.com/file/d/1P85OJl-ZbpOpVobaQU30eCFumgCr5-wV/view?usp=sharing'],
        ['kategori' => 'IKM', 'tahun' => 2021, 'periode' => 'Triwulan III','urutan' => 3, 'gambar_url' => self::IMG . 'images/picture/LAPORAN3.jpg', 'link_dokumen' => 'https://drive.google.com/file/d/1F7w468JLRQ63lDKcEeafOjwza0mZ7eF0/view?usp=sharing'],
        ['kategori' => 'IKM', 'tahun' => 2021, 'periode' => 'Triwulan IV', 'urutan' => 4, 'gambar_url' => self::IMG . 'images/picture/LAPORAN4.jpg', 'link_dokumen' => 'https://drive.google.com/file/d/1lKQJw1RKA2JmHurk0dCF1XBEFz3HZU8k/view'],

        // ── IPAK ────────────────────────────────────────────────────────────
        // 2025 (TW IV belum ada)
        ['kategori' => 'IPAK', 'tahun' => 2025, 'periode' => 'Triwulan I',  'urutan' => 1, 'gambar_url' => self::IMG . 'images/gambar/ipk/5.png', 'link_dokumen' => 'https://drive.google.com/file/d/1iJB35nk1zN8UGvPs1QnO4b6DMUrTPft3/view?usp=sharing'],
        ['kategori' => 'IPAK', 'tahun' => 2025, 'periode' => 'Triwulan II', 'urutan' => 2, 'gambar_url' => self::IMG . 'images/gambar/ipk/6.png', 'link_dokumen' => 'https://drive.google.com/file/d/14-3PtFXdRsmETrJ5Jf4NvzvW2VwuxEkL/view?usp=sharing'],
        ['kategori' => 'IPAK', 'tahun' => 2025, 'periode' => 'Triwulan III','urutan' => 3, 'gambar_url' => self::IMG . 'images/gambar/ipk/7.png', 'link_dokumen' => 'https://drive.google.com/file/d/1E17qlQqQQyUcfJDBvtwBMX-ucV1zzLKt/view?usp=sharing'],
        // 2024
        ['kategori' => 'IPAK', 'tahun' => 2024, 'periode' => 'Triwulan I',  'urutan' => 1, 'gambar_url' => self::IMG . 'images/gambar/ipk/5.png', 'link_dokumen' => 'https://drive.google.com/file/d/1GMOebzNL5PVXx_57nFvTAphO7TNot8NH/view?usp=drive_link'],
        ['kategori' => 'IPAK', 'tahun' => 2024, 'periode' => 'Triwulan II', 'urutan' => 2, 'gambar_url' => self::IMG . 'images/gambar/ipk/6.png', 'link_dokumen' => 'https://drive.google.com/file/d/1BMQE4rV1wgQ0kVScEtZioP7CnKFm6HT9/view?usp=drive_link'],
        ['kategori' => 'IPAK', 'tahun' => 2024, 'periode' => 'Triwulan III','urutan' => 3, 'gambar_url' => self::IMG . 'images/gambar/ipk/7.png', 'link_dokumen' => 'https://drive.google.com/file/d/1unnD5xi2GAFc4APbIqCarVUhf-RQwT4J/view?usp=drive_link'],
        ['kategori' => 'IPAK', 'tahun' => 2024, 'periode' => 'Triwulan IV', 'urutan' => 4, 'gambar_url' => self::IMG . 'images/gambar/ipk/8.png', 'link_dokumen' => 'https://drive.google.com/file/d/1-LmJlzeZNv8F3UaQoWYnlMQMPNooRh7-/view?usp=sharing'],
        // 2023
        ['kategori' => 'IPAK', 'tahun' => 2023, 'periode' => 'Triwulan I',  'urutan' => 1, 'gambar_url' => self::IMG . 'images/gambar/ipk/5.png', 'link_dokumen' => 'https://drive.google.com/file/d/1tMjRBk0e_m7XlDf6dEZUR1zH4IASNMf2/view?usp=drive_link'],
        ['kategori' => 'IPAK', 'tahun' => 2023, 'periode' => 'Triwulan II', 'urutan' => 2, 'gambar_url' => self::IMG . 'images/gambar/ipk/6.png', 'link_dokumen' => 'https://drive.google.com/file/d/19EwxKR1GVzkG0Nr9CiWcXkQcB0GxGCxm/view?usp=drive_link'],
        ['kategori' => 'IPAK', 'tahun' => 2023, 'periode' => 'Triwulan III','urutan' => 3, 'gambar_url' => self::IMG . 'images/gambar/ipk/7.png', 'link_dokumen' => 'https://drive.google.com/file/d/1Xj2eDuMMs7f1zecNibq9QHKYrV-St7qr/view?usp=drive_link'],
        ['kategori' => 'IPAK', 'tahun' => 2023, 'periode' => 'Triwulan IV', 'urutan' => 4, 'gambar_url' => self::IMG . 'images/gambar/ipk/8.png', 'link_dokumen' => 'https://drive.google.com/file/d/1wM3HuietRtEPdgXHJGtvnw0OO3gtO2kJ/view?usp=drive_link'],
        // 2022
        ['kategori' => 'IPAK', 'tahun' => 2022, 'periode' => 'Triwulan I',  'urutan' => 1, 'gambar_url' => self::IMG . 'images/gambar/ipk/5.png', 'link_dokumen' => 'https://drive.google.com/drive/folders/1dT67PyoIc3kLvJfBYidpW1XQuEH3yYLz?usp=sharing'],
        ['kategori' => 'IPAK', 'tahun' => 2022, 'periode' => 'Triwulan II', 'urutan' => 2, 'gambar_url' => self::IMG . 'images/gambar/ipk/6.png', 'link_dokumen' => null],
        ['kategori' => 'IPAK', 'tahun' => 2022, 'periode' => 'Triwulan III','urutan' => 3, 'gambar_url' => self::IMG . 'images/gambar/ipk/7.png', 'link_dokumen' => null],
        ['kategori' => 'IPAK', 'tahun' => 2022, 'periode' => 'Triwulan IV', 'urutan' => 4, 'gambar_url' => self::IMG . 'images/gambar/ipk/8.png', 'link_dokumen' => null],
        // 2021
        ['kategori' => 'IPAK', 'tahun' => 2021, 'periode' => 'Triwulan I',  'urutan' => 1, 'gambar_url' => self::IMG . 'images/gambar/ipk/5.png', 'link_dokumen' => 'https://drive.google.com/file/d/1aZltxdOdQboPbBjbvqR6UrztYdwyWmZM/view?usp=sharing'],
        ['kategori' => 'IPAK', 'tahun' => 2021, 'periode' => 'Triwulan II', 'urutan' => 2, 'gambar_url' => self::IMG . 'images/gambar/ipk/6.png', 'link_dokumen' => 'https://drive.google.com/file/d/1P85OJl-ZbpOpVobaQU30eCFumgCr5-wV/view?usp=sharing'],
        ['kategori' => 'IPAK', 'tahun' => 2021, 'periode' => 'Triwulan III','urutan' => 3, 'gambar_url' => self::IMG . 'images/gambar/ipk/7.png', 'link_dokumen' => 'https://drive.google.com/file/d/1F7w468JLRQ63lDKcEeafOjwza0mZ7eF0/view?usp=sharing'],
        ['kategori' => 'IPAK', 'tahun' => 2021, 'periode' => 'Triwulan IV', 'urutan' => 4, 'gambar_url' => self::IMG . 'images/gambar/ipk/8.png', 'link_dokumen' => 'https://drive.google.com/file/d/1lKQJw1RKA2JmHurk0dCF1XBEFz3HZU8k/view?usp=sharing'],

        // ── TINDAK LANJUT ───────────────────────────────────────────────────
        // 2025 (TW IV belum ada)
        ['kategori' => 'TINDAK_LANJUT', 'tahun' => 2025, 'periode' => 'Triwulan I',  'urutan' => 1, 'gambar_url' => self::IMG . 'images/gambar/9.png',  'link_dokumen' => 'https://drive.google.com/file/d/1YV6SAcIVf5G8IzL4xGYkd10OP42_Eb21/view?usp=sharing'],
        ['kategori' => 'TINDAK_LANJUT', 'tahun' => 2025, 'periode' => 'Triwulan II', 'urutan' => 2, 'gambar_url' => self::IMG . 'images/gambar/10.png', 'link_dokumen' => 'https://drive.google.com/file/d/1aXkO-uXW7DMfvXomcWSi837k2WJcW3jX/view?usp=sharing'],
        ['kategori' => 'TINDAK_LANJUT', 'tahun' => 2025, 'periode' => 'Triwulan III','urutan' => 3, 'gambar_url' => self::IMG . 'images/gambar/11.png', 'link_dokumen' => 'https://drive.google.com/file/d/1ROw0GLKjWmyvY6nKldPrRv08YSSQVP9M/view?usp=sharing'],
        // 2024
        ['kategori' => 'TINDAK_LANJUT', 'tahun' => 2024, 'periode' => 'Triwulan I',  'urutan' => 1, 'gambar_url' => self::IMG . 'images/gambar/9.png',  'link_dokumen' => 'https://drive.google.com/file/d/1bf6C00YQEubij0u5xmj9NicXUQb_gu7b/view?usp=drive_link'],
        ['kategori' => 'TINDAK_LANJUT', 'tahun' => 2024, 'periode' => 'Triwulan II', 'urutan' => 2, 'gambar_url' => self::IMG . 'images/gambar/10.png', 'link_dokumen' => 'https://drive.google.com/file/d/1aBEBZe7NHziZHB_sBv9srrNc6TrgDQ_Y/view?usp=sharing'],
        ['kategori' => 'TINDAK_LANJUT', 'tahun' => 2024, 'periode' => 'Triwulan III','urutan' => 3, 'gambar_url' => self::IMG . 'images/gambar/11.png', 'link_dokumen' => 'https://drive.google.com/file/d/1Oh0wzF-eYuEbJE2BiQBeUGqypXV6-hDe/view?usp=sharing'],
        ['kategori' => 'TINDAK_LANJUT', 'tahun' => 2024, 'periode' => 'Triwulan IV', 'urutan' => 4, 'gambar_url' => self::IMG . 'images/gambar/12.png', 'link_dokumen' => 'https://drive.google.com/file/d/15yfuW2GuJKgDGsy5r5M0kChoqaUDYOig/view?usp=sharing'],
        // 2023
        ['kategori' => 'TINDAK_LANJUT', 'tahun' => 2023, 'periode' => 'Triwulan I',  'urutan' => 1, 'gambar_url' => self::IMG . 'images/gambar/9.png',  'link_dokumen' => 'https://drive.google.com/file/d/111-GjMxBSXExexe1FDjaToAoMBzmdE12/view?usp=drive_link'],
        ['kategori' => 'TINDAK_LANJUT', 'tahun' => 2023, 'periode' => 'Triwulan II', 'urutan' => 2, 'gambar_url' => self::IMG . 'images/gambar/10.png', 'link_dokumen' => 'https://drive.google.com/file/d/1e7cYixNDwjROD5a_vdkExhZshNLrr03A/view?usp=drive_link'],
        ['kategori' => 'TINDAK_LANJUT', 'tahun' => 2023, 'periode' => 'Triwulan III','urutan' => 3, 'gambar_url' => self::IMG . 'images/gambar/11.png', 'link_dokumen' => 'https://drive.google.com/file/d/1QJFu5_69X1vgj-4NWUcvbFxRuV2XozOf/view?usp=drive_link'],
        ['kategori' => 'TINDAK_LANJUT', 'tahun' => 2023, 'periode' => 'Triwulan IV', 'urutan' => 4, 'gambar_url' => self::IMG . 'images/gambar/12.png', 'link_dokumen' => 'https://drive.google.com/file/d/1TAcIUvFwmPVsSoEnxbpn8qtI01hB-H9N/view?usp=drive_link'],
        // 2022
        ['kategori' => 'TINDAK_LANJUT', 'tahun' => 2022, 'periode' => 'Triwulan I',  'urutan' => 1, 'gambar_url' => self::IMG . 'images/gambar/9.png',  'link_dokumen' => self::IMG . 'images/Laporan_Tindak_Lanjut.pdf'],
        ['kategori' => 'TINDAK_LANJUT', 'tahun' => 2022, 'periode' => 'Triwulan II', 'urutan' => 2, 'gambar_url' => self::IMG . 'images/gambar/10.png', 'link_dokumen' => self::IMG . 'images/Laporan_Tindak_Lanjut.pdf'],
        ['kategori' => 'TINDAK_LANJUT', 'tahun' => 2022, 'periode' => 'Triwulan III','urutan' => 3, 'gambar_url' => self::IMG . 'images/gambar/11.png', 'link_dokumen' => null],
        ['kategori' => 'TINDAK_LANJUT', 'tahun' => 2022, 'periode' => 'Triwulan IV', 'urutan' => 4, 'gambar_url' => self::IMG . 'images/gambar/12.png', 'link_dokumen' => null],
        // 2021
        ['kategori' => 'TINDAK_LANJUT', 'tahun' => 2021, 'periode' => 'Triwulan I',  'urutan' => 1, 'gambar_url' => self::IMG . 'images/gambar/9.png',  'link_dokumen' => 'https://drive.google.com/file/d/1EWVzH4kfGMGLmIUIym8GXdBPFGK1tzHz/view?usp=sharing'],
        ['kategori' => 'TINDAK_LANJUT', 'tahun' => 2021, 'periode' => 'Triwulan II', 'urutan' => 2, 'gambar_url' => self::IMG . 'images/gambar/10.png', 'link_dokumen' => 'https://drive.google.com/file/d/1KgBTzToFJA54F8jaXi6R73-HcgETDzwH/view?usp=sharing'],
        ['kategori' => 'TINDAK_LANJUT', 'tahun' => 2021, 'periode' => 'Triwulan III','urutan' => 3, 'gambar_url' => self::IMG . 'images/gambar/11.png', 'link_dokumen' => 'https://drive.google.com/file/d/1J-NfNRKNzPpvOKNjWb5E0aJOAlnK0NFG/view?usp=sharing'],
        ['kategori' => 'TINDAK_LANJUT', 'tahun' => 2021, 'periode' => 'Triwulan IV', 'urutan' => 4, 'gambar_url' => self::IMG . 'images/gambar/12.png', 'link_dokumen' => null],
    ];

    public function run(): void
    {
        $now = \Carbon\Carbon::now();

        foreach ($this->data as $row) {
            DB::table('survey_laporan')->updateOrInsert(
                [
                    'kategori' => $row['kategori'],
                    'tahun'    => $row['tahun'],
                    'periode'  => $row['periode'],
                ],
                [
                    'urutan'       => $row['urutan'],
                    'gambar_url'   => $row['gambar_url'],
                    'link_dokumen' => $row['link_dokumen'],
                    'updated_at'   => $now,
                    'created_at'   => $now,
                ]
            );
        }

        $this->command->info('SurveyLaporanSeeder: ' . count($this->data) . ' baris diproses.');
    }
}
