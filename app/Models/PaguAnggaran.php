<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaguAnggaran extends Model
{
    protected $table = 'pagu_anggaran';
    protected $fillable = ['dipa', 'kategori', 'jumlah_pagu', 'tahun'];
    protected $casts = ['jumlah_pagu' => 'float', 'tahun' => 'integer'];
}
