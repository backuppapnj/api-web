<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SisaPanjar extends Model
{
    protected $table = 'sisa_panjar';

    protected $fillable = [
        'tahun',
        'bulan',
        'nomor_perkara',
        'nama_penggugat_pemohon',
        'jumlah_sisa_panjar',
        'status',
        'tanggal_setor_kas_negara',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'bulan' => 'integer',
        'jumlah_sisa_panjar' => 'decimal:2',
        'tanggal_setor_kas_negara' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getTanggalSetorKasNegaraAttribute($value)
    {
        return $value ? date('Y-m-d', strtotime($value)) : null;
    }
}
