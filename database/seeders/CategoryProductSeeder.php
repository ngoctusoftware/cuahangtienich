<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Language;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoryProductSeeder extends Seeder
{
    public function run(): void
    {
        $language = Language::where('code', 'vi')->firstOrFail();
        $categories = ['Dien thoai', 'Laptop', 'Phu kien', 'Dong ho thong minh'];

        foreach ($categories as $name) {
            $slug = Str::slug($name);
            $category = Category::whereHas('translations', function ($query) use ($language, $slug): void {
                $query->where('language_id', $language->id)->where('slug', $slug);
            })->first() ?? Category::create(['is_active' => true]);
            $category->translations()->updateOrCreate(
                ['language_id' => $language->id],
                ['name' => $name, 'slug' => $slug]
            );

            for ($i = 1; $i <= 3; $i++) {
                $productName = $name.' mau '.$i;
                $product = Product::firstOrCreate(
                    ['sku' => strtoupper(Str::slug($productName).'-'.$category->id.$i)],
                    [
                        'category_id' => $category->id,
                        'price' => rand(1, 30) * 100000,
                        'sale_price' => null,
                        'stock' => rand(5, 50),
                        'is_active' => true,
                    ]
                );
                $product->translations()->updateOrCreate(
                    ['language_id' => $language->id],
                    [
                        'name' => $productName,
                        'slug' => Str::slug($productName).'-'.$category->id.$i,
                        'description' => 'Mo ta san pham '.$productName,
                    ]
                );
            }
        }
    }
}
