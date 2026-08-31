<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoryProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Dien thoai', 'Laptop', 'Phu kien', 'Dong ho thong minh'];

        foreach ($categories as $name) {
            $category = Category::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'is_active' => true]
            );

            for ($i = 1; $i <= 3; $i++) {
                $productName = $name.' mau '.$i;
                Product::firstOrCreate(
                    ['slug' => Str::slug($productName).'-'.$category->id.$i],
                    [
                        'category_id' => $category->id,
                        'name' => $productName,
                        'sku' => strtoupper(Str::random(8)),
                        'description' => 'Mo ta san pham '.$productName,
                        'price' => rand(1, 30) * 100000,
                        'sale_price' => null,
                        'stock' => rand(5, 50),
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}
