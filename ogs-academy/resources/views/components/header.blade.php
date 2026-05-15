@php
    $logo = ($settings['site_logo_white'] ?? null) ? asset('storage/'.$settings['site_logo_white']) : asset('images/brand/ogs-logo-white.png');
    $logoDark = ($settings['site_logo'] ?? null) ? asset('storage/'.$settings['site_logo']) : asset('images/brand/ogs-logo.png');
@endphp
<header
    data-nav
    x-data="{ open:false }"
    class="fixed top-0 inset-x-0 z-50 transition-all duration-300
           [&.is-scrolled]:bg-white [&.is-scrolled]:shadow-soft [&.is-scrolled]:py-2
           bg-transparent py-4">
    <div class="container-x flex items-center justify-between gap-6">
        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex items-center gap-3 group">
            <img src="{{ $logoDark }}" alt="OGS" class="h-10 md:h-12 transition-all hidden [.is-scrolled_&]:inline-block">
            <img src="{{ $logo }}"     alt="OGS" class="h-10 md:h-12 transition-all inline-block [.is-scrolled_&]:hidden">
        </a>

        {{-- Desktop Nav --}}
        <nav class="hidden lg:flex items-center gap-1">
            @php
                $links = [
                    ['url' => route('home'),            'label' => 'الرئيسية',         'active' => request()->routeIs('home')],
                    ['url' => route('programs.index'),  'label' => 'البرامج التدريبية', 'active' => request()->routeIs('programs.*')],
                    ['url' => route('articles.index'),  'label' => 'المقالات والأخبار', 'active' => request()->routeIs('articles.*')],
                    ['url' => route('about'),           'label' => 'من نحن',           'active' => request()->routeIs('about')],
                    ['url' => route('contact'),         'label' => 'تواصل معنا',       'active' => request()->routeIs('contact')],
                ];
            @endphp
            @foreach($links as $link)
                <a href="{{ $link['url'] }}"
                   class="relative px-4 py-2 font-semibold text-sm rounded-full transition
                          {{ $link['active'] ? 'text-brand-red' : 'text-white [.is-scrolled_&]:text-brand-ink hover:text-brand-red' }}">
                    {{ $link['label'] }}
                    @if($link['active'])
                        <span class="absolute -bottom-0.5 right-4 left-4 h-0.5 bg-brand-red rounded-full"></span>
                    @endif
                </a>
            @endforeach
        </nav>

        {{-- CTA --}}
        <div class="hidden lg:flex items-center gap-3">
            @if(!empty($settings['contact_phone']))
                <a href="tel:{{ $settings['contact_phone'] }}" class="text-sm font-semibold text-white [.is-scrolled_&]:text-brand-ink hover:text-brand-red transition flex items-center gap-2">
                    <span class="w-9 h-9 rounded-full bg-white/10 [.is-scrolled_&]:bg-brand-red/10 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 0 1 2-2h2.3a1 1 0 0 1 .97.76l1.2 4.8a1 1 0 0 1-.27.95l-2 2a16 16 0 0 0 6.29 6.29l2-2a1 1 0 0 1 .95-.27l4.8 1.2a1 1 0 0 1 .76.97V19a2 2 0 0 1-2 2A17 17 0 0 1 3 5Z"/></svg>
                    </span>
                    <span dir="ltr">{{ $settings['contact_phone'] }}</span>
                </a>
            @endif
            <a href="{{ route('contact') }}" class="btn btn-primary text-sm">اطلب استشارة</a>
        </div>

        {{-- Mobile burger --}}
        <button @click="open=true" class="lg:hidden text-white [.is-scrolled_&]:text-brand-ink p-2" aria-label="فتح القائمة">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
        </button>
    </div>

    {{-- Mobile menu --}}
    <div x-show="open" x-transition.opacity class="fixed inset-0 z-50 bg-brand-black/80 lg:hidden" @click="open=false" x-cloak></div>
    <aside x-show="open" x-transition:enter="transition transform" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
           x-transition:leave="transition transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
           class="fixed top-0 right-0 bottom-0 w-72 max-w-[85vw] bg-white shadow-2xl z-50 lg:hidden" x-cloak>
        <div class="p-6 flex items-center justify-between border-b border-brand-gray">
            <img src="{{ $logoDark }}" class="h-10" alt="OGS">
            <button @click="open=false" class="p-2 text-brand-ink"><svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <nav class="p-4 flex flex-col gap-1">
            @foreach($links as $link)
                <a href="{{ $link['url'] }}"
                   class="px-4 py-3 rounded-xl font-semibold transition {{ $link['active'] ? 'bg-brand-red/10 text-brand-red' : 'text-brand-ink hover:bg-brand-gray-2' }}">
                    {{ $link['label'] }}
                </a>
            @endforeach
            <a href="{{ route('contact') }}" class="btn btn-primary mt-4">اطلب استشارة</a>
            @if(!empty($settings['contact_phone']))
                <a href="tel:{{ $settings['contact_phone'] }}" class="mt-3 text-sm text-brand-ink/70 px-4">
                    <span dir="ltr">{{ $settings['contact_phone'] }}</span>
                </a>
            @endif
        </nav>
    </aside>
</header>
