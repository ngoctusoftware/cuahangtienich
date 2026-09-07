<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    public function run(): void
    {
        Language::updateOrCreate(['code' => 'vi'], ['name' => 'Tiếng Việt', 'is_default' => true, 'is_active' => true, 'sort_order' => 1]);
        Language::updateOrCreate(['code' => 'en'], ['name' => 'English', 'is_default' => false, 'is_active' => true, 'sort_order' => 2]);
    }
}
