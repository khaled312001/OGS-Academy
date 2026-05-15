<?php

namespace Database\Seeders;

use App\Models\ProgramCategory;
use Illuminate\Database\Seeder;

class ProgramCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name_ar' => 'الأمن والسلامة الصناعية',
                'name_en' => 'Industrial Safety',
                'slug'    => 'safety',
                'description_ar' => 'برامج معتمدة في معايير السلامة المهنية والوقاية من الحوادث في بيئات العمل الصناعية.',
                'icon'    => 'shield-check',
                'color'   => '#E30613',
                'sort_order' => 1,
            ],
            [
                'name_ar' => 'النفط والغاز',
                'name_en' => 'Oil & Gas',
                'slug'    => 'oil-gas',
                'description_ar' => 'برامج تقنية وإدارية متخصصة في عمليات التكرير والإنتاج والصيانة في قطاع النفط والغاز.',
                'icon'    => 'flame',
                'color'   => '#A01818',
                'sort_order' => 2,
            ],
            [
                'name_ar' => 'الصيانة الصناعية',
                'name_en' => 'Industrial Maintenance',
                'slug'    => 'maintenance',
                'description_ar' => 'صيانة المعدات الميكانيكية والكهربائية وتطبيق برامج الصيانة الوقائية وتشخيص الأعطال.',
                'icon'    => 'wrench',
                'color'   => '#0A0A0A',
                'sort_order' => 3,
            ],
            [
                'name_ar' => 'الجودة والاعتماد',
                'name_en' => 'Quality & Compliance',
                'slug'    => 'quality',
                'description_ar' => 'تطبيق أنظمة الجودة الدولية ISO وتدقيق العمليات الصناعية.',
                'icon'    => 'badge-check',
                'color'   => '#C9A876',
                'sort_order' => 4,
            ],
            [
                'name_ar' => 'القيادة والإدارة',
                'name_en' => 'Leadership & Management',
                'slug'    => 'leadership',
                'description_ar' => 'تنمية مهارات القيادة الإدارية وإدارة الفرق الفنية في البيئات الصناعية.',
                'icon'    => 'users',
                'color'   => '#5C0808',
                'sort_order' => 5,
            ],
            [
                'name_ar' => 'المهارات الفنية',
                'name_en' => 'Technical Skills',
                'slug'    => 'technical',
                'description_ar' => 'برامج مهارات تشغيلية وفنية أساسية للموظفين الجدد والمستويات المتوسطة.',
                'icon'    => 'cog',
                'color'   => '#161616',
                'sort_order' => 6,
            ],
        ];

        foreach ($categories as $cat) {
            ProgramCategory::updateOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}
