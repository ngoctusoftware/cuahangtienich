<?php

namespace App\Repositories\Eloquent\Concerns;

use Illuminate\Support\Facades\Cache;

trait HandlesTaggedCache
{
    /**
     * Cache::tags() chỉ hỗ trợ Redis/Memcached/array.
     * Nếu driver hiện tại không hỗ trợ, fallback sang remember() thường (không tag),
     * để tránh BadMethodCallException trên file/database driver.
     */
    protected function rememberTagged(array $tags, string $key, $ttl, \Closure $callback)
    {
        $store = Cache::getStore();

        if (method_exists($store, 'tags') || $store instanceof \Illuminate\Cache\TaggableStore) {
            return Cache::tags($tags)->remember($key, $ttl, $callback);
        }

        // Fallback: vẫn cache nhưng không gắn tag (driver không hỗ trợ)
        return Cache::remember($key, $ttl, $callback);
    }
}