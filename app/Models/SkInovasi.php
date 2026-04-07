<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkInovasi extends Model
{
    protected $table = 'sk_inovasi';

    protected $fillable = [
        'tahun',
        'nomor_sk',
        'tentang',
        'file_path',
        'file_url',
        'is_active',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByTahun($query, $tahun)
    {
        return $query->where('tahun', $tahun);
    }

    public function scopeLatestYear($query)
    {
        return $query->orderBy('tahun', 'desc');
    }
}
