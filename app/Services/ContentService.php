<?php

namespace App\Services;

use App\Models\Content;
use App\Repositories\Eloquent\Concerns\HandlesTaggedCache;

// Cache nội dung tĩnh theo tag khi cache store hỗ trợ.
class ContentService
{
    use HandlesTaggedCache;

    public function __construct(protected LanguageService $languageService) {}

    public function byKey(string $key): ?object
    {
        $languageId = $this->languageService->currentLanguageId();

        return $this->rememberTagged(
            ['contents'],
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

        return $this->rememberTagged(
            ['contents'],
            "contents:type:{$type}:{$languageId}:{$limit}",
            now()->addHour(),
            fn () => Content::with('translations')
                ->where('type', $type)->where('is_active', true)
                ->latest()->limit($limit)->get()
        );
    }
}
