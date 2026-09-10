<?php

namespace App\Models;

use App\Services\LanguageService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Route;

class HeaderMenuItem extends Model
{
    protected $fillable = [
        'key',
        'icon',
        'link_type',
        'link_value',
        'is_category',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_category' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function translations(): HasMany
    {
        return $this->hasMany(HeaderMenuItemTranslation::class);
    }

    public function translation(?int $languageId = null): ?HeaderMenuItemTranslation
    {
        $languageId ??= app(LanguageService::class)->currentLanguageId();

        return $this->translations->firstWhere('language_id', $languageId)
            ?? $this->translations->first();
    }

    public function getUrlAttribute(): ?string
    {
        if ($this->is_category || ! $this->link_value) {
            return null;
        }

        return $this->link_type === 'route' && Route::has($this->link_value)
            ? route($this->link_value)
            : $this->link_value;
    }
}
