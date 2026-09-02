<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface ProductRepositoryInterface extends RepositoryInterface
{
    public function findBySlug(string $slug, int $languageId): ?object;

    public function getFeatured(int $languageId, int $limit = 8): Collection;

    public function getBestseller(int $languageId, int $limit = 8): Collection;

    public function getNewest(int $languageId, int $limit = 8): Collection;

    public function getByCategory(int $categoryId, int $languageId, int $perPage = 20);
}
