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
            ['nama' => 'Daru Halleila, S.H.', 'jabatan' => 'Hakim', 'kelompok_jabatan_id' => $kelompokMap['Hakim'] ?? 2],
            ['nama' => null, 'jabatan' => 'Hakim', 'kelompok_jabatan_id' => $kelompokMap['Hakim'] ?? 2],

            // Kepaniteraan
            ['nama' => 'H. Muhammad Hamdi, S.H., M.Hum.', 'jabatan' => 'Panitera', 'kelompok_jabatan_id' => $kelompokMap['Kepaniteraan'] ?? 3],
            ['nama' => 'Zulfah, S.H.I.', 'jabatan' => 'Panitera Muda Hukum', 'kelompok_jabatan_id' => $kelompokMap['Kepaniteraan'] ?? 3],
            ['nama' => 'Faridah Fitriyani, S.H.I.', 'jabatan' => 'Panitera Muda Gugatan', 'kelompok_jabatan_id' => $kelompokMap['Kepaniteraan'] ?? 3],
            ['nama' => null, 'jabatan' => 'Panitera Muda Permohonan', 'kelompok_jabatan_id' => $kelompokMap['Kepaniteraan'] ?? 3],
            ['nama' => 'Nuzula Yustisia, S.H.I.', 'jabatan' => 'Panitera Pengganti', 'kelompok_jabatan_id' => $kelompokMap['Kepaniteraan'] ?? 3],
            ['nama' => null, 'jabatan' => 'Jurusita', 'kelompok_jabatan_id' => $kelompokMap['Kepaniteraan'] ?? 3],
            ['nama' => 'Nurul Fitriani, A.Md. Kom', 'jabatan' => 'Jurusita Pengganti', 'kelompok_jabatan_id' => $kelompokMap['Kepaniteraan'] ?? 3],

            // Kesekretariatan
            ['nama' => 'Indra Yanita Yuliana, S.E., M.Si.', 'jabatan' => 'Sekretaris', 'kelompok_jabatan_id' => $kelompokMap['Kesekretariatan'] ?? 4],
            ['nama' => 'Iqbal Khairillah, S.H.', 'jabatan' => 'Kasubag Kepegawaian, Organisasi dan Tata Laksana', 'kelompok_jabatan_id' => $kelompokMap['Kesekretariatan'] ?? 4],
            ['nama' => null, 'jabatan' => 'Kasubag Umum dan Keuangan', 'kelompok_jabatan_id' => $kelompokMap['Kesekretariatan'] ?? 4],
            ['nama' => 'Muhammad Zaim Noor, S.H.', 'jabatan' => 'Kasubag Perencanaan, Teknologi Informasi dan Pelaporan', 'kelompok_jabatan_id' => $kelompokMap['Kesekretariatan'] ?? 4],
            ['nama' => 'Muhardiansyah, S.Kom', 'jabatan' => 'Pranata Komputer Ahli Pertama', 'kelompok_jabatan_id' => $kelompokMap['Kesekretariatan'] ?? 4],
            ['nama' => 'Raini Maulidina, S.H.', 'jabatan' => 'Analis Perkara Peradilan', 'kelompok_jabatan_id' => $kelompokMap['Kesekretariatan'] ?? 4],
            ['nama' => 'Yulinda, A.Md. Kom.', 'jabatan' => 'Pengadministrasi Registrasi Perkara', 'kelompok_jabatan_id' => $kelompokMap['Kesekretariatan'] ?? 4],
            ['nama' => 'Muhammad Ilham, S.H.', 'jabatan' => 'Analis Perkara Peradilan', 'kelompok_jabatan_id' => $kelompokMap['Kesekretariatan'] ?? 4],
            ['nama' => 'Irwan Syah Setiawan, A.Md.', 'jabatan' => 'Pengadministrasi Registrasi Perkara', 'kelompok_jabatan_id' => $kelompokMap['Kesekretariatan'] ?? 4],
            ['nama' => 'Qurrotu Aini, S.H.', 'jabatan' => 'Analis Perkara Peradilan', 'kelompok_jabatan_id' => $kelompokMap['Kesekretariatan'] ?? 4],

            // PPNPN
            ['nama' => 'Adi Irawan', 'jabatan' => 'Pengemudi', 'kelompok_jabatan_id' => $kelompokMap['PPNPN'] ?? 5],
            ['nama' => 'Najwa Hijriana, S.E.', 'jabatan' => 'Pengemudi', 'kelompok_jabatan_id' => $kelompokMap['PPNPN'] ?? 5],
            ['nama' => 'Amin Nur', 'jabatan' => 'Satpam', 'kelompok_jabatan_id' => $kelompokMap['PPNPN'] ?? 5],
            ['nama' => 'Damai Azizu, S.Kom', 'jabatan' => 'Satpam', 'kelompok_jabatan_id' => $kelompokMap['PPNPN'] ?? 5],
            ['nama' => 'Ashar, S.H.', 'jabatan' => 'Pramubakti', 'kelompok_jabatan_id' => $kelompokMap['PPNPN'] ?? 5],
            ['nama' => 'Novayanti', 'jabatan' => 'Pramubakti', 'kelompok_jabatan_id' => $kelompokMap['PPNPN'] ?? 5],
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
