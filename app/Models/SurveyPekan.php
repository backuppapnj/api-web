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
        'gambar_ipkp',
        'link_ipkp',
        'gambar_ipak',
        'link_ipak',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
