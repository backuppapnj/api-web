<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediatorBanner extends Model
{
    protected $table = 'mediator_banners';

    protected $fillable = [
        'judul',
        'image_url',
        'type',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
