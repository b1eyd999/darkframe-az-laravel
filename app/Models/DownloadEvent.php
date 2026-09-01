<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DownloadEvent extends Model
{
    public $timestamps = false;

    protected $fillable = ['plugin_id', 'user_id', 'downloaded_at'];

    protected $casts = [
        'downloaded_at' => 'datetime',
    ];
}
