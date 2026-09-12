<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Language;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryProductSeeder extends Seeder
{
    public function run(): void
    {
        $language = Language::where('code', 'vi')->firstOrFail();
        $englishLanguage = Language::where('code', 'en')->firstOrFail();
        $categoryName = 'Thời trang';
        $categorySlug = Str::slug($categoryName);

        DB::transaction(function () use ($language, $englishLanguage, $categoryName, $categorySlug): void {
            $category = Category::whereHas('translations', function ($query) use ($language, $categorySlug): void {
                $query->where('language_id', $language->id)->where('slug', $categorySlug);
            })->first() ?? Category::create(['is_active' => true]);

            $category->translations()->updateOrCreate(
                ['language_id' => $language->id],
                [
                    'name' => $categoryName,
                    'slug' => $categorySlug,
                    'description' => 'Thời trang nam nữ hiện đại, đa dạng phong cách.',
                ]
            );

            $styles = [
                'Áo thun cotton basic',
                'Áo sơ mi công sở',
                'Áo khoác dáng ngắn',
                'Quần jeans slim fit',
                'Quần kaki ống đứng',
                'Quần short năng động',
                'Váy liền thanh lịch',
                'Chân váy chữ A',
                'Đầm dự tiệc cao cấp',
                'Áo len dệt kim',
                'Áo polo cổ bẻ',
                'Áo blazer form rộng',
                'Quần jogger thể thao',
                'Đầm maxi đi biển',
                'Set đồ mặc nhà',
                'Áo hoodie unisex',
                'Giày sneaker thời trang',
                'Túi đeo chéo da mềm',
                'Mũ lưỡi trai phong cách',
                'Thắt lưng da thủ công',
            ];
            $colors = ['Đen', 'Trắng', 'Be', 'Xanh navy', 'Hồng phấn'];
            $styleTranslations = [
                'Áo thun cotton basic' => 'Basic Cotton T-Shirt',
                'Áo sơ mi công sở' => 'Office Shirt',
                'Áo khoác dáng ngắn' => 'Cropped Jacket',
                'Quần jeans slim fit' => 'Slim Fit Jeans',
                'Quần kaki ống đứng' => 'Straight-Leg Khaki Pants',
                'Quần short năng động' => 'Casual Shorts',
                'Váy liền thanh lịch' => 'Elegant Dress',
                'Chân váy chữ A' => 'A-Line Skirt',
                'Đầm dự tiệc cao cấp' => 'Premium Party Dress',
                'Áo len dệt kim' => 'Knitted Sweater',
                'Áo polo cổ bẻ' => 'Collared Polo Shirt',
                'Áo blazer form rộng' => 'Oversized Blazer',
                'Quần jogger thể thao' => 'Sport Jogger Pants',
                'Đầm maxi đi biển' => 'Beach Maxi Dress',
                'Set đồ mặc nhà' => 'Loungewear Set',
                'Áo hoodie unisex' => 'Unisex Hoodie',
                'Giày sneaker thời trang' => 'Fashion Sneakers',
                'Túi đeo chéo da mềm' => 'Soft Leather Crossbody Bag',
                'Mũ lưỡi trai phong cách' => 'Stylish Baseball Cap',
                'Thắt lưng da thủ công' => 'Handcrafted Leather Belt',
            ];
            $colorTranslations = [
                'Đen' => 'Black',
                'Trắng' => 'White',
                'Be' => 'Beige',
                'Xanh navy' => 'Navy Blue',
                'Hồng phấn' => 'Blush Pink',
            ];
            $imageUrls = [
                'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1603252110481-7ba873bf42ab?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1548883354-7622d03aca27?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1542272604-787c3835535d?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1624378439575-d8705ad7ae80?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1594633312681-425c7b97ccd1?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1595777457583-95e059d581b8?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1551488831-00ddcb6c6bd3?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1566206091558-7f218b696731?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1591369822096-ffd140ec948f?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1588117305388-c2631a279f82?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1551028719-00167b16eac5?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1529139574466-a303027c1d8b?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1551488831-00ddcb6c6bd3?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1521369909029-2afed882baee?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1624222247344-550fb60583dc?auto=format&fit=crop&w=800&q=80',
            ];
            $skus = [];
            $now = now();

            foreach ($styles as $styleIndex => $style) {
                foreach ($colors as $colorIndex => $color) {
                    $index = ($styleIndex * count($colors)) + $colorIndex;
                    $number = $index + 1;
                    $sku = sprintf('FASHION-DEMO-%03d', $number);
                    $productName = $style.' - '.$color;
                    $isFeatured = $index < 10;
                    $isBestseller = $index >= 10 && $index < 20;
                    $createdAt = $now->copy()->subDays(100 - $index);
                    $price = 199000 + (($index % 10) * 50000);

                    $product = Product::updateOrCreate(
                        ['sku' => $sku],
                        [
                            'category_id' => $category->id,
                            'thumbnail' => $imageUrls[$styleIndex],
                            'price' => $price,
                            'sale_price' => $index % 3 === 0 ? $price - 30000 : null,
                            'stock' => 20 + ($index % 30),
                            'sold_count' => $isBestseller ? 250 - $index : 10 + $index,
                            'is_featured' => $isFeatured,
                            'is_bestseller' => $isBestseller,
                            'is_active' => true,
                        ]
                    );
                    $product->forceFill(['created_at' => $createdAt])->saveQuietly();
                    $product->translations()->updateOrCreate(
                        ['language_id' => $language->id],
                        [
                            'name' => $productName,
                            'slug' => Str::slug($productName).'-'.$number,
                            'short_description' => 'Thiết kế '.$style.' với màu '.$color.' dễ phối đồ.',
                            'description' => 'Sản phẩm thời trang '.$productName.' chất lượng tốt, phù hợp sử dụng hằng ngày.',
                            'meta_title' => $productName,
                            'meta_description' => 'Mua '.$productName.' chính hãng tại cửa hàng.',
                        ]
                    );
                    $englishName = $styleTranslations[$style].' - '.$colorTranslations[$color];
                    $product->translations()->updateOrCreate(
                        ['language_id' => $englishLanguage->id],
                        [
                            'name' => $englishName,
                            'slug' => Str::slug($englishName).'-'.$number,
                            'short_description' => 'A '.$englishName.' that is easy to style for everyday wear.',
                            'description' => 'The '.$englishName.' is made with quality materials and is suitable for everyday use.',
                            'meta_title' => $englishName,
                            'meta_description' => 'Buy the '.$englishName.' from our store.',
                        ]
                    );
                    $skus[] = $sku;
                }
            }

            Product::where('sku', 'like', 'FASHION-DEMO-%')
                ->whereNotIn('sku', $skus)
                ->delete();
        });
    }
}
