<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class KeuanganPerkaraSeeder extends Seeder
{
    /**
     * Data keuangan perkara per tahun.
     * saldo_awal = carry-over dari tahun sebelumnya (diisi pada bulan 1).
     * url_detail = path relatif Joomla atau URL Google Drive.
     */
    private array $data = [
        2025 => [
            'saldo_awal' => 4234000,
            'bulan' => [
                1  => ['penerimaan' => 46460000,  'pengeluaran' => 15943500,  'url' => 'images/lipa_7_a_jan_2025_2025_02_03_02_15_49_565.pdf'],
                2  => ['penerimaan' => 57970500,  'pengeluaran' => 26492500,  'url' => 'images/LIPA_7a_Feb_2025.pdf'],
                3  => ['penerimaan' => 46093000,  'pengeluaran' => 32031500,  'url' => 'images/lipa_7_a_maret_2025_2025_04_08_03_27_19_305.pdf'],
                4  => ['penerimaan' => 49781500,  'pengeluaran' => 14817000,  'url' => 'images/LIPA_7_A_MEI_2025.pdf'],
                5  => ['penerimaan' => 64764500,  'pengeluaran' => 30307500,  'url' => 'images/Scan_2025_06_30_02_51_16_351.pdf'],
                6  => ['penerimaan' => 57009500,  'pengeluaran' => 28089000,  'url' => 'images/Lipa_7_a_juni_2025_2025_06_30_23_49_31_630.pdf'],
                7  => ['penerimaan' => 51373000,  'pengeluaran' => 28326500,  'url' => 'images/lipa_7_a_juli_2025.pdf'],
                8  => ['penerimaan' => 34469000,  'pengeluaran' => 18159000,  'url' => 'images/lipa_7_a_agustus_2025_2025_09_01_21_00_21_589.pdf'],
                9  => ['penerimaan' => 29892500,  'pengeluaran' => 12804500,  'url' => 'https://drive.google.com/file/d/1GO0xit_tpudXWrsRBsK8tIo2Pz6iDw2f/view?usp=sharing'],
                10 => ['penerimaan' => 36208000,  'pengeluaran' => 22560500,  'url' => 'images/Lipa_7_oktober.pdf'],
                11 => ['penerimaan' => 24240500,  'pengeluaran' => 16562000,  'url' => 'images/LIPA_7_November_2025_compressed.pdf'],
                12 => ['penerimaan' => 8358500,   'pengeluaran' => 7532500,   'url' => 'images/LIPA_7-A_DESEMBER_2025_WEBSITE.pdf'],
            ],
        ],
        2024 => [
            'saldo_awal' => 6363100,
            'bulan' => [
                1  => ['penerimaan' => 73555000,  'pengeluaran' => 58317000,  'url' => 'images/lipa_7a_januari_2023_2024_02_01_12_49_20_937.pdf'],
                2  => ['penerimaan' => 69771100,  'pengeluaran' => 46349000,  'url' => 'images/lipa_7_a_feb_2024.pdf'],
                3  => ['penerimaan' => 71337100,  'pengeluaran' => 56230000,  'url' => 'images/lipa_7a_maret_2024.pdf'],
                4  => ['penerimaan' => 40402100,  'pengeluaran' => 18095000,  'url' => 'images/LIPA_7-A_APRIL_2024.pdf'],
                5  => ['penerimaan' => 87282100,  'pengeluaran' => 53632100,  'url' => 'images/lipa_7a_keuangan_mei_2024.pdf'],
                6  => ['penerimaan' => 87485000,  'pengeluaran' => 44674000,  'url' => 'images/LIPA_7_a_JUNI_2024.pdf'],
                7  => ['penerimaan' => 114681000, 'pengeluaran' => 70618000,  'url' => 'images/LIPA_7-A_Juli_2024.pdf'],
                8  => ['penerimaan' => 83633000,  'pengeluaran' => 51339500,  'url' => 'images/lipa_7__a_agustus_2024_2024_09_02_03_47_40_266.pdf'],
                9  => ['penerimaan' => 86333500,  'pengeluaran' => 39876500,  'url' => 'images/lipa_7_A_sep_2024.pdf'],
                10 => ['penerimaan' => 90766000,  'pengeluaran' => 45306000,  'url' => 'images/LIPA_7_A_Oktober_2024.pdf'],
                11 => ['penerimaan' => 79660000,  'pengeluaran' => 43493500,  'url' => 'images/LIPA_7_A_November_2024.pdf'],
                12 => ['penerimaan' => 36626500,  'pengeluaran' => 32392500,  'url' => 'images/LIPA_7-A_Desember_2024.pdf'],
            ],
        ],
        2023 => [
            'saldo_awal' => 8359000,
            'bulan' => [
                1  => ['penerimaan' => 90815000,  'pengeluaran' => 69325000,  'url' => 'images/artikel/lipa7_a_jan_2023.pdf'],
                2  => ['penerimaan' => 54475000,  'pengeluaran' => 46610000,  'url' => 'images/LIPA_7_WEBSITE_FEB_2023.pdf'],
                3  => ['penerimaan' => 69500000,  'pengeluaran' => 70399000,  'url' => 'images/Keuangan_Perkara/lipa_7_a_maret_2023.pdf'],
                4  => ['penerimaan' => 2840000,   'pengeluaran' => 16645000,  'url' => 'images/Keuangan_Perkara/lipa7a_april_2023.pdf'],
                5  => ['penerimaan' => 96610000,  'pengeluaran' => 69699000,  'url' => 'images/lipa_7_a_Mei_2023.pdf'],
                6  => ['penerimaan' => 52890000,  'pengeluaran' => 53015000,  'url' => 'images/lipa7a_juni_2023.pdf'],
                7  => ['penerimaan' => 94271000,  'pengeluaran' => 66022000,  'url' => 'images/lipa_7a_juli_2023_fix.pdf'],
                8  => ['penerimaan' => 43863000,  'pengeluaran' => 46841000,  'url' => 'images/lipa7a_agustus_2023_2023_08_31_15_41_55_268.pdf'],
                9  => ['penerimaan' => 74476000,  'pengeluaran' => 45100000,  'url' => 'images/lipa_7a_sept_2023_2023_09_29_08_20_45_987.pdf'],
                10 => ['penerimaan' => 90726000,  'pengeluaran' => 55254000,  'url' => 'images/Lipa_7_a_okt_2023_2023_10_31_14_31_46_634.pdf'],
                11 => ['penerimaan' => 93362000,  'pengeluaran' => 70996000,  'url' => 'images/LIPA_7_A_NOVEMBER_2023.pdf'],
                12 => ['penerimaan' => 39346000,  'pengeluaran' => 32982900,  'url' => 'images/lipa_7a_des_2023.pdf'],
            ],
        ],
        2022 => [
            'saldo_awal' => 7905000,
            'bulan' => [
                1  => ['penerimaan' => 76395000,  'pengeluaran' => 61520000,  'url' => 'images/artikel/LAP_KEUANGAN_JANUARI.pdf'],
                2  => ['penerimaan' => 61935000,  'pengeluaran' => 52290000,  'url' => 'images/artikel/LAP_KEUANGAN_FEBRUARI.pdf'],
                3  => ['penerimaan' => 73340000,  'pengeluaran' => 70575000,  'url' => 'images/artikel/LRA/LI.PA._7.pdf'],
                4  => ['penerimaan' => 27010000,  'pengeluaran' => 32110000,  'url' => 'images/LIPA_Bulan_April_2022_PA_Penajam09-05-2022-072715.pdf'],
                5  => ['penerimaan' => 80040000,  'pengeluaran' => 63888000,  'url' => 'images/artikel/Laporan_Bulan_Mei_Tahun_202203-06-2022-100012.pdf'],
                6  => ['penerimaan' => 110197000, 'pengeluaran' => 78385000,  'url' => 'images/artikel/LRA/lipa-7_e_keuangan_juni_2022_compressed.pdf'],
                7  => ['penerimaan' => 62070000,  'pengeluaran' => 61181000,  'url' => 'images/artikel/LRA/lipa7_juli_2022_website_compressed.pdf'],
                8  => ['penerimaan' => 55585000,  'pengeluaran' => 59651000,  'url' => 'images/Keuangan_Perkara/lipa_7_Agustus_2022_compressed.pdf'],
                9  => ['penerimaan' => 27210000,  'pengeluaran' => 39275000,  'url' => 'images/LI.PA._7_september.pdf'],
                10 => ['penerimaan' => 53860000,  'pengeluaran' => 40545000,  'url' => 'images/Keuangan_Perkara/lipa_7_oktober_2022_website_compressed.pdf'],
                11 => ['penerimaan' => 72655000,  'pengeluaran' => 49170000,  'url' => 'images/artikel/LRA/lipa_7_website_nov_2022_compressed.pdf'],
                12 => ['penerimaan' => 39970000,  'pengeluaran' => 31611000,  'url' => 'images/artikel/LRA/LIPA_7_website_des_2022_compressed.pdf'],
            ],
        ],
        2021 => [
            'saldo_awal' => 13885000,
            'bulan' => [
                1  => ['penerimaan' => 136532000, 'pengeluaran' => 136532000, 'url' => 'images/artikel/LAPORAN_LIPA7_JANUARI_2021.pdf'],
                2  => ['penerimaan' => 26590000,  'pengeluaran' => 42158000,  'url' => 'images/artikel/Lipa_7a_February.pdf'],
                3  => ['penerimaan' => 62400000,  'pengeluaran' => 65500000,  'url' => 'images/artikel/LIPA_7A_BULAN_MARET.pdf'],
                4  => ['penerimaan' => 44289000,  'pengeluaran' => 45692000,  'url' => 'images/artikel/LIPA_7A_BULAN_APRIL.pdf'],
                5  => ['penerimaan' => 24369000,  'pengeluaran' => 26425000,  'url' => 'images/artikel/LIPA_7A__Bulan_Mei_2021_pdf.pdf'],
                6  => ['penerimaan' => 70280000,  'pengeluaran' => 60657000,  'url' => 'images/artikel/LAP_KEUANGAN_PERKARA_BULAN_JUNI.pdf'],
                7  => ['penerimaan' => 9945000,   'pengeluaran' => 29805000,  'url' => 'images/artikel/LIPA_7_JULI.pdf'],
                8  => ['penerimaan' => 51480000,  'pengeluaran' => 36201000,  'url' => 'images/artikel/LIPA_7A_AGUSTUS.pdf'],
                9  => ['penerimaan' => 68695000,  'pengeluaran' => 65225000,  'url' => 'images/artikel/LIPA_7A_September.pdf'],
                10 => ['penerimaan' => 57184000,  'pengeluaran' => 64404000,  'url' => 'images/artikel/LIPA_7A_Oktober.pdf'],
                11 => ['penerimaan' => 49175000,  'pengeluaran' => 54064000,  'url' => 'images/artikel/LIPA_7_A_NOVEMBER.pdf'],
                12 => ['penerimaan' => 23935000,  'pengeluaran' => 40156000,  'url' => 'images/artikel/LI.PA.__7_Des.pdf'],
            ],
        ],
        2020 => [
            'saldo_awal' => 16644400,
            'bulan' => [
                1  => ['penerimaan' => 62334000,  'pengeluaran' => 40024800,  'url' => 'https://drive.google.com/file/d/11cUqMsTvaAlOEwHeesXRrXtITW9kFdWh/view?usp=sharing'],
                2  => ['penerimaan' => 42885000,  'pengeluaran' => 41634400,  'url' => 'https://drive.google.com/file/d/1qu6SugdG5r9CjnmkAf3QYQVHee7Ywd8b/view?usp=sharing'],
                3  => ['penerimaan' => 49685000,  'pengeluaran' => 54061800,  'url' => 'https://drive.google.com/file/d/1WjiP_exWL7VDDVvbD-i8QIWOcOc_rTf1/view?usp=sharing'],
                4  => ['penerimaan' => 4280200,   'pengeluaran' => 15235400,  'url' => 'https://drive.google.com/file/d/18UW-i0vmuU584bNDWMkmDFjBiA62Fi4r/view?usp=sharing'],
                5  => ['penerimaan' => 14468000,  'pengeluaran' => 13418800,  'url' => 'https://drive.google.com/file/d/1YHxLV05GatLvTKUKXRVmZl615Fsw3cwK/view?usp=sharing'],
                6  => ['penerimaan' => 122862700, 'pengeluaran' => 97451400,  'url' => 'https://drive.google.com/file/d/1izg6P4E0gltf53oerHO0FSxiSIxoMkRE/view?usp=sharing'],
                7  => ['penerimaan' => 55562000,  'pengeluaran' => 72675200,  'url' => 'https://drive.google.com/file/d/1VMxcp-F0ACJgZdcZ6fjya_GHwWgePxM8/view?usp=sharing'],
                8  => ['penerimaan' => 47051000,  'pengeluaran' => 28050000,  'url' => 'https://drive.google.com/file/d/1KOtC5T0xBvlaYu7nnkjzUEKu3xLjHs6x/view?usp=sharing'],
                9  => ['penerimaan' => 70896000,  'pengeluaran' => 63054700,  'url' => 'https://drive.google.com/file/d/1oToa6oWSft6ibHtMIzAOzVqwWq-rgULn/view?usp=sharing'],
                10 => ['penerimaan' => 97720200,  'pengeluaran' => 63541200,  'url' => 'images/artikel/KEUANGAN_PERKARA_LIPA7_BULAN_OKTOBER_2020.pdf'],
                11 => ['penerimaan' => 89243000,  'pengeluaran' => 89243000,  'url' => 'images/artikel/LIPA_7_KEUANGAN_PERKARA_BULAN_NOPEMBER_2020.pdf'],
                12 => ['penerimaan' => 40860000,  'pengeluaran' => 40860000,  'url' => 'images/artikel/LIPA_7_KEUANGAN_PERKARA_BULAN_DESEMBER_2020.pdf'],
            ],
        ],
        2019 => [
            'saldo_awal' => 1686000,
            'bulan' => [
                1  => ['penerimaan' => 118245000, 'pengeluaran' => 73265000,  'url' => 'images/PDF/keuangan_perkara/2019-01.pdf'],
                2  => ['penerimaan' => 54257000,  'pengeluaran' => 48121000,  'url' => 'images/PDF/keuangan_perkara/2019-02.pdf'],
                3  => ['penerimaan' => 47018000,  'pengeluaran' => 50346000,  'url' => 'images/PDF/keuangan_perkara/2019-03.pdf'],
                4  => ['penerimaan' => 40490000,  'pengeluaran' => 45152000,  'url' => 'images/PDF/keuangan_perkara/2019-04.pdf'],
                5  => ['penerimaan' => 21963000,  'pengeluaran' => 34065000,  'url' => 'images/PDF/keuangan_perkara/2019-05.pdf'],
                6  => ['penerimaan' => 46219000,  'pengeluaran' => 36631000,  'url' => 'images/PDF/keuangan_perkara/2019-06.pdf'],
                7  => ['penerimaan' => 70916000,  'pengeluaran' => 74416000,  'url' => 'images/PDF/keuangan_perkara/2019-07.pdf'],
                8  => ['penerimaan' => 52807000,  'pengeluaran' => 57305000,  'url' => 'images/PDF/keuangan_perkara/2019-08.pdf'],
                9  => ['penerimaan' => 56054000,  'pengeluaran' => 58676000,  'url' => 'https://drive.google.com/file/d/1LDdKCvh9h7unJhlpmLVFovJtZHAAj8Ak/view?usp=sharing'],
                10 => ['penerimaan' => 54829000,  'pengeluaran' => 55529000,  'url' => 'https://drive.google.com/file/d/1fuEvUTijfda4TyQPcPr5R6Ne--LMtmh3/view?usp=sharing'],
                11 => ['penerimaan' => 49971000,  'pengeluaran' => 47125000,  'url' => 'https://drive.google.com/file/d/1MzvRp63lonlTTfjAycByn2S9K2F6GDVz/view?usp=sharing'],
                12 => ['penerimaan' => 19913100,  'pengeluaran' => 37092900,  'url' => 'https://drive.google.com/file/d/1V7g5LNzp7rqw3YMbYq8kL3x0RL5m_0V8/view?usp=sharing'],
            ],
        ],
    ];

    public function run(): void
    {
        // Hapus data lama agar seeder aman dijalankan berkali-kali
        DB::table('keuangan_perkara')->truncate();

        $now = Carbon::now()->toDateTimeString();
        $rows = [];

        foreach ($this->data as $tahun => $tahunData) {
            foreach ($tahunData['bulan'] as $bulan => $bulananData) {
                $rows[] = [
                    'tahun'       => $tahun,
                    'bulan'       => $bulan,
                    'saldo_awal'  => $bulan === 1 ? $tahunData['saldo_awal'] : null,
                    'penerimaan'  => $bulananData['penerimaan'],
                    'pengeluaran' => $bulananData['pengeluaran'],
                    'url_detail'  => $bulananData['url'],
                    'created_at'  => $now,
                    'updated_at'  => $now,
                ];
            }
        }

        DB::table('keuangan_perkara')->insert($rows);
    }
}
