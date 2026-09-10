<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    public function run(): void
    {
        Language::updateOrCreate(['code' => 'vi'], [
            'name' => 'Tiếng Việt',
            'name_en' => 'Vietnamese',
            'locale' => 'vi-VN',
            'direction' => 'ltr',
            'is_default' => true,
            'is_active' => true,
            'sort_order' => 1,
            'flag_icon' => 'images/flags/vn.png',
        ]);
        Language::updateOrCreate(['code' => 'en'], [
            'name' => 'Tiếng Anh',
            'name_en' => 'English',
            'locale' => 'en-US',
            'direction' => 'ltr',
            'is_default' => false,
            'is_active' => true,
            'sort_order' => 2,
            'flag_icon' => 'images/flags/us.png',
        ]);
    }
}
