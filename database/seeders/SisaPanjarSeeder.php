<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\SisaPanjar;

class SisaPanjarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Data awal dari sisa_panjar.html
     */
    public function run(): void
    {
        $data = [
            // Tahun 2025 - Disetor Kas Negara
            [
                'tahun' => 2025,
                'bulan' => 4,
                'nomor_perkara' => '279/Pdt.G/2025/PA.Pnj',
                'nama_penggugat_pemohon' => 'Nining binti Mulyana',
                'jumlah_sisa_panjar' => 427000,
                'status' => 'disetor_kas_negara',
                'tanggal_setor_kas_negara' => '2025-04-28',
            ],

            // Tahun 2024 - Belum Diambil
            [
                'tahun' => 2024,
                'bulan' => 9,
                'nomor_perkara' => '279/Pdt.G/2024/PA.Pnj',
                'nama_penggugat_pemohon' => 'Nining binti Mulyana',
                'jumlah_sisa_panjar' => 427000,
                'status' => 'belum_diambil',
                'tanggal_setor_kas_negara' => null,
            ],

            // Tahun 2024 - Disetor Kas Negara
            [
                'tahun' => 2024,
                'bulan' => 5,
                'nomor_perkara' => '341/Pdt.G/2024/PA.Pnj',
                'nama_penggugat_pemohon' => 'Hesti Karismaya binti Prio Budi Hartono',
                'jumlah_sisa_panjar' => 125000,
                'status' => 'disetor_kas_negara',
                'tanggal_setor_kas_negara' => '2024-05-02',
            ],
            [
                'tahun' => 2024,
                'bulan' => 5,
                'nomor_perkara' => '355/Pdt.G/2024/PA.Pnj',
                'nama_penggugat_pemohon' => 'Febriana Haris Bin Holid',
                'jumlah_sisa_panjar' => 90000,
                'status' => 'disetor_kas_negara',
                'tanggal_setor_kas_negara' => '2024-05-02',
            ],
            [
                'tahun' => 2024,
                'bulan' => 6,
                'nomor_perkara' => '68/Pdt.G/2024/PA.Pnj',
                'nama_penggugat_pemohon' => 'Aang Setiawan Bin Sudir',
                'jumlah_sisa_panjar' => 760000,
                'status' => 'disetor_kas_negara',
                'tanggal_setor_kas_negara' => '2024-06-04',
            ],

            // Tahun 2023 - Belum Diambil
            [
                'tahun' => 2023,
                'bulan' => 10,
                'nomor_perkara' => '341/Pdt.G/2023/PA.Pnj',
                'nama_penggugat_pemohon' => 'Hesti Karismaya binti Prio Budi Hartono',
                'jumlah_sisa_panjar' => 125000,
                'status' => 'belum_diambil',
                'tanggal_setor_kas_negara' => null,
            ],
            [
                'tahun' => 2023,
                'bulan' => 10,
                'nomor_perkara' => '355/Pdt.G/2023/PA.Pnj',
                'nama_penggugat_pemohon' => 'Febriana Haris Bin Kholid',
                'jumlah_sisa_panjar' => 90000,
                'status' => 'belum_diambil',
                'tanggal_setor_kas_negara' => null,
            ],
            [
                'tahun' => 2023,
                'bulan' => 11,
                'nomor_perkara' => '68/Pdt.G/2023/PA.Pnj',
                'nama_penggugat_pemohon' => 'Aang Setiawan Bin Sudir',
                'jumlah_sisa_panjar' => 760000,
                'status' => 'belum_diambil',
                'tanggal_setor_kas_negara' => null,
            ],

            // Tahun 2023 - Disetor Kas Negara
            [
                'tahun' => 2023,
                'bulan' => 1,
                'nomor_perkara' => '245/Pdt.G/2022/PA.Pnj',
                'nama_penggugat_pemohon' => 'Aprilia Suryani binti Syahruni',
                'jumlah_sisa_panjar' => 100000,
                'status' => 'disetor_kas_negara',
                'tanggal_setor_kas_negara' => '2023-01-02',
            ],
            [
                'tahun' => 2023,
                'bulan' => 2,
                'nomor_perkara' => '80/Pdt.P/2022/PA.Pnj',
                'nama_penggugat_pemohon' => 'Harianto bin Anwar KS',
                'jumlah_sisa_panjar' => 20000,
                'status' => 'disetor_kas_negara',
                'tanggal_setor_kas_negara' => '2023-02-22',
            ],
            [
                'tahun' => 2023,
                'bulan' => 4,
                'nomor_perkara' => '112/Pdt.G/2022/PA.Pnj',
                'nama_penggugat_pemohon' => 'Nurlia',
                'jumlah_sisa_panjar' => 10000,
                'status' => 'disetor_kas_negara',
                'tanggal_setor_kas_negara' => '2023-04-17',
            ],
            [
                'tahun' => 2023,
                'bulan' => 10,
                'nomor_perkara' => '46/Pdt.P/2023/PA.Pnj',
                'nama_penggugat_pemohon' => 'Unun Ihda Susiyati',
                'jumlah_sisa_panjar' => 20000,
                'status' => 'disetor_kas_negara',
                'tanggal_setor_kas_negara' => '2023-10-31',
            ],

            // Tahun 2022 - Disetor Kas Negara
            [
                'tahun' => 2022,
                'bulan' => 3,
                'nomor_perkara' => '19/Pdt.G/2021/PA.Pnj',
                'nama_penggugat_pemohon' => 'Dedi S bin Sahidan Pelampung',
                'jumlah_sisa_panjar' => 510000,
                'status' => 'disetor_kas_negara',
                'tanggal_setor_kas_negara' => '2022-03-17',
            ],
            [
                'tahun' => 2022,
                'bulan' => 8,
                'nomor_perkara' => '24/Pdt.P/2022/PA.Pnj',
                'nama_penggugat_pemohon' => 'Rahmat Taufik',
                'jumlah_sisa_panjar' => 107000,
                'status' => 'disetor_kas_negara',
                'tanggal_setor_kas_negara' => '2022-08-30',
            ],

            // Tahun 2021 - Disetor Kas Negara
            [
                'tahun' => 2021,
                'bulan' => 3,
                'nomor_perkara' => '77/Pdt.G/2019/PA.Pnj',
                'nama_penggugat_pemohon' => 'Mashul Ihsan bin Abdurrahim',
                'jumlah_sisa_panjar' => 100000,
                'status' => 'disetor_kas_negara',
                'tanggal_setor_kas_negara' => '2021-03-04',
            ],
            [
                'tahun' => 2021,
                'bulan' => 3,
                'nomor_perkara' => '344/Pdt.G/2019/PA.Pnj',
                'nama_penggugat_pemohon' => 'Madari bin Kasmono',
                'jumlah_sisa_panjar' => 150000,
                'status' => 'disetor_kas_negara',
                'tanggal_setor_kas_negara' => '2021-03-04',
            ],
            [
                'tahun' => 2021,
                'bulan' => 3,
                'nomor_perkara' => '42/Pdt.P/2020/PA.Pnj',
                'nama_penggugat_pemohon' => 'Bariah binti Lantamu',
                'jumlah_sisa_panjar' => 34200,
                'status' => 'disetor_kas_negara',
                'tanggal_setor_kas_negara' => '2021-03-04',
            ],
            [
                'tahun' => 2021,
                'bulan' => 3,
                'nomor_perkara' => '27/Pdt.P/2020/PA.Pnj',
                'nama_penggugat_pemohon' => 'H. Rajja bin Jake',
                'jumlah_sisa_panjar' => 34200,
                'status' => 'disetor_kas_negara',
                'tanggal_setor_kas_negara' => '2021-03-04',
            ],
            [
                'tahun' => 2021,
                'bulan' => 3,
                'nomor_perkara' => '37/Pdt.P/2020/PA.Pnj',
                'nama_penggugat_pemohon' => 'Ahmad Jaya bin Syamsuddin',
                'jumlah_sisa_panjar' => 14200,
                'status' => 'disetor_kas_negara',
                'tanggal_setor_kas_negara' => '2021-03-04',
            ],
            [
                'tahun' => 2021,
                'bulan' => 5,
                'nomor_perkara' => '47/Pdt.P/2020/PA.Pnj',
                'nama_penggugat_pemohon' => 'Istamar bin Sukardi',
                'jumlah_sisa_panjar' => 34200,
                'status' => 'disetor_kas_negara',
                'tanggal_setor_kas_negara' => '2021-05-24',
            ],
            [
                'tahun' => 2021,
                'bulan' => 5,
                'nomor_perkara' => '51/Pdt.P/2020/PA.Pnj',
                'nama_penggugat_pemohon' => 'Mansur bin Alimudin',
                'jumlah_sisa_panjar' => 10000,
                'status' => 'disetor_kas_negara',
                'tanggal_setor_kas_negara' => '2021-05-24',
            ],
            [
                'tahun' => 2021,
                'bulan' => 11,
                'nomor_perkara' => '14/Pdt.G/2021/PA.Pnj',
                'nama_penggugat_pemohon' => 'Yusni binti Masdar',
                'jumlah_sisa_panjar' => 1000,
                'status' => 'disetor_kas_negara',
                'tanggal_setor_kas_negara' => '2021-11-24',
            ],
            [
                'tahun' => 2021,
                'bulan' => 11,
                'nomor_perkara' => '27/Pdt.P/2021/PA.Pnj',
                'nama_penggugat_pemohon' => 'Jeroi bin Kadok',
                'jumlah_sisa_panjar' => 120000,
                'status' => 'disetor_kas_negara',
                'tanggal_setor_kas_negara' => '2021-11-24',
            ],
            [
                'tahun' => 2021,
                'bulan' => 11,
                'nomor_perkara' => '26/Pdt.P/2021/PA.Pnj',
                'nama_penggugat_pemohon' => 'Rahmadi bin Yuliansyah',
                'jumlah_sisa_panjar' => 20000,
                'status' => 'disetor_kas_negara',
                'tanggal_setor_kas_negara' => '2021-11-24',
            ],
            [
                'tahun' => 2021,
                'bulan' => 11,
                'nomor_perkara' => '42/Pdt.P/2021/PA.Pnj',
                'nama_penggugat_pemohon' => 'Kahar bin Rajja',
                'jumlah_sisa_panjar' => 20000,
                'status' => 'disetor_kas_negara',
                'tanggal_setor_kas_negara' => '2021-11-24',
            ],
            [
                'tahun' => 2021,
                'bulan' => 11,
                'nomor_perkara' => '45/Pdt.P/2021/PA.Pnj',
                'nama_penggugat_pemohon' => 'Alimudin in Islamil',
                'jumlah_sisa_panjar' => 120000,
                'status' => 'disetor_kas_negara',
                'tanggal_setor_kas_negara' => '2021-11-24',
            ],
        ];

        foreach ($data as $item) {
            SisaPanjar::create($item);
        }

        $this->command->info('Data sisa panjar berhasil di-import! (' . count($data) . ' records)');
    }
}
