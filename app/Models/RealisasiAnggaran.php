<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\PaguAnggaran;

class RealisasiAnggaran extends Model
{
    protected $table = 'realisasi_anggaran';

    /**
     * Relasi ke master pagu anggaran.
     * Satu realisasi terhubung ke satu pagu berdasarkan dipa, kategori, dan tahun.
     */
    public function paguMaster()
    {
        return $this->belongsTo(PaguAnggaran::class, 'dipa', 'dipa')
                    ->whereColumn('realisasi_anggaran.kategori', 'pagu_anggaran.kategori')
                    ->whereColumn('realisasi_anggaran.tahun', 'pagu_anggaran.tahun');
    }

    protected $fillable = [
        'dipa',
        'kategori',
        'bulan',
        'pagu',
        'realisasi',
        'sisa',
        'persentase',
        'tahun',
        'keterangan',
        'link_dokumen'
    ];

    protected $casts = [
        'pagu' => 'float',
        'realisasi' => 'float',
        'sisa' => 'float',
        'persentase' => 'float',
        'tahun' => 'integer',
        'bulan' => 'integer',
    ];
}
