<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@casaamaryllis.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true
        ]);

        // Create regular users
        User::factory()->count(5)->create([
            'role' => 'customer',
            'is_active' => true
        ]);
    }
}
