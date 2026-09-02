<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

// Đặt locale ứng dụng theo ngôn ngữ đã lưu trong session (đổi ở header website)
class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        app()->setLocale(session('locale', config('app.locale')));

        return $next($request);
    }
}
