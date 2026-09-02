<?php

namespace App\Services;

use App\Models\Language;
use Illuminate\Support\Facades\Cache;

class LanguageService
{
    public function active()
    {
        return Cache::remember('languages:active', now()->addHours(6), function () {
            return Language::where('is_active', true)->orderBy('sort_order')->get();
        });
    }

    public function currentLanguageId(): int
    {
        $code = session('locale', config('app.locale'));

        $lang = $this->active()->firstWhere('code', $code) ?? $this->active()->firstWhere('is_default', true);

        return $lang?->id ?? 1;
    }

    public function setLocale(string $code): void
    {
        session(['locale' => $code]);
    }
}
