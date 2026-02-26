<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsetBmn extends Model
{
    protected $table = 'aset_bmn';

    protected $fillable = [
        'tahun',
        'jenis_laporan',
        'link_dokumen',
    ];

    protected $casts = [
        'tahun' => 'integer',
    ];
}
