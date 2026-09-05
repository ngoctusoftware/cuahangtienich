<?php

namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    public function getTree(int $languageId): Collection
    {
        $loadCategories = fn (): Collection => $this->model
            ->with([
                'translations',
                'children' => fn ($query) => $query
                    ->with('translations')
                    ->where('is_active', true)
                    ->whereHas('translations'),
            ])
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->whereHas('translations')
            ->orderBy('sort_order')
            ->get();

        $categories = Cache::tags(['categories'])->remember(
            "categories:tree:v2:{$languageId}",
            now()->addHour(),
            $loadCategories
        );

        if ($categories instanceof Collection && $categories->every(
            fn ($category): bool => $category instanceof Category
        )) {
            return $categories;
        }

        Cache::tags(['categories'])->forget("categories:tree:v2:{$languageId}");

        return $loadCategories();
    }

    public function findBySlug(string $slug, int $languageId): ?object
    {
        return $this->model
            ->whereHas('translations', fn ($q) => $q->where('slug', $slug)->where('language_id', $languageId))
            ->with('translations')
            ->first();
    }
}
