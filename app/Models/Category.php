<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['parent_id', 'image', 'sort_order', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function translations(): HasMany
    {
        return $this->hasMany(CategoryTranslation::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    // Lấy bản dịch theo ngôn ngữ hiện tại (app()->getLocale() ánh xạ sang language_id ở Service)
    public function translation(?int $languageId = null): ?CategoryTranslation
    {
        $languageId ??= app(\App\Services\LanguageService::class)->currentLanguageId();

        return $this->translations->firstWhere('language_id', $languageId);
    }
}
