<?php

namespace App\View\Composers;

use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Services\CartService;
use App\Services\LanguageService;
use App\Services\SettingService;
use Illuminate\View\View;

// Chạy trước mỗi lần render view thuộc layout Shop, tự động bơm dữ liệu dùng chung
// (tên site, danh mục menu, ngôn ngữ, số lượng giỏ hàng...) — tránh lặp code ở từng Controller.
class ShopComposer
{
    public function __construct(
        protected SettingService $settingService,
        protected LanguageService $languageService,
        protected CategoryRepositoryInterface $categoryRepository,
        protected CartService $cartService,
    ) {
    }

    public function compose(View $view): void
    {
        $settings = $this->settingService->all();
        // dd($this->categoryRepository->getTree($this->languageService->currentLanguageId()));

        $view->with([
            'siteName'       => $settings['site_name'] ?? 'ZEK SHOP',
            'setting'        => fn ($key, $default = null) => $settings[$key] ?? $default,
            'languages'      => $this->languageService->active(),
            'menuCategories' => $this->categoryRepository->getTree($this->languageService->currentLanguageId()),
            'cartCount'      => collect($this->cartService->all())->sum('quantity'),
        ]);
    }
}
