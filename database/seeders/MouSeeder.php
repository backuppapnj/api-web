<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class MouSeeder extends Seeder
{
    /**
     * Data awal MOU dari halaman Joomla lama.
     * tanggal_berakhir tidak tersedia — status akan "tidak_diketahui".
     */
    private array $data = [
        [
            'tanggal'       => '2025-01-23',
            'instansi'      => 'SLB Negeri Penajam Paser Utara',
            'tentang'       => 'Kerjasama Bidang Penyediaan Layanan Bagi Penyandang Disabilitas',
            'link_dokumen'  => 'https://drive.google.com/file/d/1BQrfxTj5FXrgxjXorQskaO36PtxI6V48/view?usp=sharing',
        ],
        [
            'tanggal'       => '2025-03-10',
            'instansi'      => 'Dinas Kesehatan Kabupaten Penajam Paser Utara',
            'tentang'       => 'Layanan Edukasi dan Pemeriksaan Kesehatan Anak "Nasi Tanak" dalam Perkara Permohonan Dispensasi Kawin Pada Pengadilan Agama Penajam',
            'link_dokumen'  => 'https://drive.google.com/file/d/1ZNjHIrTv5AdN1Zwc85HdS4PUJ4Lc5g8F/view?usp=sharing',
        ],
        [
            'tanggal'       => '2024-07-31',
            'instansi'      => 'Rumah Tahanan Kelas IIB Tanah Grogot',
            'tentang'       => 'Pendampingan Tahanan atau Warga Binaan Pemasyarakatan dan proses persidangan dan mediasi serta pelaksanaan persidangan secara elektronik melalui TELECONFERNCE',
            'link_dokumen'  => 'https://drive.google.com/file/d/18zzCP4-MYPGEfNPsXigag1PqdzF1Zsla/view?usp=drive_link',
        ],
        [
            'tanggal'       => '2024-03-26',
            'instansi'      => 'Bank Syariah Indonesia',
            'tentang'       => 'Pemanfaatan Layanan Jasa dan Produk Perbankan Berdasarkan Prinsip Syariah',
            'link_dokumen'  => 'https://drive.google.com/file/d/1kuOPQERxsqHf5Q_9s-3seqQ_XiEBDy4o/view?usp=drive_link',
        ],
        [
            'tanggal'       => '2023-01-13',
            'instansi'      => 'Polres Penajam Paser Utara',
            'tentang'       => 'Pengamanan Kantor (Hakim/Pegawai/Pengunjung dan Aset Negara), Pengamanan Pelaksanaan Persidangan serta Pengamanan Pelaksanaan Eksekusi pada Pengadilan Agama Penajam',
            'link_dokumen'  => 'https://drive.google.com/file/d/1hsCiZD1Qd45f0XQ1fWyuxPViFyC7fDyS/view?usp=drive_link',
        ],
        [
            'tanggal'       => '2022-12-14',
            'instansi'      => 'Pengadilan Negeri Penajam, Kementerian Agama Kabupaten Penajam Paser Utara serta Pemerintah Daerah Kabupaten Penajam Paser Utara',
            'tentang'       => 'Pelayanan Terpadu Data Kependudukan dan Penerbitan Dokumen Kependudukan dan Pencatatan Sipil Serta Pelayanan Kesehatan Calon Pengantin',
            'link_dokumen'  => 'https://drive.google.com/file/d/1D2S-oV5yHtecKoUZhI46RCiNOLKlIFPo/view?usp=drive_link',
        ],
        [
            'tanggal'       => '2022-06-29',
            'instansi'      => 'Dinas Kesehatan Kabupaten Penajam Paser Utara',
            'tentang'       => 'Layanan Edukasi dan Pemeriksaan Kesehatan dalam Perkara Dispensasi Kawin',
            'link_dokumen'  => 'images/artikel/MOU_Dinkes_TTD_compressed.pdf',
        ],
        [
            'tanggal'       => '2021-08-20',
            'instansi'      => 'Kementerian Agama Kabupaten Penajam Paser Utara',
            'tentang'       => 'Pemanfaatan Teknologi Akurasi Data Perceraian',
            'link_dokumen'  => 'images/artikel/MOU_dengan_KEMENAG-dikompresi.pdf',
        ],
        [
            'tanggal'       => '2021-08-18',
            'instansi'      => 'Sekolah Luar Biasa Negeri Kabupaten Penajam Paser Utara',
            'tentang'       => 'Penyediaan Layanan Penyandang Disabilitas',
            'link_dokumen'  => 'images/artikel/MOU_SLB.pdf',
        ],
        [
            'tanggal'       => '2021-04-08',
            'instansi'      => 'Dinas Kependudukan Dan Catatan Sipil Kabupaten Penajam Paser Utara',
            'tentang'       => 'Pemanfaatan Teknologi Informasi Untuk Akurasi Data Kependudukan Dan Catatan Sipil',
            'link_dokumen'  => 'https://drive.google.com/file/d/1cREJt5XBHq-Nla5ibthe6mSFSgTzapq5/view?usp=sharing',
        ],
        [
            'tanggal'       => '2020-09-18',
            'instansi'      => 'PT Bank Syariah Mandiri Cabang Penajam',
            'tentang'       => 'Layanan Pendampingan Service Excellent Untuk Pelayanan Prima Pada PTSP PA Penajam',
            'link_dokumen'  => 'https://drive.google.com/file/d/1kKgHaryx4WGV-FLWt5lE0G9uzsvWGWmH/view?usp=sharing',
        ],
        [
            'tanggal'       => '2020-08-31',
            'instansi'      => 'Pusat Bantuan Hukum Perhimpunan Advokat Indonesia',
            'tentang'       => 'Pelayanan Posbakum Non DIPA',
            'link_dokumen'  => 'https://drive.google.com/file/d/1nzdhaw55kXMyx0FH2K_7eFrbRJFybpb9/view?usp=sharing',
        ],
    ];

    public function run(): void
    {
        // Hapus data lama agar seeder aman dijalankan berkali-kali
        DB::table('mou')->truncate();

        $now = Carbon::now()->toDateTimeString();
        $rows = [];

        foreach ($this->data as $item) {
            $rows[] = [
                'tanggal'          => $item['tanggal'],
                'instansi'         => $item['instansi'],
                'tentang'          => $item['tentang'],
                'tanggal_berakhir' => null,
                'link_dokumen'     => $item['link_dokumen'],
                'tahun'            => date('Y', strtotime($item['tanggal'])),
                'created_at'       => $now,
                'updated_at'       => $now,
            ];
        }

        DB::table('mou')->insert($rows);
    }
}
