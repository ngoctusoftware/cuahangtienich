<?php

namespace App\Services;

use App\Models\Language;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

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

    public function storefrontLanguages(): Collection
    {
        return $this->active()
            ->filter(fn (Language $language): bool => $this->isSupportedLocale($language->code))
            ->values();
    }

    public function supportedLocales(): array
    {
        return config('app.supported_locales', []);
    }

    public function isSupportedLocale(string $code): bool
    {
        return in_array($code, $this->supportedLocales(), true);
    }

    public function currentLanguageId(): int
    {
        $code = session('locale', config('app.locale'));
        $languages = $this->active();

        $lang = $languages->firstWhere('code', $code)
            ?? $languages->firstWhere('is_default', true);

        return $lang?->id ?? 1;
    }

    public function fallbackLanguageId(): int
    {
        $languages = $this->active();

        return $languages->firstWhere('is_default', true)?->id
            ?? $languages->firstWhere('code', config('app.fallback_locale'))?->id
            ?? 1;
    }

    public function setLocale(string $code): void
    {
        abort_unless($this->isSupportedLocale($code), 404);

        session(['locale' => $code]);
    }
}
