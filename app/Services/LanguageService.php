<?php

namespace App\Services;

use App\Models\Language;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;

class LanguageService
{
    public function active(): Collection
    {
        $data = Cache::remember('languages:active', now()->addHours(6), function () {
            // Cache mảng thuần (array), không cache Eloquent Collection
            return Language::where('is_active', true)
                ->orderBy('sort_order')
                ->get()
                ->toArray();
        });

        // Hydrate lại thành Eloquent Collection từ mảng đã cache
        return Language::hydrate($data);
    }

    public function currentLanguageId(): int
    {
        $code = session('locale', config('app.locale'));
        $languages = $this->active();

        $lang = $languages->firstWhere('code', $code)
            ?? $languages->firstWhere('is_default', true);

        return $lang?->id ?? 1;
    }

    public function setLocale(string $code): void
    {
        session(['locale' => $code]);
    }
}