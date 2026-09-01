<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plugin extends Model
{
    protected $fillable = [
        'name', 'description', 'compatible_program', 'version', 'icon', 'preview_video',
        'file_path', 'file_original_name', 'file_size', 'uploaded_by', 'downloads',
    ];

    public function reviews(): HasMany
    {
        return $this->hasMany(PluginReview::class);
    }

    public function downloadEvents(): HasMany
    {
        return $this->hasMany(DownloadEvent::class);
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
