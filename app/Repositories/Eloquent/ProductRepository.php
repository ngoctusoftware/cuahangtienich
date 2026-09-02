<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    public function findBySlug(string $slug, int $languageId): ?object
    {
        return $this->model
            ->whereHas('translations', fn ($q) => $q->where('slug', $slug)->where('language_id', $languageId))
            ->with(['translations', 'images', 'category.translations'])
            ->where('is_active', true)
            ->first();
    }

    // Dùng Redis cache (qua Cache facade, driver Redis cấu hình ở .env) để tăng tốc trang chủ
    public function getFeatured(int $languageId, int $limit = 8): Collection
    {
        return Cache::tags(['products'])->remember(
            "products:featured:{$languageId}:{$limit}",
            now()->addMinutes(30),
            fn () => $this->model->with('translations')
                ->where('is_featured', true)->where('is_active', true)
                ->latest()->limit($limit)->get()
        );
    }

    public function getBestseller(int $languageId, int $limit = 8): Collection
    {
        return Cache::tags(['products'])->remember(
            "products:bestseller:{$languageId}:{$limit}",
            now()->addMinutes(30),
            fn () => $this->model->with('translations')
                ->where('is_bestseller', true)->where('is_active', true)
                ->orderByDesc('sold_count')->limit($limit)->get()
        );
    }

    public function getNewest(int $languageId, int $limit = 8): Collection
    {
        return Cache::tags(['products'])->remember(
            "products:newest:{$languageId}:{$limit}",
            now()->addMinutes(30),
            fn () => $this->model->with('translations')
                ->where('is_active', true)
                ->latest()->limit($limit)->get()
        );
    }

    public function getByCategory(int $categoryId, int $languageId, int $perPage = 20)
    {
        return $this->model->with('translations')
            ->where('category_id', $categoryId)
            ->where('is_active', true)
            ->paginate($perPage);
    }
}
