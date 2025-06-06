<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = 'john@admin.com';
        User::updateOrCreate(
            ['email' => $email],
            [
                'first_name'    => 'John',
                'last_name'     => 'Doe',
                'username'      => 'admin',
                'email'         => $email,
                'password'      => Hash::make('pAssword123@'),
                'is_admin'      => 1,
                'address'       => 'Quezon City, Metro Manila',
                'postcode'      => '1234',
                'contact_phone' => '09123456789',
            ]
        );
    }
}
