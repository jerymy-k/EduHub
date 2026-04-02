<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'), // default password
            'role' => 'admin',
            'phone' => null,
            'profile_photo' => null,
            'email_verified_at' => now(),
        ]);
    }
}
