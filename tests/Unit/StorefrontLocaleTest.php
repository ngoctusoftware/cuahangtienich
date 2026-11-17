<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Models\ProductTranslation;
use App\Services\LanguageService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

class StorefrontLocaleTest extends TestCase
{
    public function test_supported_locales_switch_between_vietnamese_and_english(): void
    {
        $languageService = app(LanguageService::class);

        $languageService->setLocale('vi');
        app()->setLocale('vi');
        $this->assertSame('Tìm kiếm sản phẩm...', __('storefront.header.search_placeholder'));

        $languageService->setLocale('en');
        app()->setLocale('en');
        $this->assertSame('Search products...', __('storefront.header.search_placeholder'));
    }

    public function test_unsupported_locales_cannot_be_selected(): void
    {
        $this->expectException(NotFoundHttpException::class);

        app(LanguageService::class)->setLocale('fr');
    }

    public function test_storefront_validation_messages_follow_the_selected_locale(): void
    {
        app()->setLocale('vi');

        $validator = Validator::make([], ['name' => 'required']);

        $this->assertSame('Vui lòng nhập họ tên.', $validator->errors()->first('name'));
    }

    public function test_all_static_storefront_keys_exist_in_both_catalogues(): void
    {
        $keys = [];

        foreach (File::allFiles(resource_path('views')) as $file) {
            preg_match_all(
                '/__\(\s*[\'"](storefront\.[a-zA-Z0-9_.]+)[\'"](?:\s*,|\s*\))/',
                File::get($file->getPathname()),
                $matches
            );

            $keys = array_merge($keys, $matches[1]);
        }

        $keys = array_unique([...$keys, 'storefront.languages.vi', 'storefront.languages.en']);

        foreach (['vi', 'en'] as $locale) {
            app()->setLocale($locale);

            foreach ($keys as $key) {
                $this->assertNotSame($key, __($key), "Missing {$locale} translation for {$key}.");
            }
        }
    }

    public function test_product_translation_falls_back_to_the_default_language(): void
    {
        $languageService = \Mockery::mock(LanguageService::class);
        $languageService->shouldReceive('fallbackLanguageId')->once()->andReturn(1);
        $this->app->instance(LanguageService::class, $languageService);

        $product = new Product;
        $product->setRelation('translations', new Collection([
            new ProductTranslation(['language_id' => 1, 'name' => 'Default translation']),
        ]));

        $this->assertSame('Default translation', $product->translation(2)?->name);
    }
}
