# OGS Academy — موقع أكاديمي + لوحة تحكم

موقع تعريفي ولوحة تحكم لأكاديمية **OGS** للخدمات التدريبية في مكة المكرّمة، تحت إشراف المؤسسة العامة للتدريب التقني والمهني.

## ✨ المزايا

### الواجهة العامة (B2B)
- 🏠 صفحة رئيسية ديناميكية مع هيرو، شريط ثقة، إحصائيات، تصنيفات، برامج مميَّزة
- 📚 صفحة برامج تدريبية مع فلتر بالتصنيف وبحث + صفحات تفاصيل لكل برنامج
- 📰 قسم مقالات وأخبار كامل بتصنيفات
- ℹ️ صفحة "من نحن" قابلة للتحرير الكامل
- 📞 صفحة تواصل + استمارة استفسار B2B لكل برنامج
- 🌐 SEO كامل: meta tags + Open Graph + Twitter Cards + JSON-LD + sitemap.xml + robots.txt

### لوحة التحكم
- 🔐 نظام صلاحيات (Super / Admin / Editor)
- 📊 Dashboard بإحصائيات وأنشطة
- ✏️ إدارة برامج (CRUD كامل + محاور + مخرجات تعلم + متطلبات)
- 📝 إدارة مقالات (CRUD مع تصنيفات + tags + featured + جدولة نشر)
- 🏷️ إدارة تصنيفات
- 📥 طلبات تسجيل مع فلتر B2B / فردي + تصدير CSV
- 💬 رسائل تواصل
- 🤝 إدارة شركاء + جهات إشراف
- ⭐ آراء العملاء
- 📄 إدارة محتوى كل صفحة بكل أقسامها وصورها
- ⚙️ إعدادات الموقع الكاملة بـ tabs

## 🛠️ التقنيات

- **Backend:** Laravel 12 + PHP 8.2 + MySQL/MariaDB
- **Frontend:** Blade + Tailwind CSS v4 + Alpine.js + AOS + GSAP
- **Admin:** نظام صلاحيات RBAC + WordPress-style sidebar
- **i18n:** RTL عربي primary + إنجليزي optional

## 🚀 التشغيل المحلي

### المتطلبات
- PHP 8.2+ مع extensions: `zip`, `pdo_mysql`, `mbstring`, `openssl`, `gd`, `intl`
- Composer 2.x
- Node.js 18+ مع npm
- MySQL 8 أو MariaDB 10.4+

### الخطوات

```bash
# 1) تثبيت Composer dependencies
composer install

# 2) تثبيت npm dependencies
npm install

# 3) نسخ ملف البيئة + توليد المفتاح
cp .env.example .env
php artisan key:generate

# 4) عدّل DB_DATABASE / DB_USERNAME / DB_PASSWORD + ADMIN_PASSWORD في .env

# 5) إنشاء قاعدة البيانات
mysql -u root -e "CREATE DATABASE ogs_academy CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# 6) تشغيل migrations + seeders
php artisan migrate --seed

# 7) ربط مجلد التخزين بالـ public
php artisan storage:link

# 8) بناء الواجهة
npm run build

# 9) تشغيل السيرفر
php artisan serve
```

افتح: `http://127.0.0.1:8000`
لوحة التحكم: `http://127.0.0.1:8000/admin/login`
(بيانات الدخول من `ADMIN_EMAIL` و `ADMIN_PASSWORD` في `.env`)

## 📁 هيكل المشروع

```
app/
├── Http/
│   ├── Controllers/         # Public + Admin\* controllers
│   ├── Middleware/          # AdminMiddleware
│   └── Requests/            # FormRequests للتحقق
├── Models/                  # Eloquent models
└── Providers/               # ViewServiceProvider لمشاركة settings عبر الـ views

config/admin_pages.php       # سجل الصفحات القابلة للتحرير من لوحة التحكم

database/
├── migrations/              # 14 migration
└── seeders/                 # 8 seeders (مع OGS brand defaults)

resources/
├── css/app.css              # Tailwind v4 + design tokens
├── js/app.js                # Alpine + AOS + GSAP + UX scripts
└── views/
    ├── layouts/             # app + admin layouts
    ├── components/          # header, footer, program-card, partners-section, seo
    ├── pages/               # public pages
    └── admin/               # admin CRUDs + dashboard + pages editor
```

## 🎨 الهوية البصرية

- **اللون الأساسي:** `#A01818` (Brand Red)
- **اللهب:** `#E30613` (Accent Flame)
- **الأسود:** `#0A0A0A`
- **الخطوط:** Cairo (عربي) + Inter (إنجليزي)
- **الأسلوب:** صناعي/مؤسسي — صور مصانع وبيئات صناعية ثقيلة

## 🔒 الأمان للإنتاج

قبل النشر:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com
SESSION_SECURE_COOKIE=true
ADMIN_PASSWORD=<strong-random-password>
MAIL_MAILER=smtp
```

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 📄 الترخيص

ملكية خاصة بـ **أكاديمية OGS للخدمات التدريبية**.
الكود مطوَّر بواسطة [Khaled Ahmed](https://khaledahmed.net) ([Barmagly](https://github.com/khaled312001)).
