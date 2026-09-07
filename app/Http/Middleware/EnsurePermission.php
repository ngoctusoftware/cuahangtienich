<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// Middleware kiểm tra quyền theo slug, dùng: ->middleware('permission:products.create')
class EnsurePermission
{
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = $request->user();

        abort_if(!$user, 403);

        // Super Admin luôn được phép truy cập mọi chức năng
        if ($user->hasRole('super-admin') || $user->hasPermission($permission)) {
            return $next($request);
        }

        abort(403, 'Bạn không có quyền truy cập chức năng này.');
    }
}
