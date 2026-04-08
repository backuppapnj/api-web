<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InovasiSeeder extends Seeder
{
    private array $data = [
        // ═══════════════════════════════════════════════════════════
        // INOVASI KEBIJAKAN (Sesuai SK 1297/KPA.W17-A8/OT1.6/XII/2025)
        // ═══════════════════════════════════════════════════════════
        [
            'kategori' => 'Inovasi Kebijakan',
            'nama_inovasi' => 'Percepatan Penyelesaian Perkara',
            'deskripsi' => 'Inovasi Kebijakan Percepatan Penyelesaian Perkara dari 5 (lima) bulan menjadi 1 (satu) bulan. Menurut SEMA No. 2 Tahun 2014 penyelesaian perkara tingkat pertama maksimal 5 bulan. PA Penajam menerapkan kebijakan ini sehingga mayoritas penyelesaian perkara kurang dari 1 bulan. Dahulu masyarakat harus berbulan-bulan menunggu perkaranya selesai. Inovasi kebijakan ini memangkas proses penyelesaian perkara, khususnya yang pihaknya berdomisili di wilayah Penajam, dan bukan perkara kebendaan yang memerlukan pemeriksaan setempat. Asas cepat, sederhana, biaya ringan terpenuhi.',
            'link_dokumen' => null,
            'urutan' => 1,
        ],
        [
            'kategori' => 'Inovasi Kebijakan',
            'nama_inovasi' => 'Validasi Data Kependudukan Kerjasama dengan Disdukcapil',
            'deskripsi' => 'Inovasi Kebijakan Validasi Data Kependudukan Kerjasama dengan Disdukcapil Kabupaten Penajam. Digunakan untuk memperbarui status kependudukan di KTP dan KK pasca-perceraian. Masyarakat tidak hanya mendapatkan akta cerai, tetapi juga langsung memperoleh Kartu Keluarga dan KTP terbaru dengan status perkawinan yang telah diperbarui. Layanan ini langsung di Meja PTSP PA Penajam, memangkas rantai birokrasi yang panjang dan berbelit.',
            'link_dokumen' => null,
            'urutan' => 2,
        ],
        [
            'kategori' => 'Inovasi Kebijakan',
            'nama_inovasi' => 'Pelatihan Service Excellence Kerjasama dengan Bank Syariah Indonesia',
            'deskripsi' => 'Inovasi Kebijakan Pelatihan Service Excellence Kerjasama dengan Bank Syariah Indonesia. Program pelatihan untuk meningkatkan kualitas pelayanan prima kepada masyarakat dengan standar perbankan syariah. Pegawai dilatih untuk memberikan pelayanan yang profesional, ramah, dan berorientasi pada kepuasan pengguna layanan.',
            'link_dokumen' => null,
            'urutan' => 3,
        ],
        [
            'kategori' => 'Inovasi Kebijakan',
            'nama_inovasi' => 'PARABOLA - Pendaftaran Perkara Jemput Bola',
            'deskripsi' => 'Inovasi Kebijakan PARABOLA (Pendaftaran Perkara Jemput Bola). Merupakan inovasi kebijakan yang memberikan pelayanan pendaftaran perkara berbasis on the spot. Petugas PA Penajam mendatangi daerah terpencil yang sukar mengakses keadilan, melakukan pendaftaran perkara dengan cepat, sederhana, dan berbiaya ringan. Berkat inovasi Parabola, akses masyarakat terhadap keadilan lebih terbuka, hemat waktu, biaya, dan jarak tempuh.',
            'link_dokumen' => null,
            'urutan' => 4,
        ],
        [
            'kategori' => 'Inovasi Kebijakan',
            'nama_inovasi' => 'PACAR ARTIS - Pelayanan Akta Cerai Antar Gratis',
            'deskripsi' => 'Inovasi Kebijakan PACAR ARTIS (Pelayanan Akta Cerai Antar Gratis). Merupakan inovasi kebijakan yang menjadi solusi bagi masyarakat yang domisilinya jauh dari kantor PA Penajam. Mereka yang hendak mengambil produk akta cerai maupun salinan putusan/penetapan, tidak perlu datang ke PA Penajam karena petugas akan memberikan layanan on the spot ke daerah terpencil. Dengan demikian akses keadilan masyarakat lebih terbuka, hemat waktu, biaya, dan jarak tempuh.',
            'link_dokumen' => null,
            'urutan' => 5,
        ],
        [
            'kategori' => 'Inovasi Kebijakan',
            'nama_inovasi' => 'BRYAN CAKEP - Briefing Layanan Cakep',
            'deskripsi' => 'Inovasi Kebijakan BRYAN CAKEP (Briefing Layanan Cakep). Program briefing rutin untuk meningkatkan kualitas pelayanan kepada masyarakat. Melalui briefing ini, pegawai mendapatkan arahan dan evaluasi terkait pelayanan sehingga dapat memberikan layanan yang cakep (cepat, akurat, berkualitas, dan profesional) kepada masyarakat.',
            'link_dokumen' => null,
            'urutan' => 6,
        ],
        [
            'kategori' => 'Inovasi Kebijakan',
            'nama_inovasi' => 'Sharing Session "We Listen, We Resolve"',
            'deskripsi' => 'Sharing Session "We Listen, We Resolve". Forum diskusi dan berbagi pengalaman antar pegawai untuk meningkatkan kemampuan dalam mendengarkan dan menyelesaikan permasalahan masyarakat. Session ini bertujuan untuk membangun budaya organisasi yang responsif dan solutif terhadap kebutuhan pengguna layanan.',
            'link_dokumen' => null,
            'urutan' => 7,
        ],

        // ═══════════════════════════════════════════════════════════
        // INOVASI APLIKASI
        // ═══════════════════════════════════════════════════════════
        [
            'kategori' => 'Inovasi Aplikasi',
            'nama_inovasi' => 'SI SUKMA - Sistem Distribusi dan Disposisi Surat',
            'deskripsi' => 'Aplikasi SI SUKMA (Sistem Informasi Surat Masuk dan Kelima) untuk penunjang kelancaran distribusi dan disposisi surat keluar dan masuk. Aplikasi Tata Persuratan yang merekam semua jenis surat masuk dan surat keluar yang membantu proses disposisi surat kepada pejabat yang bertanggungjawab untuk menangani surat sehingga tata persuratan bisa berjalan secara elektronik.',
            'link_dokumen' => null,
            'urutan' => 8,
        ],
        [
            'kategori' => 'Inovasi Aplikasi',
            'nama_inovasi' => 'SIPERAWAT - Pemberitahuan Perkara via Whatsapp',
            'deskripsi' => 'Sistem Informasi Pemberitahuan Perkara via Whatsapp (SIPERAWAT). Aplikasi sistem notifikasi SIPP melalui media whatsapp untuk memberikan informasi terkini kepada masyarakat terkait status perkara mereka. Masyarakat dapat menerima pemberitahuan otomatis tanpa harus datang ke pengadilan.',
            'link_dokumen' => null,
            'urutan' => 9,
        ],
        [
            'kategori' => 'Inovasi Aplikasi',
            'nama_inovasi' => 'SITARA - Sistem Informasi Biaya Perkara',
            'deskripsi' => 'Sistem Informasi Biaya Perkara (SITARA). Sistem perhitungan taksiran panjar perkara khusus wilayah Pengadilan Agama Penajam. Aplikasi ini membantu masyarakat untuk mengetahui estimasi biaya perkara secara transparan dan akurat sebelum mendaftarkan perkaranya.',
            'link_dokumen' => null,
            'urutan' => 10,
        ],
        [
            'kategori' => 'Inovasi Aplikasi',
            'nama_inovasi' => 'APIK - Administrasi ATK Perkara',
            'deskripsi' => 'Administrasi ATK Perkara (APIK). Sistem pengelolaan administrasi alat tulis kantor untuk keperluan perkara. Aplikasi ini membantu monitoring dan pengelolaan persediaan ATK terkait proses perkara agar lebih efisien dan terdokumentasi dengan baik.',
            'link_dokumen' => null,
            'urutan' => 11,
        ],
        [
            'kategori' => 'Inovasi Aplikasi',
            'nama_inovasi' => 'PERFORMA - Informasi Mediasi Via Whatsapp',
            'deskripsi' => 'Percepatan Informasi Mediasi Via Whatsapp (PERFORMA). Aplikasi untuk mempercepat penyebaran informasi terkait jadwal dan hasil mediasi melalui platform whatsapp. Para pihak yang berperkara dapat menerima informasi mediasi secara real-time.',
            'link_dokumen' => null,
            'urutan' => 12,
        ],
        [
            'kategori' => 'Inovasi Aplikasi',
            'nama_inovasi' => 'IDAMAN - Mediasi Dalam Jaringan',
            'deskripsi' => 'Inovasi Mediasi Dalam Jaringan (IDAMAN). Platform mediasi online yang memungkinkan para pihak melakukan proses mediasi secara virtual tanpa harus bertemu langsung. Sangat bermanfaat untuk para pihak yang berada di lokasi berbeda atau memiliki keterbatasan waktu.',
            'link_dokumen' => null,
            'urutan' => 13,
        ],
        [
            'kategori' => 'Inovasi Aplikasi',
            'nama_inovasi' => 'SIMBARA - Monitoring Pengelolaan Barang Persediaan ATK',
            'deskripsi' => 'Aplikasi SIMBARA (Sistem Monitoring Pengelolaan Barang Persediaan ATK). Sistem untuk memonitor dan mengelola persediaan alat tulis kantor secara elektronik. Aplikasi ini membantu dalam perencanaan, pengadaan, dan distribusi ATK agar lebih efisien dan terkontrol.',
            'link_dokumen' => null,
            'urutan' => 14,
        ],
        [
            'kategori' => 'Inovasi Aplikasi',
            'nama_inovasi' => 'SIPESKA - Sistem Pendaftaran Surat Kuasa',
            'deskripsi' => 'SIPESKA (Sistem Pendaftaran Surat Kuasa). Aplikasi untuk mendaftarkan dan mengelola surat kuasa secara elektronik. Sistem ini mempermudah proses administrasi surat kuasa dan memastikan validitas dokumen kuasa yang digunakan dalam perkara.',
            'link_dokumen' => null,
            'urutan' => 15,
        ],
        [
            'kategori' => 'Inovasi Aplikasi',
            'nama_inovasi' => 'PANTURA - Pantau Tugas Dari Mana Saja',
            'deskripsi' => 'PANTURA (Pantau Tugas Dari Mana Saja). Aplikasi monitoring tugas dan kinerja pegawai yang dapat diakses dari mana saja. Atasan dapat memantau progress pekerjaan pegawai secara real-time, sementara pegawai dapat melaporkan tugas mereka secara online.',
            'link_dokumen' => null,
            'urutan' => 16,
        ],
        [
            'kategori' => 'Inovasi Aplikasi',
            'nama_inovasi' => 'PERWIRA - Penilaian Kinerja Pegawai',
            'deskripsi' => 'PERWIRA (Penilaian Kinerja Pegawai). Sistem penilaian kinerja pegawai berbasis digital yang objektif dan transparan. Aplikasi ini membantu dalam evaluasi kinerja pegawai secara berkala dan memberikan feedback untuk pengembangan kompetensi.',
            'link_dokumen' => null,
            'urutan' => 17,
        ],

        // ═══════════════════════════════════════════════════════════
        // INOVASI LAYANAN PUBLIK
        // ═══════════════════════════════════════════════════════════
        [
            'kategori' => 'Inovasi Layanan Publik',
            'nama_inovasi' => 'Layanan Antrian Sidang',
            'deskripsi' => 'Layanan Antrian Sidang. Aplikasi pengambilan nomor antrian untuk layanan sidang. Masyarakat dapat mengambil nomor antrian secara online atau di lokasi untuk mengikuti sidang, sehingga mengurangi waktu tunggu dan kerumunan di pengadilan.',
            'link_dokumen' => null,
            'urutan' => 18,
        ],
        [
            'kategori' => 'Inovasi Layanan Publik',
            'nama_inovasi' => 'Layanan Antrian PTSP',
            'deskripsi' => 'Layanan Antrian PTSP (Pelayanan Terpadu Satu Pintu). Aplikasi pengambilan nomor antrian untuk layanan PTSP. Sistem antrian modern yang memungkinkan masyarakat mendapatkan pelayanan PTSP dengan lebih teratur dan efisien.',
            'link_dokumen' => null,
            'urutan' => 19,
        ],
        [
            'kategori' => 'Inovasi Layanan Publik',
            'nama_inovasi' => 'PTSL - Pelayanan Terpadu Satu Pintu',
            'deskripsi' => 'Pelayanan Terpadu Satu Pintu/One Spot Integrated Service (PTSL). Sistem pelayanan yang mengintegrasikan berbagai layanan pengadilan dalam satu tempat. Masyarakat dapat mengakses berbagai layanan tanpa harus berpindah-pindah meja atau ruangan.',
            'link_dokumen' => null,
            'urutan' => 20,
        ],
        [
            'kategori' => 'Inovasi Layanan Publik',
            'nama_inovasi' => 'NASI TANAK - Layanan Edukasi dan Pemeriksaan Kesehatan Anak',
            'deskripsi' => 'NASI TANAK (Layanan Edukasi dan Pemeriksaan Kesehatan Anak). Program layanan sosial yang menyediakan edukasi dan pemeriksaan kesehatan bagi anak-anak, terutama anak-anak dari keluarga yang berperkara di pengadilan. Kolaborasi dengan instansi kesehatan terkait.',
            'link_dokumen' => null,
            'urutan' => 21,
        ],
        [
            'kategori' => 'Inovasi Layanan Publik',
            'nama_inovasi' => 'SILANTAS - Layanan Penyandang Disabilitas',
            'deskripsi' => 'SILANTAS (Inovasi Layanan Penyandang Disabilitas). Layanan khusus untuk penyandang disabilitas yang meliputi fasilitas drop zone, jalur difabel, meja khusus difabel, kursi roda, pendamping prioritas yang melakukan mobilitas melayani kebutuhan layanan. PA Penajam juga menyediakan layanan penerjemah bagi penyandang disabilitas.',
            'link_dokumen' => null,
            'urutan' => 22,
        ],

        // ═══════════════════════════════════════════════════════════
        // APLIKASI DITJEN BADAN PERADILAN AGAMA (17 Aplikasi)
        // ═══════════════════════════════════════════════════════════
        [
            'kategori' => 'Aplikasi Ditjen Badilag',
            'nama_inovasi' => 'Aplikasi Antrian Sidang',
            'deskripsi' => 'Aplikasi Antrian Sidang dari Ditjen Badan Peradilan Agama. Sistem pengambilan nomor antrian sidang secara elektronik untuk mengatur jadwal dan mengurangi waktu tunggu para pihak di pengadilan.',
            'link_dokumen' => null,
            'urutan' => 23,
        ],
        [
            'kategori' => 'Aplikasi Ditjen Badilag',
            'nama_inovasi' => 'Aplikasi Notifikasi Perkara',
            'deskripsi' => 'Aplikasi Notifikasi Perkara dari Ditjen Badan Peradilan Agama. Sistem pengiriman notifikasi otomatis terkait perkembangan perkara kepada para pihak melalui SMS, email, atau whatsapp.',
            'link_dokumen' => null,
            'urutan' => 24,
        ],
        [
            'kategori' => 'Aplikasi Ditjen Badilag',
            'nama_inovasi' => 'Aplikasi Informasi Produk Pengadilan',
            'deskripsi' => 'Aplikasi Informasi Produk Pengadilan dari Ditjen Badan Peradilan Agama. Sistem informasi yang menyediakan akses terhadap produk-produk pengadilan seperti putusan, penetapan, dan akta cerai.',
            'link_dokumen' => null,
            'urutan' => 25,
        ],
        [
            'kategori' => 'Aplikasi Ditjen Badilag',
            'nama_inovasi' => 'Aplikasi E-Register',
            'deskripsi' => 'Aplikasi E-Register dari Ditjen Badan Peradilan Agama. Sistem pendaftaran perkara secara elektronik yang memungkinkan pendaftaran perkara dari mana saja tanpa harus datang ke pengadilan.',
            'link_dokumen' => null,
            'urutan' => 26,
        ],
        [
            'kategori' => 'Aplikasi Ditjen Badilag',
            'nama_inovasi' => 'Aplikasi Basis Data Terpadu Kemiskinan',
            'deskripsi' => 'Aplikasi Basis Data Terpadu Kemiskinan dari Ditjen Badan Peradilan Agama. Database terpadu untuk mengidentifikasi masyarakat kurang mampu yang berhak mendapatkan layanan prodeo (gratis).',
            'link_dokumen' => null,
            'urutan' => 27,
        ],
        [
            'kategori' => 'Aplikasi Ditjen Badilag',
            'nama_inovasi' => 'Aplikasi E-Keuangan',
            'deskripsi' => 'Aplikasi E-Keuangan dari Ditjen Badan Peradilan Agama. Sistem pengelolaan keuangan pengadilan secara elektronik termasuk panjar biaya perkara, SPP, dan pertanggungjawaban keuangan.',
            'link_dokumen' => null,
            'urutan' => 28,
        ],
        [
            'kategori' => 'Aplikasi Ditjen Badilag',
            'nama_inovasi' => 'Command Center',
            'deskripsi' => 'Command Center dari Ditjen Badan Peradilan Agama. Pusat monitoring dan pengendalian penyelenggaraan peradilan secara real-time yang menampilkan berbagai indikator kinerja pengadilan.',
            'link_dokumen' => null,
            'urutan' => 29,
        ],
        [
            'kategori' => 'Aplikasi Ditjen Badilag',
            'nama_inovasi' => 'Aplikasi Eksaminasi',
            'deskripsi' => 'Aplikasi Eksaminasi dari Ditjen Badan Peradilan Agama. Sistem untuk melakukan eksaminasi atau pemeriksaan terhadap putusan hakim guna menjaga kualitas dan konsistensi putusan.',
            'link_dokumen' => null,
            'urutan' => 30,
        ],
        [
            'kategori' => 'Aplikasi Ditjen Badilag',
            'nama_inovasi' => 'Aplikasi PNBP Fungsional',
            'deskripsi' => 'Aplikasi PNBP Fungsional dari Ditjen Badan Peradilan Agama. Sistem pengelolaan Penerimaan Negara Bukan Pajak (PNBP) fungsional peradilan termasuk perhitungan dan pelaporan.',
            'link_dokumen' => null,
            'urutan' => 31,
        ],
        [
            'kategori' => 'Aplikasi Ditjen Badilag',
            'nama_inovasi' => 'Aplikasi Validasi Akta Cerai',
            'deskripsi' => 'Aplikasi Validasi Akta Cerai dari Ditjen Badan Peradilan Agama. Sistem untuk memvalidasi keaslian akta cerai melalui database terpusat untuk mencegah pemalsuan dokumen.',
            'link_dokumen' => null,
            'urutan' => 32,
        ],
        [
            'kategori' => 'Aplikasi Ditjen Badilag',
            'nama_inovasi' => 'Aplikasi Gugatan Mandiri',
            'deskripsi' => 'Aplikasi Gugatan Mandiri dari Ditjen Badan Peradilan Agama. Platform yang memungkinkan masyarakat membuat gugatan/permohonan secara mandiri tanpa bantuan kuasa hukum melalui panduan online.',
            'link_dokumen' => null,
            'urutan' => 33,
        ],
        [
            'kategori' => 'Aplikasi Ditjen Badilag',
            'nama_inovasi' => 'Portal Ekonomi Syariah',
            'deskripsi' => 'Portal Ekonomi Syariah dari Ditjen Badan Peradilan Agama. Portal informasi dan layanan terkait ekonomi syariah termasuk penyelesaian sengketa ekonomi syariah.',
            'link_dokumen' => null,
            'urutan' => 34,
        ],
        [
            'kategori' => 'Aplikasi Ditjen Badilag',
            'nama_inovasi' => 'Pusat Data Perkara',
            'deskripsi' => 'Pusat Data Perkara dari Ditjen Badan Peradilan Agama. Repository data perkara terpusat yang menyimpan informasi lengkap tentang seluruh perkara yang terdaftar di pengadilan.',
            'link_dokumen' => null,
            'urutan' => 35,
        ],
        [
            'kategori' => 'Aplikasi Ditjen Badilag',
            'nama_inovasi' => 'Aplikasi PTSP Online Pengadilan Tingkat Banding',
            'deskripsi' => 'Aplikasi PTSP Online Pengadilan Tingkat Banding dari Ditjen Badan Peradilan Agama. Layanan Pelayanan Terpadu Satu Pintu secara online untuk perkara tingkat banding di Pengadilan Tinggi Agama.',
            'link_dokumen' => null,
            'urutan' => 36,
        ],
        [
            'kategori' => 'Aplikasi Ditjen Badilag',
            'nama_inovasi' => 'Aplikasi Penilaian APM',
            'deskripsi' => 'Aplikasi Penilaian APM (Aspek Pelaksanaan Manajemen) dari Ditjen Badan Peradilan Agama. Sistem penilaian kinerja manajemen pengadilan berdasarkan indikator yang telah ditetapkan.',
            'link_dokumen' => null,
            'urutan' => 37,
        ],
        [
            'kategori' => 'Aplikasi Ditjen Badilag',
            'nama_inovasi' => 'Laporan Elektronik (e-Laporan)',
            'deskripsi' => 'Laporan Elektronik (e-Laporan) dari Ditjen Badan Peradilan Agama. Sistem pelaporan elektronik untuk berbagai jenis laporan pengadilan secara terintegrasi dan real-time.',
            'link_dokumen' => null,
            'urutan' => 38,
        ],
        [
            'kategori' => 'Aplikasi Ditjen Badilag',
            'nama_inovasi' => 'Aplikasi Vision - Virtualisasi Surat Izin Online',
            'deskripsi' => 'Aplikasi Vision (Virtualisasi Surat Izin Online) dari Ditjen Badan Peradilan Agama. Sistem pengajuan dan pengelolaan surat izin pegawai secara online tanpa perlu datang ke kantor.',
            'link_dokumen' => null,
            'urutan' => 39,
        ],

        // ═══════════════════════════════════════════════════════════
        // APLIKASI PENGADILAN TINGGI AGAMA SAMARINDA (2 Aplikasi)
        // ═══════════════════════════════════════════════════════════
        [
            'kategori' => 'Aplikasi PTA Samarinda',
            'nama_inovasi' => 'Aplikasi SIPESUT',
            'deskripsi' => 'Aplikasi SIPESUT dari Pengadilan Tinggi Agama Samarinda. Sistem informasi yang dikembangkan oleh PTA Samarinda untuk mendukung pelayanan dan administrasi peradilan di wilayah hukum PTA Samarinda.',
            'link_dokumen' => null,
            'urutan' => 40,
        ],
        [
            'kategori' => 'Aplikasi PTA Samarinda',
            'nama_inovasi' => 'Aplikasi TAPTA',
            'deskripsi' => 'Aplikasi TAPTA dari Pengadilan Tinggi Agama Samarinda. Aplikasi yang dikembangkan oleh PTA Samarinda untuk meningkatkan efisiensi dan efektivitas pelayanan pengadilan di wilayah hukumnya.',
            'link_dokumen' => null,
            'urutan' => 41,
        ],
    ];

    public function run(): void
    {
        // Truncate table untuk clean slate
        DB::table('inovasi')->truncate();

        $now = Carbon::now();

        // Batch insert semua data
        $insertData = array_map(function ($row) use ($now) {
            return [
                'nama_inovasi' => $row['nama_inovasi'],
                'deskripsi' => $row['deskripsi'],
                'kategori' => $row['kategori'],
                'link_dokumen' => $row['link_dokumen'],
                'urutan' => $row['urutan'],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }, $this->data);

        DB::table('inovasi')->insert($insertData);

        $this->command->info('InovasiSeeder: ' . count($this->data) . ' baris diproses.');
    }
}
