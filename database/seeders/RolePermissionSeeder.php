<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $groups = [
            'settings'  => ['view', 'update'],
            'contents'  => ['view', 'create', 'update', 'delete'],
            'categories'=> ['view', 'create', 'update', 'delete'],
            'products'  => ['view', 'create', 'update', 'delete'],
            'users'     => ['view', 'create', 'update', 'delete'],
            'orders'    => ['view', 'update'],
            'payments'  => ['view', 'update'],
            'customers' => ['view', 'create', 'update', 'delete'],
            'languages' => ['view', 'create', 'update', 'delete'],
        ];

        $permissionIds = [];
        foreach ($groups as $group => $actions) {
            foreach ($actions as $action) {
                $permission = Permission::updateOrCreate(
                    ['slug' => "{$group}.{$action}"],
                    ['name' => "{$group}.{$action}", 'group' => $group]
                );
                $permissionIds[] = $permission->id;
            }
        }

        $superAdmin = Role::updateOrCreate(['slug' => 'super-admin'], ['name' => 'Super Admin']);
        $superAdmin->permissions()->sync($permissionIds);

        $admin = User::updateOrCreate(
            ['email' => 'admin@zekagency.vn'],
            ['name' => 'Administrator', 'password' => bcrypt('Admin@123'), 'is_active' => true]
        );
        $admin->roles()->syncWithoutDetaching([$superAdmin->id]);
    }
}
