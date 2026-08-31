<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Kiem tra user hien tai co permission (slug) truyen vao khong.
     * Su dung: ->middleware('permission:products.manage')
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(403);
        }

        // Admin luon co toan quyen
        if ($user->role && $user->role->slug === 'admin') {
            return $next($request);
        }

        if (! $user->hasPermission($permission)) {
            abort(403, 'Ban khong co quyen thuc hien thao tac nay.');
        }

        return $next($request);
    }
}
