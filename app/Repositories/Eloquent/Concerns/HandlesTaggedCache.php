<?php

namespace App\Repositories\Eloquent\Concerns;

use Illuminate\Cache\TaggableStore;
use Illuminate\Support\Facades\Cache;

trait HandlesTaggedCache
{
    protected function rememberTagged(array $tags, string $key, mixed $ttl, \Closure $callback): mixed
    {
        if ($this->supportsTaggedCache()) {
            return Cache::tags($tags)->remember($key, $ttl, $callback);
        }

        return $callback();
    }

    protected function forgetTagged(array $tags, string $key): void
    {
        if ($this->supportsTaggedCache()) {
            Cache::tags($tags)->forget($key);
        }
    }

    protected function flushTagged(array $tags): void
    {
        if ($this->supportsTaggedCache()) {
            Cache::tags($tags)->flush();
        }
    }

    protected function supportsTaggedCache(): bool
    {
        $store = Cache::getStore();

        return method_exists($store, 'tags') || $store instanceof TaggableStore;
    }
}
