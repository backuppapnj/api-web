<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPegawai extends Model
{
    protected $table = 'jenis_pegawai';

    protected $fillable = [
        'nama',
        'urutan',
    ];

    protected $casts = [
        'urutan' => 'integer',
    ];

    public function uraianTugas()
    {
        return $this->hasMany(UraianTugas::class, 'jenis_pegawai_id');
    }
}
