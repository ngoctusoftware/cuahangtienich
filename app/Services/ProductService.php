<?php

namespace App\Services;

use App\Repositories\Contracts\ProductRepositoryInterface;

// Tầng Service: chứa business logic, controller chỉ gọi service, không đụng trực tiếp Eloquent
class ProductService
{
    public function __construct(
        protected ProductRepositoryInterface $productRepository,
        protected LanguageService $languageService,
    ) {
    }

    public function homepageSections(): array
    {
        $languageId = $this->languageService->currentLanguageId();

        return [
            'featured'   => $this->productRepository->getFeatured($languageId),
            'bestseller' => $this->productRepository->getBestseller($languageId),
            'newest'     => $this->productRepository->getNewest($languageId),
        ];
    }

    public function detail(string $slug)
    {
        return $this->productRepository->findBySlug($slug, $this->languageService->currentLanguageId());
    }

    public function byCategory(int $categoryId, int $perPage = 20)
    {
        return $this->productRepository->getByCategory($categoryId, $this->languageService->currentLanguageId(), $perPage);
    }
}
