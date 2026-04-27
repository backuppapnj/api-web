<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyLaporan extends Model
{
    protected $table = 'survey_laporan';

    protected $fillable = [
        'kategori',
        'tahun',
        'periode',
        'urutan',
        'gambar_url',
        'link_dokumen',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'urutan' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
