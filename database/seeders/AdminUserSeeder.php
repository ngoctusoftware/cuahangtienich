<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('slug', 'admin')->first();        
        $data =  [
            'role_id'           => $adminRole['id'],
            'name'              => 'Quan tri vien',
            'password'          => Hash::make('password'),
            'is_active'         => true,
            'email_verified_at' => now(),
        ];        
        User::firstOrCreate(['email' => 'admin@gmail.com'], $data);
    }
}
