<?php

namespace App\Http\Middleware;

use App\Services\LanguageService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// Đặt locale ứng dụng theo ngôn ngữ đã lưu trong session (đổi ở header website)
class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $languageService = app(LanguageService::class);
        $locale = session('locale', config('app.locale'));

        if (! is_string($locale) || ! $languageService->isSupportedLocale($locale)) {
            $locale = config('app.fallback_locale');
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
