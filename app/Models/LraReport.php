<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LraReport extends Model
{
    protected $table = 'lra_reports';

    protected $fillable = [
        'tahun',
        'jenis_dipa',
        'triwulan',
        'judul',
        'file_url',
        'cover_url',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'triwulan' => 'integer',
    ];
}
