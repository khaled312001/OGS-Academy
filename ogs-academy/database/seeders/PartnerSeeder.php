<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    public function run(): void
    {
        // Remove old placeholder partners that no longer have files
        Partner::whereIn('name_ar', ['شركة شريكة 1', 'شركة شريكة 2', 'شركة شريكة 3', 'شركة شريكة 4'])
            ->delete();

        $partners = [
            ['name_ar' => 'المؤسسة العامة للتدريب التقني والمهني', 'name_en' => 'TVTC',                              'logo' => 'partners/tvtc.jpg',         'type' => 'supervisor', 'sort_order' => 1],
            ['name_ar' => 'جامعة أم القرى',                        'name_en' => 'Umm Al-Qura University',            'logo' => 'partners/uqu.jpg',          'type' => 'supervisor', 'sort_order' => 2],
            ['name_ar' => 'شركة وادي مكة للتقنية',                  'name_en' => 'Wadi Makkah Company For Technology', 'logo' => 'partners/wadi-makkah.jpg',  'type' => 'supervisor', 'sort_order' => 3],
            ['name_ar' => 'الأكاديمية السعودية',                    'name_en' => 'Saudi Academy',                     'logo' => 'partners/saudi-academy.jpg', 'type' => 'partner',    'sort_order' => 4],
        ];

        foreach ($partners as $row) {
            Partner::updateOrCreate(['name_ar' => $row['name_ar']], $row);
        }
    }
}
