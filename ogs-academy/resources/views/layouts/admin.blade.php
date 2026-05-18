<!doctype html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'لوحة التحكم') | OGS Academy</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
@vite(['resources/css/app.css', 'resources/js/app.js'])
@stack('head')
</head>
<body class="bg-brand-gray-2 text-brand-ink font-sans antialiased min-h-screen" x-data="{ sidebarOpen: false, newMenuOpen:false, userMenuOpen:false, notifOpen:false, searchOpen:false }">

@php
    $newInquiriesCount = \App\Models\Inquiry::new()->count();
    $unreadMessagesCount = \App\Models\ContactMessage::unread()->count();
    $notifTotal = $newInquiriesCount + $unreadMessagesCount;
@endphp

{{-- ===== Sidebar Overlay (mobile) ===== --}}
<div x-show="sidebarOpen" x-cloak @click="sidebarOpen=false" class="fixed inset-0 z-30 bg-brand-black/60 lg:hidden backdrop-blur-sm"></div>

{{-- ====================== SIDEBAR (WP-Style) ====================== --}}
<aside :class="sidebarOpen ? 'translate-x-0' : 'translate-x-full'"
       class="admin-sidebar fixed top-0 right-0 bottom-0 w-72 bg-brand-black text-white z-40 lg:translate-x-0 transition-transform overflow-y-auto flex flex-col">

    {{-- Brand --}}
    <div class="p-5 border-b border-white/10 flex items-center gap-3">
        <div class="w-11 h-11 rounded-xl bg-white/10 p-1.5 flex items-center justify-center">
            <img src="{{ ($settings['site_logo'] ?? null) ? asset('storage/'.$settings['site_logo']) : asset('images/brand/ogs-logo.png') }}" alt="OGS" class="max-w-full max-h-full object-contain">
        </div>
        <div>
            <p class="text-sm font-extrabold">{{ $settings['site_name_ar'] ?? 'OGS Academy' }}</p>
            <p class="text-xs text-white/50">لوحة التحكم</p>
        </div>
    </div>

    {{-- Nav grouped --}}
    @php
        $iconSvg = [
            'home'      => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="m3 12 9-9 9 9M5 10v10h14V10"/></svg>',
            'book'      => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M12 6.042A8.97 8.97 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/></svg>',
            'tag'       => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z"/><circle cx="6.75" cy="6.75" r=".75" fill="currentColor"/></svg>',
            'inbox'     => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M3 13.125V6.375A3.375 3.375 0 0 1 6.375 3h11.25A3.375 3.375 0 0 1 21 6.375v6.75M3 13.125c0 .621.504 1.125 1.125 1.125h3.151c.464 0 .891.263 1.105.671l1.25 2.39c.213.408.64.671 1.104.671h3.13a1.25 1.25 0 0 0 1.104-.671l1.25-2.39c.213-.408.64-.671 1.104-.671h3.152c.621 0 1.125-.504 1.125-1.125M3 13.125V18a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3v-4.875"/></svg>',
            'mail'      => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 8l9 6 9-6M3 8v10a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V8M3 8a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2"/></svg>',
            'handshake' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="7" r="4"/><path stroke-linecap="round" d="M5.5 21a6.5 6.5 0 0 1 13 0"/></svg>',
            'star'      => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M11.5 3.5 14 9l6 .9-4.5 4.2 1.2 6L11.5 17l-5.2 3 1.2-6L3 9.9 9 9Z"/></svg>',
            'file'      => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M14 3v6h6M14 3H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9l-6-6Z"/></svg>',
            'pencil'    => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m16.86 4.49 2.65 2.65a1.5 1.5 0 0 1 0 2.12l-9.4 9.4a2 2 0 0 1-1.06.55l-3.85.66a.5.5 0 0 1-.58-.58l.66-3.85a2 2 0 0 1 .55-1.06l9.4-9.4a1.5 1.5 0 0 1 2.12 0Z"/></svg>',
            'image'     => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M4 16l4-4 5 5 3-3 4 4M3 5h18a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z"/><circle cx="9" cy="9" r="2"/></svg>',
            'cog'       => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.7 1.7 0 0 0 .3 1.8l.1.1a2 2 0 1 1-2.8 2.8l-.1-.1a1.7 1.7 0 0 0-1.8-.3 1.7 1.7 0 0 0-1 1.5V21a2 2 0 1 1-4 0v-.1a1.7 1.7 0 0 0-1.1-1.5 1.7 1.7 0 0 0-1.8.3l-.1.1A2 2 0 1 1 4.3 17l.1-.1a1.7 1.7 0 0 0 .3-1.8 1.7 1.7 0 0 0-1.5-1H3a2 2 0 1 1 0-4h.1a1.7 1.7 0 0 0 1.5-1.1 1.7 1.7 0 0 0-.3-1.8l-.1-.1a2 2 0 1 1 2.8-2.8l.1.1a1.7 1.7 0 0 0 1.8.3H9a1.7 1.7 0 0 0 1-1.5V3a2 2 0 1 1 4 0v.1a1.7 1.7 0 0 0 1 1.5 1.7 1.7 0 0 0 1.8-.3l.1-.1a2 2 0 1 1 2.8 2.8l-.1.1a1.7 1.7 0 0 0-.3 1.8V9a1.7 1.7 0 0 0 1.5 1H21a2 2 0 1 1 0 4h-.1a1.7 1.7 0 0 0-1.5 1Z"/></svg>',
            'users'     => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path stroke-linecap="round" d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
            'eye'       => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8Z"/><circle cx="12" cy="12" r="3"/></svg>',
        ];
        $sections = [
            'الرئيسية' => [
                ['route' => 'admin.dashboard',  'label' => 'لوحة التحكم', 'icon' => 'home'],
            ],
            'إدارة المحتوى' => [
                ['route' => 'admin.programs.index',    'label' => 'البرامج التدريبية','icon' => 'book',  'pattern' => 'admin.programs.*'],
                ['route' => 'admin.categories.index',  'label' => 'التصنيفات',         'icon' => 'tag',   'pattern' => 'admin.categories.*'],
                ['route' => 'admin.articles.index',    'label' => 'المقالات والأخبار',  'icon' => 'pencil','pattern' => 'admin.articles.*'],
                ['route' => 'admin.pages.index',       'label' => 'إدارة المحتوى',      'icon' => 'file',  'pattern' => 'admin.pages.*'],
            ],
            'التفاعل والتسويق' => [
                ['route' => 'admin.inquiries.index',   'label' => 'طلبات التسجيل',  'icon' => 'inbox', 'pattern' => 'admin.inquiries.*', 'badge' => $newInquiriesCount],
                ['route' => 'admin.messages.index',    'label' => 'الرسائل',        'icon' => 'mail',  'pattern' => 'admin.messages.*',  'badge' => $unreadMessagesCount],
                ['route' => 'admin.testimonials.index','label' => 'آراء العملاء',   'icon' => 'star',  'pattern' => 'admin.testimonials.*'],
                ['route' => 'admin.partners.index',    'label' => 'الشركاء',        'icon' => 'handshake','pattern' => 'admin.partners.*'],
            ],
            'النظام' => [
                ['route' => 'admin.settings.index',    'label' => 'الإعدادات العامة', 'icon' => 'cog',   'pattern' => 'admin.settings.*'],
                ['route' => 'admin.users.index',       'label' => 'المستخدمون',      'icon' => 'users', 'pattern' => 'admin.users.*'],
            ],
        ];
    @endphp

    <nav class="flex-1 p-3 space-y-5 text-sm">
        @foreach($sections as $sectionLabel => $items)
            <div>
                <p class="px-3 mb-2 text-[0.65rem] uppercase tracking-[.2em] text-white/40 font-bold">{{ $sectionLabel }}</p>
                <div class="space-y-1">
                    @foreach($items as $item)
                        @php $isActive = isset($item['pattern']) ? request()->routeIs($item['pattern']) : request()->routeIs($item['route']); @endphp
                        <a href="{{ route($item['route']) }}"
                           class="group flex items-center justify-between gap-3 px-3 py-2.5 rounded-xl transition relative
                                  {{ $isActive ? 'bg-gradient-to-l from-brand-red/20 to-transparent text-white' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                            <span class="flex items-center gap-3">
                                <span class="{{ $isActive ? 'text-brand-flame' : '' }}">{!! $iconSvg[$item['icon']] !!}</span>
                                <span class="font-semibold">{{ $item['label'] }}</span>
                            </span>
                            @if(!empty($item['badge']) && $item['badge'] > 0)
                                <span class="text-[10px] font-bold bg-brand-red px-1.5 py-0.5 rounded-md min-w-[20px] text-center">{{ $item['badge'] }}</span>
                            @endif
                            @if($isActive)
                                <span class="absolute right-0 top-1/2 -translate-y-1/2 h-6 w-0.5 bg-brand-flame rounded-full"></span>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
        @endforeach
    </nav>

    {{-- Footer area --}}
    <div class="p-4 border-t border-white/10 text-sm">
        <a href="{{ route('home') }}" target="_blank" class="flex items-center justify-between gap-2 px-3 py-2 rounded-lg text-white/60 hover:bg-white/5 hover:text-white transition">
            <span class="flex items-center gap-2">{!! $iconSvg['eye'] !!} عرض الموقع</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M14 5l7 7-7 7M3 12h18"/></svg>
        </a>
    </div>
</aside>

{{-- ====================== MAIN ====================== --}}
<div class="lg:mr-72 min-h-screen flex flex-col">

    {{-- ====================== TOPBAR ====================== --}}
    <header class="sticky top-0 z-20 bg-white border-b border-brand-gray">
        <div class="px-4 lg:px-6 py-3 flex items-center justify-between gap-3">
            {{-- Left: title + mobile burger --}}
            <div class="flex items-center gap-3 flex-1 min-w-0">
                <button @click="sidebarOpen=true" class="lg:hidden p-2 rounded-lg hover:bg-brand-gray-2 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5"/></svg>
                </button>
                <div class="min-w-0">
                    <h1 class="text-base lg:text-lg font-extrabold text-brand-ink truncate">@yield('title', 'لوحة التحكم')</h1>
                    @hasSection('subtitle')<p class="text-xs text-brand-ink/60 truncate">@yield('subtitle')</p>@endif
                </div>
            </div>

            {{-- Right: search + + new + notifications + profile --}}
            <div class="flex items-center gap-1.5 lg:gap-2">

                {{-- Search (mobile toggle) --}}
                <button @click="searchOpen=!searchOpen" class="md:hidden p-2 rounded-xl hover:bg-brand-gray-2" aria-label="بحث">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="m21 21-4.3-4.3"/></svg>
                </button>
                {{-- Search desktop --}}
                <form action="{{ route('admin.programs.index') }}" class="hidden md:block relative">
                    <input type="search" name="q" placeholder="بحث في البرامج..."
                           class="w-56 lg:w-64 pl-3 pr-10 py-2 rounded-xl bg-brand-gray-2 border-transparent focus:bg-white focus:border-brand-red focus:ring focus:ring-brand-red/15 text-sm">
                    <svg class="w-4 h-4 absolute right-3 top-3 text-brand-ink/40" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="m21 21-4.3-4.3"/></svg>
                </form>

                {{-- + New menu --}}
                <div class="relative">
                    <button @click="newMenuOpen=!newMenuOpen" class="btn btn-primary !py-2 !px-3 lg:!px-4 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M12 5v14m-7-7h14"/></svg>
                        <span class="hidden md:inline">جديد</span>
                    </button>
                    <div x-show="newMenuOpen" @click.outside="newMenuOpen=false" x-cloak x-transition class="absolute left-0 top-full mt-2 w-56 bg-white border border-brand-gray rounded-2xl shadow-soft p-2 z-30">
                        @php $newItems=[['admin.programs.create','برنامج','book'],['admin.articles.create','مقال','pencil'],['admin.categories.create','تصنيف','tag'],['admin.partners.create','شريك','handshake'],['admin.testimonials.create','رأي عميل','star'],['admin.users.create','مستخدم','users']]; @endphp
                        @foreach($newItems as [$r,$l,$i])
                            <a href="{{ route($r) }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-semibold text-brand-ink hover:bg-brand-red hover:text-white transition">
                                <span class="opacity-70">{!! $iconSvg[$i] !!}</span> {{ $l }}
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Notifications --}}
                <div class="relative">
                    <button @click="notifOpen=!notifOpen" class="p-2 rounded-xl hover:bg-brand-gray-2 relative">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0"/></svg>
                        @if($notifTotal)
                            <span class="absolute top-1 left-1 w-2.5 h-2.5 bg-brand-red rounded-full ring-2 ring-white animate-pulse"></span>
                        @endif
                    </button>
                    <div x-show="notifOpen" @click.outside="notifOpen=false" x-cloak x-transition class="absolute left-0 top-full mt-2 w-80 bg-white border border-brand-gray rounded-2xl shadow-soft z-30 overflow-hidden">
                        <div class="p-4 border-b border-brand-gray flex items-center justify-between">
                            <p class="font-extrabold">الإشعارات</p>
                            <span class="text-xs text-brand-ink/60"><span data-notif-count>{{ $notifTotal }}</span> جديد</span>
                        </div>
                        <div class="divide-y divide-brand-gray max-h-80 overflow-y-auto">
                            @if($newInquiriesCount > 0)
                                <a href="{{ route('admin.inquiries.index') }}" class="block p-4 hover:bg-brand-gray-2 transition">
                                    <p class="font-bold text-sm flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-brand-red"></span> {{ $newInquiriesCount }} طلب جديد</p>
                                    <p class="text-xs text-brand-ink/60 mt-1">طلبات تسجيل في انتظار المراجعة</p>
                                </a>
                            @endif
                            @if($unreadMessagesCount > 0)
                                <a href="{{ route('admin.messages.index') }}" class="block p-4 hover:bg-brand-gray-2 transition">
                                    <p class="font-bold text-sm flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-brand-flame"></span> {{ $unreadMessagesCount }} رسالة جديدة</p>
                                    <p class="text-xs text-brand-ink/60 mt-1">رسائل من صفحة تواصل معنا</p>
                                </a>
                            @endif
                            @if($notifTotal === 0)
                                <p class="p-6 text-center text-sm text-brand-ink/50">لا توجد إشعارات جديدة</p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Profile --}}
                <div class="relative">
                    <button @click="userMenuOpen=!userMenuOpen" class="flex items-center gap-2 p-1 lg:p-2 rounded-xl hover:bg-brand-gray-2 transition">
                        <img src="{{ auth()->user()->avatar_url }}" class="w-8 h-8 rounded-full bg-brand-gray ring-2 ring-brand-red/20" alt="">
                        <div class="hidden lg:block text-right">
                            <p class="text-sm font-bold leading-tight">{{ auth()->user()->name }}</p>
                            <p class="text-[10px] text-brand-ink/60">{{ ['superadmin'=>'سوبر أدمن','admin'=>'أدمن','editor'=>'محرر'][auth()->user()->role] ?? '' }}</p>
                        </div>
                    </button>
                    <div x-show="userMenuOpen" @click.outside="userMenuOpen=false" x-cloak x-transition class="absolute left-0 top-full mt-2 w-60 bg-white border border-brand-gray rounded-2xl shadow-soft p-2 z-30">
                        <div class="px-4 py-3 border-b border-brand-gray mb-2">
                            <p class="font-bold">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-brand-ink/60" dir="ltr">{{ auth()->user()->email }}</p>
                        </div>
                        <a href="{{ route('admin.users.edit', auth()->user()) }}" class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm hover:bg-brand-gray-2 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path stroke-linecap="round" d="M4 21a8 8 0 1 1 16 0"/></svg>
                            ملفي الشخصي
                        </a>
                        <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm hover:bg-brand-gray-2 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 12s4-8 9-8 9 8 9 8-4 8-9 8-9-8-9-8Z"/><circle cx="12" cy="12" r="3"/></svg>
                            عرض الموقع
                        </a>
                        <form method="POST" action="{{ route('admin.logout') }}" class="mt-2 pt-2 border-t border-brand-gray">
                            @csrf
                            <button class="w-full text-right px-4 py-2 rounded-xl hover:bg-red-50 hover:text-red-600 text-sm transition flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 9V5.25A2.25 2.25 0 0 0 12.75 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 6.75 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75"/></svg>
                                تسجيل الخروج
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Mobile search bar (toggleable) --}}
        <div x-show="searchOpen" x-cloak x-transition class="md:hidden px-4 pb-3">
            <form action="{{ route('admin.programs.index') }}" class="relative">
                <input type="search" name="q" placeholder="بحث..." class="w-full pl-3 pr-10 py-2 rounded-xl bg-brand-gray-2 focus:bg-white focus:border-brand-red focus:ring focus:ring-brand-red/15 text-sm">
                <svg class="w-4 h-4 absolute right-3 top-3 text-brand-ink/40" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="m21 21-4.3-4.3"/></svg>
            </form>
        </div>

        {{-- Breadcrumb (optional via section) --}}
        @hasSection('breadcrumb')
            <div class="px-4 lg:px-6 py-2 bg-brand-gray-2/50 border-t border-brand-gray text-xs">
                @yield('breadcrumb')
            </div>
        @endif
    </header>

    {{-- ====================== CONTENT ====================== --}}
    <main class="flex-1 p-4 lg:p-6">
        @if(session('success'))
            <div x-data="{show:true}" x-show="show" x-init="setTimeout(()=>show=false,5000)"
                 class="mb-5 p-4 rounded-xl bg-green-50 border border-green-200 text-green-800 flex items-start justify-between gap-3">
                <p class="flex items-center gap-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="m4.5 12.75 6 6 9-13.5"/></svg> {{ session('success') }}</p>
                <button @click="show=false" class="text-green-700">×</button>
            </div>
        @endif
        @if($errors->any() && !request()->routeIs('admin.login'))
            <div class="mb-5 p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-sm">
                @foreach($errors->all() as $error)<p>• {{ $error }}</p>@endforeach
            </div>
        @endif

        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="border-t border-brand-gray bg-white px-4 lg:px-6 py-3 text-xs text-brand-ink/50 flex items-center justify-between flex-wrap gap-2">
        <p>© {{ now()->year }} OGS Academy — لوحة التحكم</p>
        <p>الإصدار 1.0.0</p>
    </footer>
