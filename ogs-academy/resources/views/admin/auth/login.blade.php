<!doctype html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>تسجيل الدخول | لوحة تحكم OGS</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-brand-black text-white relative overflow-hidden flex items-center">

{{-- Background pattern --}}
<div class="absolute inset-0 -z-10">
    <div class="absolute inset-0 bg-gradient-to-tr from-brand-red-900 via-brand-black to-brand-black"></div>
    <div class="absolute -top-32 -right-32 w-96 h-96 rounded-full bg-brand-red/40 blur-3xl"></div>
    <div class="absolute -bottom-32 -left-32 w-96 h-96 rounded-full bg-brand-flame/20 blur-3xl"></div>
</div>

<div class="container-x grid lg:grid-cols-2 gap-12 items-center py-10">
    {{-- Brand side --}}
    <div class="hidden lg:block">
        <img src="{{ ($settings['site_logo_white'] ?? null) ? asset('storage/'.$settings['site_logo_white']) : asset('images/brand/ogs-logo-white.png') }}" alt="OGS" class="h-16 mb-8">
        <h1 class="text-5xl font-extrabold leading-tight mb-4">لوحة التحكم</h1>
        <p class="text-white/70 text-lg max-w-md leading-relaxed mb-12">إدارة كاملة لمحتوى الموقع — البرامج، الاستفسارات، الإعدادات، والمزيد.</p>
        <div class="flex gap-3">
            <span class="flame-bar"></span>
            <p class="text-sm text-white/50">تحت إشراف المؤسسة العامة للتدريب التقني والمهني</p>
        </div>
    </div>

    {{-- Form card --}}
    <div class="w-full max-w-md mx-auto">
        <div class="rounded-3xl bg-white text-brand-ink p-8 md:p-10 shadow-2xl">
            <div class="text-center mb-8 lg:hidden">
                <img src="{{ ($settings['site_logo'] ?? null) ? asset('storage/'.$settings['site_logo']) : asset('images/brand/ogs-logo.png') }}" alt="OGS" class="h-14 mx-auto mb-4">
            </div>
            <h2 class="text-2xl font-extrabold mb-2">تسجيل الدخول</h2>
            <p class="text-brand-ink/60 text-sm mb-8">أدخل بيانات الدخول للوصول إلى لوحة التحكم.</p>

            @if($errors->any())
                <div class="mb-5 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-bold mb-2">البريد الإلكتروني</label>
                    <input type="email" name="email" value="{{ old('email') }}" required dir="ltr"
                           class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">
                </div>
                <div>
                    <label class="block text-sm font-bold mb-2">كلمة المرور</label>
                    <input type="password" name="password" required
                           class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">
                </div>
                <label class="flex items-center gap-2 text-sm select-none">
                    <input type="checkbox" name="remember" class="rounded text-brand-red focus:ring-brand-red border-brand-gray"> تذكّرني
                </label>
                <button type="submit" class="btn btn-primary w-full mt-2">دخول لوحة التحكم</button>
            </form>

            <p class="text-xs text-center text-brand-ink/40 mt-8">
                © {{ now()->year }} OGS Academy
            </p>
        </div>
    </div>
</div>

</body>
</html>
