@php
    $logoWhite = ($settings['site_logo_white'] ?? null) ? asset('storage/'.$settings['site_logo_white']) : asset('images/brand/ogs-logo-white.png');
    $logoDark  = ($settings['site_logo']       ?? null) ? asset('storage/'.$settings['site_logo'])       : asset('images/brand/ogs-logo.png');
    $links = [
        ['url' => route('home'),            'label' => 'الرئيسية',         'active' => request()->routeIs('home')],
        ['url' => route('programs.index'),  'label' => 'البرامج التدريبية', 'active' => request()->routeIs('programs.*')],
        ['url' => route('articles.index'),  'label' => 'المقالات والأخبار', 'active' => request()->routeIs('articles.*')],
        ['url' => route('about'),           'label' => 'من نحن',           'active' => request()->routeIs('about')],
        ['url' => route('contact'),         'label' => 'تواصل معنا',       'active' => request()->routeIs('contact')],
    ];
@endphp

{{-- ===== TOP BAR (slim, supervisor-style strip) ===== --}}
<div class="hidden md:block fixed top-0 inset-x-0 z-[51] bg-brand-black text-white text-xs border-b border-white/5
            transition-all duration-300
            [&[data-hide=true]]:-translate-y-full"
     x-data="{ hidden: false }" x-init="window.addEventListener('scroll', () => { hidden = window.scrollY > 80 }, { passive: true })"
     :data-hide="hidden">
    <div class="container-x flex items-center justify-between h-9">
        <div class="flex items-center gap-5">
            @if(!empty($settings['contact_phone']))
                <a href="tel:{{ $settings['contact_phone'] }}" class="inline-flex items-center gap-1.5 text-white/80 hover:text-brand-flame transition" dir="ltr">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 0 1 2-2h2.3a1 1 0 0 1 .97.76l1.2 4.8a1 1 0 0 1-.27.95l-2 2a16 16 0 0 0 6.29 6.29l2-2a1 1 0 0 1 .95-.27l4.8 1.2a1 1 0 0 1 .76.97V19a2 2 0 0 1-2 2A17 17 0 0 1 3 5Z"/></svg>
                    <span class="font-semibold">{{ $settings['contact_phone'] }}</span>
                </a>
            @endif
            @if(!empty($settings['contact_email']))
                <a href="mailto:{{ $settings['contact_email'] }}" class="hidden sm:inline-flex items-center gap-1.5 text-white/80 hover:text-brand-flame transition" dir="ltr">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l9 6 9-6M3 8v10a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V8"/></svg>
                    {{ $settings['contact_email'] }}
                </a>
            @endif
        </div>
        <div class="flex items-center gap-4 text-white/70">
            <span class="hidden md:inline">تحت إشراف المؤسسة العامة للتدريب التقني والمهني</span>
            @foreach(['twitter','linkedin','instagram','youtube','facebook'] as $sn)
                @if(!empty($settings['social_'.$sn]))
                    <a href="{{ $settings['social_'.$sn] }}" target="_blank" rel="noopener" class="hover:text-brand-flame transition" aria-label="{{ ucfirst($sn) }}">
                        @switch($sn)
                            @case('twitter')   <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231L18.244 2.25Zm-1.161 17.52h1.833L7.084 4.126H5.117L17.083 19.77Z"/></svg> @break
                            @case('linkedin')  <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0H5a5 5 0 0 0-5 5v14a5 5 0 0 0 5 5h14a5 5 0 0 0 5-5V5a5 5 0 0 0-5-5ZM8 19H5V8h3v11ZM6.5 6.732a1.764 1.764 0 1 1 0-3.528 1.764 1.764 0 0 1 0 3.528ZM20 19h-3v-5.604c0-3.368-4-3.113-4 0V19h-3V8h3v1.765C14.396 8.179 20 8.06 20 13.31V19Z"/></svg> @break
                            @case('instagram') <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069ZM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0Zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324ZM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8Zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881Z"/></svg> @break
                            @case('youtube')   <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814ZM9.545 15.568V8.432L15.818 12l-6.273 3.568Z"/></svg> @break
                            @case('facebook')  <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073C24 5.405 18.627 0 12 0S0 5.405 0 12.073C0 18.1 4.388 23.094 10.125 24v-8.437H7.078v-3.49h3.047V9.412c0-3.017 1.792-4.682 4.532-4.682 1.313 0 2.686.235 2.686.235v2.971h-1.513c-1.491 0-1.955.93-1.955 1.886v2.262h3.328l-.532 3.49h-2.796V24C19.612 23.094 24 18.1 24 12.073Z"/></svg> @break
                        @endswitch
                    </a>
                @endif
            @endforeach
        </div>
    </div>
