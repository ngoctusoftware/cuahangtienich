<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Content;
use App\Models\Language;
use App\Models\Setting;
use App\Models\StoreBenefit;
use App\Services\ProductService;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(protected ProductService $productService) {}

    public function index(): View {
        $listLanguages = Language::orderBy('name', 'asc')->get();
        $settings      = Setting::all()->pluck('value', 'key')->toArray();
        $sections      = $this->productService->homepageSections();
        $banners       = Banner::with('translations')->where('is_active', true)->orderBy('sort_order')->get();
        $benefits      = StoreBenefit::with('translations')->where('is_active', true)->orderBy('sort_order')->get();

        // Testimonials & tin tức có thể quản lý qua bảng "contents" (type=testimonial/news) ở Admin (Phase 3)
        $testimonials = [
            ['name' => 'Mrs. Linh Vương', 'role' => 'Khách hàng thân thiết', 'content' => 'Sản phẩm chất lượng, giao hàng rất nhanh, sẽ ủng hộ shop lâu dài.', 'avatar' => asset('images/avatars/1.jpg')],
            ['name' => 'Mr. Quân Lai', 'role'    => 'Khách hàng', 'content'            => 'Dịch vụ chăm sóc khách hàng rất tận tâm, tư vấn nhiệt tình.', 'avatar'       => asset('images/avatars/2.jpg')],
            ['name' => 'Mr. Nam Trần', 'role'    => 'Khách hàng', 'content'            => 'Giá cả hợp lý, đóng gói cẩn thận, rất hài lòng.', 'avatar'                   => asset('images/avatars/3.jpg')],
        ];
        $news = Content::with('translations')->where('type', 'news')->where('is_active', true)->latest()->limit(3)->get();
        $data = [
            'testimonials' => $testimonials,
            'news' => $news,
            'settings' => $settings,
            'languages' => $listLanguages,
            'banners' => $banners,
            'benefits' => $benefits,
        ];

        return view('home.index', array_merge($sections, $data));
    }
}
