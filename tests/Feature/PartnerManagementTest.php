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

    public function test_partner_export_route_downloads_an_excel_file(): void
    {
        Partner::factory()->create();

        $this->actingAs($this->createSuperAdmin())
            ->get(route('admin.partners.export.all'))
            ->assertDownload('partners-all.xls');
    }

    public function test_partner_import_template_is_downloadable(): void
    {
        $this->actingAs($this->createSuperAdmin())
            ->get(route('admin.partners.import-template'))
            ->assertDownload('partners-import-template.xls');
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
