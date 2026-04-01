<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mou extends Model
{
    protected $table = 'mou';

    protected $fillable = [
        'tanggal',
        'instansi',
        'tentang',
        'tanggal_berakhir',
        'link_dokumen',
        'tahun',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'tanggal_berakhir' => 'date',
        'tahun' => 'integer',
    ];
}