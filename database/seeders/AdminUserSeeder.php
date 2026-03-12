<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admins = [
            [
                'name' => 'Admin User',
                'email' => 'admin@dreamscape.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@dreamscape.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],
            [
                'name' => 'Game Master',
                'email' => 'gamemaster@dreamscape.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],
        ];

        foreach ($admins as $admin) {
            User::create($admin);
        }

        $this->command->info('3 beheerders zijn aangemaakt!');
    }
}
