<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KelompokJabatan extends Model
{
    protected $table = 'kelompok_jabatan';

    protected $fillable = [
        'nama_kelompok',
        'urutan',
    ];

    protected $casts = [
        'urutan' => 'integer',
    ];

    public function uraianTugas()
    {
        return $this->hasMany(UraianTugas::class, 'kelompok_jabatan_id');
    }
}
