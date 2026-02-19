<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DipaPok extends Model
{
    protected $table = 'dipapok';
    protected $primaryKey = 'id_dipa';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'id_dipa',
        'kode_dipa',
        'jns_dipa',
        'thn_dipa',
        'revisi_dipa',
        'tgl_dipa',
        'alokasi_dipa',
        'doc_dipa',
        'doc_pok',
        'tgl_update',
    ];

    protected $casts = [
        'id_dipa'      => 'integer',
        'thn_dipa'     => 'integer',
        'alokasi_dipa' => 'integer',
        'tgl_dipa'     => 'date',
        'tgl_update'   => 'datetime',
    ];

    protected $appends = ['id'];

    public function getIdAttribute(): int
    {
        return $this->id_dipa;
    }
}
