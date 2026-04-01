<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LraReport;

class LraReportSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['tahun' => 2025, 'jenis_dipa' => 'DIPA 01', 'periode' => 'semester_1', 'judul' => 'LRA Semester 1 DIPA 01 Tahun 2025', 'file_url' => 'https://drive.google.com/file/d/1FkkI_zMHbCi5rngDwduX27dNGTk8dIzS/view?usp=sharing', 'cover_url' => null],
            ['tahun' => 2025, 'jenis_dipa' => 'DIPA 01', 'periode' => 'semester_2', 'judul' => 'LRA Semester 2 DIPA 01 Tahun 2025', 'file_url' => 'https://drive.google.com/file/d/1uEqnubSl8sXcfcN7eKSlfqtoO5OWy_a8/view?usp=sharing', 'cover_url' => null],
            ['tahun' => 2025, 'jenis_dipa' => 'DIPA 01', 'periode' => 'unaudited', 'judul' => 'LRA Unaudited DIPA 01 Tahun 2025', 'file_url' => 'https://drive.google.com/file/d/1gnZe_J-raFpDMpgvWAZqulZUiddZArN-/view?usp=sharing', 'cover_url' => null],
            ['tahun' => 2025, 'jenis_dipa' => 'DIPA 04', 'periode' => 'semester_1', 'judul' => 'LRA Semester 1 DIPA 04 Tahun 2025', 'file_url' => 'https://drive.google.com/file/d/1AWGs9LtbJC6a6gXOvHMBpWuHadQqYSTf/view?usp=sharing', 'cover_url' => null],
            ['tahun' => 2025, 'jenis_dipa' => 'DIPA 04', 'periode' => 'semester_2', 'judul' => 'LRA Semester 2 DIPA 04 Tahun 2025', 'file_url' => 'https://drive.google.com/file/d/1jAL7DD85GxaplGyeGInbVC5PkRUBmr-C/view?usp=sharing', 'cover_url' => null],
            ['tahun' => 2025, 'jenis_dipa' => 'DIPA 04', 'periode' => 'unaudited', 'judul' => 'LRA Unaudited DIPA 04 Tahun 2025', 'file_url' => 'https://drive.google.com/file/d/16naY0gdPtkado5Y3r2cEZ-puBsVxwX8z/view?usp=sharing', 'cover_url' => null],
            ['tahun' => 2024, 'jenis_dipa' => 'DIPA 01', 'periode' => 'semester_1', 'judul' => 'LRA Semester 1 DIPA 01 Tahun 2024', 'file_url' => 'https://drive.google.com/file/d/19vGd1E-XM2EEMETG1gdTy9LtrFO9hJBD/view', 'cover_url' => null],
            ['tahun' => 2024, 'jenis_dipa' => 'DIPA 01', 'periode' => 'semester_2', 'judul' => 'LRA Semester 2 DIPA 01 Tahun 2024', 'file_url' => 'https://drive.google.com/file/d/1tbVCIGzY1BZ8J97Zdv51imw4T76q3eEF/view', 'cover_url' => null],
            ['tahun' => 2024, 'jenis_dipa' => 'DIPA 01', 'periode' => 'unaudited', 'judul' => 'LRA Unaudited DIPA 01 Tahun 2024', 'file_url' => 'https://drive.google.com/file/d/17tAXMpGoTILVflWmzFRpuuybx_ld6uRm/view', 'cover_url' => null],
            ['tahun' => 2024, 'jenis_dipa' => 'DIPA 01', 'periode' => 'audited', 'judul' => 'LRA Audited DIPA 01 Tahun 2024', 'file_url' => 'https://drive.google.com/file/d/1JxETbqUVeUB6315klzvLwCzZCt_WoQw5/view', 'cover_url' => null],
            ['tahun' => 2024, 'jenis_dipa' => 'DIPA 04', 'periode' => 'semester_1', 'judul' => 'LRA Semester 1 DIPA 04 Tahun 2024', 'file_url' => 'https://drive.google.com/file/d/1rS3n-nWdWnKEhX-tFvVGpfBUUqPfe4yN/view', 'cover_url' => null],
            ['tahun' => 2024, 'jenis_dipa' => 'DIPA 04', 'periode' => 'semester_2', 'judul' => 'LRA Semester 2 DIPA 04 Tahun 2024', 'file_url' => 'https://drive.google.com/file/d/1AKhhzSENWL2wat0ROIX7JITpQ4yHCAeK/view', 'cover_url' => null],
            ['tahun' => 2024, 'jenis_dipa' => 'DIPA 04', 'periode' => 'unaudited', 'judul' => 'LRA Unaudited DIPA 04 Tahun 2024', 'file_url' => 'https://drive.google.com/file/d/1KwvJJ9TpWPbDT-zAqFCofrvTXDybeP-U/view', 'cover_url' => null],
            ['tahun' => 2024, 'jenis_dipa' => 'DIPA 04', 'periode' => 'audited', 'judul' => 'LRA Audited DIPA 04 Tahun 2024', 'file_url' => 'https://drive.google.com/file/d/1s2swxIrbWYxKnwJn4exJtKgd3RjHjITt/view', 'cover_url' => null],
        ];

        foreach ($data as $item) {
            LraReport::updateOrCreate(
                ['tahun' => $item['tahun'], 'jenis_dipa' => $item['jenis_dipa'], 'periode' => $item['periode']],
                $item
            );
        }
    }
}
