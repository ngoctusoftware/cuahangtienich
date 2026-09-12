<?php

namespace Database\Seeders;

use App\Models\HeaderMenuItem;
use App\Models\Language;
use Illuminate\Database\Seeder;

class HeaderMenuSeeder extends Seeder
{
    public function run(): void
    {
        $languages = Language::where('is_active', true)->get()->keyBy('code');
        $items = [
            ['key' => 'categories', 'icon' => 'fas fa-bars', 'is_category' => true, 'link_value' => null, 'sort_order' => 10, 'labels' => ['vi' => 'DANH MỤC SẢN PHẨM', 'en' => 'PRODUCT CATEGORIES']],
            ['key' => 'home', 'icon' => null, 'is_category' => false, 'link_value' => 'home', 'sort_order' => 20, 'labels' => ['vi' => 'TRANG CHỦ', 'en' => 'HOME']],
            ['key' => 'about', 'icon' => null, 'is_category' => false, 'link_type' => 'route', 'link_value' => 'about', 'sort_order' => 30, 'labels' => ['vi' => 'GIỚI THIỆU', 'en' => 'ABOUT US']],
            ['key' => 'news', 'icon' => null, 'is_category' => false, 'link_value' => 'products.newest', 'sort_order' => 40, 'labels' => ['vi' => 'TIN TỨC', 'en' => 'NEWS']],
            ['key' => 'recruitment', 'icon' => null, 'is_category' => false, 'link_value' => 'products.bestseller', 'sort_order' => 50, 'labels' => ['vi' => 'TUYỂN DỤNG', 'en' => 'RECRUITMENT']],
            ['key' => 'contact', 'icon' => null, 'is_category' => false, 'link_type' => 'url', 'link_value' => '/trang/contact', 'sort_order' => 60, 'labels' => ['vi' => 'LIÊN HỆ', 'en' => 'CONTACT']],
        ];

        foreach ($items as $item) {
            $labels = $item['labels'];
            unset($item['labels']);
            $menuItem = HeaderMenuItem::updateOrCreate(['key' => $item['key']], $item + ['link_type' => 'route', 'is_active' => true]);
            foreach ($languages as $code => $language) {
                $menuItem->translations()->updateOrCreate(
                    ['language_id' => $language->id],
                    ['label' => $labels[$code] ?? $labels['en'] ?? $labels['vi']]
                );
            }
        }
    }
}
