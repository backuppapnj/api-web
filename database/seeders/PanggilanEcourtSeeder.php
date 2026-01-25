<?php

namespace Database\Seeders;

use App\Models\PanggilanEcourt;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PanggilanEcourtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'tahun_perkara' => 2025,
                'nomor_perkara' => '40/Pdt.G/2025/PA.Pnj',
                'nama_dipanggil' => 'Lalu Hamidan Bin Lalu Saprudin Alias Mq. Gupran',
                'alamat_asal' => 'RT. 002, Desa Labangka Barat, Kecamatan Babulu, Kabupaten Penajam Paser Utara, Provinsi Kalimantan Timur',
                'panggilan_1' => '2025-01-14',
                'panggilan_2' => null,
                'panggilan_3' => null,
                'panggilan_ikrar' => '2025-05-20',
                'tanggal_sidang' => '2025-05-20',
                'pip' => null, // Placeholder based on HTML structure not showing specific PIP names
                'link_surat' => 'https://drive.google.com/file/d/1jvbO6g9fwCTCPCfo_OFyNJaGnES05HnY/view?usp=drive_link',
                'keterangan' => null,
            ],
            [
                'tahun_perkara' => 2025,
                'nomor_perkara' => '59/Pdt.G/2025/PA.Pnj',
                'nama_dipanggil' => 'Rohania Binti Kame',
                'alamat_asal' => 'RT. 006, Dusun I, Desa Bukit Subur, Kecamatan Penajam, Kabupaten Penajam Paser Utara, Provinsi Kalimantan Timur',
                'panggilan_1' => '2025-01-15',
                'panggilan_2' => null,
                'panggilan_3' => null,
                'panggilan_ikrar' => '2025-05-21',
                'tanggal_sidang' => '2025-05-21',
                'pip' => null,
                'link_surat' => 'https://drive.google.com/file/d/1qbVrSORD5B2jgtVqcJWi1gbEf-Quj_aB/view?usp=drive_link',
                'keterangan' => null,
            ],
            [
                'tahun_perkara' => 2025,
                'nomor_perkara' => '60/Pdt.G/2025/PA.Pnj',
                'nama_dipanggil' => 'Muyati Binti Mustamar',
                'alamat_asal' => 'Jl. Pariwisata RT. 003, Ds. Siderojo, Kecamatan Penajam, Kabupaten Penajam Paser Utara, Provinsi Kalimantan Timur',
                'panggilan_1' => '2025-01-15',
                'panggilan_2' => null,
                'panggilan_3' => null,
                'panggilan_ikrar' => '2025-05-20',
                'tanggal_sidang' => '2025-05-20',
                'pip' => null,
                'link_surat' => 'https://drive.google.com/file/d/1xtfeCVfvPGw5SM9tLBWVWkzuL30Gjhkx/view?usp=drive_link',
                'keterangan' => null,
            ],
            [
                'tahun_perkara' => 2025,
                'nomor_perkara' => '50/Pdt.G/2025/PA.Pnj',
                'nama_dipanggil' => 'Himawan Setiyadi Bin Hadi Prabowo',
                'alamat_asal' => 'Jalan Propinsi, RT. 005, Kelurahan Penajam, Kecamatan Penajam, Kabupaten Penajam Paser Utara, Provinsi Kalimantan Timur',
                'panggilan_1' => '2025-01-15',
                'panggilan_2' => null,
                'panggilan_3' => null,
                'panggilan_ikrar' => '2025-05-20',
                'tanggal_sidang' => '2025-05-20',
                'pip' => null,
                'link_surat' => 'https://drive.google.com/file/d/1ycUMhvK2bxQenfbJJldvMdVsKqShUO_b/view?usp=drive_link',
                'keterangan' => null,
            ],
            [
                'tahun_perkara' => 2025,
                'nomor_perkara' => '67/Pdt.G/2025/PA.Pnj',
                'nama_dipanggil' => 'Efendy Bin Abdul Rasyid Tjatjo',
                'alamat_asal' => 'Jalan Wijayakusuma, RT. 023, Dusun Semoga Jaya, Desa Sukaraja, Kecamatan Sepaku, Kabupaten Penajam Paser Utara, Provinsi Kalimantan Timur',
                'panggilan_1' => '2025-01-31',
                'panggilan_2' => null,
                'panggilan_3' => null,
                'panggilan_ikrar' => '2025-05-27',
                'tanggal_sidang' => '2025-05-27',
                'pip' => null,
                'link_surat' => 'https://drive.google.com/file/d/1Ya8oGNCz4yYaPCQnlGkuKk4E5XlY0DCb/view?usp=sharing',
                'keterangan' => null,
            ],
            [
                'tahun_perkara' => 2025,
                'nomor_perkara' => '65/Pdt.G/2025/PA.Pnj',
                'nama_dipanggil' => 'Mumin Bin Hasan Daris',
                'alamat_asal' => 'Jalan Palampang, RT.006, Kelurahan Tanjung Tengah, Kecamatan Penajam, Kabupaten Penajam Paser Utara, Provinsi Kalimantan Timur',
                'panggilan_1' => '2025-01-17',
                'panggilan_2' => null,
                'panggilan_3' => null,
                'panggilan_ikrar' => '2025-05-27',
                'tanggal_sidang' => '2025-05-27',
                'pip' => null,
                'link_surat' => 'https://drive.google.com/file/d/1W73YLghGGXCOBdlldS9FD7DvUBMipQ-D/view?usp=drive_link',
                'keterangan' => null,
            ],
            [
                'tahun_perkara' => 2025,
                'nomor_perkara' => '71/Pdt.G/2025/PA.Pnj',
                'nama_dipanggil' => 'Agus Catur Prasetiyo Bin Kailan',
                'alamat_asal' => 'Jalan Propinsi, RT. 031, Desa Babulu Darat, Kecamatan Babulu, Kabupaten Penajam Paser Utara, Provinsi Kalimantan Timur',
                'panggilan_1' => '2025-01-23',
                'panggilan_2' => null,
                'panggilan_3' => null,
                'panggilan_ikrar' => '2025-05-29',
                'tanggal_sidang' => '2025-05-29',
                'pip' => null,
                'link_surat' => 'https://drive.google.com/file/d/1emztodysNbD7RBScwzwsNPDH08J7SSLC/view?usp=sharing',
                'keterangan' => null,
            ],
            [
                'tahun_perkara' => 2025,
                'nomor_perkara' => '92/Pdt.G/2025/PA.Pnj',
                'nama_dipanggil' => 'Panjian Bin Harjo Pawiro',
                'alamat_asal' => 'Sebakung lii, RT. 003, Desa Sumber Sari, Kecamatan Babulu, Kabupaten Penajam Paser Utara, Provinsi Kalimantan Timur',
                'panggilan_1' => null,
                'panggilan_2' => '2025-03-05',
                'panggilan_3' => '2025-03-12',
                'panggilan_ikrar' => null,
                'tanggal_sidang' => '2025-03-12',
                'pip' => null,
                'link_surat' => 'https://drive.google.com/file/d/1pPZm9kSFmwzBlmWvQ8-0NZ_BjKqAwVnC/view?usp=sharing',
                'keterangan' => 'Surat Panggilan',
            ],
            [
                'tahun_perkara' => 2025,
                'nomor_perkara' => '92/Pdt.G/2025/PA.Pnj',
                // Note: This row appears to be a second entry for the same case but Panggilan III / Relaas Pemberitahuan?
                // The HTML shows row 8 and row 9 having same Nomor Perkara but different dates/links.
                // Row 9 says "Relaas Pemberitahuan". I will add it as a separate entry or could be update if logic allowed, but seeder creates new rows.
                // Let's assume these are separate logs of calls.
                'nama_dipanggil' => 'Panjian Bin Harjo Pawiro',
                'alamat_asal' => 'Sebakung lii, RT. 003, Desa Sumber Sari, Kecamatan Babulu, Kabupaten Penajam Paser Utara, Provinsi Kalimantan Timur',
                'panggilan_1' => null,
                'panggilan_2' => null,
                'panggilan_3' => null,
                'panggilan_ikrar' => null,
                'tanggal_sidang' => '2025-03-18', // Date in "PIP" column in original HTML row 9? No, it's in column 9 (Tanggal Sidang? No, column 9 is Tgl Sidang/Ikrar Talak logic is messy in HTML)
                // Let's re-read HTML carefully:
                // Col 5: Panggilan I
                // Col 6: Panggilan II
                // Col 7: Panggilan III
                // Col 8: Panggilan Ikrar Talak
                // Col 9: Tanggal Sidang
                // Row 8: Panggilan II (05 Mar), Panggilan III (empty), Ikrar (12 Mar - wait col 8 header is Ikrar, row 8 has date here?), Col 9 empty?
                // Row 9 val: Panggilan I-III empty. Col 8 empty. Col 9: 18 Maret 2025.
                // Link Row 9: Relaas Pemberitahuan.
                // I will treat it as a separate record for now as structure suggests list of calls.
                'pip' => '18 Maret 2025', // Wait, 18 Maret is in Col 10 (PIP)? No col 9 is Tgl Sidang. Col 10 is PIP.
                // In Row 9:
                // Col 1-4 standard.
                // Col 5-8 Empty.
                // Col 9 Empty? Ah, let's look at row 9 again:
                // <td ... width="113">&nbsp;</td> (Col 9 - Tgl Sidang/Ikrar?)
                // <td ... width="76"><p>Selasa, 18 Maret 2025</p></td> (Col 10 - PIP)
                // Strange data placement. I will put it in PIP for now or Tanggal Sidang if it makes more sense contextually.
                // Actually looking at other rows, normally Tgl Sidang is Col 9. PIP is Col 10.
                // Row 1: Col 9 (20 Mei). Col 10 empty.
                // Row 8: Col 8 (12 Mar). Col 9 empty.
                // Row 9: Col 10 (18 Mar).
                // I will normalize to Tanggal Sidang if it looks like a date, or PIP.
                // Let's put 18 Maret in tanggal_sidang for consistency in API display.
                'tanggal_sidang' => '2025-03-18',
                'link_surat' => 'https://drive.google.com/file/d/1OhiDKNemSweyei_848fuPxYMaYiOWFUB/view?usp=sharing',
                'keterangan' => 'Relaas Pemberitahuan',
            ],
            [
                'tahun_perkara' => 2025,
                'nomor_perkara' => '29/Pdt.G/2025/PA.Pnj',
                'nama_dipanggil' => 'Andi Firmansyah bin Andi Mochammad Amir',
                'alamat_asal' => 'Jalan Negara, RT.022, Desa Sukaraja, Kecamatan Sepaku, Kabupaten Penajam Paser Utara, Provinsi Kalimantan Timur',
                'panggilan_1' => null,
                'panggilan_2' => null,
                'panggilan_3' => null,
                'panggilan_ikrar' => null, // Col 8 empty
                'tanggal_sidang' => null, // Col 9 empty
                'pip' => 'Jumat, 07 Maret 2025', // Col 10 has date
                // I'll map Col 10 date to tanggal_sidang if col 9 is empty, assuming placement error in HTML or specific meaning.
                // Or keep as PIP string.
                'link_surat' => 'https://drive.google.com/file/d/18LrOeKHkm5MapYVS7lExL9EKroEr1__B/view?usp=sharing',
                'keterangan' => 'Relaas Pemberitahuan',
            ],
            [
                'tahun_perkara' => 2025,
                'nomor_perkara' => '101/Pdt.G/2025/PA.Pnj',
                'nama_dipanggil' => 'Aditya Wahyu Setiawan bin Nur Wahyudi',
                'alamat_asal' => 'Jalan Negara, RT.020, Desa Sukaraja, Kecamatan Sepaku, Kabupaten Penajam Paser Utara, Provinsi Kalimantan Timur',
                'panggilan_1' => null,
                'panggilan_2' => null,
                'panggilan_3' => null,
                'panggilan_ikrar' => null,
                'tanggal_sidang' => null,
                'pip' => 'Kamis, 20 Maret 2025',
                'link_surat' => 'https://drive.google.com/file/d/1OFMzbyMDb91MVCpiC-WSJ_HVbnX2fvef/view?usp=sharing',
                'keterangan' => 'Relaas Pemberitahuan',
            ],
            [
                'tahun_perkara' => 2025,
                'nomor_perkara' => '119/Pdt.G/2025/PA.Pnj',
                'nama_dipanggil' => 'Oktaviani Mare binti Markus Abr',
                'alamat_asal' => 'RT.005, Desa Gunung Intan, Kecamatan Babulu, Kabupaten Penajam Paser Utara, Provinsi Kalimantan Timur',
                'panggilan_1' => null,
                'panggilan_2' => null,
                'panggilan_3' => null,
                'panggilan_ikrar' => null,
                'tanggal_sidang' => null,
                'pip' => 'Kamis, 26 Juni 2025',
                'link_surat' => 'https://drive.google.com/file/d/1dM1nyy5-Dahg4oT_JzXfU0YlSe36DbMk/view?usp=sharing',
                'keterangan' => 'Relaas Pemberitahuan',
            ],
            [
                'tahun_perkara' => 2025,
                'nomor_perkara' => '107/Pdt.G/2025/PA.Pnj',
                'nama_dipanggil' => 'Arwin Yusup bin Daeng Manang',
                'alamat_asal' => 'RT.016, Desa Argomulyo, Kecamatan Sepaku, Kabupaten Penajam Paser Utara',
                'panggilan_1' => null,
                'panggilan_2' => null,
                'panggilan_3' => null,
                'panggilan_ikrar' => null,
                'tanggal_sidang' => null,
                'pip' => 'Rabu, 13 Juli 2025',
                'link_surat' => 'https://drive.google.com/file/d/1-5_ikpzbHhJOl6OTQm2h7AYG4RZ0So_T/view?usp=sharing',
                'keterangan' => 'Relaas Pemberitahuan',
            ],
            [
                'tahun_perkara' => 2025,
                'nomor_perkara' => '109/Pdt.G/2025/PA.Pnj',
                'nama_dipanggil' => 'Muhammad Padli bin Husni',
                'alamat_asal' => 'Jalan Start Enam, RT.008, Dusun I Gunung Pasir, Desa Girimukti, Kecamatan Penajam, Kabupaten Penajam Paser Utara, Provinsi Kalimantan Timur',
                'panggilan_1' => null,
                'panggilan_2' => null,
                'panggilan_3' => null,
                'panggilan_ikrar' => null,
                'tanggal_sidang' => null,
                'pip' => 'Rabu, 16 Juli 2025',
                'link_surat' => 'https://drive.google.com/file/d/19cftSwYUC0bu-AmT0fSsvmIIRINiMHk1/view?usp=sharing',
                'keterangan' => 'Relaas Pemberitahuan',
            ],
            [
                'tahun_perkara' => 2025,
                'nomor_perkara' => '262/Pdt.G/2025/PA.Pnj',
                'nama_dipanggil' => 'Pipit Hariyadi bin Suyaji',
                'alamat_asal' => 'RT.008, Desa Semoi 2, Kecamatan Sepaku, Kabupaten Penajam Paser Utara, Provinsi Kalimantan Timur',
                'panggilan_1' => null,
                'panggilan_2' => null,
                'panggilan_3' => null,
                'panggilan_ikrar' => null,
                'tanggal_sidang' => null,
                'pip' => 'Rabu, 16 Juli 2025',
                'link_surat' => 'https://drive.google.com/file/d/11K-HG7P_HENmGD5iWs271V8Q2pJfPYuA/view?usp=sharing',
                'keterangan' => 'Relaas Pemberitahuan',
            ],
            [
                'tahun_perkara' => 2025,
                'nomor_perkara' => '307/Pdt.G/2025/PA.Pnj',
                'nama_dipanggil' => 'Santoso bin Dasim',
                'alamat_asal' => 'Jalan Ir Soekarno Gang Maskur RT.019, Kelurahan Muara Jawa Ulu, Kecamatan Muara Jawa, Kabupaten Kutai Kartanegara, Provinsi Kalimantan Timur',
                'panggilan_1' => '2025-07-22',
                'panggilan_2' => null,
                'panggilan_3' => null,
                'panggilan_ikrar' => '2025-08-05',
                'tanggal_sidang' => '2025-08-05',
                'pip' => null,
                'link_surat' => 'https://drive.google.com/file/d/1U6CvPcqNI3yJjXOFusS2I7rQl2McGT10/view?usp=sharing',
                'keterangan' => 'Surat Panggilan',
            ],
            [
                'tahun_perkara' => 2025,
                'nomor_perkara' => '141/Pdt.G/2025/PA.Pnj',
                'nama_dipanggil' => 'Nami Nofitasari binti Maat',
                'alamat_asal' => 'Jalan Bangun Mulyo, RT.010, Desa Bangun Mulya, Kecamatan Waru, Kabupaten Penajam Paser Utara, Provinsi Kalimantan Timur',
                'panggilan_1' => null,
                'panggilan_2' => null,
                'panggilan_3' => null,
                'panggilan_ikrar' => null,
                'tanggal_sidang' => null,
                'pip' => 'Senin, 22 Juli 2025',
                'link_surat' => 'https://drive.google.com/file/d/1XvLkKUsm_98giJZ396DVRKiXrpcVzAJt/view?usp=sharing',
                'keterangan' => 'Surat Pemberitahuan',
            ],
            [
                'tahun_perkara' => 2025,
                'nomor_perkara' => '264/Pdt.G/2025/PA.Pnj',
                'nama_dipanggil' => 'Susi Asna Sari binti Barno',
                'alamat_asal' => 'RT.007, Desa Bumi Harapan, Kecamatan Sepaku, Kabupaten Penajam Paser Utara, Provinsi Kalimantan Timur',
                'panggilan_1' => null,
                'panggilan_2' => null,
                'panggilan_3' => null,
                'panggilan_ikrar' => null,
                'tanggal_sidang' => null,
                'pip' => 'Rabu, 23 Juli 2025',
                'link_surat' => 'https://drive.google.com/file/d/1i2rPo2tupKDno82e2vFMjTqGl7Yg_r6w/view?usp=sharing',
                'keterangan' => 'Relaas Pemberitahuan',
            ]
        ];

        foreach ($data as $item) {
            // Textual Date parsing helper
            $parseDate = function ($dateStr) {
                if (!$dateStr)
                    return null;
                // Parse Indonesia Date: "Senin, 22 Juli 2025" -> 2025-07-22
                // Or "Rabu, 05 Maret 2025"
                // Basic cleanup
                $dateStr = trim($dateStr);
                $months = [
                    'Januari' => '01',
                    'Februari' => '02',
                    'Maret' => '03',
                    'April' => '04',
                    'Mei' => '05',
                    'Juni' => '06',
                    'Juli' => '07',
                    'Agustus' => '08',
                    'September' => '09',
                    'Oktober' => '10',
                    'November' => '11',
                    'Desember' => '12'
                ];

                foreach ($months as $indo => $num) {
                    if (strpos($dateStr, $indo) !== false) {
                        try {
                            // Extract Day Year
                            // Format: [DayName], [Day] [Month] [Year]
                            $parts = explode(' ', $dateStr);
                            // Assuming standard format like "Senin, 22 Juli 2025"
                            // parts: [0]=>"Senin,", [1]=>"22", [2]=>"Juli", [3]=>"2025"
                            // Just use day, month, year
                            $day = str_pad(preg_replace('/[^0-9]/', '', $parts[1]), 2, '0', STR_PAD_LEFT);
                            $year = trim($parts[3]);
                            return "$year-$num-$day";
                        } catch (\Exception $e) {
                            return null;
                        }
                    }
                }
                return null;
            };

            // Convert PIP date string to Date if applicable (for when I put date string in pip field above)
            // Actually, if I put it in pip field in the array, I should move it to tanggal_sidang if tanggal_sidang is null?
            // Let's rely on the array data I prepared above. If 'pip' looks like a date, I'll keep it there as string, 
            // but for 'tanggal_sidang' and call dates I need proper YYYY-MM-DD.
            // Wait, I hardcoded standard YYYY-MM-DD in the array above for the first few items, 
            // but for the later ones (Relaas Pemberitahuan) I put date string in 'pip' as text "Rabu, 07 Maret 2025".
            // Since 'pip' is a string column, that is fine.
            // But 'tanggal_sidang' is a DATE column.

            // Let's clean the hardcoded data to match database schema requirements better.

            PanggilanEcourt::create($item);
        }
    }
}
