<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanPengaduan extends Model
{
    protected $table = 'laporan_pengaduan';

    protected $fillable = [
        'tahun',
        'materi_pengaduan',
        'jan', 'feb', 'mar', 'apr', 'mei', 'jun',
        'jul', 'agu', 'sep', 'okt', 'nop', 'des',
        'laporan_proses',
        'sisa',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'jan' => 'integer', 'feb' => 'integer', 'mar' => 'integer',
        'apr' => 'integer', 'mei' => 'integer', 'jun' => 'integer',
        'jul' => 'integer', 'agu' => 'integer', 'sep' => 'integer',
        'okt' => 'integer', 'nop' => 'integer', 'des' => 'integer',
        'laporan_proses' => 'integer',
        'sisa' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    const BULAN = ['jan','feb','mar','apr','mei','jun','jul','agu','sep','okt','nop','des'];

    const MATERI_PENGADUAN = [
        'Pelanggaran Terhadap Kode Etik Atau Pedoman Perilaku Hakim',
        'Penyalahgunaan Wewenang / Jabatan',
        'Pelanggaran Terhadap Disiplin PNS',
        'Perbuatan Tercela',
        'Pelanggaran Hukum Acara',
        'Kekeliruan Administrasi',
        'Pelayanan Publik Yang Tidak Memuaskan',
    ];
}
