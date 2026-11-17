<?php

namespace Database\Seeders;

use App\Models\Content;
use App\Models\Language;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TestimonialsSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'key' => 'testimonial-linh-vuong',
                'name' => 'Mrs. Linh Vương',
                'body' => 'Sản phẩm chất lượng, giao hàng rất nhanh, sẽ ủng hộ shop lâu dài.',
                'body_en' => 'Great product quality and fast delivery. I will definitely shop here again.',
                'rating' => 5,
            ],
            [
                'key' => 'testimonial-quan-lai',
                'name' => 'Mr. Quân Lai',
                'body' => 'Dịch vụ chăm sóc khách hàng rất tận tâm, tư vấn nhiệt tình.',
                'body_en' => 'The customer service team is attentive and always happy to help.',
                'rating' => 5,
            ],
            [
                'key' => 'testimonial-nam-tran',
                'name' => 'Mr. Nam Trần',
                'body' => 'Giá cả hợp lý, đóng gói cẩn thận, rất hài lòng.',
                'body_en' => 'Fair prices, careful packaging, and an excellent experience.',
                'rating' => 5,
            ],
        ];

        $language = Language::where('code', 'vi')->where('is_active', true)->first();

        if (! $language) {
            return;
        }

        $englishLanguage = Language::where('code', 'en')->where('is_active', true)->first();

        foreach ($testimonials as $testimonial) {
            $content = Content::updateOrCreate(
                ['key' => $testimonial['key']],
                [
                    'type' => 'testimonial',
                    'rating' => $testimonial['rating'],
                    'is_active' => true,
                ],
            );

            $content->translations()->updateOrCreate(
                ['language_id' => $language->id],
                [
                    'title' => $testimonial['name'],
                    'slug' => Str::slug($testimonial['name']),
                    'body' => $testimonial['body'],
                ],
            );

            if ($englishLanguage) {
                $content->translations()->updateOrCreate(
                    ['language_id' => $englishLanguage->id],
                    [
                        'title' => $testimonial['name'],
                        'slug' => Str::slug($testimonial['name']),
                        'body' => $testimonial['body_en'],
                    ],
                );
            }
        }
    }
}
