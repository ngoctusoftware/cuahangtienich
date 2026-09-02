<?php

namespace App\Services;

use App\Repositories\Contracts\CategoryRepositoryInterface;

class CategoryService
{
    public function __construct(
        protected CategoryRepositoryInterface $categoryRepository,
        protected LanguageService $languageService,
    ) {
    }

    public function menuTree()
    {
        return $this->categoryRepository->getTree($this->languageService->currentLanguageId());
    }

    public function detail(string $slug)
    {
        return $this->categoryRepository->findBySlug($slug, $this->languageService->currentLanguageId());
    }
}
