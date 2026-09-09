<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\HeroSlide;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        $slides = [
            [
                'title' => 'GIẢI PHÁP MUA SẮM<br>TOÀN DIỆN CHO BẠN',
                'description' => 'ZEK SHOP mang đến hàng ngàn sản phẩm chất lượng với mức giá tốt nhất, giao hàng nhanh toàn quốc, hỗ trợ đổi trả và thanh toán linh hoạt.',
                'cta_text' => 'MUA SẮM NGAY',
                'cta_link' => 'products.newest',
                'image' => 'images/banner/inet.jpeg',
                'bg_class' => 'bg-slide-1',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'FLASH SALE 9/9<br>GIẢM ĐẾN 60%',
                'description' => 'Săn deal khủng dịp 9/9, hàng ngàn sản phẩm giảm giá sốc, số lượng có hạn, nhanh tay đặt hàng ngay hôm nay.',
                'cta_text' => 'ĐĂNG KÝ NGAY',
                'cta_link' => 'promotions.flashsale',
                'image' => 'images/banner/cloudfly.png',
                'bg_class' => 'bg-slide-2',
                'sort_order' => 2,
                'is_active' => true,
            ],
        ];

        foreach ($slides as $slide) {
            Banner::create($slide);
        }
    }
}