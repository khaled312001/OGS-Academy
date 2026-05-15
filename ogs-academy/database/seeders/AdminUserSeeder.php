<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@ogs-academy.com'],
            [
                'name'      => 'مدير الأكاديمية',
                'phone'     => '+966 5711 078 03',
                'password'  => Hash::make('OgsAdmin@2026'),
                'role'      => User::ROLE_SUPER,
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
