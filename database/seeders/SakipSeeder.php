<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SakipSeeder extends Seeder
{
    private array $data = [
        // ── 2025 ──────────────────────────────────────────────────────────────
        ['tahun' => 2025, 'jenis_dokumen' => 'Indikator Kinerja Utama',
            'uraian' => 'Indikator Kiner Utama (IKU) Pengadilan mengacu pada Surat Keputusan Sekretaris Mahkamah Agung Republik Indonesia Nomor 173/SEK/SK/I/2022 tanggal 31 Januari 2022 tentang Penetapan Indikator Kinerja Utama (IKU) pada Pengadilan Tingkat Banding dan Pengadilan Tingkat Pertama di Lingkungan Mahkmah Agung Republik Indonesia.',
            'link_dokumen' => 'https://drive.google.com/file/d/1gzZcFwDuPUKY9D5gc26Ehd8NSypemTL0/view?usp=sharing'],
        ['tahun' => 2025, 'jenis_dokumen' => 'Rencana Strategis',
            'uraian' => 'Perencanaan Strategis suatu proses yang berorientasi pada hasil yang ingin dicapai selama kurun waktu 1 (satu) sampai dengan 5 (lima) tahun secara sistematis dan bersinambungan dengan memperhitungkan potensi, peluang dan kendala yang ada pada lingkungan Pengadian Agama Penajam.',
            'link_dokumen' => 'https://drive.google.com/file/d/1Al4bA7A5lUut2yEtznJqfqPglkJY0NA3/view?usp=sharing'],
        ['tahun' => 2025, 'jenis_dokumen' => 'Program Kerja',
            'uraian' => null,
            'link_dokumen' => 'https://drive.google.com/file/d/1Z2clJ16ElXIJzgtolBHSN8ECo6XRs5Vq/view?usp=sharing'],
        ['tahun' => 2025, 'jenis_dokumen' => 'Rencana Kinerja Tahunan',
            'uraian' => null,
            'link_dokumen' => 'https://drive.google.com/file/d/1dVHNfuqKAgtGoc8qllCgQI47bILWtF12/view?usp=sharing'],
        ['tahun' => 2025, 'jenis_dokumen' => 'Perjanjian Kinerja',
            'uraian' => null,
            'link_dokumen' => 'https://drive.google.com/file/d/1VHCMLtSwKLHL6ESMTVXzPBdaM-ySPvX4/view?usp=sharing'],
        ['tahun' => 2025, 'jenis_dokumen' => 'Rencana Aksi',
            'uraian' => null,
            'link_dokumen' => 'https://drive.google.com/file/d/1YC1G0OBohMlJyTx7mQNQaiywPDa4wUN5/view?usp=sharing'],
        ['tahun' => 2025, 'jenis_dokumen' => 'Laporan Kinerja Instansi Pemerintah',
            'uraian' => null,
            'link_dokumen' => 'https://drive.google.com/file/d/1m_znxxw9cCw4YHK2VnxrMZ962GiWS2m1/view?usp=sharing'],

        // ── 2024 ──────────────────────────────────────────────────────────────
        ['tahun' => 2024, 'jenis_dokumen' => 'Indikator Kinerja Utama',
            'uraian' => 'Indikator Kiner Utama (IKU) Pengadilan mengacu pada Surat Keputusan Sekretaris Mahkamah Agung Republik Indonesia Nomor 173/SEK/SK/I/2022 tanggal 31 Januari 2022 tentang Penetapan Indikator Kinerja Utama (IKU) pada Pengadilan Tingkat Banding dan Pengadilan Tingkat Pertama di Lingkungan Mahkmah Agung Republik Indonesia.',
            'link_dokumen' => 'https://drive.google.com/file/d/1wbmRfZO-mGYf8WxJTRv44Rtk7n0-Hx6J/view?usp=drive_link'],
        ['tahun' => 2024, 'jenis_dokumen' => 'Rencana Strategis',
            'uraian' => 'Perencanaan Strategis suatu proses yang berorientasi pada hasil yang ingin dicapai selama kurun waktu 1 (satu) sampai dengan 5 (lima) tahun secara sistematis dan bersinambungan dengan memperhitungkan potensi, peluang dan kendala yang ada pada lingkungan Pengadian Agama Penajam.',
            'link_dokumen' => 'https://drive.google.com/file/d/109u6PSOc7uKUnxiVUD1VdQQYpPujO5Y6/view?usp=drive_link'],
        ['tahun' => 2024, 'jenis_dokumen' => 'Program Kerja',
            'uraian' => null,
            'link_dokumen' => 'https://drive.google.com/file/d/1CfFIJohnzDaSHCLg6MyVxwDOM2f2x_XT/view?usp=drive_link'],
        ['tahun' => 2024, 'jenis_dokumen' => 'Rencana Kinerja Tahunan',
            'uraian' => null,
            'link_dokumen' => 'https://drive.google.com/file/d/1B9U-u65pLvabvFVYbtOxwVdnH6yLcsL0/view?usp=drive_link'],
        ['tahun' => 2024, 'jenis_dokumen' => 'Perjanjian Kinerja',
            'uraian' => null,
            'link_dokumen' => 'https://drive.google.com/file/d/1KogvjPlfHyunSX98AJK3ksrO2x6cjHv8/view?usp=drive_link'],
        ['tahun' => 2024, 'jenis_dokumen' => 'Rencana Aksi',
            'uraian' => null,
            'link_dokumen' => 'https://drive.google.com/file/d/1shWZVT4DeRusNebruxqP7ThsmRwce_bM/view?usp=drive_link'],
        ['tahun' => 2024, 'jenis_dokumen' => 'Laporan Kinerja Instansi Pemerintah',
            'uraian' => null,
            'link_dokumen' => 'https://drive.google.com/file/d/1ddbNctYUBycAzkrAloG1SQdQ_qVISP0H/view?usp=drive_link'],

        // ── 2023 ──────────────────────────────────────────────────────────────
        ['tahun' => 2023, 'jenis_dokumen' => 'Indikator Kinerja Utama',
            'uraian' => 'Indikator Kiner Utama (IKU) Pengadilan mengacu pada Surat Keputusan Sekretaris Mahkamah Agung Republik Indonesia Nomor 173/SEK/SK/I/2022 tanggal 31 Januari 2022 tentang Penetapan Indikator Kinerja Utama (IKU) pada Pengadilan Tingkat Banding dan Pengadilan Tingkat Pertama di Lingkungan Mahkmah Agung Republik Indonesia.',
            'link_dokumen' => 'https://drive.google.com/file/d/1blxf-_XFLbLWMcRXzljqK7jg2kfU2IFk/view?usp=drive_link'],
        ['tahun' => 2023, 'jenis_dokumen' => 'Rencana Strategis',
            'uraian' => 'Perencanaan Strategis suatu proses yang berorientasi pada hasil yang ingin dicapai selama kurun waktu 1 (satu) sampai dengan 5 (lima) tahun secara sistematis dan bersinambungan dengan memperhitungkan potensi, peluang dan kendala yang ada pada lingkungan Pengadian Agama Penajam.',
            'link_dokumen' => 'https://drive.google.com/file/d/1XB2pTRGP7zV1xynA5IdnxR-IXXX3qyGz/view?usp=share_link'],
        ['tahun' => 2023, 'jenis_dokumen' => 'Program Kerja',
            'uraian' => null,
            'link_dokumen' => 'https://drive.google.com/file/d/1IEOIdV4hnzNLNn3UUq5xbb6YkAUTPwF2/view?usp=share_link'],
        ['tahun' => 2023, 'jenis_dokumen' => 'Rencana Kinerja Tahunan',
            'uraian' => null,
            'link_dokumen' => 'https://drive.google.com/file/d/1mv2PAGUrwQmzYjmHmJKwixSLN9Shx7rd/view?usp=share_link'],
        ['tahun' => 2023, 'jenis_dokumen' => 'Perjanjian Kinerja',
            'uraian' => null,
            'link_dokumen' => 'https://drive.google.com/file/d/1o-FW9P5AZv43R-hgPiRyLAd_DUEL_l-R/view?usp=sharing'],
        ['tahun' => 2023, 'jenis_dokumen' => 'Rencana Aksi',
            'uraian' => null,
            'link_dokumen' => 'https://drive.google.com/file/d/17gE52R7NF8HQZRLz3YWwvXPjcs1lzlsY/view?usp=share_link'],
        ['tahun' => 2023, 'jenis_dokumen' => 'Laporan Kinerja Instansi Pemerintah',
            'uraian' => null,
            'link_dokumen' => 'https://drive.google.com/file/d/1h_4q2rl9mRkr0DSDUuuNjiueVsyt06lH/view?usp=share_link'],

        // ── 2022 ──────────────────────────────────────────────────────────────
        ['tahun' => 2022, 'jenis_dokumen' => 'Indikator Kinerja Utama',
            'uraian' => 'Indikator Kiner Utama (IKU) Pengadilan mengacu pada Surat Keputusan Ketua Mahkamah Agung Republik Indonesia Nomor 192/KMA/SK/XI/2016 tanggal 09 Nopember 2016 tentang Penetapan Reviu Indikator Kinerja Utama Mahkamah Agung Republik Indonesia.',
            'link_dokumen' => 'https://drive.google.com/file/d/1WAHeQCh5hLpMWNCm6YLLKJMsbbGTH7Jq/view?usp=sharing'],
        ['tahun' => 2022, 'jenis_dokumen' => 'Rencana Strategis',
            'uraian' => 'Perencanaan Strategis suatu proses yang berorientasi pada hasil yang ingin dicapai selama kurun waktu 1 (satu) sampai dengan 5 (lima) tahun secara sistematis dan bersinambungan dengan memperhitungkan potensi, peluang dan kendala yang ada pada lingkungan Pengadian Agama Penajam.',
            'link_dokumen' => 'https://drive.google.com/file/d/18zALJLfIs3rhJNV1HqpCNIrJT4XEBKvW/view?usp=sharing'],
        ['tahun' => 2022, 'jenis_dokumen' => 'Program Kerja',
            'uraian' => null,
            'link_dokumen' => 'https://drive.google.com/file/d/1-BDlekeD83qKnnIiHHeJJzHC8zhnGq94/view?usp=sharing'],
        ['tahun' => 2022, 'jenis_dokumen' => 'Rencana Kinerja Tahunan',
            'uraian' => null,
            'link_dokumen' => 'https://drive.google.com/file/d/1ihcCybCjfvZGMYs3NNtRuO0NBhP5oUfC/view?usp=sharing'],
        ['tahun' => 2022, 'jenis_dokumen' => 'Perjanjian Kinerja',
            'uraian' => null,
            'link_dokumen' => 'https://drive.google.com/file/d/1e9eAb7LNaqaXfsRRnh6qG_AjhNKP3ihr/view?usp=sharing'],
        ['tahun' => 2022, 'jenis_dokumen' => 'Rencana Aksi',
            'uraian' => null,
            'link_dokumen' => 'https://drive.google.com/file/d/1sjhCVvMWlcj3tPMj32Gr6EJBGjjwAKOa/view?usp=sharing'],
        ['tahun' => 2022, 'jenis_dokumen' => 'Laporan Kinerja Instansi Pemerintah',
            'uraian' => null,
            'link_dokumen' => 'https://drive.google.com/file/d/1HXmWbyWV-itAcdQg2xg8Z053kPhhHGc_/view?usp=sharing'],

        // ── 2021 ──────────────────────────────────────────────────────────────
        ['tahun' => 2021, 'jenis_dokumen' => 'Indikator Kinerja Utama',
            'uraian' => 'Indikator Kiner Utama (IKU) Pengadilan mengacu pada Surat Keputusan Ketua Mahkamah Agung Republik Indonesia Nomor 192/KMA/SK/XI/2016 tanggal 09 Nopember 2016 tentang Penetapan Reviu Indikator Kinerja Utama Mahkamah Agung Republik Indonesia.',
            'link_dokumen' => 'https://drive.google.com/file/d/1WAHeQCh5hLpMWNCm6YLLKJMsbbGTH7Jq/view?usp=sharing'],
        ['tahun' => 2021, 'jenis_dokumen' => 'Rencana Strategis',
            'uraian' => 'Perencanaan Strategis suatu proses yang berorientasi pada hasil yang ingin dicapai selama kurun waktu 1 (satu) sampai dengan 5 (lima) tahun secara sistematis dan bersinambungan dengan memperhitungkan potensi, peluang dan kendala yang ada pada lingkungan Pengadian Agama Penajam.',
            'link_dokumen' => 'https://drive.google.com/file/d/1WAHeQCh5hLpMWNCm6YLLKJMsbbGTH7Jq/view?usp=sharing'],
        ['tahun' => 2021, 'jenis_dokumen' => 'Program Kerja',
            'uraian' => null,
            'link_dokumen' => 'https://drive.google.com/file/d/1-BDlekeD83qKnnIiHHeJJzHC8zhnGq94/view?usp=sharing'],
        ['tahun' => 2021, 'jenis_dokumen' => 'Rencana Kinerja Tahunan',
            'uraian' => null,
            'link_dokumen' => null],
        ['tahun' => 2021, 'jenis_dokumen' => 'Perjanjian Kinerja',
            'uraian' => null,
            'link_dokumen' => null],
        ['tahun' => 2021, 'jenis_dokumen' => 'Rencana Aksi',
            'uraian' => null,
            'link_dokumen' => null],
        ['tahun' => 2021, 'jenis_dokumen' => 'Laporan Kinerja Instansi Pemerintah',
            'uraian' => null,
            'link_dokumen' => null],

        // ── 2020 ──────────────────────────────────────────────────────────────
        ['tahun' => 2020, 'jenis_dokumen' => 'Indikator Kinerja Utama',
            'uraian' => 'Indikator Kiner Utama (IKU) Pengadilan mengacu pada Surat Keputusan Ketua Mahkamah Agung Republik Indonesia Nomor 192/KMA/SK/XI/2016 tanggal 09 Nopember 2016 tentang Penetapan Reviu Indikator Kinerja Utama Mahkamah Agung Republik Indonesia.',
            'link_dokumen' => 'https://drive.google.com/file/d/1e5IDMswbHMLTzFFV3nJaOe9funQTq664/view?usp=sharing'],
        ['tahun' => 2020, 'jenis_dokumen' => 'Rencana Strategis',
            'uraian' => 'Perencanaan Strategis suatu proses yang berorientasi pada hasil yang ingin dicapai selama kurun waktu 1 (satu) sampai dengan 5 (lima) tahun secara sistematis dan bersinambungan dengan memperhitungkan potensi, peluang dan kendala yang ada pada lingkungan Pengadian Agama Penajam.',
            'link_dokumen' => 'https://drive.google.com/file/d/1e5IDMswbHMLTzFFV3nJaOe9funQTq664/view?usp=sharing'],
        ['tahun' => 2020, 'jenis_dokumen' => 'Program Kerja',
            'uraian' => null,
            'link_dokumen' => 'https://drive.google.com/file/d/1SOXdeHuwgs3pU1HV3Y73YgF-XQ3oOpTy/view?usp=sharing'],
        ['tahun' => 2020, 'jenis_dokumen' => 'Rencana Kinerja Tahunan',
            'uraian' => null,
            'link_dokumen' => 'https://drive.google.com/file/d/1JGn0Gigv5XPsRHdVWVOrt8-M7WrC7nbV/view?usp=sharing'],
        ['tahun' => 2020, 'jenis_dokumen' => 'Perjanjian Kinerja',
            'uraian' => null,
            'link_dokumen' => 'https://drive.google.com/file/d/14Wq9v24vtH_PwLBIuuDyOPlt5lWvKMD7/view?usp=sharing'],
        ['tahun' => 2020, 'jenis_dokumen' => 'Rencana Aksi',
            'uraian' => null,
            'link_dokumen' => 'https://drive.google.com/file/d/1Q1YLICqC4LY-PCO3wo1pUER3AdzxYNf9/view?usp=sharing'],
        ['tahun' => 2020, 'jenis_dokumen' => 'Laporan Kinerja Instansi Pemerintah',
            'uraian' => null,
            'link_dokumen' => 'https://drive.google.com/file/d/10eFHalqWEvjUIq2OHKzXJiKmcEVoyxTV/view?usp=sharing'],

        // ── 2019 ──────────────────────────────────────────────────────────────
        ['tahun' => 2019, 'jenis_dokumen' => 'Indikator Kinerja Utama',
            'uraian' => 'Indikator Kiner Utama (IKU) Pengadilan mengacu pada Surat Keputusan Ketua Mahkamah Agung Republik Indonesia Nomor 192/KMA/SK/XI/2016 tanggal 09 Nopember 2016 tentang Penetapan Reviu Indikator Kinerja Utama Mahkamah Agung Republik Indonesia.',
            'link_dokumen' => 'https://drive.google.com/file/d/1eJewsRBXjhwTihmAK-NuG4AbBf3Z_0Ie/view?usp=sharing'],
        ['tahun' => 2019, 'jenis_dokumen' => 'Rencana Strategis',
            'uraian' => 'Perencanaan Strategis suatu proses yang berorientasi pada hasil yang ingin dicapai selama kurun waktu 1 (satu) sampai dengan 5 (lima) tahun secara sistematis dan bersinambungan dengan memperhitungkan potensi, peluang dan kendala yang ada pada lingkungan Pengadian Agama Penajam.',
            'link_dokumen' => 'https://drive.google.com/file/d/1gt9wDn2X-2FDbV1koLNsnxbwNUs_VWqd/view?usp=sharing'],
        ['tahun' => 2019, 'jenis_dokumen' => 'Program Kerja',
            'uraian' => null,
            'link_dokumen' => 'https://drive.google.com/file/d/1eb0me0R6xl2pZdWG12woYo11BpH2zCDj/view?usp=sharing'],
        ['tahun' => 2019, 'jenis_dokumen' => 'Rencana Kinerja Tahunan',
            'uraian' => null,
            'link_dokumen' => 'https://drive.google.com/file/d/1uamGNY7DTUa_SVG25WkJfd-HoKmUi14n/view?usp=sharing'],
        ['tahun' => 2019, 'jenis_dokumen' => 'Perjanjian Kinerja',
            'uraian' => null,
            'link_dokumen' => 'https://drive.google.com/file/d/1R8VzUzcwjgbgXI9si5kiarD7kwq6EwmN/view?usp=sharing'],
        ['tahun' => 2019, 'jenis_dokumen' => 'Rencana Aksi',
            'uraian' => null,
            'link_dokumen' => null],
        ['tahun' => 2019, 'jenis_dokumen' => 'Laporan Kinerja Instansi Pemerintah',
            'uraian' => null,
            'link_dokumen' => null],
    ];

    public function run(): void
    {
        $now = \Carbon\Carbon::now();

        foreach ($this->data as $row) {
            DB::table('sakip')->updateOrInsert(
                [
                    'tahun'         => $row['tahun'],
                    'jenis_dokumen' => $row['jenis_dokumen'],
                ],
                [
                    'uraian'        => $row['uraian'],
                    'link_dokumen' => $row['link_dokumen'],
                    'updated_at'    => $now,
                    'created_at'    => $now,
                ]
            );
        }

        $this->command->info('SakipSeeder: ' . count($this->data) . ' baris diproses.');
    }
}
