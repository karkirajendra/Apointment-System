<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\BusinessOwner;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        BusinessOwner::firstOrCreate(
            ['username' => 'admin'],
            [
                'business_name' => 'Hospital Admin',
                'firstname' => 'Admin',
                'lastname' => 'User',
                'password' => bcrypt('AdminPass123!'),
                'address' => '1 Admin Street',
                'phone' => '0000000000',
            ]
        );
    }
}
