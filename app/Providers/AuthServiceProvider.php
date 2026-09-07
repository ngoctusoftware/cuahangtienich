<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

// Đăng ký logic phân quyền (RBAC): mọi @can('xxx.yyy') trong Blade / $user->can() trong code
// sẽ được kiểm tra qua User::hasPermission() (Phase 1) — dựa trên bảng roles/permissions.
class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::before(function ($user, string $ability) {
            // Super Admin có toàn quyền, bỏ qua kiểm tra chi tiết từng permission
            if (method_exists($user, 'hasRole') && $user->hasRole('super-admin')) {
                return true;
            }

            return $user->hasPermission($ability) ?: null;
        });
    }
}
