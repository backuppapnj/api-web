<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sakip extends Model
{
    protected $table = 'sakip';

    protected $fillable = [
        'tahun',
        'jenis_dokumen',
        'uraian',
        'link_dokumen',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
