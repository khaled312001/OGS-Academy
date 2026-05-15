<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    public function run(): void
    {
        $partners = [
            ['name_ar' => 'المؤسسة العامة للتدريب التقني والمهني','name_en' => 'TVTC','logo' => 'partners/tvtc.png','type' => 'supervisor','sort_order' => 1],
            ['name_ar' => 'جامعة أم القرى','name_en' => 'Umm Al-Qura University','logo' => 'partners/uqu.png','type' => 'supervisor','sort_order' => 2],
            ['name_ar' => 'شركة وادي مكة للتقنية','name_en' => 'Wadi Makkah Company For Technology','logo' => 'partners/wadi-makkah.png','type' => 'supervisor','sort_order' => 3],
            ['name_ar' => 'الأكاديمية السعودية','name_en' => 'Saudi Academy','logo' => 'partners/saudi-academy.png','type' => 'partner','sort_order' => 4],
            ['name_ar' => 'شركة شريكة 1','logo' => 'partners/client-1.png','type' => 'partner','sort_order' => 5],
            ['name_ar' => 'شركة شريكة 2','logo' => 'partners/client-2.png','type' => 'partner','sort_order' => 6],
            ['name_ar' => 'شركة شريكة 3','logo' => 'partners/client-3.png','type' => 'partner','sort_order' => 7],
            ['name_ar' => 'شركة شريكة 4','logo' => 'partners/client-4.png','type' => 'partner','sort_order' => 8],
        ];

        foreach ($partners as $row) {
            Partner::updateOrCreate(['name_ar' => $row['name_ar']], $row);
        }
    }
}
