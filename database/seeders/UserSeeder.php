<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin default
        User::create([
            'name' => 'Admin Dinsos',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // Operator Desa default
        User::create([
            'name' => 'Operator Desa Maju',
            'email' => 'desa@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'desa',
        ]);
    }
}
