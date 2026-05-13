<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@rbac.com'],
            [
                'name'     => 'Admin User',
                'password' => Hash::make('Admin@12345'),
            ]
        );
        $admin->assignRole('Admin');

        $manager = User::firstOrCreate(
            ['email' => 'manager@rbac.com'],
            [
                'name'     => 'Manager User',
                'password' => Hash::make('Manager@12345'),
            ]
        );
        $manager->assignRole('Manager');

        $customer = User::firstOrCreate(
            ['email' => 'customer@rbac.com'],
            [
                'name'     => 'Customer User',
                'password' => Hash::make('Customer@12345'),
            ]
        );
        $customer->assignRole('Customer');
    }
}