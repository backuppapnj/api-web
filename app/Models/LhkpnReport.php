<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LhkpnReport extends Model
{
    protected $table = 'lhkpn_reports';

    protected $fillable = [
        'nip',
        'nama',
        'jabatan',
        'tahun',
        'jenis_laporan',
        'tanggal_lapor',
        'link_tanda_terima',
        'link_pengumuman',
        'link_spt',
        'link_dokumen_pendukung',
    ];

    protected $casts = [
        'tanggal_lapor' => 'date',
        'tahun' => 'integer',
    ];
}