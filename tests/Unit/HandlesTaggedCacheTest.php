<?php

namespace Tests\Unit;

use App\Repositories\Eloquent\Concerns\HandlesTaggedCache;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class HandlesTaggedCacheTest extends TestCase
{
    public function test_unsupported_stores_bypass_tagged_caching(): void
    {
        config(['cache.default' => 'file']);
        Cache::purge();

        $cache = $this->taggedCache();
        $calls = 0;
        $callback = function () use (&$calls): int {
            return ++$calls;
        };

        $this->assertSame(1, $cache->remember(['products'], 'featured', 60, $callback));
        $this->assertSame(2, $cache->remember(['products'], 'featured', 60, $callback));
        $cache->flush(['products']);
        $this->assertSame(3, $cache->remember(['products'], 'featured', 60, $callback));
    }

    public function test_taggable_stores_cache_and_flush_entries_by_tag(): void
    {
        config(['cache.default' => 'array']);
        Cache::purge();

        $cache = $this->taggedCache();
        $calls = 0;
        $callback = function () use (&$calls): int {
            return ++$calls;
        };

        $this->assertSame(1, $cache->remember(['products'], 'featured', 60, $callback));
        $this->assertSame(1, $cache->remember(['products'], 'featured', 60, $callback));
        $cache->flush(['products']);
        $this->assertSame(2, $cache->remember(['products'], 'featured', 60, $callback));
    }

    private function taggedCache(): object
    {
        return new class
        {
            use HandlesTaggedCache;

            public function remember(array $tags, string $key, mixed $ttl, \Closure $callback): mixed
            {
                return $this->rememberTagged($tags, $key, $ttl, $callback);
            }

            public function flush(array $tags): void
            {
                $this->flushTagged($tags);
            }
        };
    }
}
