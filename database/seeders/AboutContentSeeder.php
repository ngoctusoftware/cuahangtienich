<?php

namespace Database\Seeders;

use App\Models\Content;
use App\Models\Language;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AboutContentSeeder extends Seeder
{
    public function run(): void
    {
        $content = Content::updateOrCreate(
            ['key' => 'about-us'],
            ['type' => 'page', 'is_active' => true],
        );

        $translations = [
            'vi' => [
                'title' => 'Về chúng tôi',
                'body' => '<p>Chào mừng bạn đến với ZEK SHOP – nơi cung cấp những sản phẩm chất lượng và trải nghiệm mua sắm tiện lợi.</p><p>Chúng tôi luôn đặt sự hài lòng của khách hàng làm trọng tâm, lựa chọn sản phẩm kỹ lưỡng và đồng hành tận tâm trong từng đơn hàng.</p><h2>Giá trị của chúng tôi</h2><ul><li>Sản phẩm được chọn lọc với tiêu chuẩn rõ ràng.</li><li>Tư vấn nhanh chóng, minh bạch và thân thiện.</li><li>Giao hàng an toàn, hỗ trợ khách hàng chu đáo.</li></ul>',
            ],
            'en' => [
                'title' => 'About us',
                'body' => '<p>Welcome to ZEK SHOP, your destination for quality products and a convenient shopping experience.</p><p>Customer satisfaction is at the heart of everything we do. We carefully select our products and support you throughout every order.</p><h2>Our values</h2><ul><li>Carefully selected products with clear standards.</li><li>Fast, transparent and friendly advice.</li><li>Safe delivery and thoughtful customer support.</li></ul>',
            ],
        ];

        foreach ($translations as $code => $translation) {
            $language = Language::where('code', $code)->where('is_active', true)->first();

            if (! $language) {
                continue;
            }

            $content->translations()->updateOrCreate(
                ['language_id' => $language->id],
                [
                    'title' => $translation['title'],
                    'slug' => Str::slug($translation['title']),
                    'body' => $translation['body'],
                ],
            );
        }
    }
}