</div>

{{-- ===== Toast container for new notifications ===== --}}
<div id="admin-notif-toast"
     class="fixed bottom-6 left-6 z-[60] hidden flex-col gap-2 max-w-sm"
     style="display:none;flex-direction:column;"></div>

{{-- ===== Notification polling + sound (Web Audio API; no asset needed) ===== --}}
<script>
(() => {
    const POLL_URL = "{{ route('admin.notifications.count') }}";
    const POLL_INTERVAL_MS = 25_000;  // 25s
    const STORAGE_KEY = 'ogs_notif_baseline_v1';

    // === Sound: a pleasant 2-tone chime via Web Audio API ===
    let audioCtx = null;
    function ensureAudio() {
        if (audioCtx) return audioCtx;
        const C = window.AudioContext || window.webkitAudioContext;
        if (!C) return null;
        audioCtx = new C();
        return audioCtx;
    }
    function playChime() {
        const ctx = ensureAudio();
        if (!ctx) return;
        if (ctx.state === 'suspended') ctx.resume();
        const tones = [
            { f: 880, t: 0,    d: 0.18, g: 0.18 },
            { f: 1175, t: 0.18, d: 0.22, g: 0.16 },
        ];
        tones.forEach(({ f, t, d, g }) => {
            const o = ctx.createOscillator();
            const gn = ctx.createGain();
            o.type = 'sine'; o.frequency.value = f;
            gn.gain.setValueAtTime(0, ctx.currentTime + t);
            gn.gain.linearRampToValueAtTime(g, ctx.currentTime + t + 0.02);
            gn.gain.exponentialRampToValueAtTime(0.0001, ctx.currentTime + t + d);
            o.connect(gn).connect(ctx.destination);
            o.start(ctx.currentTime + t);
            o.stop(ctx.currentTime + t + d + 0.02);
        });
    }

    // Unlock audio on first user interaction (browsers require gesture)
    let audioUnlocked = false;
    const unlock = () => {
        if (audioUnlocked) return;
        const ctx = ensureAudio(); if (!ctx) return;
        if (ctx.state === 'suspended') ctx.resume().then(() => { audioUnlocked = true; });
        else audioUnlocked = true;
    };
    ['click','keydown','touchstart'].forEach(ev => document.addEventListener(ev, unlock, { once: true, passive: true }));

    // === Toast ===
    function showToast({ title, body, href }) {
        const c = document.getElementById('admin-notif-toast');
        if (!c) return;
        c.style.display = 'flex';
        const el = document.createElement('a');
        el.href = href || '#';
        el.className = 'block bg-white border-2 border-brand-red rounded-2xl shadow-soft px-5 py-4 hover:scale-[1.02] transition no-underline text-brand-ink';
        el.style.cssText = 'box-shadow:0 12px 32px rgba(160,24,24,0.25);transform:translateX(-20px);opacity:0;transition:all .3s;';
        el.innerHTML = `
            <div class="flex items-start gap-3">
                <div style="width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,#A01818 0%,#5C0808 100%);color:#fff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0"/></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-extrabold text-sm text-brand-red">${title}</p>
                    <p class="text-xs text-brand-ink/70 mt-1 leading-relaxed">${body}</p>
                </div>
                <button onclick="event.preventDefault();this.closest('a').remove();" class="text-brand-ink/40 hover:text-brand-ink shrink-0 text-lg leading-none">×</button>
            </div>
        `;
        c.prepend(el);
        // Animate in
        setTimeout(() => { el.style.transform='translateX(0)'; el.style.opacity='1'; }, 10);
        // Auto-dismiss after 12s
        setTimeout(() => { el.style.opacity='0'; el.style.transform='translateX(-20px)'; setTimeout(()=>el.remove(), 300); }, 12000);
    }

    // === Polling ===
    async function poll() {
        try {
            const r = await fetch(POLL_URL, { credentials: 'same-origin', headers: { 'Accept': 'application/json' } });
            if (!r.ok) return;
            const data = await r.json();

            // Update header badge counter live
            document.querySelectorAll('[data-notif-count]').forEach(el => { el.textContent = data.total; });

            // Read previous baseline
            let prev;
            try { prev = JSON.parse(sessionStorage.getItem(STORAGE_KEY) || 'null'); } catch (e) { prev = null; }

            if (prev) {
                const newInq = data.latest_inquiry > prev.latest_inquiry;
                const newMsg = data.latest_message > prev.latest_message;
                if (newInq || newMsg) {
                    playChime();
                    if (newInq) showToast({
                        title: '🔔 طلب جديد',
                        body:  'وصلك طلب برنامج جديد من نموذج الموقع. اضغط لعرض التفاصيل.',
                        href:  '{{ route("admin.inquiries.index") }}',
                    });
                    if (newMsg) showToast({
                        title: '📧 رسالة جديدة',
                        body:  'وصلتك رسالة جديدة من صفحة التواصل.',
                        href:  '{{ route("admin.messages.index") }}',
                    });
                }
            }
            sessionStorage.setItem(STORAGE_KEY, JSON.stringify({
                latest_inquiry: data.latest_inquiry,
                latest_message: data.latest_message,
            }));
        } catch (e) {
            // silent
        }
    }

    // Start polling after a small delay so initial baseline is set
    poll();
    setInterval(poll, POLL_INTERVAL_MS);

    // === Manual test: a "test sound" button anyone can wire up ===
    window.ogsTestNotificationSound = () => playChime();
})();
</script>

@stack('scripts')
</body>
</html>
