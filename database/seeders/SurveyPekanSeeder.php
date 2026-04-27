<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SurveyPekanSeeder extends Seeder
{
    /**
     * Base URL untuk gambar yang masih dihosting di situs Joomla lama.
     */
    private const IMG = 'https://pa-penajam.go.id/images/';

    /**
     * Helper untuk membangun row data pekan survei.
     */
    private function row(string $tanggalMulai, string $tanggalSelesai, string $imgIkm, string $imgIpkp, string $imgIpak, ?string $linkIkm = null, ?string $linkIpkp = null, ?string $linkIpak = null): array
    {
        return [
            'tanggal_mulai'   => $tanggalMulai,
            'tanggal_selesai' => $tanggalSelesai,
            'tahun'           => (int) date('Y', strtotime($tanggalMulai)),
            'gambar_ikm'      => self::IMG . $imgIkm,
            'gambar_ipkp'     => self::IMG . $imgIpkp,
            'gambar_ipak'     => self::IMG . $imgIpak,
            'link_ikm'        => $linkIkm,
            'link_ipkp'       => $linkIpkp,
            'link_ipak'       => $linkIpak,
        ];
    }

    public function run(): void
    {
        $rows = [
            // ── 2025 ─────────────────────────────────────────────────────────
            $this->row('2025-12-01', '2025-12-05', 'IKM_01_Des-_05_Des_2025.png', 'IPKP_01_Des-_05_Des_2025.png', 'IPAK_01_Des-_05_Des_2025.png'),
            $this->row('2025-11-24', '2025-11-28', 'IKM_24-28Nov_2025.png',       'IPKP_24-28Nov_2025.png',       'IPAK_24-28Nov_2025.png'),
            $this->row('2025-11-17', '2025-11-21', 'IKM_17-21Nov_25.png',         'IPKP_17-21Nov_25.png',         'IPAK_17-21Nov_25.png'),
            $this->row('2025-11-10', '2025-11-14', 'IKM_10-14Nov_25.png',         'IPKP_10-14Nov_25.png',         'IPAK_10-14Nov_25.png'),
            $this->row('2025-11-03', '2025-11-07', 'IKM_03-07Okt_25.png',         'IPKP_03-07Okt_25.png',         'IPAK_03-07Okt_25.png'),
            $this->row('2025-10-27', '2025-10-31', 'IKM_27-31okt_25.png',         'IPKP_27-31okt_25.png',         'IPAK_27-31okt_25.png'),
            $this->row('2025-10-20', '2025-10-24', 'IKM_20-24okt_25.png',         'IPKP_20-24okt_25.png',         'IPAK_20-24okt_25.png'),
            $this->row('2025-10-13', '2025-10-17', 'IKM_13-17okt_25.png',         'IPKP_13-17Okt_25.png',         'IPAK_13-17Okt_25.png'),
            $this->row('2025-10-06', '2025-10-10', 'SKM_06-10_Okto_2025.png',     'IPKP_06-10_Okto_2025.png',     'IPAK_06-10_Okto_2025.png'),
            $this->row('2025-09-22', '2025-09-26', 'IKM_22-26Sep.png',            'IPKP_22-26Sep.png',            'IPAK_22-26Sep.png'),
            $this->row('2025-09-15', '2025-09-19', 'IKM_15-19Sep.png',            'IPKP_15-19Sep.png',            'IPAK_15-19Sep.png'),
            $this->row('2025-09-08', '2025-09-12', 'IKM_8-12Sep.png',             'IPKP_8-12Sep.png',             'IPAK_8-12Sep.png'),
            $this->row('2025-08-25', '2025-08-29', 'IKM_25-29Agus_2025.png',      'IPKP_25-29Agus_2025.png',      'IPAK_25-29Agus_2025.png'),
            $this->row('2025-08-19', '2025-08-22', 'ikm19-22agustus2025.png',     'ipkp19-22agustus2025.png',     'ipak19-22agustus2025.png'),
            $this->row('2025-08-01', '2025-08-08', 'ikm1-8Agustus2025.png',       'ipkp1-8Agustus2025.png',       'ipak1-8Agustus2025.png'),
            $this->row('2025-07-28', '2025-07-31', 'ikm28-31juli2025.png',        'ipkp28-31juli2025.png',        'ipak28-31juli2025.png'),
            $this->row('2025-07-21', '2025-07-25', 'ikm21-25juli2025.png',        'ipkp21-25juli2025.png',        'ipak21-25juli2025.png'),
            $this->row('2025-07-01', '2025-07-04', 'Survei_IKM_01-04_Juli.png',   'Survei_IPKP_01-04_Juli.png',   'Survei_IPAK_01-04_Juli.png'),
            $this->row('2025-06-23', '2025-06-30', 'Survei_IKM_23-30_Juni.png',   'Survei_IPKP_23-30_Juni.png',   'Survei_IPAK_23-30_Juni.png'),
            $this->row('2025-06-16', '2025-06-20', 'Survei_IKM_16-20_Juni.png',   'Survei_IPKP16-20_Juni.png',    'Survei_IPAK16-20_Juni.png'),
            $this->row('2025-06-09', '2025-06-13', 'Survei_IKM_09-13_Juni.png',   'Survei_IPKP_09-13_Juni.png',   'Survei_IPAK_09-13_Juni.png'),
            $this->row('2025-05-26', '2025-05-28', 'IKM_26-28_Mei.png',           'IPKP_26-28Mei.png',            'IPAK_26-28Mei.png'),
            $this->row('2025-05-19', '2025-05-23', '19-23_mei.png',               'ipkp19-23.png',                'ipak19-23.png'),
            $this->row('2025-05-14', '2025-05-16', 'LAYER_SURVEY_WEB_IKM_14-16_Mei.png',  'LAYER_SURVEY_WEB_IPKP_14-16_Mei.png',  'LAYER_SURVEY_WEB_IPAK_14-16_Mei.png'),
            $this->row('2025-04-21', '2025-04-25', 'LAYER_SURVEY_WEB_IKM_21-25Apr.png',   'LAYER_SURVEY_WEB_IPKP_21-25Apr.png',   'LAYER_SURVEY_WEB_IPAK_21-24Apr.png'),
            $this->row('2025-04-14', '2025-04-17', 'LAYER_SURVEY_WEB_IKM_14-17Apr.png',   'LAYER_SURVEY_WEB_IPKP_14-17Apr.png',   'LAYER_SURVEY_WEB_IPAK_14-17Apr.png'),
            $this->row('2025-04-08', '2025-04-11', 'LAYER_SURVEY_WEB_IKM_08-11Apr.png',   'LAYER_SURVEY_WEB_IPKP_08-11Apr.png',   'LAYER_SURVEY_WEB_IPAK_08-11Apr.png'),
            $this->row('2025-03-17', '2025-03-21', 'LAYER_SURVEY_WEB_17_mret.png',        'LAYER_SURVEY_WEB_17_mret.2.png',       'LAYER_SURVEY_WEB_17_mret.3.png'),
            $this->row('2025-03-10', '2025-03-14', 'LAYER_SURVEY_WEB_1.png',              'LAYER_SURVEY_WEB_2.png',               'LAYER_SURVEY_WEB_3.png'),
            $this->row('2025-03-03', '2025-03-07', 'LAYER_SURVEY_WEB_3-7_Maret.png',      'LAYER_SURVEY_WEB_IPKP_3-7_Maret.png',  'LAYER_SURVEY_WEB_IPAK_3-7_Meret.png'),
            $this->row('2025-02-24', '2025-02-28', 'LAYER_SURVEY_IKM_24-27_feb.png',      'LAYER_SURVEY_IPKP_24-27_feb.png',      'LAYER_SURVEY_IPAK_24-28_feb.png'),
            $this->row('2025-02-17', '2025-02-21', 'LAYER_SURVEY_IKM_17-21_feb.png',      'LAYER_SURVEY_IPKP_17-21_feb.png',      'LAYER_SURVEY_IPAK_17-21_feb.png'),
            $this->row('2025-02-10', '2025-02-14', 'survey_IKM_10-14_Feb_2025.png',       'survey_IPKP_10-14_Feb_2025.png',       'survey_IPAK_10-14_Feb_2025.png'),
            $this->row('2025-01-30', '2025-01-31', 'survey_IKM_30-31_jan_2025.png',       'survey_IPKP_30-31_jan_2025.png',       'survey_IPAK_30-31_jan_2025.png'),
            $this->row('2025-01-20', '2025-01-24', 'LAYER_SURVEY_WEB_16.png',             'LAYER_SURVEY_WEB_17.png',              'LAYER_SURVEY_WEB_18.png'),
            $this->row('2025-01-13', '2025-01-17', 'LAYER_SURVEY_WEB_11.png',             'LAYER_SURVEY_WEB_10.png',              'LAYER_SURVEY_WEB_12.png'),
            $this->row('2025-01-06', '2025-01-10', 'LAYER_SURVEY_WEB_14.png',             'LAYER_SURVEY_WEB_13.png',              'LAYER_SURVEY_WEB_15.png'),

            // ── 2024 ─────────────────────────────────────────────────────────
            $this->row('2024-10-07', '2024-10-11', '07_-_11_Oktober.png',          '7.png',                         '15.png',                              'https://drive.google.com/file/d/1J55qRNdsCSU1vQ5gRPCu2enJcyKkD6dX/view?usp=sharing'),
            $this->row('2024-10-14', '2024-10-18', '14-18_Oktober.png',            '8.png',                         '16.png'),
            $this->row('2024-10-21', '2024-10-25', '21-25.png',                    '21-25_Oktober.png',             '17.png'),
            $this->row('2024-10-28', '2024-11-01', '5.png',                        '10.png',                        'survey_28-10_nov_2024.png'),
            $this->row('2024-11-04', '2024-11-08', '04-08_Nov_IKM.png',            '04-08_Nov_IPKP.png',            '11.png'),
            $this->row('2024-11-11', '2024-11-15', '11-15_Nov_IKM.png',            '14.png',                        '11-15_Nov_IPAk.png'),
            $this->row('2024-11-25', '2024-11-29',
                'Feedback_scale_satisfaction_rating_design_Instagram_Post_Flyer_300_x_300_piksel.png',
                'Feedback_scale_satisfaction_rating_design_Instagram_Post_Flyer_300_x_300_piksel_1.png',
                'Feedback_scale_satisfaction_rating_design_Instagram_Post_Flyer_300_x_300_piksel_2.png'),
            $this->row('2024-12-09', '2024-12-13',
                'Feedback_scale_satisfaction_rating_design_Instagram_Post_Flyer_300_x_300_piksel_5.png',
                'Feedback_scale_satisfaction_rating_design_Instagram_Post_Flyer_300_x_300_piksel_3.png',
                'Feedback_scale_satisfaction_rating_design_Instagram_Post_Flyer_300_x_300_piksel_4.png'),
            $this->row('2024-12-16', '2024-12-20', 'LAYER_SURVEY_WEB_5.png',       'LAYER_SURVEY_WEB_4.png',        'LAYER_SURVEY_WEB_3.png'),
            $this->row('2024-12-23', '2024-12-27', 'LAYER_SURVEY_WEB_6.png',       'LAYER_SURVEY_WEB_7.png',        'LAYER_SURVEY_WEB_8.png'),
        ];

        $now = \Carbon\Carbon::now();

        foreach ($rows as $row) {
            DB::table('survey_pekan')->updateOrInsert(
                [
                    'tanggal_mulai'   => $row['tanggal_mulai'],
                    'tanggal_selesai' => $row['tanggal_selesai'],
                ],
                [
                    'tahun'        => $row['tahun'],
                    'gambar_ikm'   => $row['gambar_ikm'],
                    'gambar_ipkp'  => $row['gambar_ipkp'],
                    'gambar_ipak'  => $row['gambar_ipak'],
                    'link_ikm'     => $row['link_ikm'],
                    'link_ipkp'    => $row['link_ipkp'],
                    'link_ipak'    => $row['link_ipak'],
                    'updated_at'   => $now,
                    'created_at'   => $now,
                ]
            );
        }

        $this->command->info('SurveyPekanSeeder: ' . count($rows) . ' baris diproses.');
    }
}
