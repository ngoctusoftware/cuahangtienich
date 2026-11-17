<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Partner::updateOrCreate(
            ['name' => 'Đối tác mẫu'],
            [
                'contact_name' => 'Bộ phận kinh doanh',
                'phone' => '0900000000',
                'email' => 'partner@example.com',
                'address' => 'Việt Nam',
                'notes' => 'Đối tác mẫu để bắt đầu quản lý.',
                'is_active' => true,
            ]
        );
    }
}
