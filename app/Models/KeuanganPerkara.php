<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeuanganPerkara extends Model
{
    protected $table = 'keuangan_perkara';

    protected $fillable = [
        'tahun',
        'bulan',
        'saldo_awal',
        'penerimaan',
        'pengeluaran',
        'url_detail',
    ];

    protected $casts = [
        'tahun'      => 'integer',
        'bulan'      => 'integer',
        'saldo_awal' => 'integer',
        'penerimaan' => 'integer',
        'pengeluaran'=> 'integer',
    ];

    const NAMA_BULAN = [
        1  => 'Januari',
        2  => 'Februari',
        3  => 'Maret',
        4  => 'April',
        5  => 'Mei',
        6  => 'Juni',
        7  => 'Juli',
        8  => 'Agustus',
        9  => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];
}
