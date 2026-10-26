<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Owner Gerai
        User::updateOrCreate(
            ['email' => 'owner@electrohub.com'],
            [
                'name' => 'Owner ElectroHub',
                'password' => Hash::make('password123'),
                'role' => 'owner',
            ]
        );

        // 2. Staff Kasir
        User::updateOrCreate(
            ['email' => 'staff@electrohub.com'],
            [
                'name' => 'Staff Kasir 1',
                'password' => Hash::make('password123'),
                'role' => 'staff',
            ]
        );

        // 3. Akun Customer
        User::updateOrCreate(
            ['email' => 'customer@electrohub.com'],
            [
                'name' => 'Pelanggan Setia',
                'password' => Hash::make('password123'),
                'role' => 'customer',
            ]
        );
    }
}