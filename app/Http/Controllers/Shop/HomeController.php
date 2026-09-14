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

    public function index(): View
    {
        $listLanguages  = Language::orderBy('name', 'asc')->get();
        $settings       = Setting::all()->pluck('value', 'key')->toArray();
        $sections       = $this->productService->homepageSections();
        $banners        = Banner::with('translations')->where('is_active', true)->orderBy('sort_order')->get();
        $benefits       = StoreBenefit::with('translations')->where('is_active', true)->orderBy('sort_order')->get();

        $testimonials = Content::with('translations')
            ->where('type', 'testimonial')
            ->where('is_active', true)
            ->latest()
            ->limit(3)
            ->get();
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
