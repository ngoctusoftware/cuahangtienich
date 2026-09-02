<?php

namespace App\Services;

use App\Models\Content;
use Illuminate\Support\Facades\Cache;

// Lấy nội dung tĩnh (banner, giới thiệu, tin tức...) do Admin quản lý, có cache Redis
class ContentService
{
    public function __construct(protected LanguageService $languageService)
    {
    }

    public function byKey(string $key): ?object
    {
        $languageId = $this->languageService->currentLanguageId();

        return Cache::tags(['contents'])->remember(
            "content:{$key}:{$languageId}",
            now()->addHour(),
            fn () => Content::with('translations')
                ->where('key', $key)->where('is_active', true)
                ->first()?->translation($languageId)
        );
    }

    public function listByType(string $type, int $limit = 3)
    {
        $languageId = $this->languageService->currentLanguageId();

        return Cache::tags(['contents'])->remember(
            "contents:type:{$type}:{$languageId}:{$limit}",
            now()->addHour(),
            fn () => Content::with('translations')
                ->where('type', $type)->where('is_active', true)
                ->latest()->limit($limit)->get()
        );
    }
}
