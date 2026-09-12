<?php

namespace App\Models;

use App\Services\LanguageService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Route;

class Banner extends Model
{
    protected $fillable = [
        'eyebrow',
        'title',
        'description',
        'cta_text',
        'cta_link',
        'cta_type',
        'image',
        'bg_class',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function translations(): HasMany
    {
        return $this->hasMany(BannerTranslation::class);
    }

    public function translation(?int $languageId = null): ?BannerTranslation
    {
        $languageId ??= app(LanguageService::class)->currentLanguageId();

        return $this->translations->firstWhere('language_id', $languageId)
            ?? $this->translations->first();
    }

    // Accessor: trả về full URL của ảnh
    public function getImageUrlAttribute(): string
    {
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }

        return asset($this->image);
    }

    // Accessor: resolve link (route name hoặc URL raw)
    public function getResolvedLinkAttribute(): ?string
    {
        if (! $this->cta_link) {
            return null;
        }

        return Route::has($this->cta_link)
            ? route($this->cta_link)
            : $this->cta_link;
    }
}
