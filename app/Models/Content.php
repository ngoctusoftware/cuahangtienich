<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Content extends Model
{
    protected $fillable = ['key', 'type', 'image', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function translations(): HasMany
    {
        return $this->hasMany(ContentTranslation::class);
    }

    public function translation(?int $languageId = null): ?ContentTranslation
    {
        $languageId ??= app(\App\Services\LanguageService::class)->currentLanguageId();

        return $this->translations->firstWhere('language_id', $languageId);
    }
}
