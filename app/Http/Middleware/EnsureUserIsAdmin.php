<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Chi cho phep Admin / Nhan vien vao khu vuc quan tri.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->isAdmin()) {
            abort(403, 'Ban khong co quyen truy cap trang quan tri.');
        }

        return $next($request);
    }
}
