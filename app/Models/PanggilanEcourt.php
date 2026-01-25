<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PanggilanEcourt extends Model
{
    protected $fillable = [
        'tahun_perkara',
        'nomor_perkara',
        'nama_dipanggil',
        'alamat_asal',
        'panggilan_1',
        'panggilan_2',
        'panggilan_3',
        'panggilan_ikrar',
        'tanggal_sidang',
        'pip',
        'link_surat',
        'keterangan'
    ];

    protected $casts = [
        'tahun_perkara' => 'integer',
        'panggilan_1' => 'date',
        'panggilan_2' => 'date',
        'panggilan_3' => 'date',
        'panggilan_ikrar' => 'date',
        'tanggal_sidang' => 'date',
    ];
}
