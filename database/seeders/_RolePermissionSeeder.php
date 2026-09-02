<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['name' => 'Quan ly nguoi dung', 'slug' => 'users.manage'],
            ['name' => 'Quan ly phan quyen', 'slug' => 'roles.manage'],
            ['name' => 'Quan ly san pham', 'slug' => 'products.manage'],
            ['name' => 'Quan ly don hang', 'slug' => 'orders.manage'],
            ['name' => 'Quan ly thanh toan', 'slug' => 'payments.manage'],
        ];

        foreach ($permissions as $p) {
            Permission::firstOrCreate(['slug' => $p['slug']], $p);
        }

        $admin = Role::firstOrCreate(
            ['slug' => 'admin'],
            ['name' => 'Quan tri vien', 'description' => 'Toan quyen he thong']
        );
        $admin->permissions()->sync(Permission::pluck('id'));

        $staff = Role::firstOrCreate(
            ['slug' => 'staff'],
            ['name' => 'Nhan vien', 'description' => 'Quan ly san pham, don hang, thanh toan']
        );
        $staff->permissions()->sync(
            Permission::whereIn('slug', ['products.manage', 'orders.manage', 'payments.manage'])->pluck('id')
        );

        Role::firstOrCreate(
            ['slug' => 'customer'],
            ['name' => 'Khach hang', 'description' => 'Nguoi dung mua hang tren website']
        );
    }
}
