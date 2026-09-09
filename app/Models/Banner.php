<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'title',
        'description',
        'cta_text',
        'cta_link',
        'image',
        'bg_class',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Accessor: trả về full URL của ảnh
    public function getImageUrlAttribute(): string
    {
        return asset($this->image);
    }

    // Accessor: resolve link (route name hoặc URL raw)
    public function getResolvedLinkAttribute(): ?string
    {
        if (!$this->cta_link) {
            return null;
        }

        return \Illuminate\Support\Facades\Route::has($this->cta_link)
            ? route($this->cta_link)
            : $this->cta_link;
    }
}