<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $list = [
            [
                'author_name'    => 'م. أحمد العتيبي',
                'author_title'   => 'مدير التدريب والتطوير',
                'author_company' => 'شركة الصناعات البتروكيماوية',
                'quote_ar' => 'وجدنا في أكاديمية OGS شريكاً حقيقياً في رفع كفاءات فرقنا الفنية. البرامج مصممة بدقة لاحتياجات الميدان والمحاضرون من خيرة المختصين.',
                'rating' => 5,
                'sort_order' => 1,
            ],
            [
                'author_name'    => 'سارة الزهراني',
                'author_title'   => 'أخصائي شؤون موظفين أول',
                'author_company' => 'مجموعة الطاقة الوطنية',
                'quote_ar' => 'التزام احترافي وتنظيم متميز. كل تفاصيل الدورة من المحتوى إلى الشهادات تعكس مؤسسية حقيقية.',
                'rating' => 5,
                'sort_order' => 2,
            ],
            [
                'author_name'    => 'م. عبدالله القرشي',
                'author_title'   => 'مدير عمليات',
                'author_company' => 'شركة الأسمنت الإقليمية',
                'quote_ar' => 'بعد إرسال ٢٥ موظفاً لبرنامج الصيانة الوقائية، انخفض وقت التوقف غير المخطط في خطوط الإنتاج بنسبة ملحوظة. استثمار مجزٍ.',
                'rating' => 5,
                'sort_order' => 3,
            ],
        ];

        foreach ($list as $row) {
            Testimonial::updateOrCreate(['author_name' => $row['author_name']], $row);
        }
    }
}
