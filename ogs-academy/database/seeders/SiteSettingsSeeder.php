<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            // ===== general =====
            ['key' => 'site_name_ar',  'value' => 'أكاديمية OGS للخدمات التدريبية',  'group' => 'general', 'label_ar' => 'اسم الموقع (عربي)',  'sort_order' => 1],
            ['key' => 'site_name_en',  'value' => 'OGS Academy For Training Services','group' => 'general','label_ar' => 'اسم الموقع (إنجليزي)','sort_order' => 2],
            ['key' => 'site_tagline_ar','value' => 'تحت إشراف المؤسسة العامة للتدريب التقني والمهني','group' => 'general','label_ar' => 'الوسم التعريفي (عربي)','sort_order' => 3],
            ['key' => 'site_tagline_en','value' => 'Under the supervision of the Technical and Vocational Training Corporation','group' => 'general','label_ar' => 'الوسم التعريفي (إنجليزي)','sort_order' => 4],
            ['key' => 'site_logo',     'value' => 'brand/ogs-logo.png',                'type' => 'image','group' => 'general','label_ar' => 'الشعار الأساسي','sort_order' => 5],
            ['key' => 'site_logo_white','value'=> 'brand/ogs-logo-white.png',          'type' => 'image','group' => 'general','label_ar' => 'شعار أبيض (للهيرو)','sort_order' => 6],
            ['key' => 'site_favicon',  'value' => 'brand/favicon.png',                 'type' => 'image','group' => 'general','label_ar' => 'الأيقونة المفضّلة','sort_order' => 7],

            // ===== hero =====
            ['key' => 'hero_kicker',     'value' => 'تدريب مؤسسي معتمد','group' => 'hero','label_ar' => 'تمهيد الهيرو','sort_order' => 1],
            ['key' => 'hero_title_ar',   'value' => 'نحوّل القوى العاملة في القطاع الصناعي إلى كفاءات قادرة على القيادة','group' => 'hero','label_ar' => 'عنوان الهيرو (عربي)','sort_order' => 2],
            ['key' => 'hero_subtitle_ar','value' => 'منصة تدريب متخصصة موجهة للشركات والمؤسسات في قطاعات النفط والغاز والصناعات الثقيلة — برامج مصممة لاحتياجات الميدان وبيد محاضرين معتمدين.','group' => 'hero','label_ar' => 'الوصف الفرعي','sort_order' => 3],
            ['key' => 'hero_cta_primary',  'value' => 'استعرض البرامج', 'group' => 'hero','label_ar' => 'زر رئيسي','sort_order' => 4],
            ['key' => 'hero_cta_secondary','value' => 'اطلب استشارة',   'group' => 'hero','label_ar' => 'زر ثانوي','sort_order' => 5],
            ['key' => 'hero_image',        'value' => 'hero/industrial-1.jpg','type' => 'image','group' => 'hero','label_ar' => 'صورة الخلفية','sort_order' => 6],

            // ===== contact =====
            ['key' => 'contact_email',     'value' => 'info@ogs-academy.com', 'group' => 'contact','label_ar' => 'البريد الإلكتروني','sort_order' => 1],
            ['key' => 'contact_phone',     'value' => '+966 5711 078 03',     'group' => 'contact','label_ar' => 'رقم الهاتف','sort_order' => 2],
            ['key' => 'contact_whatsapp',  'value' => '+966 5711 078 03',     'group' => 'contact','label_ar' => 'رقم واتساب','sort_order' => 3],
            ['key' => 'contact_address_ar','value' => 'مبنى وادي مكة للأعمال — جامعة أم القرى — مكة المكرمة — المملكة العربية السعودية','group' => 'contact','label_ar' => 'العنوان (عربي)','sort_order' => 4],
            ['key' => 'contact_address_en','value' => 'Wadi Makkah Business Building — Umm Al-Qura University — Makkah — KSA','group' => 'contact','label_ar' => 'العنوان (إنجليزي)','sort_order' => 5],
            ['key' => 'contact_map_url',   'value' => 'https://maps.google.com/?q=Umm+Al-Qura+University+Makkah','group' => 'contact','label_ar' => 'رابط الخريطة','sort_order' => 6],
            ['key' => 'work_hours_ar',     'value' => 'الأحد – الخميس · 9 صباحًا – 5 مساءً','group' => 'contact','label_ar' => 'ساعات العمل','sort_order' => 7],

            // ===== about =====
            ['key' => 'about_title_ar',    'value' => 'من نحن', 'group' => 'about','label_ar' => 'عنوان من نحن','sort_order' => 1],
            ['key' => 'about_short_ar',    'value' => 'أكاديمية OGS مؤسسة تدريبية سعودية متخصصة في قطاعات النفط والغاز والصناعات الثقيلة، تحت إشراف المؤسسة العامة للتدريب التقني والمهني. نقدّم برامج موجهة للشركات لرفع كفاءات فرقها الفنية والإدارية وفق أفضل المعايير.','group' => 'about','label_ar' => 'النبذة المختصرة','sort_order' => 2],
            ['key' => 'about_image',       'value' => 'about/building.jpg','type' => 'image','group' => 'about','label_ar' => 'صورة من نحن','sort_order' => 3],

            // ===== stats =====
            ['key' => 'stat_trainees',  'value' => '5400', 'type' => 'number','group' => 'stats','label_ar' => 'عدد المتدربين','sort_order' => 1],
            ['key' => 'stat_programs',  'value' => '42',   'type' => 'number','group' => 'stats','label_ar' => 'عدد البرامج','sort_order' => 2],
            ['key' => 'stat_companies', 'value' => '128',  'type' => 'number','group' => 'stats','label_ar' => 'شركات شريكة','sort_order' => 3],
            ['key' => 'stat_satisfaction','value' => '97', 'type' => 'number','group' => 'stats','label_ar' => 'نسبة الرضا (%)','sort_order' => 4],

            // ===== social =====
            ['key' => 'social_twitter',  'value' => 'https://twitter.com/ogs_academy',  'group' => 'social','label_ar' => 'تويتر','sort_order' => 1],
            ['key' => 'social_linkedin', 'value' => 'https://linkedin.com/company/ogs-academy','group' => 'social','label_ar' => 'لينكدإن','sort_order' => 2],
            ['key' => 'social_instagram','value' => 'https://instagram.com/ogs_academy','group' => 'social','label_ar' => 'إنستجرام','sort_order' => 3],
            ['key' => 'social_youtube',  'value' => '', 'group' => 'social','label_ar' => 'يوتيوب','sort_order' => 4],
            ['key' => 'social_facebook', 'value' => '', 'group' => 'social','label_ar' => 'فيسبوك','sort_order' => 5],

            // ===== seo =====
            ['key' => 'meta_title',       'value' => 'أكاديمية OGS — التدريب الصناعي المعتمد للشركات', 'group' => 'seo','label_ar' => 'عنوان الميتا','sort_order' => 1],
            ['key' => 'meta_description', 'value' => 'برامج تدريبية متخصصة للشركات في قطاعات النفط والغاز والصناعات الثقيلة بإشراف المؤسسة العامة للتدريب التقني والمهني.','group' => 'seo','label_ar' => 'وصف الميتا','sort_order' => 2],
            ['key' => 'meta_keywords',    'value' => 'تدريب صناعي, نفط, غاز, OGS, تدريب الشركات, السعودية, مكة, أمن وسلامة', 'group' => 'seo','label_ar' => 'الكلمات المفتاحية','sort_order' => 3],
        ];

        foreach ($defaults as $row) {
            SiteSetting::updateOrCreate(['key' => $row['key']], $row);
        }
    }
}
