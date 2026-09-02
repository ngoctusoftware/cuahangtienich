<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

// Middleware kiểm tra quyền của user admin trước khi vào 1 route
// Cách dùng: Route::middleware('permission:products.create')->...
class CheckPermission
{
    public function handle(Request $request, Closure $next, string $permission)
    {
        $user = $request->user('web');

        abort_unless($user && $user->hasPermission($permission), 403, 'Bạn không có quyền truy cập chức năng này.');

        return $next($request);
    }
}
