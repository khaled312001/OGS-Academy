<?php

/*
|--------------------------------------------------------------------------
| Admin Pages Registry
|--------------------------------------------------------------------------
| Each entry represents an editable page on the public site.
| Sections group related fields. Each field maps to a key in site_settings.
| For 'about', extra Page DB content fields are exposed alongside.
*/

return [

    'home' => [
        'title'       => 'الصفحة الرئيسية',
        'description' => 'تحرير الهيرو، الإحصائيات، النصوص التعريفية المعروضة على الواجهة.',
        'icon'        => 'home',
        'color'       => '#A01818',
        'preview_url' => '/',
        'cover'       => 'images/brand/hero-industrial.jpg',
        'sections'    => [
            'hero' => [
                'label'       => 'قسم الهيرو',
                'description' => 'القسم الافتتاحي في أعلى الصفحة الرئيسية.',
                'icon'        => 'sparkles',
                'fields' => [
                    ['key' => 'hero_kicker',       'label' => 'تمهيد علوي صغير',  'type' => 'text',     'placeholder' => 'تدريب مؤسسي معتمد'],
                    ['key' => 'hero_title_ar',     'label' => 'العنوان الرئيسي', 'type' => 'textarea', 'rows' => 3],
                    ['key' => 'hero_subtitle_ar',  'label' => 'الوصف الفرعي',    'type' => 'textarea', 'rows' => 4],
                    ['key' => 'hero_cta_primary',  'label' => 'نص الزر الرئيسي', 'type' => 'text',     'cols' => 2],
                    ['key' => 'hero_cta_secondary','label' => 'نص الزر الثانوي', 'type' => 'text',     'cols' => 2],
                    ['key' => 'hero_image',        'label' => 'صورة خلفية الهيرو','type' => 'image'],
                ],
            ],
            'stats' => [
                'label'       => 'الإحصائيات',
                'description' => 'الأرقام المعروضة أسفل الهيرو وفي صفحة من نحن.',
                'icon'        => 'chart',
                'fields' => [
                    ['key' => 'stat_trainees',    'label' => 'عدد المتدربين',   'type' => 'number', 'cols' => 2],
                    ['key' => 'stat_programs',    'label' => 'عدد البرامج',     'type' => 'number', 'cols' => 2],
                    ['key' => 'stat_companies',   'label' => 'شركات شريكة',     'type' => 'number', 'cols' => 2],
                    ['key' => 'stat_satisfaction','label' => 'نسبة الرضا (%)',  'type' => 'number', 'cols' => 2],
                ],
            ],
            'about_strip' => [
                'label'       => 'قسم "لماذا OGS"',
                'description' => 'النص المختصر والصورة الجانبية في الصفحة الرئيسية وصفحة من نحن.',
                'icon'        => 'document',
                'fields' => [
                    ['key' => 'about_short_ar', 'label' => 'النص التعريفي المختصر', 'type' => 'textarea', 'rows' => 4],
                    ['key' => 'about_image',    'label' => 'صورة المنشأة',         'type' => 'image'],
                ],
            ],
        ],
        'cta_links' => [
            ['label' => 'إدارة البرامج المميَّزة', 'route' => 'admin.programs.index', 'icon' => 'book'],
            ['label' => 'إدارة آراء العملاء',     'route' => 'admin.testimonials.index', 'icon' => 'star'],
            ['label' => 'إدارة الشركاء',          'route' => 'admin.partners.index', 'icon' => 'handshake'],
        ],
    ],

    'programs' => [
        'title'       => 'صفحة البرامج التدريبية',
        'description' => 'صفحة قائمة البرامج. المحتوى الفعلي للبرامج يُدار من قسم البرامج التدريبية.',
        'icon'        => 'book',
        'color'       => '#8B0E0E',
        'preview_url' => '/programs',
        'cover'       => 'images/brand/about-1.jpg',
        'sections'    => [],
        'cta_links' => [
            ['label' => 'إدارة البرامج', 'route' => 'admin.programs.index', 'icon' => 'book'],
            ['label' => 'إدارة التصنيفات', 'route' => 'admin.categories.index', 'icon' => 'tag'],
        ],
        'note' => 'يتم عرض البرامج المنشورة من قسم البرامج، مع فلترة حسب التصنيف وبحث. لا توجد إعدادات نصية إضافية لهذه الصفحة حالياً.',
    ],

    'articles' => [
        'title'       => 'صفحة المقالات والأخبار',
        'description' => 'صفحة قائمة المقالات. المحتوى يُدار من قسم المقالات.',
        'icon'        => 'pencil',
        'color'       => '#161616',
        'preview_url' => '/articles',
        'cover'       => 'images/brand/hero-industrial.jpg',
        'sections'    => [],
        'cta_links' => [
            ['label' => 'إدارة المقالات', 'route' => 'admin.articles.index', 'icon' => 'pencil'],
        ],
        'note' => 'يتم عرض المقالات المنشورة من قسم المقالات. لا توجد إعدادات نصية إضافية لهذه الصفحة حالياً.',
    ],

    'about' => [
        'title'        => 'صفحة من نحن',
        'description'  => 'المحتوى التعريفي الكامل: النبذة، الرؤية، الرسالة، القيم، ومميزاتنا.',
        'icon'         => 'file',
        'color'        => '#5C0808',
        'preview_url'  => '/about',
        'cover'        => 'images/brand/about-1.jpg',
        'page_db_slug' => 'about',
        'sections'    => [
            'intro' => [
                'label'       => 'النبذة العامة',
                'description' => 'العنوان والنص التعريفي والصورة الرئيسية.',
                'icon'        => 'document',
                'fields' => [
                    ['key' => 'about_title_ar', 'label' => 'العنوان',         'type' => 'text'],
                    ['key' => 'about_short_ar', 'label' => 'النص التعريفي',   'type' => 'textarea', 'rows' => 4],
                    ['key' => 'about_image',    'label' => 'صورة المنشأة',    'type' => 'image'],
                ],
            ],
        ],
        'page_fields' => [
            ['key' => 'content_ar',  'label' => 'المحتوى الرئيسي (HTML)',     'type' => 'textarea', 'rows' => 10, 'monospace' => true],
            ['key' => 'vision_ar',   'label' => 'الرؤية',                    'type' => 'textarea', 'rows' => 3, 'section_field' => true],
            ['key' => 'mission_ar',  'label' => 'الرسالة',                   'type' => 'textarea', 'rows' => 3, 'section_field' => true],
        ],
        'page_repeaters' => [
            'values' => [
                'label'  => 'القيم المؤسسية',
                'fields' => [
                    ['key' => 'title_ar', 'label' => 'العنوان', 'type' => 'text'],
                    ['key' => 'desc_ar',  'label' => 'الوصف',   'type' => 'textarea', 'rows' => 2],
                ],
            ],
            'why_us' => [
                'label'  => 'لماذا تختار OGS',
                'fields' => [
                    ['key' => 'title_ar', 'label' => 'العنوان', 'type' => 'text'],
                    ['key' => 'desc_ar',  'label' => 'الوصف',   'type' => 'textarea', 'rows' => 2],
                ],
            ],
        ],
    ],

    'contact' => [
        'title'       => 'صفحة تواصل معنا',
        'description' => 'بيانات الاتصال، ساعات العمل، رابط الخريطة، نموذج التواصل.',
        'icon'        => 'mail',
        'color'       => '#E30613',
        'preview_url' => '/contact',
        'cover'       => 'images/brand/hero-industrial.jpg',
        'sections'    => [
            'contact_info' => [
                'label'       => 'بيانات الاتصال',
                'description' => 'هذه البيانات تظهر في صفحة تواصل وفي Footer الموقع.',
                'icon'        => 'mail',
                'fields' => [
                    ['key' => 'contact_email',      'label' => 'البريد الإلكتروني', 'type' => 'text', 'dir' => 'ltr', 'cols' => 2],
                    ['key' => 'contact_phone',      'label' => 'رقم الهاتف',        'type' => 'text', 'dir' => 'ltr', 'cols' => 2],
                    ['key' => 'contact_whatsapp',   'label' => 'رقم واتساب',        'type' => 'text', 'dir' => 'ltr', 'cols' => 2],
                    ['key' => 'work_hours_ar',      'label' => 'ساعات العمل',       'type' => 'text',                'cols' => 2],
                    ['key' => 'contact_address_ar', 'label' => 'العنوان (عربي)',    'type' => 'textarea', 'rows' => 2],
                    ['key' => 'contact_map_url',    'label' => 'رابط الخريطة',      'type' => 'text', 'dir' => 'ltr'],
                ],
            ],
        ],
    ],

    'footer' => [
        'title'       => 'تذييل الموقع (Footer)',
        'description' => 'الشعار، النص التعريفي، حسابات التواصل، يظهر في كل الصفحات.',
        'icon'        => 'file',
        'color'       => '#0A0A0A',
        'preview_url' => '/',
        'cover'       => 'images/brand/hero-industrial.jpg',
        'sections'    => [
            'brand' => [
                'label'       => 'الهوية البصرية',
                'description' => 'الشعار واسم الموقع والسطر التعريفي.',
                'icon'        => 'sparkles',
                'fields' => [
                    ['key' => 'site_name_ar',    'label' => 'اسم الموقع (عربي)',     'type' => 'text', 'cols' => 2],
                    ['key' => 'site_name_en',    'label' => 'اسم الموقع (إنجليزي)',  'type' => 'text', 'cols' => 2, 'dir' => 'ltr'],
                    ['key' => 'site_tagline_ar', 'label' => 'السطر التعريفي',         'type' => 'textarea', 'rows' => 2],
                    ['key' => 'site_logo',       'label' => 'الشعار (للأسطح الفاتحة)','type' => 'image', 'cols' => 2],
                    ['key' => 'site_logo_white', 'label' => 'الشعار (للأسطح الداكنة)','type' => 'image', 'cols' => 2],
                    ['key' => 'site_favicon',    'label' => 'أيقونة المتصفح (favicon)','type' => 'image'],
                ],
            ],
            'social' => [
                'label'       => 'حسابات التواصل',
                'description' => 'روابط الحسابات تظهر في Footer.',
                'icon'        => 'star',
                'fields' => [
                    ['key' => 'social_twitter',   'label' => 'تويتر / X',    'type' => 'text', 'dir' => 'ltr', 'cols' => 2],
                    ['key' => 'social_linkedin',  'label' => 'لينكدإن',      'type' => 'text', 'dir' => 'ltr', 'cols' => 2],
                    ['key' => 'social_instagram', 'label' => 'إنستجرام',     'type' => 'text', 'dir' => 'ltr', 'cols' => 2],
                    ['key' => 'social_youtube',   'label' => 'يوتيوب',       'type' => 'text', 'dir' => 'ltr', 'cols' => 2],
                ],
            ],
            'seo' => [
                'label'       => 'تحسين محركات البحث',
                'description' => 'بيانات الميتا الافتراضية لكل صفحات الموقع.',
                'icon'        => 'document',
                'fields' => [
                    ['key' => 'meta_title',       'label' => 'Meta Title',       'type' => 'text'],
                    ['key' => 'meta_description', 'label' => 'Meta Description', 'type' => 'textarea', 'rows' => 2],
                    ['key' => 'meta_keywords',    'label' => 'Meta Keywords',    'type' => 'text'],
                ],
            ],
        ],
    ],
];
