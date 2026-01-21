<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Panggilan extends Model
{
    protected $table = 'panggilan_ghaib';

    protected $fillable = [
        'tahun_perkara',
        'nomor_perkara',
        'nama_dipanggil',
        'alamat_asal',
        'panggilan_1',
        'panggilan_2',
        'panggilan_ikrar',
        'tanggal_sidang',
        'pip',
        'link_surat',
        'keterangan'
    ];

    protected $casts = [
        'panggilan_1' => 'date',
        'panggilan_2' => 'date',
        'panggilan_ikrar' => 'date',
        'tanggal_sidang' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Format tanggal untuk output
    public function getPanggilan1Attribute($value)
    {
        return $value ? date('Y-m-d', strtotime($value)) : null;
    }

    public function getPanggilan2Attribute($value)
    {
        return $value ? date('Y-m-d', strtotime($value)) : null;
    }

    public function getPanggilanIkrarAttribute($value)
    {
        return $value ? date('Y-m-d', strtotime($value)) : null;
    }

    public function getTanggalSidangAttribute($value)
    {
        return $value ? date('Y-m-d', strtotime($value)) : null;
    }
}
