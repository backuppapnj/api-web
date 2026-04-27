<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyPekan extends Model
{
    protected $table = 'survey_pekan';

    protected $fillable = [
        'tahun',
        'tanggal_mulai',
        'tanggal_selesai',
        'gambar_ikm',
        'link_ikm',
        'nilai_ikm',
        'gambar_ipkp',
        'link_ipkp',
        'nilai_ipkp',
        'gambar_ipak',
        'link_ipak',
        'nilai_ipak',
        'total_responden',
        'catatan',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'nilai_ikm' => 'float',
        'nilai_ipkp' => 'float',
        'nilai_ipak' => 'float',
        'total_responden' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
