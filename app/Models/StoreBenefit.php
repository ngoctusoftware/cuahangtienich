<?php

namespace App\Models;

use App\Services\LanguageService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StoreBenefit extends Model
{
    protected $fillable = ['icon', 'sort_order', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function translations(): HasMany
    {
        return $this->hasMany(StoreBenefitTranslation::class);
    }

    public function translation(?int $languageId = null): ?StoreBenefitTranslation
    {
        $languageId ??= app(LanguageService::class)->currentLanguageId();

        return $this->translations->firstWhere('language_id', $languageId)
            ?? $this->translations->first();
    }
}
