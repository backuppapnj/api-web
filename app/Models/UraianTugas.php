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
        'jenis_pegawai_id',
        'foto_url',
        'link_dokumen',
        'uraian_tugas',
        'urutan',
    ];

    protected $casts = [
        'kelompok_jabatan_id' => 'integer',
        'jenis_pegawai_id'    => 'integer',
        'urutan'              => 'integer',
    ];

    public function kelompokJabatan()
    {
        return $this->belongsTo(KelompokJabatan::class, 'kelompok_jabatan_id');
    }

    public function jenisPegawai()
    {
        return $this->belongsTo(JenisPegawai::class, 'jenis_pegawai_id');
    }
}
