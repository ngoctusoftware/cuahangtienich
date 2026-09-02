<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// Chặn tài khoản admin bị khoá (is_active = false) dù vẫn còn phiên đăng nhập
class EnsureUserIsActive
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && !$user->is_active) {
            auth()->logout();

            return redirect()->route('admin.login')->withErrors(['email' => 'Tài khoản của bạn đã bị khoá.']);
        }

        return $next($request);
    }
}
