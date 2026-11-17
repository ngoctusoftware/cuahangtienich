<?php

namespace App\Models;

use App\Services\LanguageService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Content extends Model
{
    protected $fillable = ['key', 'type', 'image', 'rating', 'is_active'];

    protected $casts = ['rating' => 'integer', 'is_active' => 'boolean'];

    public function translations(): HasMany
    {
        return $this->hasMany(ContentTranslation::class);
    }

    public function translation(?int $languageId = null): ?ContentTranslation
    {
        $languageId ??= app(LanguageService::class)->currentLanguageId();

        return $this->translations->firstWhere('language_id', $languageId)
            ?? $this->translations->firstWhere(
                'language_id',
                app(LanguageService::class)->fallbackLanguageId()
            )
            ?? $this->translations->first();
    }
}
