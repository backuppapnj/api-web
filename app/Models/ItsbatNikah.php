<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItsbatNikah extends Model
{
    protected $table = 'itsbat_nikah';

    protected $fillable = [
        'nomor_perkara',
        'pemohon_1',
        'pemohon_2',
        'tanggal_pengumuman',
        'tanggal_sidang',
        'link_detail',
        'tahun_perkara'
    ];

    protected $casts = [
        'tanggal_pengumuman' => 'date',
        'tanggal_sidang' => 'date',
    ];
}
