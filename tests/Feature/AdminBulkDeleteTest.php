<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\Partner;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminBulkDeleteTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_bulk_delete_categories(): void
    {
        $toDelete = [
            Category::create(['sort_order' => 1]),
            Category::create(['sort_order' => 2]),
        ];
        $toKeep = Category::create(['sort_order' => 3]);

        $this->actingAs($this->createSuperAdmin())
            ->delete(route('admin.categories.bulk-destroy'), [
                'ids' => array_map(fn (Category $category): int => $category->id, $toDelete),
            ])
            ->assertRedirect();

        foreach ($toDelete as $category) {
            $this->assertDatabaseMissing('categories', ['id' => $category->id]);
        }
        $this->assertDatabaseHas('categories', ['id' => $toKeep->id]);
    }

    public function test_bulk_delete_refuses_partners_assigned_to_products(): void
    {
        $linkedPartner = Partner::factory()->create();
        $unlinkedPartner = Partner::factory()->create();
        $category = Category::create([]);
        Product::create([
            'category_id' => $category->id,
            'partner_id' => $linkedPartner->id,
            'sku' => 'LINKED-PARTNER',
            'price' => 100,
        ]);

        $this->actingAs($this->createSuperAdmin())
            ->delete(route('admin.partners.bulk-destroy'), [
                'ids' => [$linkedPartner->id, $unlinkedPartner->id],
            ])
            ->assertSessionHasErrors('ids');

        $this->assertDatabaseHas('partners', ['id' => $linkedPartner->id]);
        $this->assertDatabaseHas('partners', ['id' => $unlinkedPartner->id]);

        $this->actingAs(User::first())
            ->delete(route('admin.partners.bulk-destroy'), ['ids' => [$unlinkedPartner->id]])
            ->assertRedirect();

        $this->assertDatabaseMissing('partners', ['id' => $unlinkedPartner->id]);
    }

    public function test_admin_can_bulk_delete_products(): void
    {
        $category = Category::create([]);
        $toDelete = Product::create([
            'category_id' => $category->id,
            'sku' => 'BULK-DELETE',
            'price' => 100,
        ]);
        $toKeep = Product::create([
            'category_id' => $category->id,
            'sku' => 'BULK-KEEP',
            'price' => 100,
        ]);

        $this->actingAs($this->createSuperAdmin())
            ->delete(route('admin.products.bulk-destroy'), ['ids' => [$toDelete->id]])
            ->assertRedirect();

        $this->assertDatabaseMissing('products', ['id' => $toDelete->id]);
        $this->assertDatabaseHas('products', ['id' => $toKeep->id]);
    }

    public function test_admin_can_bulk_delete_customer_groups_and_unassign_customers(): void
    {
        $toDelete = CustomerGroup::create(['name' => 'Nhóm cần xóa']);
        $toKeep = CustomerGroup::create(['name' => 'Nhóm giữ lại']);
        $customer = Customer::create([
            'customer_group_id' => $toDelete->id,
            'name' => 'Khách hàng',
            'email' => 'customer@example.com',
            'password' => Hash::make('password'),
        ]);

        $this->actingAs($this->createSuperAdmin())
            ->delete(route('admin.customer-groups.bulk-destroy'), ['ids' => [$toDelete->id]])
            ->assertRedirect();

        $this->assertDatabaseMissing('customer_groups', ['id' => $toDelete->id]);
        $this->assertDatabaseHas('customer_groups', ['id' => $toKeep->id]);
        $this->assertDatabaseHas('customers', [
            'id' => $customer->id,
            'customer_group_id' => null,
        ]);
    }

    public function test_admin_can_bulk_delete_customers(): void
    {
        $toDelete = Customer::create([
            'name' => 'Khách cần xóa',
            'email' => 'delete@example.com',
            'password' => Hash::make('password'),
        ]);
        $toKeep = Customer::create([
            'name' => 'Khách giữ lại',
            'email' => 'keep@example.com',
            'password' => Hash::make('password'),
        ]);

        $this->actingAs($this->createSuperAdmin())
            ->delete(route('admin.customers.bulk-destroy'), ['ids' => [$toDelete->id]])
            ->assertRedirect();

        $this->assertDatabaseMissing('customers', ['id' => $toDelete->id]);
        $this->assertDatabaseHas('customers', ['id' => $toKeep->id]);
    }

    public function test_admin_can_bulk_delete_users_but_cannot_delete_the_active_user(): void
    {
        $admin = $this->createSuperAdmin();
        $toDelete = User::factory()->create();
        $toKeep = User::factory()->create();

        $this->actingAs($admin)
            ->delete(route('admin.users.bulk-destroy'), ['ids' => [$toDelete->id]])
            ->assertRedirect();

        $this->assertDatabaseMissing('users', ['id' => $toDelete->id]);
        $this->assertDatabaseHas('users', ['id' => $toKeep->id]);

        $this->delete(route('admin.users.bulk-destroy'), ['ids' => [$admin->id]])
            ->assertSessionHasErrors('ids');

        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    public function test_managed_lists_show_bulk_delete_controls(): void
    {
        $admin = $this->createSuperAdmin();

        foreach ([
            'admin.categories.index',
            'admin.partners.index',
            'admin.products.index',
            'admin.customer-groups.index',
            'admin.customers.index',
            'admin.users.index',
        ] as $routeName) {
            $this->actingAs($admin)
                ->get(route($routeName))
                ->assertOk()
                ->assertSee('Xóa đã chọn')
                ->assertSee('Chọn tất cả trên trang');
        }
    }

    private function createSuperAdmin(): User
    {
        $user = User::factory()->create();
        $role = Role::create(['name' => 'Super Admin', 'slug' => 'super-admin']);
        $user->roles()->attach($role);

        return $user;
    }
}
