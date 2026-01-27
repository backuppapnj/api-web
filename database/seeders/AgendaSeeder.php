<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class AgendaSeeder extends Seeder
{
    private function normalizeWhitespace($value): string
    {
        if ($value === null) {
            return '';
        }

        $value = preg_replace('/\s+/', ' ', trim((string) $value));
        return $value === null ? '' : $value;
    }

    private function parseTanggalAgenda($raw): ?string
    {
        if (!$raw) {
            return null;
        }

        $s = $this->normalizeWhitespace($raw);
        if ($s === '') {
            return null;
        }

        $months = [
            'januari' => '01',
            'februari' => '02',
            'maret' => '03',
            'april' => '04',
            'mei' => '05',
            'juni' => '06',
            'juli' => '07',
            'agustus' => '08',
            'september' => '09',
            'oktober' => '10',
            'november' => '11',
            'desember' => '12',
        ];

        // Expected: "22 Oktober 2025" (can contain newlines/spaces in source)
        if (!preg_match('/\b(\d{1,2})\s+([A-Za-z]+)\s+(\d{4})\b/', $s, $m)) {
            return null;
        }

        $day = str_pad($m[1], 2, '0', STR_PAD_LEFT);
        $monthName = strtolower($m[2]);
        $year = $m[3];

        if (!isset($months[$monthName])) {
            return null;
        }

        return $year . '-' . $months[$monthName] . '-' . $day;
    }

    public function run()
    {
        $data = [
            [
                'tanggal_agenda' => '22
                            Oktober 2025',
                'isi_agenda' => 'Rabu,
                        22 Oktober 2025, Telah dilaksanakan Penandatanganan MOU Pengadilan Agama Penajam dengan Dinas
                        Pemberdayaan Perempuan, Perlindungan Anak, Pengendalian Penduduk, dan Keluarga Berencana
                        (DP3AP3KB) tentang Layanan Konseling Bagi Pemohon Dispensasi Kawin Pada Pengadilan Agama Penajam
                        dan Pemenuhan Hak Perempuan dan Anak Pasca Perceraian di Kabupaten Penajam Paser Utara.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '17
                            Oktober 2025',
                'isi_agenda' => 'Jum’at,
                        17 Oktober 2025, Ketua Pengadilan Agama Penajam Bapak Fattahurridlo Al Ghany S.H.I., M.S.I
                        beserta jajaran mengikuti Kegiatan Dialog Yudisial yang diselenggarakan oleh IKAHI secara
                        Daring.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '13
                            Oktober 2025',
                'isi_agenda' => 'Senin,
                        13 Oktober 2025, telah dilaksanakan Rapat Rutin Pimpinan Pengadilan Agama Penajam.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '06
                            Oktober 2025',
                'isi_agenda' => 'Senin,
                        06 Oktober 2025, Ketua Pengadilan Agama Penajam YM Bapak Fattahurridlo Al Ghany S.H.I., M.S.I
                        beserta jajaran mengikuti Kegiatan Pertemuan Rutin Sarasehan Interaktif (PERISAI) Episode Ke-10
                        dengan Tema Mengurangi Kompleksitas Esekusi Perdata "Problematika, Solusi, dan Prospek Pemberuan
                        Hukum" secara Daring.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '05
                            Oktober 2025',
                'isi_agenda' => 'Minggu,
                        05 Oktober 2025, Ketua Pengadilan Agama Penajam menghadiri Upacara Peringatan Hari Ulang Tahun
                        Ke-80 TNI Tahun 2025 yang bertempat di Komando Distrik Militer (Kodim) 0913 Penajam Paser
                        Utara.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '04
                            Oktober 2025',
                'isi_agenda' => 'Sabtu,
                        04 Oktober 2025, Ketua Pengadilan Agama Penajam Bapak Fattahurridlo Al Ghany S.H.I., M.S.I
                        memghadiri acara Peringatan Hari Kesatuan Gerak (HKG) PKK ke-53 Tingkat Kabupaten Penajam Paser
                        Utara Tahun 2025 dengan tema “Bergerak Bersama PKK Mewujudkan Asta Cita Menuju Indonesia
                        Emas”.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '03
                            Oktober 2025',
                'isi_agenda' => 'Jum’at,
                        03 Oktober 2025. Pimpinan Pengadilan Agama Penajam beserta jajaran mengikuti Bimbingan Teknis
                        Peningkatan Kompetensi Mediator secara Daring.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '01
                            Oktober 2025',
                'isi_agenda' => 'Rabu,
                        1 Oktober 2025, Ketua Pengadilan Agama Penajam YM Bapak Fattahurridlo Al Ghany S.H.I.,M.S.I.
                        menghadiri Peringatan Hari Kesaktian Pancasila yang digelar di halaman Kantor Bupati
                        PPU.Upacara
                        ini diikuti Forkopimda Kabupaten PPU, organisasi masyarakat (ormas), serta tamu undangan
                        lainnya.dengan
                        tema “Pancasila Perekat Bangsa Menuju Indonesia Raya” diharapkan kita dapat
                        mewujudkan melalui sikap saling menghargai perbedaan dan memperkuat persatuan sesuai dengan
                        ideologi Pancasila.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '30
                            September 2025',
                'isi_agenda' => 'Selasa,
                        30 September 2025, Pengadilan Agama Penajam melaksanakan kegiatan Bedah Berkas dengan narasumber
                        yaitu Ketua Pengadilan Agama Penajam YM. Bapak Fattahurridlo Al Ghany S.H.I.,M.S.IKegiatan
                        ini dihadiri oleh staff bagian Kepaniteraan dan dilaksanakan di Ruang Sidang Utama Pengadilan
                        Agama Penajam',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '24
                            September 2025',
                'isi_agenda' => 'Rabu,
                        24 September 2025, Pengadilan Agama Penajam melaksanakan kegiatan Diklat di Tempat Kerja (DDTK).
                        Materi disampaikan oleh Hakim Pengadilan Agama Penajam, Ibu Vidya Nurchaliza, S.H selaku
                        narasumber. Kegiatan ini diikuti oleh petugas layanan bagian PTSP dan aparatur yang terkait,
                        sebagai upaya untuk meningkatkan pemahaman serta keterampilan dalam memberikan pelayanan publik
                        yang optimal.Melalui
                        materi yang disampaikan, para peserta dibekali nilai-nilai dasar pelayanan, seperti kebersihan,
                        keramahan, ketepatan serta solutif dalam menangani kebutuhan masyarakat.Kegiatan
                        ini merupakan bentuk komitmen Pengadilan Agama Penajam dalam menciptakan lingkungan pelayanan
                        yang berorientasi pada kepuasan masyarakat.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '22
                            September 2025',
                'isi_agenda' => 'Senin,
                        22 September 2025, Dengan telah keluarnya persetujuan Pemusnahan Barang Milik Negara Selain
                        Tanah dan/atau Bangunan pada Pengadilan Agama Penajam, Ketua Pengadilan Agama Penajam Bapak
                        Fattahurridlo Al Ghany S.H.I., M.S.I beserta jajaran telah melakukan Pemusnahan Barang
                        Persediaan Blangko Akta Cerai yang bertempat di halaman Gedung Baru Pengadilan Agama
                        Penajam.Pemusnahan
                        blangko akta cerai tersebut bertujuan untuk menghindari penyalahgunaan dokumen penting.
                        Pemusnahan blangko akta cerai ini dilakukan dengan cara dibakar',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '19
                            September 2025',
                'isi_agenda' => 'Kamis,
                        19 September 2025, Ketua Pengadilan Agama Penajam Bapak Fattahurridlo Al Ghany S.H.I., M.S.I
                        menghadiri Launching Logo dan Tagline City Branding Kabupaten Penajam Paser Utara “Gerbang
                        Nusantara” dan Talk Show dengan tema “Sinergi Penajam Paser Utara sebagai Gerbang
                        Nusantara untuk Kaltim Sukses Menuju Generasi Emas” yang diselenggaran di Kampus Gunadarma
                        Penajam Paser Utara.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '17
                                September 2025',
                'isi_agenda' => 'Rabu,
                        17 September 2025, Ketua Pengadilan Agama Penajam YM Bapak Fattahurridlo Al Ghany S.H.I., M.S.I
                        menyaksikan Wisuda Purnabakti Ketua PTA Bandung secara virtual melalui zoom di ruang Media
                        Center Pengadilan Agama Penajam.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '04
                                September 2025',
                'isi_agenda' => 'Kamis,
                        04 September 2025, Ketua Pengadilan Agama Penajam Bapak Fattahurridlo Al Ghany S.H.I., M.S.I
                        beserta jajaran melaksanakan Rapat Monitoring dan Evaluasi PPID.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '31
                            Agustus 2025',
                'isi_agenda' => 'Minggu,
                        31 Agustus 2025, Ketua Pengadilan Agama Penajam YM Bapak Fattahurridlo Al Ghany S.H.I.,M.S.I
                        Menghadiri Rapat Komitmen Bersama untuk Menjaga Kondusifitas Penajam Paser Utara.Dalam
                        rapat tersebut, Bupati Penajam Paser Utara menegaskan pentingnya menjaga persatuan di tengah
                        dinamika yang terjadi saat ini. Kondusifitas wilayah merupakan tanggung jawab seluruh elemen,
                        baik pemerintah maupun masyarakat, sehingga dibutuhkan komitmen bersama untuk menciptakan
                        suasana yang aman dan damai.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '29
                            Agustus 2025',
                'isi_agenda' => 'Jumat,
                        29 Agustus 2025, Ketua Pengadilan Agama Penajam YM Bapak Fattahurridlo Al Ghany S.H.I.,M.S.I dan
                        Panitera Pengadilan Agama Penajam Bapak H. Muhammad Hamdi, S.H., M.Hum. melaksanakan Monitoring
                        dan Evaluasi PosbakumKegiatan
                        ini dilakukan untuk memastikan layanan bantuan hukum di Pengadilan Agama Penajam berjalan
                        optimal dan mudah diakses oleh masyarakat pencari keadilan',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '29
                            Agustus 2025',
                'isi_agenda' => 'Jumat,
                        29 Agustus 2025, Ketua Pengadilan Agama Penajam YM Bapak Fattahurridlo Al Ghany S.H.I.,M.S.I dan
                        Panitera Pengadilan Agama Penajam Bapak H. Muhammad Hamdi, S.H., M.Hum. melaksanakan Koordinasi
                        dan Konsultasi Terkait Proses Hukum dengan Unit Pelaksana Teknis Daerah Perlindungan Perempuan
                        dan Anak (UPTD-PPA) Kabupaten Penajam Paser Utara dalam memberikan layanan perlindungan hukum
                        kepada perempuan dan anak korban kekerasan',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '29
                            Agustus 2025',
                'isi_agenda' => 'Jumat,
                                29 Agustus 2025, Ketua Pengadilan Agama Penajam YM Bapak Fattahurridlo Al Ghany
                                S.H.I.,M.S.I beserta jajaran pimpinan dan pegawai Pengadilan Agama Penajam mengikuti
                                Pemanggilan Peserta Bimtek Kaum Rentan Berhadapan dengan Hukum bagi Tenaga Teknis di
                                Lingkungan Peradilan Agama dengan Tema "Pedoman Mengadili Perkara Kaum Rentan Berhadapan
                                dengan Hukum dalam Perkara Jinayat"yang
                                diadakan secara Daring di ruang Media Center Pengadilan Agama
                                Penajam',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '21
                            Agustus 2025',
                'isi_agenda' => 'Kamis,
                        21 Agustus 2025, Pimpinan Pengadilan Agama Penajam beserta jajaran mengikuti kegiatan Diskusi
                        Hukum Pengadilan Agama se Wilayah Hukum Pengadilan Tinggi Agama Samarinda Dengan Tema
                        "Transformasi Digital 6.0.0 Melalui Bedah Berkas, Upaya, Meningkatkan Profesionalitas Tenaga
                        Teknis Peradilan Agama Dalam Pelayanan Hukum di Wilayah Hukum Pengadilan Tinggi Agama
                        Samarinda."',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '19
                            Agustus 2025',
                'isi_agenda' => 'Selasa,
                        19 Agustus 2025, Jajaran pimpinan dan Hakim Pengadilan Agama Penajam bersama dengan Pengadilan
                        Negeri Penajam mengikuti siaran langsung melalui kanal YouTube Mahkamah Agung Republik Indonesia
                        dalam rangka Hari Ulang Tahun Mahkamah Agung RI ke-80.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '15
                            Agustus 2025',
                'isi_agenda' => 'Jum\'at,
                        15 Agustus 2025, Ketua Pengadilan Agama Penajam Bapak Fattahurridlo Al Ghany S.H.I., M.S.I
                        menghadiri Pengukuhan Pasukan Pengibar Bendera Pusaka (PASKIBRAKA) yang berlokasi di IKN.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '07
                                Agustus 2025',
                'isi_agenda' => 'Kamis,
                        07 Agustus 2025, Ketua Pengadilan Agama Penajam Bapak Fattahurridlo Al Ghany S.H.I., M.S.I
                        mengikuti Gerakan Pembagian Bendera Merah Putih Tahun 2025 di Kabupaten Penajam Paser Utara yang
                        diselenggarakan oleh Pemerintah Kabupaten Penajam Paser Utara.Kegiatan
                        ini merupakan tindak lanjut atas Instruksi Menteri Dalam Negeri guna mendorong masyarakat di
                        seluruh Indonesia untuk berpartisipasi dalam Gerakan Pembagian 10 Juta Bendera Merah Putih serta
                        mengibarkannya sepanjang bulan Agustus sebagai bentum penghormatan dan cinta kepada tanah
                        air.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '4
                                Agustus 2025',
                'isi_agenda' => 'Senin,
                        4 Agustus 2025, Ketua Pengadilan Agama Penajam YM Bapak Fattahurridlo Al Ghainy S.H.I.,M.S.I
                        menghadiri Soft Launching Integrasi Retribusi Jasa Kepelabuhan Buluminung yang merupakan bentuk
                        kerjasama dari Pemerintah Daerah Kabupaten Penajam Paser Utara dengan Bank Kaltimtara.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '22
                                    Juli 2025',
                'isi_agenda' => 'Selasa,
                        22 Juli 2025, Ketua Pengadilan Agama Penajam YM Bapak Fattahurridlo Al Ghainy S.H.I.,M.S.I.
                        Menghadiri Acara Pisah Sambut Dandim 0913 Kabupaten Penajam Paser Utara Dari Letkol Inf Arfan
                        Affandi, S.E. Kepada Letkol Inf Andhika Ganessakti.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '12
                                Juli 2025',
                'isi_agenda' => 'Sabtu,
                        12 Juli 2025, Ketua Pengadilan Agama Penajam Bapak Fattahurridlo Al Ghany S.H.I., M.S.I
                        menghadiri acara Pentas Seni dan Gebyar UMKM serta Pembagian Bendera Merah Putih yang bertempat
                        di Alun-Alun Penyembolum Penajam Paser Utara.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '11
                                Juli 2025',
                'isi_agenda' => 'Jum\'at,
                        11 Juli 2025, Pimpinan Pengadilan Agama Penajam beserta jajaran mengikuti Bimtek Kaum Rentan
                        Berhadapan Dengan Hukum Bagi Tenaga Teknis Di Lingkungan Peradilan Agama Secara Daring Tahun
                        2025 dengan tema "Kebijakan Pemerintah Tentang Pembangunan Hukum Terkait Pelayanan Keadilan bagi
                        Kaum Rentan".',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '9
                                    Juli 2025',
                'isi_agenda' => 'Rabu,
                        9 Juli 2025, telah dilaksanakan Rapat Rutin Pimpinan Pengadilan Agama Penajam.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '8
                                    Juli 2025',
                'isi_agenda' => 'Selasa,
                        8 Juli 2025, Ketua Pengadilan Agama Penajam YM Bapak Fattahurridlo Al Ghany S.H.I., M.S.I
                        Menghadiri Rapat Paripurna terkait penyampaian Nota Penjelasan dan pandangan Umum Fraksi-Fraksi
                        DPRD terhadap Raperda RPJMD 2025-2029 Kabupaten Penajam Paser Utara.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '3
                                Juli 2025',
                'isi_agenda' => 'Kamis,
                        3 Juli 2025 Hakim Pengadilan Agama Penajam YM Ibu Vidya Nurchaliza, S.H. menghadiri Grand Final
                        Duta Wisata Penajam Paser Utara Fest 2025 yang bertempat di Halaman Kantor Bupati Penajam Paser
                        Utara.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '2
                                Juli 2025',
                'isi_agenda' => 'Rabu,
                        2 Juli 2025 Ketua Pengadilan Agama Penajam YM Bapak Fattahurridlo Al Ghany S.H.I., M.S.I
                        menghadiri acara Pembukaan Penajam Paser Utara Fest 2025 yang bertempat di Halaman Kantor Bupati
                        Penajam Paser Utara.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '1
                                Juli 2025',
                'isi_agenda' => 'Selasa,
                        1 Juli 2025, Ketua Pengadilan Agama Penajam Bapak Fattahurridlo Al Ghainy S.H.I.,M.S.I
                        Menghadiri Upacara Hari Bhayangkara Ke-79 yang berlangsung di Lapangan Apel Mapolres
                        PPU.Upacara
                        tersebut juga turut dihadiri oleh jajaran Forkopimda, tokoh masyarakat, dan tamu undangan
                        lainnya.Peringatan
                        Hari Bhayangkara tahun ini mengusung tema “Polri untuk Masyarakat”, yang menegaskan
                        bahwa Polri adalah garda terdepan dalam menjaga keamanan, ketertiban, serta membantu masyarakat
                        dalam berbagai aspek kehidupan.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '24
                            Juni 2025',
                'isi_agenda' => 'Selasa
                        24 Juni 2025, Ketua Pngadilan Agama Penajam YM Bapak Fattahurridlo Al Ghany S.H.I., M.S.I
                        menghadiri Rapat Kordinasi Badan Kesatuan Bangsa dan Politik se-Kalimeantan Timur Tahun 2025
                        yang bertempat di Gedung Graha Pemuda Penajam yang dihadiri oleh Kepala Kesatuan Bangsa dan
                        Politik se-Kalimantan Timur.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '23
                                Juni 2025',
                'isi_agenda' => 'Senin,
                        23 Juni 2025, Pimpinan Pengadilan Agama Penajam menghadiri Pengantar Alih Tugas Dra. H. Muhayah,
                        S.H., M.H. sebagai Wakil Ketua Pengadilan Tinggi Agama Surabaya.Sebagai
                        ungkapan perpisahan, Pimpinan Pengadilan Agama Penajam turut menyerahkan karikatur bergambar
                        dirinya sebagai bentuk kenang-kenangan kepada Ibu Dra. H. Muhayah, S.H., M.H., dan sebagai
                        simbol penghargaan atas kebersamaan serta kontribusi beliau selama ini.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '23
                                Juni 2025',
                'isi_agenda' => 'Senin,
                        23 Juni 2025, Pimpinan Pengadilan Agama Penajam menghadiri acara Pembinaan Pimpinan yang
                        diselenggarakan oleh Pengadilan Tinggi Agama Samarinda bertempat di Aula PTA Samarinda. Acara
                        ini juga dihadiri oleh para Ketua, Wakil Ketua, Sekretaris, dan Panitera dari Pengadilan Agama
                        lainnya yang berada di wilayah hukum PTA Samarinda.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '23
                                Juni 2025',
                'isi_agenda' => 'Senin,
                        23 Juni 2025, Para Pimpinan Pengadilan Agama Penajam menghadiri Pelantikan dan Pengambilan
                        Sumpah Jabatan Wakil Ketua Pengadilan Tinggi Agama Samarinda Bapak Drs. H. Rd. Mahbub Tobti,
                        M.H. dan Ketua Pengadilan Agama Grogot Bapak Fitriah Aziz, S.H. yang dilaksanakan di Aula
                        Pengadilan Tinggi Agama Samarinda',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '20
                                Juni 2025',
                'isi_agenda' => 'Jumat,
                        20 Juni 2025, Pimpinan beserta jajaran melaksanakan Bimbingan Teknis Peningkatan Kompetensi
                        Tenaga Teknisi Di Lingkungan Peradilan Agama dengan tema “Etika dan Perilaku Layanan
                        terhadap Kaum Rentan” secara daring di Ruang Media Center Pengadilan Agama Penajam.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '03
                            Juni 2025',
                'isi_agenda' => 'Selasa
                        03 Juni 2025, Pimpinan Pengadilan Agama Penajam YM Bapak Fattahurridlo Al Ghany S.H.I., M.S.I
                        beserta jajaran mengikuti Penandatangan Nota Kesepahaman Dan Perjanjian Kerja Sama Secara
                        Daring.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '2
                                Juni 2025',
                'isi_agenda' => 'Senin,
                        2 Juni 2025, Ketua Pengadilan Agama Penajam YM Fattahurridlo Al Ghainy S.H.I.,M.S.I Menghadiri
                        Upacara Memperingati Hari Lahir Pancasila yang diselenggarakan oleh Pemerintah Kabupaten Penajam
                        Paser Utara di Halaman Kantor Bupati Penajam Paser Utara (PPU).',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '19
                                Mei 2025',
                'isi_agenda' => 'Senin,
                        19 Mei 2025, telah dilaksanakan Rapat Rutin Pimpinan Pengadilan Agama Penajam.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '5
                                mei 2025',
                'isi_agenda' => 'Senin,
                        5 mei 2025, Ketua Pengadilan Agama Penajam Bapak Fattahurridlo Al Ghainy S.H.I.,M.S.I mengikuti
                        Sosialisasi Perjanjian Kerjasama Isbat Wakaf Terpadu dan Pendaftaran Tanah Wakaf Lintas Sektor
                        secara daring melalui zoom di ruang media center Pengadilan Agama Penajam.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '5
                                mei 2025',
                'isi_agenda' => 'Senin,
                        5 mei 2025, telah dilaksanakan Rapat Rutin Pimpinan Pengadilan Agama Penajam.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '2
                                Mei 2025',
                'isi_agenda' => 'Ketua
                        Pengadilan Agama Penajam YM Bapak Fattahurridlo Al Ghainy S.H.I.,M.S.I Menghadiri Upacara
                        Peringatan Hari Pendidikan Nasional Tahun 2025 dengan tema “Partisipasi Semesta Wujudkan
                        Pendidikan Bermutu Untuk Semua”. Diselenggarakan di Lapangan Upacara Kantor Bupati Penajam
                        Paser Utara, Upacara ini dihadiri oleh pelajar, guru, tokoh masyarakat, serta jajaran
                        Forkopimda.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '30
                                April 2025',
                'isi_agenda' => 'Ketua
                        Pengadilan Agama Penajam YM Bapak Fattahurridlo Al Ghany S.H.I., M.S.I menghadiri Pembukaan
                        Teknologi Tepat Guna (TTG) XI Tingkat Provinsi Kalimantan Timur dan Pameran Pembangunan HUT Ke
                        23 PPU Tahun 2025 yang bertempat di Lapangan Luar Stadion Panglima Sentik.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '29
                                April 2025',
                'isi_agenda' => 'Pimpinan
                        Pengadilan Agama beserta jajaran menghadiri acara Peelepasan dan Pengantar Purnabakti Ketua
                        Pengadilan Tinggi Agama Samarinda, Bapak H. Helminizami, S.H., M.H. Semoga kesuksesan dan
                        kebahagiaan senantiasa menyertai.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '28
                                April 2025',
                'isi_agenda' => 'Pengadilan
                        Agama Penajam Menghadiri Wisuda Purnabakti Ketua Pengadilan Tinggi Agama Samarinda YM Bapak H.
                        Helminizami, S.H., M.H.Acara
                        digelar dengan khidmat dan penuh penghormatan di PTA Samarinda, dihadiri oleh para pimpinan dan
                        perwakilan dari peradilan agama se-Kalimantan Timur.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '27
                                April 2025',
                'isi_agenda' => 'Ketua
                        Pengadilan Agama Penajam YM Bapak Fattahurridlo Al Ghany S.H.I., M.S.I Menghadiri Pembinaan
                        Tuaka Agama dan Hakim Agung oleh Ketua Kamar Agama Mahkamah Agung RI, YM Bapak Dr. H. Yasardin,
                        S.H., M.Hum yang bertempat di Pengadilan Tinggi Agama Samarinda.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '26
                                April 2025',
                'isi_agenda' => 'Pimpinan
                        beserta jajaran melaksanakan Bimbingan Teknis Peningkatan Kompetensi Tenaga Teknisi Di
                        Lingkungan Peradilan Agama dengan tema “Perlindungan Hak Asasi Manusia Dalam Penyelesaian
                        Hukum Keluarga” secara daring.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '24
                                April 2025',
                'isi_agenda' => 'Ketua
                        Pengadilan Agama Penajam YM Bapak Fattahurridlo Al Ghany S.H.I., M.S.I Menghadiri Acara
                        Penyerahaan Kartu Penerima Bantuan Jaminan Sosial Ketenagakerjaan bagi 15.000 Pekerja Rentan di
                        Kabupaten Penajam Paser Utara.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '24
                                April 2025',
                'isi_agenda' => 'Telah
                        dilaksanakan Rapat Koordinasi Finalisasi Persiapan Kedatangan Rombongan KMA ke Kalimantan Timur
                        yang diikuti oleh Pimpinan Pengadilan Agama Penajam.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '23
                                April 2025',
                'isi_agenda' => 'Telah
                        dilaksanakan Rapat Rutin Pimpinan Pengadilan Agama Penajam.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '23
                                April 2025',
                'isi_agenda' => 'Pimpinan
                        dan Hakim Pengadilan Agama Penajam menghadiri Puncak Peringatan Hari Ulang Tahun Ikatan Hakim
                        Indonesia yang ke 72 dengan Tema “Hakim Berintegritas Peradilan Berkualitas” via
                        Zoom Meeting.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '21
                                April 2025',
                'isi_agenda' => 'Ketua
                        Pengadilan Agama Penajam Bapak Fattahurridlo Al Ghainy S.H.I.,M.S.I beserta Hakim Pengadilan
                        Agama Penajam mengikuti Seminar Internasional dalam Rangka HUT ke-72 IKAHI dengan tema
                        “Penegakan Hukum Terhadap Contempt of Court dalam Mewujudkan Peradilan Berkualitas”
                        secara daring melalui zoom di ruang media center Pengadilan Agama Penajam',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '17
                                April 2025',
                'isi_agenda' => 'Pengadilan
                        Agama Penajam menerima Kunjungan dari Protokoler Mahkamah Agung dan Pengadilan Tinggi Agama
                        Samarinda.Kedatangan
                        tim disambut langsung oleh Ketua Pengadilan Agama Penajam, Bapak Fattahurridlo Al Ghainy
                        S.H.I.,M.S.I, beserta jajaran pimpinan dan aparatur Pengadilan Agama Penajam. Dalam kesempatan
                        tersebut, dilakukan peninjauan terhadap sarana dan prasarana pengadilan, tata kelola ruang
                        kerja, dan standar pelayanan publik.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '15
                                April 2025',
                'isi_agenda' => 'Ketua
                        Pengadilan Agama Penajam YM Bapak Fattahureidlo Al Ghany, S.H.I., M.S.I beserta jajaran
                        melakukan sidak 5S dan 5rin guna meningkatkam efisiensi, efektivitas, dan produktivitas kerja,
                        serta meningkatkan kualitas pelayanan kepada masyarakat.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '9
                                April 2025',
                'isi_agenda' => 'Wakil
                        Ketua Pengadilan Agama Penajam YM Ibu Nahdiyanti, S.H.I., M.H Menghadiri Penandatanganan
                        Kesepakatan Bersama antara Pemerintah Penajam Paser Utara dengan PT ITCI KARTIKA UTAMA dan PT
                        ARSARI TIRTA PRADANA.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '27
                                Maret 2025',
                'isi_agenda' => 'Pembinaan
                        dan Pengarahan pimpinan bagi PPNPN Hibah Pengadilan Agama Penajam sebelum libur lebaran.
                        Kegiatan ini dipimpin oleh Wakil Ketua PA Penajam YM. Ibu Nahdiyanti S.H.I., M.H. sebagai bentuk
                        evaluasi sekaligus penguatan komitmen kerja bagi seluruh PPNPN.Dalam
                        arahannya, YM. Ibu Nahdiyanti S.H.I., M.H. menekankan pentingnya disiplin, tanggung jawab, dan
                        profesionalisme dalam menjalankan setiap tugas dan kegiatan di lingkungan peradilan. Ditekankan
                        pula bahwa setiap pegawai memiliki peran penting dalam mendukung kelancaran pelayanan di
                        Pengadilan Agama Penajam. Oleh karena itu, komitmen dan semangat kerja yang tinggi harus
                        senantiasa dijaga, baik sebelum maupun setelah libur Lebaran.Dengan
                        adanya pembinaan ini, diharapkan seluruh PPNPN semakin memahami tugas serta perannya serta terus
                        meningkatkan kualitas kerja demi terwujudnya pelayanan yang profesional, transparan, dan
                        berintegritas.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '20
                                Maret 2025',
                'isi_agenda' => 'Ketua
                        Pengadilan Agama Penajam Bapak Fattahurridlo Al Ghainy S.H.I.,M.S.I menghadiri Acara Buka Puasa
                        Bersama & Bakti Sosial yang diselenggarakan oleh POLRES PPU.Acara
                        ini juga dihadiri oleh Pimpinan Forkopimda Kabupaten PPU, tokoh masyarakat, dan juga undangan
                        lainnya. Tidak hanya sebagai ajang silaturahmi melainkan juga menjadi momen untuk berbagi kepada
                        sesama, yaitu dengan menyerahkan bantuan sosial kepada masyarakat yang kurang mampu.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '16
                                    Maret 2025',
                'isi_agenda' => 'Ketua
                            Pengadilan Agama Penajam, YM Bapak Fattahurridlo Al Ghany, S.H.I., M.S.I menghadiri
                            Penutupan Ramadhan Fest.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '14
                                Maret 2025',
                'isi_agenda' => 'Pimpinan
                        dan Aparatur Pengadilan Agama Penajam mengikuti Pembinaan dan Pengawasan dengan Fokus
                        Optimalisasi Pembangunan Zona Integritas oleh PTA Samarinda via daring di ruang Media Center
                        Pengadilan Agama Penajam.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '14
                                Maret 2025',
                'isi_agenda' => 'Ketua
                        Pengadilan Agama Penajam, YM Bapak Fattahurridlo Al Ghany, S.H.I., M.S.I menghadiri Pembukann
                        Penajam Fest dan Buka Puasa Bersama.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '13
                                Maret 2025',
                'isi_agenda' => 'Telah
                        dilaksanakan Diklat Di Tempat Kerja (DDTK) Service Excellent Petugas Layanan bersama BSI KCP
                        Penajam. Tujuan diadakannya kegiatan ini yaitu guna memberikan pelayanan yang lebih maksimal
                        lagi kepada masyarakat.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '7
                                Maret 2025',
                'isi_agenda' => 'Telah
                        dilaksanakan Rapat Pengelola Keuangan bersama Pimpinan.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '5
                                Maret 2025',
                'isi_agenda' => 'Ketua
                        Pengadilan Agama Penajam YM Bapak Fattahurridlo Al-Ghany, S.H.I.,M.S.I menghadiri Rapat
                        Paripurna DPRD dalam rangka Pidato Sambutan Bupati Penajam Paser Utara masa jabatan Tahun
                        2025-2030.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '5
                                maret 2025',
                'isi_agenda' => 'Para
                        Pimpinan Pengadilan Agama Penajam mengikuti pencanangan sistem manajemen anti penyuapan (SMAP)
                        secara daring melalui zoom di ruang media center Pengadilan Agama Penajam',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '4
                                maret 2025',
                'isi_agenda' => 'Ketua
                        Pengadilan Agama Penajam Bapak Fattahurridlo Al Ghainy S.H.I.,M.S.I menghadiri Safari Ramadhan
                        PPU 1446 H, yang diselenggarakan di Halaman Rumah Jabatan (RuJab) Bupati Penajam Paser Utara
                        (PPU).Safari
                        Ramadhan merupakan Kegiatan tahunan Kabupaten PPU yang bertujuan untuk mempererat silaturahmi
                        antara pemerintah daerah, instansi terkait, dan masyarakat. Tidak hanya mempererat hubungan
                        antar instansi, tetapi juga menjadi wadah untuk saling berbagi inspirasi dan memperkuat
                        nilai-nilai kebersamaan di tengah masyarakat.Dengan
                        semangat Ramadhan, diharapkan kegiatan ini semakin memperkokoh komitmen bersama dalam membangun
                        Kabupaten PPU yang lebih sejahtera, berintegritas, dan penuh keberkahan di bulan yang suci
                        ini.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '24
                                Februari 2025',
                'isi_agenda' => 'Pimpinan
                        Pengadilan Agama Penajam menghadiri Rapat Koordinasi Daerah Pengadilan Tinggi Agama Samarinda
                        dan Pengadilan Agama Se-Wilayah Kalimantan Timur yang bertempat di Aula PTA Samarinda.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '23
                            Februari 2025',
                'isi_agenda' => 'Ketua
                        Pengadilan Agama Penajam, YM Bapak Fattahuridlo Al Ghani, S.H.I., M.S.I menghadiri peringatan
                        Hari Peduli Sampah Nasional Tahun 2025 yang bertema "Kolaborasi untuk Indonesia
                        Bersih".Kegiatan
                        ini bertujuan untuk meningkatkan kesadaran masyarakat tentang pentingnya menjaga kebersihan
                        lingkungan dan mengelola sampah dengan benar sehingga dapat menciptakan lingkungan yang bersih
                        dan sehat.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '19 Februari
                            2025',
                'isi_agenda' => 'Pada pukul 09.20 WIB di Bairung Gedung Tower Mahkamah Agung Republik
                        Indonesia, Ketua Pengadilan Agama Penajam, Fattahurridlo al Ghany, S.H.I., M.S.I. menghadiri
                        secara langsung acara Laporan Tahunan (Laptah) Mahkamah Agung (MA) Republik Indonesia (RI) Tahun
                        2024. Sidang Istimewa Laporan Tahunan Mahkamah Agung Tahun 2024 ini dipimpin langsung oleh Ketua
                        Mahkamah Agung Republik Indonesia, YM Bapak Prof. Dr. H. Sunarto, S.H., M.H. Laporan Tahunan
                        Mahkamah Agung ini dihadiri oleh Para Hakim Agung, Para Ketua Pengadilan Tingkat Banding dan
                        Para Ketua Pengadilan Tingkat Pertama. Acara ini juga dihadiri langsung oleh Presiden Republik
                        Indonesia, Bapak Prabowo Subianto dan undangan lainnya, di antaranya yaitu delegasi Mahkamah
                        Agung Negara Sahabat serta Duta Besar Negara Sahabat. Dengan mengusung tema "Dengan Integritas,
                        Peradilan Berkualitas," Laptah 2024 menegaskan bahwa kualitas peradilan hanya dapat dicapai
                        apabila integritas menjadi pondasi utama dalam setiap proses hukum. Dalam pidatonya, Ketua
                        Mahkamah Agung, Prof. Sunarto, menegaskan pentingnya peran individu dalam mewujudkan sistem
                        peradilan yang bersih dan adil. "Pribadi berintegritas menciptakan peradilan berkualitas, dan
                        peradilan berkualitas menciptakan keadilan," ujar Prof. Sunarto.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '31 Januari 2025',
                'isi_agenda' => 'Ketua Pengadilan Agama Penajam, Bapak Fattahurridlo Al Ghany, S.H.I.,
                        M.S.I Menghadiri Acara Silaturahim dan Sarasehan Antara PJ Bupati dengan Bupati Penajam Paser
                        Utara Terpilih. Pada acara tersebut Bapak Ketua Pengadilan Agama Penajam juga melakukan
                        penanaman pohon bersama para tamu undangan lainnya sebagai bentuk membangun komunitas dan
                        meningkatkan rasa kebersamaan.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '24 Januari 2025',
                'isi_agenda' => 'Public Campaign kali ini dilakukan dengan cara mensosialisasikan ke
                        masyarakat desa Argo Mulyo dan dilanjutkan ke Ibu Kota Nusantara. Masih dengan tujuan yang sama
                        yaitu mensosialisasikan dan mewujudkan komitmen kuat dari Pengadilan Agama Penajam dalam
                        melakukan pembangunan Zona Integritas Menuju Wilayah Bebas Korupsi (WBK) dan Wilayah Birokrasi
                        Bersih Melayani (WBBM).',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '23 Januari 2025',
                'isi_agenda' => 'Telah dilakukan Penandatanganan Perjanjian Kerjasama Pengadilan Agama
                        Penajam dan SLB Negeri Penajam Paser Utara Kerjasama bidang penyedia pelayanan bagi penyandang
                        disabilitas bertujuan untuk meningkatkan aksesibilitas dan pelayanan yang inklusif bagi
                        penyandang disabilitas. Kerjasama ini mencakup penyediaan fasilitas yang ramah disabilitas,
                        serta pendampingan khusus dalam proses layanan hukum. Dengan adanya kerjasama ini, diharapkan
                        penyandang disabilitas dapat memperoleh kemudahan dalam mengakses pelayanan, serta merasa lebih
                        dihargai dan dilibatkan dalam proses hukum yang berlangsung.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '22 Januari 2025',
                'isi_agenda' => 'Rapat Zona Integritas dipimpin oleh Ketua Bapak Fattahurridlo Al
                            Ghainy S.H.I.,M.S.I dan diikuti oleh seluruh Aparatur Pengadilan Agama Penajam. Rapat kali
                            ini memberikan penjelasan mengenai Zona Integritas serta membahas langkah-langkah strategis
                            untuk memperkuat komitmen bersama dalam pembangunan Zona Integritas menuju Wilayah Bebas
                            Korupsi (WBK).Dalam rapat ini juga mengevaluasi
                            pelaksanaan sebelumnya serta apa kendala yang terjadi. Sehingga kedepannya ini dapat
                            berjalan maksimal.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '21 Januari 2025',
                'isi_agenda' => 'Dalam rangka mewujudkan program Mahkamah Agung RI yaitu pembangunan
                            Zona Integritas menuju Wilayah Bebas Korupsi (WBK) dan Wilayah Birokrasi Bersih Melayani
                            (WBBM), Pengadilan Agama Penajam pada tanggal 21 Januari 2025, menggelar kegiatan Public
                            Campaign dengan cara pembagian stiker kepada masyarakat.Kegiatan ini bertujuan mensosialisasikan dan menunjukkan komitmen
                            kuat dari Pengadilan Agama Penajam dalam melakukan pembangunan Zona Integritas menuju
                            Wilayah Bebas Korupsi (WBK) serta mengajak seluruh Masyarakat untuk ikut mengawali dan
                            mengawasi pembangunan Zona Integritas pada Pengadilan Agama Penajam. Pada kegiatan tersebut
                            Pimpinan dan Aparatur Pengadilan Agama Penajam ikut serta dalam pembagian Stiker kampanye
                            Zona Integritas pada masyarakat.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '13 Januari 2025',
                'isi_agenda' => 'Pimpinan
                        Pengadilan Agama Penajam YM Bapak Fattahurridlo Al-Ghany S.H.I.,M.S.I Beserta Jajarannya
                        Melakukan Diklat Di Tempat Kerja Secara Langsung Petugas Pelayanan Terpadu Satu Pintu (PTSP)
                        Guna Memgevaluasi Kualitas Layanan Yang Telah Diberikan Kepada Masyarakat.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '7 Januari 2025',
                'isi_agenda' => 'Telah
                        dilaksanakan Rapat Kerja Tahun 2025 Pengadilan Agama Penajam dengan tema "Integritas Kuat, SDM
                        Hebat, Wujudkan Peradilan Yang Modern" yang dipimpin oleh Ketua Pengadilan Agama Penajam YM.
                        Bapak Fattahurridlo Al Ghany S.H.I, M.S.I dan diikuti oleh seluruh aparatur Pengadilan Agama
                        Penajam.Kami
                        bersama-sama merancang langkah strategis untuk meningkatkan kualitas pelayanan dan mewujudkan
                        sistem peradilan yang adaptif di era modern. Penguatan integritas dan kompetensi SDM menjadi
                        kunci utama dalammenciptakankeadilan yang transparan dan terpercaya. Bersama, kita bergerak menuju perubahan yang lebih
                        baik!',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '3 Januari 2025',
                'isi_agenda' => 'Ketua
                        Pengadilan Agama Penajam YM.FATTAHURRIDLO AL GHANY,S.H.I.,M.S.I. Menghadiri :Upacara
                        Hari Amal Bakti Kementerian Agama RI ke-79 di Lingkungan Kantor Kementerian Agama Kabupaten
                        Penajam Paser Utara.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '2 Januari 2025',
                'isi_agenda' => 'Aparatur
                            Pengadilan Agama Penajam Melaksanakan :Penandatangan
                            Komitemen Bersama yang di Mulai dari Ketua Pengadilan Agama Penajam YM.Fattahurridlo Al
                            Ghany,S.H.I.,M.S.I dan Wakil Ketua Pengadilan Agama Penajam YM.Nahdiyanti,S.H.I.,M.H dan di
                            lanjut oleh pegawai lainnya.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'tanggal_agenda' => '2 Januari 2025',
                'isi_agenda' => 'Telah
                        Melaksanakan:Pembacaan
                        dan Penandatangan Pakta Integritas di Pengadilan Agama Penajam.',
                'created_at' => date('Y-m-d H:i:s')
            ],
        ];

        $now = Carbon::now()->toDateTimeString();
        $inserted = 0;
        $updated = 0;
        $skipped = 0;

        foreach ($data as $row) {
            $tanggal = $this->parseTanggalAgenda($row['tanggal_agenda'] ?? null);
            $isi = $this->normalizeWhitespace($row['isi_agenda'] ?? null);

            if (!$tanggal) {
                $skipped++;
                $this->command?->warn('Skipped invalid tanggal_agenda: ' . $this->normalizeWhitespace($row['tanggal_agenda'] ?? ''));
                continue;
            }

            if ($isi === '') {
                $skipped++;
                $this->command?->warn('Skipped empty isi_agenda for tanggal_agenda: ' . $tanggal);
                continue;
            }

            $query = DB::table('agenda_pimpinan')
                ->where('tanggal_agenda', $tanggal)
                ->where('isi_agenda', $isi);

            if ($query->exists()) {
                $query->update(['updated_at' => $now]);
                $updated++;
                continue;
            }

            DB::table('agenda_pimpinan')->insert([
                'tanggal_agenda' => $tanggal,
                'isi_agenda' => $isi,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            $inserted++;
        }

        $this->command?->info("AgendaSeeder: inserted {$inserted}, updated {$updated}, skipped {$skipped}.");
    }
}
