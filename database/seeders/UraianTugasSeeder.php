<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UraianTugasSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil ID master data
        $kelompokMap = DB::table('kelompok_jabatan')->pluck('id', 'nama_kelompok');
        $jenisPns = DB::table('jenis_pegawai')->where('nama', 'PNS')->value('id');

        $data = [
            // Pimpinan
            ['nama' => 'Fattahurridlo Al Ghany, S.H.I., M.S.I.', 'jabatan' => 'Ketua', 'kelompok_jabatan_id' => $kelompokMap['Pimpinan'] ?? 1],
            ['nama' => 'Nahdiyanti, S.H.I., M.H.', 'jabatan' => 'Wakil Ketua', 'kelompok_jabatan_id' => $kelompokMap['Pimpinan'] ?? 1],

            // Hakim
            ['nama' => 'Nur Rizka Fani, S.H.', 'jabatan' => 'Hakim', 'kelompok_jabatan_id' => $kelompokMap['Hakim'] ?? 2],
            ['nama' => 'Vidya Nurchaliza, S.H.', 'jabatan' => 'Hakim', 'kelompok_jabatan_id' => $kelompokMap['Hakim'] ?? 2],

            // Kepaniteraan
            ['nama' => 'H. Muhammad Hamdi, S.H., M.Hum.', 'jabatan' => 'Panitera', 'kelompok_jabatan_id' => $kelompokMap['Kepaniteraan'] ?? 3],
            ['nama' => 'Zulfah, S.H.I.', 'jabatan' => 'Panitera Muda Hukum', 'kelompok_jabatan_id' => $kelompokMap['Kepaniteraan'] ?? 3],
            ['nama' => 'Faridah Fitriyani, S.H.I.', 'jabatan' => 'Panitera Muda Gugatan', 'kelompok_jabatan_id' => $kelompokMap['Kepaniteraan'] ?? 3],
            ['nama' => 'Nuzula Yustisia, S.H.I.', 'jabatan' => 'Panitera Muda Permohonan', 'kelompok_jabatan_id' => $kelompokMap['Kepaniteraan'] ?? 3],
            ['nama' => 'Raini Maulidina, S.H.', 'jabatan' => 'Panitera Pengganti', 'kelompok_jabatan_id' => $kelompokMap['Kepaniteraan'] ?? 3],
            ['nama' => 'Muhammad Miftahudin, S.H.', 'jabatan' => 'Jurusita', 'kelompok_jabatan_id' => $kelompokMap['Kepaniteraan'] ?? 3],
            ['nama' => 'Nurul Fitriani, A.Md. Kom', 'jabatan' => 'Jurusita Pengganti', 'kelompok_jabatan_id' => $kelompokMap['Kepaniteraan'] ?? 3],
            ['nama' => 'Yulinda, A.Md. Kom.', 'jabatan' => 'Pengelola Penanganan Perkara', 'kelompok_jabatan_id' => $kelompokMap['Kepaniteraan'] ?? 3],
            ['nama' => 'Muhammad Ilham, S.H.', 'jabatan' => 'Klerek - Analis Perkara Peradilan', 'kelompok_jabatan_id' => $kelompokMap['Kepaniteraan'] ?? 3],
            ['nama' => 'Irwan Syah Setiawan, A.Md.', 'jabatan' => 'Pengelola Penanganan Perkara', 'kelompok_jabatan_id' => $kelompokMap['Kepaniteraan'] ?? 3],
            ['nama' => 'Qurrotu Aini, S.H.', 'jabatan' => 'Klerek - Analis Perkara Peradilan', 'kelompok_jabatan_id' => $kelompokMap['Kepaniteraan'] ?? 3],
            ['nama' => 'Raina Putri Nasuha, S.H.', 'jabatan' => 'Klerek - Analis Perkara Peradilan', 'kelompok_jabatan_id' => $kelompokMap['Kepaniteraan'] ?? 3],
            ['nama' => 'Cucu Khofifah, S.H.', 'jabatan' => 'Klerek - Analis Perkara Peradilan', 'kelompok_jabatan_id' => $kelompokMap['Kepaniteraan'] ?? 3],
            ['nama' => 'Jakfar, A.Md.A.B.', 'jabatan' => 'Klerek - Dokumentalis Hukum', 'kelompok_jabatan_id' => $kelompokMap['Kepaniteraan'] ?? 3],
            ['nama' => 'Nuravita Pramesti, A.Md.', 'jabatan' => 'Klerek - Dokumentalis Hukum', 'kelompok_jabatan_id' => $kelompokMap['Kepaniteraan'] ?? 3],
            ['nama' => 'Novayanti', 'jabatan' => 'Operator - Penata Layanan Operasional', 'kelompok_jabatan_id' => $kelompokMap['Kepaniteraan'] ?? 3],

            // Kesekretariatan
            ['nama' => 'Indra Yanita Yuliana, S.E., M.Si.', 'jabatan' => 'Sekretaris', 'kelompok_jabatan_id' => $kelompokMap['Kesekretariatan'] ?? 4],
            ['nama' => 'Muhammad Zaim Noor, S.H.', 'jabatan' => 'Kasubag Umum dan Keuangan', 'kelompok_jabatan_id' => $kelompokMap['Kesekretariatan'] ?? 4],
            ['nama' => 'Awaluddin Nur, S.H.I.', 'jabatan' => 'Kasubag Perencanaan, Teknologi Informasi dan Pelaporan', 'kelompok_jabatan_id' => $kelompokMap['Kesekretariatan'] ?? 4],
            ['nama' => 'Muhardiansyah, S.Kom', 'jabatan' => 'Pranata Komputer Ahli Pertama', 'kelompok_jabatan_id' => $kelompokMap['Kesekretariatan'] ?? 4],
            ['nama' => 'Adi Irawan', 'jabatan' => 'Pengelola Umum Operasional', 'kelompok_jabatan_id' => $kelompokMap['Kesekretariatan'] ?? 4],
            ['nama' => 'Najwa Hijriana, S.E.', 'jabatan' => 'Operator - Penata Layanan Operasional', 'kelompok_jabatan_id' => $kelompokMap['Kesekretariatan'] ?? 4],
            ['nama' => 'Amin Nur', 'jabatan' => 'Operator Layanan Operasional', 'kelompok_jabatan_id' => $kelompokMap['Kesekretariatan'] ?? 4],
            ['nama' => 'Damai Azizu, S.Kom', 'jabatan' => 'Operator - Penata Layanan Operasional', 'kelompok_jabatan_id' => $kelompokMap['Kesekretariatan'] ?? 4],
            ['nama' => 'Ashar, S.H.', 'jabatan' => 'Operator - Penata Layanan Operasional', 'kelompok_jabatan_id' => $kelompokMap['Kesekretariatan'] ?? 4],
        ];

        $now = now();
        $records = [];

        foreach ($data as $index => $item) {
            $records[] = [
                'nama'                => $item['nama'],
                'jabatan'             => $item['jabatan'],
                'kelompok_jabatan_id' => $item['kelompok_jabatan_id'],
                'jenis_pegawai_id'    => $jenisPns,
                'nip'                 => null,
                'foto_url'            => null,
                'link_dokumen'        => null,
                'uraian_tugas'        => null,
                'urutan'              => $index,
                'created_at'          => $now,
                'updated_at'          => $now,
            ];
        }

        DB::table('uraian_tugas')->insert($records);

        $this->command->info('Uraian tugas berhasil di-seed! (' . count($records) . ' records)');
    }
}
