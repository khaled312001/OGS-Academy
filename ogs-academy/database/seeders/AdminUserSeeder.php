<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin credentials sourced from environment for security.
        // Set ADMIN_EMAIL and ADMIN_PASSWORD in your .env file before seeding.
        $email    = env('ADMIN_EMAIL', 'admin@ogs-academy.com');
        $password = env('ADMIN_PASSWORD');

        if (empty($password)) {
            $this->command?->warn('⚠️  ADMIN_PASSWORD is not set in .env — using a one-time random password.');
            $password = bin2hex(random_bytes(8));
            $this->command?->warn("   Random admin password: {$password}");
            $this->command?->warn('   Save this password securely and set ADMIN_PASSWORD in .env to override.');
        }

        User::updateOrCreate(
            ['email' => $email],
            [
                'name'              => env('ADMIN_NAME', 'مدير الأكاديمية'),
                'phone'             => env('ADMIN_PHONE', '+966 5711 078 03'),
                'password'          => Hash::make($password),
                'role'              => User::ROLE_SUPER,
                'is_active'         => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
