<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UraianTugas extends Model
{
    protected $table = 'uraian_tugas';

    protected $fillable = [
        'nama',
        'jabatan',
        'kelompok_jabatan_id',
        'nip',
        'status_kepegawaian',
        'foto_url',
        'link_dokumen',
        'urutan',
    ];

    protected $casts = [
        'kelompok_jabatan_id' => 'integer',
        'urutan' => 'integer',
    ];

    public function kelompokJabatan()
    {
        return $this->belongsTo(KelompokJabatan::class, 'kelompok_jabatan_id');
    }
}
