-- =====================================================
-- DATA AWAL PANGGILAN GHAIB
-- Import dengan: php artisan db:seed --class=PanggilanSeeder
-- atau import langsung file ini ke database
-- =====================================================
INSERT INTO `panggilan_ghaib` (
        `tahun_perkara`,
        `nomor_perkara`,
        `nama_dipanggil`,
        `alamat_asal`,
        `panggilan_1`,
        `panggilan_2`,
        `panggilan_ikrar`,
        `tanggal_sidang`,
        `pip`,
        `link_surat`,
        `created_at`,
        `updated_at`
    )
VALUES (
        2025,
        '22/Pdt.G/2025/PA.pnj',
        'Kismanto Bin Painu',
        'RT.002, RW.000, Kel/Desa Riko, Kecamatan Penajam, Kabupaten Penajam Paser Utara.',
        '2025-01-09',
        NULL,
        NULL,
        '2025-05-20',
        NULL,
        'https://drive.google.com/file/d/1dac9YV7aeNdoZgrBl3dR0Teej-iE6909/view?usp=sharing',
        NOW(),
        NOW()
    ),
    (
        2025,
        '53/Pdt.G/2025/PA.pnj',
        'Siti Rohmah bin Misbah',
        'Jalan Danau Tondano, RT.006, Desa Bukit Raya, Kecamatan Sepaku, Kabupaten Penajam Paser Utara.',
        '2025-01-14',
        NULL,
        NULL,
        '2025-05-20',
        NULL,
        'https://drive.google.com/file/d/1OM-mvKt2-Rz_RVk9zYFbqJetnmpEoCU5/view?usp=sharing',
        NOW(),
        NOW()
    ),
    (
        2025,
        '50/Pdt.G/2025/PA.pnj',
        'Himawan Setiyadi Bin Hadi Prabowo',
        'Jalan Propinsi, RT. 005, Kelurahan Sepan, Kecamatan Penajam, Kabupaten Penajam Paser Utara.',
        '2025-01-15',
        NULL,
        NULL,
        '2025-05-20',
        NULL,
        'https://drive.google.com/file/d/1ycUMhvK2bxQenfbJJldvMdVsKqShUO_b/view?usp=drive_link',
        NOW(),
        NOW()
    );
-- NOTE: File ini hanya contoh 3 data pertama
-- Untuk data lengkap, gunakan database.sql di folder parent