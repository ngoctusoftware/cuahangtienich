<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Route;

class BannerTranslation extends Model
{
    protected $fillable = [
        'banner_id',
        'language_id',
        'eyebrow',
        'title',
        'description',
        'cta_text',
        'cta_link',
    ];

    public function banner(): BelongsTo
    {
        return $this->belongsTo(Banner::class);
    }

    public function getResolvedLinkAttribute(): ?string
    {
        if (! $this->cta_link) {
            return null;
        }

        return Route::has($this->cta_link) ? route($this->cta_link) : $this->cta_link;
    }
}
