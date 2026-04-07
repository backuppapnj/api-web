<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inovasi extends Model
{
    protected $table = 'inovasi';

    protected $fillable = [
        'nama_inovasi',
        'deskripsi',
        'kategori',
        'link_dokumen',
        'urutan',
    ];

    protected $casts = [
        'urutan' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
