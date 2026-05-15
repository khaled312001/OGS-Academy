<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            SiteSettingsSeeder::class,
            ProgramCategorySeeder::class,
            ProgramSeeder::class,
            PartnerSeeder::class,
            TestimonialSeeder::class,
            PageSeeder::class,
            ArticleSeeder::class,
        ]);
    }
}
