<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InovasiSeeder extends Seeder
{
    private array $data = [
        // ── Inovasi Layanan ───────────────────────────────────────────────────
        [
            'kategori' => 'Inovasi Layanan',
            'nama_inovasi' => 'PARABOLA',
            'deskripsi' => 'Pendaftaran Perkara Jemput Bola (PARABOLA). Merupakan inovasi kebijakan yang memberikan pelayanan pendaftaran perkara berbasis on the spot. Petugas PA Penajam mendatangi daerah terpencil yang sukar mengakses keadilan, melakukan pendaftaran perkara dengan cepat, sederhana, dan berbiaya ringan. Sebelumnya, akses keadilan masyarakat Penajam sangat terhambat karena berada di daerah pelosok. Sehingga ketika hendak mendaftarkan perkara harus datang ke PA Penajam. Berkat inovasi Parabola, akses masyarakat terhadap keadilan lebih terbuka, hemat waktu, biaya, dan jarak tempuh.',
            'link_dokumen' => null,
            'urutan' => 1,
        ],
        [
            'kategori' => 'Inovasi Layanan',
            'nama_inovasi' => 'PACAR ARTIS',
            'deskripsi' => 'Pelayanan Akta Cerai Antar Gratis (PACAR ARTIS). Merupakan inovasi kebijakan yang menjadi solusi bagi masyarakat yang domisilinya jauh dari kantor PA Penajam. Mereka yang hendak mengambil produk akta cerai maupun salinan putusan/penetapan, tidak perlu datang ke PA Penajam karena petugas akan memberikan layanan on the spot ke daerah terpencil. Dengan demikian akses keadilan masyarakat Penajam lebih terbuka, hemat waktu, biaya, dan jarak tempuh.',
            'link_dokumen' => null,
            'urutan' => 2,
        ],
        [
            'kategori' => 'Inovasi Layanan',
            'nama_inovasi' => 'SI KUDA TAPIL',
            'deskripsi' => 'Inovasi Akurasi Data Kependudukan dan Pencatatan Sipil (SI KUDA TAPIL). Inovasi ini berkat kerjasama dengan Disdukcapil Kabupaten penajam. Digunakan untuk memperbarui status kependudukan di KTP dan KK pasca-perceraian. Masyarakat tidak hanya mendapatkan akta cerai, tetapi juga langsung memperoleh Kartu Keluarga dan KTP terbaru dengan status perkawinan yang telah diperbarui. Layanan pengambilan produk ini langsung di Meja PTSP PA Penajam. Dahulu masyarakat setelah resmi bercerai hanya mendapatkan akta cerai. Setelah itu, harus menempuh birokrasi yang panjang untuk mengubah statusnya di KK dan KTP dengan mendatangi Kantor Disdukcapil. Sehingga memakan waktu dan biaya transportasi. Sekarang Si Kuda Tapil mampu memangkas rantai birokrasi yang panjang dan berbelit. Masyarakat terbantu karena tidak hanya mendapatkan akta cerai, tetapi juga langsung memperoleh Kartu Keluarga dan KTP terbaru dengan status perkawinan yang telah diperbarui di meja PTSP PA Penajam.',
            'link_dokumen' => null,
            'urutan' => 3,
        ],
        [
            'kategori' => 'Inovasi Layanan',
            'nama_inovasi' => 'SI TAPERA',
            'deskripsi' => 'Inovasi Percepatan Penyelesaian Perkara (SI TAPERA). Menurut SEMA No. 2 Tahun 2014 penyelesaian perkara tingkat pertama maksimal 5 bulan. Meskipun demikian PA Penajam menerapkan Si Tapera sehingga mayoritas penyelesaian perkara kurang dari 1 bulan. Dahulu masyarakat harus berbulan-bulan menunggu perkaranya selesai. Sehingga asas cepat, sederhana, biaya ringan kurang maksimal diwujudkan. Inovasi kebijakan ini memangkas proses penyelesaian perkara, khususnya yang pihaknya berdomisili di wilayah Penajam, dan bukan perkara kebendaan yang memerlukan pemeriksaan setempat dan lain-lain. Asas cepat, sederhana, biaya ringan terpenuhi.',
            'link_dokumen' => null,
            'urutan' => 4,
        ],
        [
            'kategori' => 'Inovasi Layanan',
            'nama_inovasi' => 'SI ACI',
            'deskripsi' => 'Sistem Informasi Akta Cerai (SI ACI). Inovasi aplikasi ini digunakan untuk merekam data pihak yang telah mengambil akta cerai sehingga menghindari terjadinya penyalahgunaan oleh pihak yang tidak bertanggungjawab. Data pengambilan akta cerai kurang terdokumentasi dengan baik dan berpotensi orang yang mengambil produk bukanlah yang bersangkutan. Berkat inovasi tersebut, data terdokumentasi dengan baik karena aplikasi ini merekam wajah dan KTP pihak pengambil produk sehingga meminimalisir terjadinya penyalahgunaan oleh pihak yang tidak bertanggungjawab.',
            'link_dokumen' => null,
            'urutan' => 5,
        ],
        [
            'kategori' => 'Inovasi Layanan',
            'nama_inovasi' => 'SI LANTAS',
            'deskripsi' => 'Inovasi Layanan Penyandang Disabilitas (SI LANTAS). Dahulu masyarakat berkebutuhan khusus perlakuannya disamakan dengan manusia normal. Sekarang penyandang disabilitas memperoleh layanan khusus, antara lain fasilitas drop zone, jalur difabel, meja khusus difabel, kursi roda, pendamping prioritas yang melakukan mobilitas melayani kebutuhan layanan. Di samping itu, PA Penajam juga menyediakan layanan penerjemah bagi penyandang disabilitas.',
            'link_dokumen' => null,
            'urutan' => 6,
        ],
        [
            'kategori' => 'Inovasi Layanan',
            'nama_inovasi' => 'SI-SUKMA',
            'deskripsi' => 'SI-SUKMA. Aplikasi Tata Persuratan yang merekam semua jenis surat masuk dan surat keluar yang membantu proses disposisi surat kepada pejabat yang bertanggungjawab untuk menangani surat sehingga tata persuratan bisa berjalan secara elektronik.',
            'link_dokumen' => null,
            'urutan' => 7,
        ],
        [
            'kategori' => 'Inovasi Layanan',
            'nama_inovasi' => 'SI LINTANG',
            'deskripsi' => 'SI LINTANG. Layanan informasi untuk kaum rentang melalui media whatsapp dan google form.',
            'link_dokumen' => null,
            'urutan' => 8,
        ],
        [
            'kategori' => 'Inovasi Layanan',
            'nama_inovasi' => 'SI PERAWAT',
            'deskripsi' => 'SI PERAWAT. Aplikasi Sistem notifikasi sipp melalui media whatsapp.',
            'link_dokumen' => null,
            'urutan' => 9,
        ],
        [
            'kategori' => 'Inovasi Layanan',
            'nama_inovasi' => 'SEPEDA ONLINE',
            'deskripsi' => 'SEPEDA ONLINE. Sistem Pelayanan Disabilitas Online merupakan pelayanan khusus penyandang disabilitas di pengadilan agama penajam dalam memperoleh akses peradilan.',
            'link_dokumen' => null,
            'urutan' => 10,
        ],
        [
            'kategori' => 'Inovasi Layanan',
            'nama_inovasi' => 'SI-TARA',
            'deskripsi' => 'SI-TARA (Sistem Informasi Taksiran Panjar Perkara). Sistem Perhitungan taksiran panjar perkara khusus wilayah Pengadilan Agama Penajam.',
            'link_dokumen' => null,
            'urutan' => 11,
        ],
        [
            'kategori' => 'Inovasi Layanan',
            'nama_inovasi' => 'Layanan Antrian Sidang dan PTSP',
            'deskripsi' => 'Layanan Antrian Sidang dan PTSP. Aplikasi Pengambilan nomor antrian untuk layanan PTSP dan Sidang.',
            'link_dokumen' => null,
            'urutan' => 12,
        ],
        [
            'kategori' => 'Inovasi Layanan',
            'nama_inovasi' => 'SK Inovasi',
            'deskripsi' => 'SK Inovasi Pengadilan Agama Penajam.',
            'link_dokumen' => 'https://drive.google.com/file/d/1-Z-ncf0pIBs-yfxSCmrpQotKVaMLqn90/view?usp=drive_link',
            'urutan' => 13,
        ],

        // ── Inovasi Layanan Saat Pandemi ──────────────────────────────────────
        [
            'kategori' => 'Inovasi Layanan Saat Pandemi',
            'nama_inovasi' => 'Layanan Informasi',
            'deskripsi' => 'Layanan Informasi. Selama masa pandemi, untuk menghindari kontak langsung, PA Penajam membuka layanan informasi melalui website, nomor telpon layanan, media sosial berupa TikTok, Facebook, Instagram, dan youtube.',
            'link_dokumen' => null,
            'urutan' => 1,
        ],
        [
            'kategori' => 'Inovasi Layanan Saat Pandemi',
            'nama_inovasi' => 'Layanan Pembuatan Gugatan melalui Gugatan Mandiri',
            'deskripsi' => 'Layanan Pembuatan Gugatan melalui Gugatan Mandiri. Aplikasi ini menyediakan tata cara dan menu pembuatan gugatan secara mandiri sesuai kebutuhan pengguna. PA Penajam sudah berulangkali membatasi layanan tatap muka karena pandemi, sehingga masyarakat kesulitan membuat surat gugatan/permohonan. Sekarang Masyarakat bisa membuat surat gugatan/permohonan secara mandiri melalui link yang ditautkan di website www.pa-penajam.go.id.',
            'link_dokumen' => null,
            'urutan' => 2,
        ],
        [
            'kategori' => 'Inovasi Layanan Saat Pandemi',
            'nama_inovasi' => 'Layanan Pendaftaran Perkara melalui e-Court',
            'deskripsi' => 'Layanan Pendaftaran Perkara melalui e-Court. Aplikasi ini menyediakan menu pendaftaran secara elektronik. Selama pendemi masyarakat kesulitan mendaftar perkara karena ada pembatasan layanan. Melalui e-Court saat ini masyarakat bisa mendaftar perkara dari manapun, baik sebagai pengguna terdaftar maupun pengguna lainnya.',
            'link_dokumen' => null,
            'urutan' => 3,
        ],
        [
            'kategori' => 'Inovasi Layanan Saat Pandemi',
            'nama_inovasi' => 'Layanan Persidangan secara Elektronik/Elitigasi',
            'deskripsi' => 'Layanan Persidangan secara Elektronik/Elitigasi. Masyarakat melaksanakan persidangan secara elektronik tanpa harus datang ke pengadilan. Karena persidangan dengan tatap muka berpotensi penularan virus Corona. Tentunya persidangan dilakukan dengan memenuhi ketentuan PERMA No.1 Tahun 2019.',
            'link_dokumen' => null,
            'urutan' => 4,
        ],
        [
            'kategori' => 'Inovasi Layanan Saat Pandemi',
            'nama_inovasi' => 'Layanan Pembayaran melalui QRIS (Layaris)',
            'deskripsi' => 'Layanan Pembayaran melalui QRIS (Layaris). Aplikasi Quick Response Code Indonesia Standard (QRIS) merupakan kerjasama dengan Bank Syariah Indonesia berupa pembayaran berbasis barcode, sehingga mencegah kontak dan penularan virus Corona. QRIS merupakan salah satu implementasi Visi Sistem Pembayaran Indonesia (SPI) 2025. Dahulu masyarakat membayar panjar biaya perkara dengan tunai, mesin ATM, mesin EDC, sehingga berpotensi penularan virus Corona. Masyarakat bisa membayar panjar biaya perkara dengan QRIS sehingga terhindar dari Corona.',
            'link_dokumen' => null,
            'urutan' => 5,
        ],
    ];

    public function run(): void
    {
        $now = Carbon::now();

        foreach ($this->data as $row) {
            DB::table('inovasi')->updateOrInsert(
                [
                    'nama_inovasi' => $row['nama_inovasi'],
                    'kategori' => $row['kategori'],
                ],
                [
                    'deskripsi' => $row['deskripsi'],
                    'link_dokumen' => $row['link_dokumen'],
                    'urutan' => $row['urutan'],
                    'updated_at' => $now,
                    'created_at' => $now,
                ]
            );
        }

        $this->command->info('InovasiSeeder: ' . count($this->data) . ' baris diproses.');
    }
}
