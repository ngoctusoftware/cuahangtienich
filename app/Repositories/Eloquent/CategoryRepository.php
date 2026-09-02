<?php

namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    public function getTree(int $languageId)
    {
        return Cache::tags(['categories'])->remember(
            "categories:tree:{$languageId}",
            now()->addHour(),
            fn () => $this->model->with('translations', 'children.translations')
                ->whereNull('parent_id')
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get()
        );
    }

    public function findBySlug(string $slug, int $languageId): ?object
    {
        return $this->model
            ->whereHas('translations', fn ($q) => $q->where('slug', $slug)->where('language_id', $languageId))
            ->with('translations')
            ->first();
    }
}
