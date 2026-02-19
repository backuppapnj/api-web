<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DipaPok extends Model
{
    protected $table = 'dipapok';
    protected $primaryKey = 'kode_dipa';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'thn_dipa',
        'revisi_dipa',
        'jns_dipa',
        'tgl_dipa',
        'alokasi_dipa',
        'doc_dipa',
        'doc_pok',
    ];

    protected $casts = [
        'thn_dipa' => 'integer',
        'alokasi_dipa' => 'float',
        'tgl_dipa' => 'date',
    ];
}
