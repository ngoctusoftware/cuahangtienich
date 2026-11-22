<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Language;
use App\Models\Partner;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class PartnerManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_a_partner(): void
    {
        $this->actingAs($this->createSuperAdmin())
            ->post(route('admin.partners.store'), [
                'name' => 'Đối tác ABC',
                'contact_name' => 'Nguyễn Văn A',
                'phone' => '0900000000',
                'email' => 'abc@example.com',
                'is_active' => 1,
            ])
            ->assertRedirect(route('admin.partners.index'));

        $this->assertDatabaseHas('partners', [
            'name' => 'Đối tác ABC',
            'contact_name' => 'Nguyễn Văn A',
            'phone' => '0900000000',
            'email' => 'abc@example.com',
        ]);
    }

    public function test_admin_can_import_partners_from_csv_and_update_matching_names(): void
    {
        Partner::factory()->create([
            'name' => 'Đối tác nhập',
            'contact_name' => 'Liên hệ cũ',
        ]);
        $file = UploadedFile::fake()->createWithContent(
            'partners.csv',
            "name,contact_name,phone,email,address,notes,is_active\nĐối tác nhập,Liên hệ mới,0900000000,import@example.com,Hà Nội,Ghi chú,1\n"
        );

        $this->actingAs($this->createSuperAdmin())
            ->post(route('admin.partners.import'), ['file' => $file])
            ->assertRedirect();

        $this->assertDatabaseCount('partners', 1);
        $this->assertDatabaseHas('partners', [
            'name' => 'Đối tác nhập',
            'contact_name' => 'Liên hệ mới',
            'email' => 'import@example.com',
        ]);
    }

    public function test_admin_can_import_partners_from_xlsx_file(): void
    {
        Partner::factory()->create([
            'name' => 'Đối tác nhập',
            'contact_name' => 'Liên hệ cũ',
        ]);
        $file = $this->makeXlsxUpload([
            ['name', 'contact_name', 'phone', 'email', 'address', 'notes', 'is_active'],
            ['Đối tác nhập', 'Liên hệ mới', '0900000000', 'import@example.com', 'Hà Nội', 'Ghi chú', '1'],
        ]);

        $this->actingAs($this->createSuperAdmin())
            ->post(route('admin.partners.import'), ['file' => $file])
            ->assertRedirect();

        $this->assertDatabaseCount('partners', 1);
        $this->assertDatabaseHas('partners', [
            'name' => 'Đối tác nhập',
            'contact_name' => 'Liên hệ mới',
            'email' => 'import@example.com',
        ]);
    }

    public function test_admin_can_import_the_generated_xls_template(): void
    {
        $admin = $this->createSuperAdmin();
        $template = $this->actingAs($admin)
            ->get(route('admin.partners.import-template'))
            ->streamedContent();
        $file = UploadedFile::fake()->createWithContent('partners.xls', $template);

        $this->actingAs($admin)
            ->post(route('admin.partners.import'), ['file' => $file])
            ->assertRedirect()
            ->assertSessionHas('success', 'Đã import 0 đối tác.');
    }

    public function test_import_rejects_unsupported_file_extensions_with_a_translated_error(): void
    {
        $file = UploadedFile::fake()->createWithContent('partners.txt', 'not a spreadsheet');

        $this->actingAs($this->createSuperAdmin())
            ->postJson(route('admin.partners.import'), ['file' => $file])
            ->assertUnprocessable()
            ->assertJsonPath('errors.file.0', 'tệp tin phải có phần mở rộng là một trong các loại: xls, xlsx, csv.');
    }

    public function test_category_export_route_downloads_an_excel_file(): void
    {
        $language = $this->createLanguage();
        Category::create(['sort_order' => 1, 'is_active' => true]);
        Category::create(['sort_order' => 2, 'is_active' => false]);
        $category = Category::first();
        $category->translations()->create(['language_id' => $language->id, 'name' => 'Danh mục mẫu', 'slug' => 'danh-muc-mau']);

        $this->actingAs($this->createSuperAdmin())
            ->get(route('admin.categories.export.all'))
            ->assertDownload('categories-all.xls');
    }

    public function test_category_import_template_has_the_expected_columns_and_imports_its_format(): void
    {
        $language = $this->createLanguage();
        $admin = $this->createSuperAdmin();
        $template = $this->actingAs($admin)
            ->get(route('admin.categories.import-template'))
            ->assertDownload('categories-import-template.xls')
            ->streamedContent();

        $this->assertStringContainsString('Tên danh mục', $template);
        $this->assertStringContainsString('Danh mục cha', $template);
        $this->assertStringContainsString('Thứ tự', $template);
        $this->assertStringContainsString('Trạng thái', $template);
        $this->assertStringContainsString('Google Gemini', $template);
        $this->assertStringContainsString('Hoạt động', $template);

        $file = UploadedFile::fake()->createWithContent(
            'categories.csv',
            "Tên danh mục,Danh mục cha,Thứ tự,Trạng thái\nGoogle Gemini,,1,Hoạt động\n"
        );

        $this->actingAs($admin)
            ->post(route('admin.categories.import'), ['file' => $file])
            ->assertRedirect();

        $this->assertDatabaseHas('categories', ['sort_order' => 1, 'is_active' => true]);
        $this->assertDatabaseHas('category_translations', [
            'language_id' => $language->id,
            'name' => 'Google Gemini',
            'slug' => 'google-gemini',
        ]);
    }

    public function test_partner_export_route_downloads_an_excel_file(): void
    {
        Partner::factory()->create([
            'zalo_telegram_link' => 'https://zalo.me/doitac',
            'telegram_support_link' => 'https://t.me/doitac',
        ]);

        $export = $this->actingAs($this->createSuperAdmin())
            ->get(route('admin.partners.export.all'))
            ->assertDownload('partners-all.xls');
        $content = $export->streamedContent();

        $this->assertStringContainsString('Link Zalo/ Telegrams', $content);
        $this->assertStringContainsString('https://zalo.me/doitac', $content);
        $this->assertStringContainsString('https://t.me/doitac', $content);
    }

    public function test_partner_import_template_is_downloadable(): void
    {
        $admin = $this->createSuperAdmin();
        $template = $this->actingAs($admin)
            ->get(route('admin.partners.import-template'))
            ->assertDownload('partners-import-template.xls')
            ->streamedContent();

        $this->assertStringContainsString('Tên đối tác', $template);
        $this->assertStringContainsString('Link Zalo/ Telegrams', $template);
        $this->assertStringContainsString('Người liên hệ Zalo', $template);
        $this->assertStringContainsString('Link hỗ trợ Tele', $template);
        $this->assertStringContainsString('Điện thoại', $template);
        $this->assertStringContainsString('Email', $template);
        $this->assertStringContainsString('Địa chỉ', $template);
        $this->assertStringContainsString('Ghi chú', $template);
        $this->assertStringContainsString('Trạng thái', $template);

        $file = UploadedFile::fake()->createWithContent(
            'partners.csv',
            "Tên đối tác,Link Zalo/ Telegrams,Người liên hệ Zalo,Link hỗ trợ Tele,Điện thoại,Email,Địa chỉ,Ghi chú,Trạng thái\nĐối tác nhập,https://zalo.me/doitac,Liên hệ Zalo,https://t.me/doitac,0900000000,import@example.com,Hà Nội,Ghi chú,Hoạt động\n"
        );

        $this->actingAs($admin)
            ->post(route('admin.partners.import'), ['file' => $file])
            ->assertRedirect();

        $this->assertDatabaseHas('partners', [
            'name' => 'Đối tác nhập',
            'zalo_telegram_link' => 'https://zalo.me/doitac',
            'contact_name' => 'Liên hệ Zalo',
            'telegram_support_link' => 'https://t.me/doitac',
            'phone' => '0900000000',
            'email' => 'import@example.com',
            'address' => 'Hà Nội',
            'notes' => 'Ghi chú',
            'is_active' => true,
        ]);
    }

    public function test_product_import_template_includes_partner_and_english_name_fields(): void
    {
        $vietnameseLanguage = $this->createLanguage();
        $englishLanguage = Language::create([
            'code' => 'en',
            'name' => 'Tiếng Anh',
            'name_en' => 'English',
            'locale' => 'en-US',
            'direction' => 'ltr',
            'is_active' => true,
        ]);
        $category = $this->createCategory($vietnameseLanguage);
        $partner = Partner::factory()->create(['name' => 'Đối tác nhập']);
        $admin = $this->createSuperAdmin();
        $template = $this->actingAs($admin)
            ->get(route('admin.products.import-template'))
            ->assertDownload('products-import-template.xls')
            ->streamedContent();

        $this->assertStringContainsString('Tên sản phẩm</Data></Cell><Cell><Data ss:Type="String">Tên sản phẩm tiếng Anh', $template);
        $this->assertStringContainsString('Tên đối tác', $template);

        $file = UploadedFile::fake()->createWithContent(
            'products.csv',
            "Mã SKU,Tên sản phẩm,Tên sản phẩm tiếng Anh,Danh mục,Tên đối tác,Giá gốc,Giá khuyến mãi,Tồn kho,Nổi bật,Bán chạy,Trạng thái,Mô tả ngắn,Mô tả chi tiết\nSKU-IMPORT,Áo mẫu,,{$category->translation()->name},{$partner->name},150,100,2,1,0,1,,\n"
        );

        $this->actingAs($admin)
            ->post(route('admin.products.import'), ['file' => $file])
            ->assertRedirect();

        $this->assertDatabaseHas('products', [
            'sku' => 'SKU-IMPORT',
            'partner_id' => $partner->id,
        ]);
        $this->assertDatabaseHas('product_translations', [
            'language_id' => $vietnameseLanguage->id,
            'name' => 'Áo mẫu',
        ]);
        $this->assertDatabaseHas('product_translations', [
            'language_id' => $englishLanguage->id,
            'name' => 'Ao mau',
        ]);
    }

    public function test_current_partner_page_can_be_exported(): void
    {
        Partner::factory()->create();

        $this->actingAs($this->createSuperAdmin())
            ->get(route('admin.partners.export.current', ['page' => 1]))
            ->assertDownload('partners-page-1.xls');
    }

    public function test_admin_can_assign_a_partner_to_a_product(): void
    {
        $language = $this->createLanguage();
        $category = $this->createCategory($language);
        $partner = Partner::factory()->create();

        $this->actingAs($this->createSuperAdmin())
            ->post(route('admin.products.store'), [
                'category_id' => $category->id,
                'partner_id' => $partner->id,
                'sku' => 'PARTNER-001',
                'price' => 100000,
                'stock' => 5,
                'is_active' => 1,
                'translations' => [
                    $language->id => [
                        'name' => 'Sản phẩm đối tác',
                        'short_description' => 'Mô tả ngắn',
                        'description' => 'Mô tả chi tiết',
                    ],
                ],
            ])
            ->assertRedirect(route('admin.products.index'));

        $this->assertDatabaseHas('products', [
            'sku' => 'PARTNER-001',
            'partner_id' => $partner->id,
        ]);
    }

    public function test_product_without_a_thumbnail_uses_the_no_image_asset(): void
    {
        $product = new Product;

        $this->assertSame(asset('images/noImage.png'), $product->thumbnail_url);
    }

    public function test_product_detail_query_loads_its_partner(): void
    {
        $language = $this->createLanguage();
        $category = $this->createCategory($language);
        $partner = Partner::factory()->create();
        $product = Product::create([
            'category_id' => $category->id,
            'partner_id' => $partner->id,
            'sku' => 'PARTNER-DETAIL-001',
            'price' => 100000,
            'stock' => 5,
            'is_active' => true,
        ]);
        $translation = $product->translations()->create([
            'language_id' => $language->id,
            'name' => 'Sản phẩm đối tác',
            'slug' => 'san-pham-doi-tac',
        ]);

        $productDetail = app(ProductRepositoryInterface::class)->findBySlug($translation->slug, $language->id);

        $this->assertNotNull($productDetail);
        $this->assertSame($partner->name, $productDetail->partner->name);
    }

    public function test_partner_cannot_be_deleted_while_assigned_to_a_product(): void
    {
        $language = $this->createLanguage();
        $category = $this->createCategory($language);
        $partner = Partner::factory()->create();

        Product::create([
            'category_id' => $category->id,
            'partner_id' => $partner->id,
            'sku' => 'PARTNER-DELETE-001',
            'price' => 100000,
            'stock' => 1,
            'is_active' => true,
        ]);

        $this->actingAs($this->createSuperAdmin())
            ->from(route('admin.partners.index'))
            ->delete(route('admin.partners.destroy', $partner))
            ->assertRedirect(route('admin.partners.index'))
            ->assertSessionHasErrors('partner');

        $this->assertDatabaseHas('partners', ['id' => $partner->id]);
    }

    private function makeXlsxUpload(array $rows): UploadedFile
    {
        $path = tempnam(sys_get_temp_dir(), 'partners-import-');
        unlink($path);
        $path .= '.xlsx';

        $sharedStrings = [];
        foreach ($rows as $row) {
            foreach ($row as $value) {
                $stringValue = (string) $value;
                if (! in_array($stringValue, $sharedStrings, true)) {
                    $sharedStrings[] = $stringValue;
                }
            }
        }
        $sharedIndex = array_flip($sharedStrings);

        $zip = new \ZipArchive;
        $zip->open($path, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        $zip->addFromString('[Content_Types].xml', <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">
    <Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>
    <Default Extension="xml" ContentType="application/xml"/>
    <Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>
    <Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>
    <Override PartName="/xl/sharedStrings.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sharedStrings+xml"/>
</Types>
XML);
        $zip->addFromString('_rels/.rels', <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
    <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>
</Relationships>
XML);
        $zip->addFromString('docProps/app.xml', <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Properties xmlns="http://schemas.openxmlformats.org/officeDocument/2006/extended-properties" xmlns:vt="http://schemas.openxmlformats.org/officeDocument/2006/docPropsVTypes"/>
XML);
        $zip->addFromString('docProps/core.xml', <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<cp:coreProperties xmlns:cp="http://schemas.openxmlformats.org/package/2006/metadata/core-properties" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:dcterms="http://purl.org/dc/terms/" xmlns:dcmitype="http://purl.org/dc/dcmitype/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"><dc:title>Partner import</dc:title></cp:coreProperties>
XML);
        $zip->addFromString('xl/workbook.xml', <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">
    <sheets>
        <sheet name="Partners" sheetId="1" r:id="rId1"/>
    </sheets>
</workbook>
XML);
        $zip->addFromString('xl/_rels/workbook.xml.rels', <<<'XML'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
    <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>
    <Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/sharedStrings" Target="sharedStrings.xml"/>
</Relationships>
XML);
        $zip->addFromString('xl/sharedStrings.xml', $this->buildSharedStringsXml($sharedStrings));
        $zip->addFromString('xl/worksheets/sheet1.xml', $this->buildSheetXml($rows, $sharedIndex));
        $zip->close();

        return new UploadedFile($path, 'partners.xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', null, true);
    }

    private function buildSharedStringsXml(array $sharedStrings): string
    {
        $xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><sst xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" count="'.count($sharedStrings).'" uniqueCount="'.count($sharedStrings).'">';
        foreach ($sharedStrings as $value) {
            $xml .= '<si><t>'.htmlspecialchars($value, ENT_XML1 | ENT_QUOTES, 'UTF-8').'</t></si>';
        }

        return $xml.'</sst>';
    }

    private function buildSheetXml(array $rows, array $sharedIndex): string
    {
        $xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main"><sheetData>';
        foreach ($rows as $rowNumber => $row) {
            $xml .= '<row r="'.($rowNumber + 1).'">';
            foreach ($row as $columnIndex => $value) {
                $column = $this->excelColumnLetter($columnIndex + 1);
                $xml .= '<c r="'.$column.($rowNumber + 1).'" t="s"><v>'.$sharedIndex[(string) $value].'</v></c>';
            }
            $xml .= '</row>';
        }

        return $xml.'</sheetData></worksheet>';
    }

    private function excelColumnLetter(int $column): string
    {
        $letters = '';
        while ($column > 0) {
            $column--;
            $letters = chr(65 + ($column % 26)).$letters;
            $column = intdiv($column, 26);
        }

        return $letters;
    }

    private function createLanguage(): Language
    {
        return Language::create([
            'code' => 'vi',
            'name' => 'Tiếng Việt',
            'name_en' => 'Vietnamese',
            'locale' => 'vi-VN',
            'direction' => 'ltr',
            'is_default' => true,
            'is_active' => true,
            'sort_order' => 1,
        ]);
    }

    private function createCategory(Language $language): Category
    {
        $category = Category::create(['sort_order' => 1, 'is_active' => true]);
        $category->translations()->create([
            'language_id' => $language->id,
            'name' => 'Danh mục',
            'slug' => 'danh-muc',
        ]);

        return $category;
    }

    private function createSuperAdmin(): User
    {
        $user = User::factory()->create();
        $role = Role::create(['name' => 'Super Admin', 'slug' => 'super-admin']);
        $user->roles()->attach($role);

        return $user;
    }
}
