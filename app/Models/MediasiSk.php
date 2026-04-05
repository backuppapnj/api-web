<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediasiSk extends Model
{
    protected $table = 'mediasi_sk';

    protected $fillable = [
        'tahun',
        'link_sk_hakim',
        'link_sk_non_hakim',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
