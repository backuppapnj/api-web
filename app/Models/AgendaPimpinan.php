<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgendaPimpinan extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'agenda_pimpinan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tanggal_agenda',
        'isi_agenda',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'tanggal_agenda' => 'date',
    ];
}
