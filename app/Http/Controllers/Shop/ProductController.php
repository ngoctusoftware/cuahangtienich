<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Services\LanguageService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService,
        protected CategoryRepositoryInterface $categoryRepository,
        protected LanguageService $languageService,
    ) {}

    public function show(string $slug): View
    {
        $product = $this->productService->detail($slug);
        abort_if(! $product, 404);

        return view('products.show', compact('product'));
    }

    public function byCategory(string $slug): View
    {
        $languageId = $this->languageService->currentLanguageId();
        $category = $this->categoryRepository->findBySlug($slug, $languageId);
        abort_if(! $category, 404);

        $products = $this->productService->byCategory($category->id);
        $allCategories = $this->categoryRepository->getTree($languageId);

        return view('products.index', compact('products', 'category', 'allCategories'));
    }

    public function search(Request $request): View
    {
        $data = $request->validate([
            'q' => ['required', 'string', 'max:100'],
        ]);
        $query = trim($data['q']);
        $products = $this->productService->search($query);
        $allCategories = $this->categoryRepository->getTree($this->languageService->currentLanguageId());

        return view('products.index', [
            'products' => $products,
            'category' => null,
            'allCategories' => $allCategories,
            'searchQuery' => $query,
        ]);
    }

    public function newest(): View
    {
        $products = $this->productService->homepageSections()['newest'];
        $allCategories = $this->categoryRepository->getTree($this->languageService->currentLanguageId());

        return view('products.index', ['products' => $products, 'category' => null, 'allCategories' => $allCategories]);
    }

    public function bestseller(): View
    {
        $products = $this->productService->homepageSections()['bestseller'];
        $allCategories = $this->categoryRepository->getTree($this->languageService->currentLanguageId());

        return view('products.index', ['products' => $products, 'category' => null, 'allCategories' => $allCategories]);
    }

    public function featured(): View
    {
        $products = $this->productService->homepageSections()['featured'];
        $allCategories = $this->categoryRepository->getTree($this->languageService->currentLanguageId());

        return view('products.index', ['products' => $products, 'category' => null, 'allCategories' => $allCategories]);
    }
}
