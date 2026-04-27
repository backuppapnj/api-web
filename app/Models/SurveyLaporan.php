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
        'nilai_indeks',
        'kategori_mutu',
        'jumlah_responden',
        'unsur_terendah',
        'unsur_tertinggi',
        'kesimpulan',
        'rekomendasi',
        'gambar_url',
        'link_dokumen',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'urutan' => 'integer',
        'nilai_indeks' => 'float',
        'jumlah_responden' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
