<?php

namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Eloquent\Concerns\HandlesTaggedCache;
use App\Services\LanguageService;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    use HandlesTaggedCache;

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

        $categories = $this->rememberTagged(
            ['categories'],
            "categories:tree:v2:{$languageId}",
            now()->addHour(),
            $loadCategories
        );

        if ($categories instanceof Collection && $categories->every(
            fn ($category): bool => $category instanceof Category
        )) {
            return $categories;
        }

        $this->forgetTagged(['categories'], "categories:tree:v2:{$languageId}");

        return $loadCategories();
    }

    public function findBySlug(string $slug, int $languageId): ?object
    {
        $category = $this->model
            ->whereHas('translations', fn ($query) => $query->where('slug', $slug)->where('language_id', $languageId))
            ->with('translations')
            ->first();

        if ($category) {
            return $category;
        }

        $fallbackLanguageId = app(LanguageService::class)->fallbackLanguageId();

        return $this->model
            ->whereHas('translations', fn ($query) => $query->where('slug', $slug)->where('language_id', $fallbackLanguageId))
            ->with('translations')
            ->first();
    }
}
