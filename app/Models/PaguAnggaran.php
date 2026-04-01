<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaguAnggaran extends Model
{
    protected $table = 'pagu_anggaran';
    protected $fillable = ['dipa', 'kategori', 'jumlah_pagu', 'tahun'];
    protected $casts = ['jumlah_pagu' => 'decimal:2', 'tahun' => 'integer'];

    /**
     * Mutator untuk jumlah_pagu - simpan sebagai string untuk menghindari overflow
     */
    public function setJumlahPaguAttribute($value)
    {
        // Simpan sebagai string, database decimal akan menangani dengan benar
        $this->attributes['jumlah_pagu'] = is_numeric($value) ? (string) $value : $value;
    }

    /**
     * Accessor untuk jumlah_pagu - return sebagai float
     */
    public function getJumlahPaguAttribute($value)
    {
        return (float) $value;
    }
}
