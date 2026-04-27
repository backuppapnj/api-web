<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyPekan extends Model
{
    protected $table = 'survey_pekan';

    protected $fillable = [
        'tahun',
        'tanggal_mulai',
        'tanggal_selesai',
        'gambar_ikm',
        'link_ikm',
        'nilai_ikm',
        'gambar_ipkp',
        'link_ipkp',
        'nilai_ipkp',
        'gambar_ipak',
        'link_ipak',
        'nilai_ipak',
        'total_responden',
        'catatan',
    ];

    protected $casts = [
        'tahun' => 'integer',
        // CATATAN: TIDAK pakai cast 'date' di sini.
        // Cast 'date' membuat Carbon di-serialize sebagai ISO UTC
        // (mis. "2026-02-19T16:00:00.000000Z") yang mundur 1 hari dari
        // tanggal lokal di timezone Asia/Makassar (UTC+8).
        // Frontend lalu ekstrak naif "2026-02-19", sehingga tanggal nampak
        // tidak berubah / mundur 1 hari setelah save.
        // Solusinya: pakai accessor di bawah yang mengembalikan string
        // 'Y-m-d' polos tanpa konversi timezone.
        'nilai_ikm' => 'float',
        'nilai_ipkp' => 'float',
        'nilai_ipak' => 'float',
        'total_responden' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Format tanggal_mulai sebagai string 'Y-m-d' polos
     * (tanpa konversi timezone) supaya frontend menerima nilai
     * persis seperti yang tersimpan di kolom DATE MySQL.
     */
    public function getTanggalMulaiAttribute($value): ?string
    {
        return $value ? date('Y-m-d', strtotime($value)) : null;
    }

    /**
     * Format tanggal_selesai sebagai string 'Y-m-d' polos.
     */
    public function getTanggalSelesaiAttribute($value): ?string
    {
        return $value ? date('Y-m-d', strtotime($value)) : null;
    }
}
