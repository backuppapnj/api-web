<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RealisasiAnggaran extends Model
{
    protected $table = 'realisasi_anggaran';

    protected $fillable = [
        'dipa',
        'kategori',
        'bulan',
        'pagu',
        'realisasi',
        'sisa',
        'persentase',
        'tahun',
        'keterangan',
        'link_dokumen'
    ];

    protected $casts = [
        'pagu' => 'float',
        'realisasi' => 'float',
        'sisa' => 'float',
        'persentase' => 'float',
        'tahun' => 'integer',
        'bulan' => 'integer',
    ];
}
