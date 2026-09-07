<?php

namespace App\Repositories\Contracts;

interface CategoryRepositoryInterface extends RepositoryInterface
{
    public function getTree(int $languageId);

    public function findBySlug(string $slug, int $languageId): ?object;
}