</div>

{{-- ===== MAIN HEADER ===== --}}
<header data-nav x-data="{ open:false }"
        class="fixed inset-x-0 z-50 transition-all duration-300
               top-0 md:top-9 [&.is-scrolled]:!top-0
               [&.is-scrolled]:bg-white/95 [&.is-scrolled]:backdrop-blur-md [&.is-scrolled]:shadow-soft [&.is-scrolled]:border-b [&.is-scrolled]:border-brand-gray
               bg-transparent">

    <div class="container-x flex items-center justify-between gap-4 transition-all duration-300
                h-16 md:h-20 [&.is-scrolled]:h-16">

        {{-- ============ Logo ============ --}}
        <a href="{{ route('home') }}" class="flex items-center gap-3 shrink-0">
            <img src="{{ $logoDark }}"  alt="OGS Academy" class="h-10 md:h-11 transition-all hidden [.is-scrolled_&]:inline-block">
            <img src="{{ $logoWhite }}" alt="OGS Academy" class="h-10 md:h-11 transition-all inline-block [.is-scrolled_&]:hidden">
            <div class="hidden xl:flex flex-col leading-tight border-r-2 border-white/20 [.is-scrolled_&]:border-brand-gray pr-3">
                <span class="text-sm font-extrabold text-white [.is-scrolled_&]:text-brand-ink">أكاديمية OGS</span>
                <span class="text-[10px] text-white/70 [.is-scrolled_&]:text-brand-ink/60 tracking-wider">للخدمات التدريبية</span>
            </div>
        </a>

        {{-- ============ Desktop Nav ============ --}}
        <nav class="hidden lg:flex items-center gap-0.5">
            @foreach($links as $link)
                <a href="{{ $link['url'] }}"
                   class="relative px-3 xl:px-4 py-2 font-semibold text-sm rounded-lg transition-all duration-200 group
                          {{ $link['active']
                              ? 'text-brand-flame [.is-scrolled_&]:text-brand-red'
                              : 'text-white/90 hover:text-white [.is-scrolled_&]:text-brand-ink [.is-scrolled_&]:hover:text-brand-red' }}">
                    {{ $link['label'] }}
                    {{-- Active underline --}}
                    <span class="absolute -bottom-1.5 right-2 left-2 h-[3px] rounded-full transition-all duration-300
                                 {{ $link['active'] ? 'bg-brand-flame [.is-scrolled_&]:bg-brand-red opacity-100 scale-x-100' : 'bg-brand-red opacity-0 scale-x-0 group-hover:opacity-50 group-hover:scale-x-50' }}"></span>
                </a>
            @endforeach
        </nav>

        {{-- ============ CTAs ============ --}}
        <div class="hidden lg:flex items-center gap-3 shrink-0">
            <a href="{{ route('contact') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full font-bold text-sm transition-all duration-200
                      bg-brand-red text-white hover:bg-brand-red-700 hover:scale-105 shadow-brand
                      [.is-scrolled_&]:shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-5v5l3 2"/></svg>
                اطلب استشارة
            </a>
        </div>

        {{-- ============ Mobile burger ============ --}}
        <button @click="open=true" class="lg:hidden p-2 rounded-lg text-white [.is-scrolled_&]:text-brand-ink hover:bg-white/10 [.is-scrolled_&]:hover:bg-brand-gray-2 transition" aria-label="فتح القائمة">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
        </button>
    </div>

    {{-- ============ Mobile Menu Drawer ============ --}}
    <div x-show="open" x-transition.opacity class="fixed inset-0 z-50 bg-brand-black/70 backdrop-blur-sm lg:hidden" @click="open=false" x-cloak></div>
    <aside x-show="open"
           x-transition:enter="transition transform duration-300" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
           x-transition:leave="transition transform duration-200" x-transition:leave-start="translate-x-0"   x-transition:leave-end="-translate-x-full"
           class="fixed top-0 right-0 bottom-0 w-80 max-w-[88vw] bg-white shadow-2xl z-50 lg:hidden flex flex-col" x-cloak>
        {{-- Mobile header --}}
        <div class="p-5 flex items-center justify-between border-b border-brand-gray bg-brand-black text-white">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <img src="{{ $logoWhite }}" class="h-9" alt="OGS Academy">
                <div class="flex flex-col leading-tight">
                    <span class="text-sm font-extrabold">أكاديمية OGS</span>
                    <span class="text-[10px] text-white/60">للخدمات التدريبية</span>
                </div>
            </a>
            <button @click="open=false" class="p-2 rounded-lg hover:bg-white/10 transition" aria-label="إغلاق">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Mobile nav links --}}
        <nav class="p-4 flex-1 overflow-y-auto">
            <div class="text-[10px] uppercase tracking-widest text-brand-ink/40 font-bold mb-2 px-2">القائمة</div>
            <div class="flex flex-col gap-1">
                @foreach($links as $link)
                    <a href="{{ $link['url'] }}"
                       class="flex items-center justify-between px-4 py-3 rounded-xl font-semibold transition group
                              {{ $link['active'] ? 'bg-brand-red text-white shadow-brand' : 'text-brand-ink hover:bg-brand-gray-2' }}">
                        {{ $link['label'] }}
                        <svg class="w-4 h-4 opacity-50 group-hover:opacity-100 transition rotate-180" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M9 5l7 7-7 7"/></svg>
                    </a>
                @endforeach
            </div>

            <a href="{{ route('contact') }}" class="btn btn-primary w-full mt-6">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-5v5l3 2"/></svg>
                اطلب استشارة الآن
            </a>
        </nav>

        {{-- Mobile footer (contact + social) --}}
        <div class="border-t border-brand-gray p-5 bg-brand-gray-2/40 text-sm space-y-3">
            @if(!empty($settings['contact_phone']))
                <a href="tel:{{ $settings['contact_phone'] }}" class="flex items-center gap-3 text-brand-ink hover:text-brand-red transition" dir="ltr">
                    <span class="w-9 h-9 rounded-full bg-brand-red/10 text-brand-red flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 0 1 2-2h2.3a1 1 0 0 1 .97.76l1.2 4.8a1 1 0 0 1-.27.95l-2 2a16 16 0 0 0 6.29 6.29l2-2a1 1 0 0 1 .95-.27l4.8 1.2a1 1 0 0 1 .76.97V19a2 2 0 0 1-2 2A17 17 0 0 1 3 5Z"/></svg>
                    </span>
                    <span class="font-semibold">{{ $settings['contact_phone'] }}</span>
                </a>
            @endif
            @if(!empty($settings['contact_email']))
                <a href="mailto:{{ $settings['contact_email'] }}" class="flex items-center gap-3 text-brand-ink hover:text-brand-red transition text-xs" dir="ltr">
                    <span class="w-9 h-9 rounded-full bg-brand-red/10 text-brand-red flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l9 6 9-6M3 8v10a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V8"/></svg>
                    </span>
                    {{ $settings['contact_email'] }}
                </a>
            @endif
        </div>
    </aside>
</header>

