<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\Language;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        $slides = [
            [
                'eyebrow' => 'MUA SẮM THÔNG MINH · SỐNG TRỌN NIỀM VUI',
                'title' => 'GIẢI PHÁP MUA SẮM<br>TOÀN DIỆN CHO BẠN',
                'description' => 'ZEK SHOP mang đến hàng ngàn sản phẩm chất lượng với mức giá tốt nhất, giao hàng nhanh toàn quốc, hỗ trợ đổi trả và thanh toán linh hoạt.',
                'cta_text' => 'MUA SẮM NGAY',
                'cta_link' => 'products.newest',
                'cta_type' => 'link',
                'image' => 'images/banner/inet.jpeg',
                'bg_class' => 'bg-slide-1',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'eyebrow' => 'ƯU ĐÃI ĐỘC QUYỀN · SỐ LƯỢNG CÓ HẠN',
                'title' => 'FLASH SALE 9/9<br>GIẢM ĐẾN 60%',
                'description' => 'Săn deal khủng dịp 9/9, hàng ngàn sản phẩm giảm giá sốc, số lượng có hạn, nhanh tay đặt hàng ngay hôm nay.',
                'cta_text' => 'ĐĂNG KÝ NGAY',
                'cta_link' => 'promotions.flashsale',
                'cta_type' => 'link',
                'image' => 'images/banner/cloudfly.png',
                'bg_class' => 'bg-slide-2',
                'sort_order' => 2,
                'is_active' => true,
            ],
        ];

        foreach ($slides as $slide) {
            $banner = Banner::create($slide);

            foreach (Language::where('is_active', true)->get() as $language) {
                $banner->translations()->create([
                    'language_id' => $language->id,
                    'eyebrow' => $slide['eyebrow'],
                    'title' => $slide['title'],
                    'description' => $slide['description'],
                    'cta_text' => $slide['cta_text'],
                    'cta_link' => $slide['cta_link'],
                ]);
            }
        }
    }
}
