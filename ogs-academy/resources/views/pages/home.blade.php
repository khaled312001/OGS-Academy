@extends('layouts.app')

@section('content')

{{-- ========================= HERO ========================= --}}
<section class="relative min-h-[88svh] lg:min-h-screen flex items-center overflow-hidden">
    {{-- Background image (visible) --}}
    @php $heroImg = ($settings['hero_image'] ?? null) ? asset('storage/'.$settings['hero_image']) : asset('images/brand/hero-industrial.jpg'); @endphp
    <div class="absolute inset-0 bg-cover bg-center scale-110" data-hero-bg style="background-image:url('{{ $heroImg }}')"></div>

    {{-- Gradient overlays (stronger on mobile to hide image watermarks) --}}
    <div class="absolute inset-0 bg-gradient-to-l from-brand-black/90 via-brand-red-900/85 to-brand-black/85 lg:from-brand-black/75 lg:via-brand-red-900/55 lg:to-brand-black/60"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-brand-black/90 via-brand-black/40 to-brand-black/30 lg:from-brand-black/80 lg:via-brand-black/20 lg:to-transparent"></div>
    <div class="absolute inset-0 bg-brand-black/40 lg:bg-transparent"></div>
    <div class="hidden lg:block absolute inset-0" style="background: radial-gradient(ellipse at 70% 40%, rgba(227,6,19,0.18) 0%, transparent 60%);"></div>

    {{-- Decorative flame motifs (desktop only) --}}
    <div class="hidden lg:block absolute left-12 top-1/3 w-1 h-28 bg-flame-gradient rounded-full animate-flame-flicker opacity-70 z-10"></div>
    <div class="hidden lg:block absolute right-1/3 top-1/4 w-px h-20 bg-flame-gradient rounded-full opacity-40 animate-flame-flicker z-10" style="animation-delay:.8s"></div>

    <div class="container-x relative z-10 w-full pt-28 pb-12 sm:pt-32 sm:pb-16 lg:pt-36 lg:pb-24 text-white">
        <div class="max-w-3xl">

            {{-- Badges row --}}
            <div class="flex flex-wrap gap-2 mb-5 sm:mb-7" data-aos="fade-up">
                <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur border border-white/20 rounded-full px-3 py-1.5 sm:px-4 sm:py-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-brand-flame animate-pulse"></span>
                    <span class="text-xs sm:text-sm font-semibold">{{ $settings['hero_kicker'] ?? 'تدريب مؤسسي معتمد' }}</span>
                </div>
                <div class="inline-flex items-center gap-1.5 bg-brand-red border border-brand-flame/60 rounded-full px-3 py-1.5 sm:px-4 sm:py-2">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 21V9l9-6 9 6v12M9 21V12h6v9"/></svg>
                    <span class="text-xs sm:text-sm font-bold whitespace-nowrap">B2B · للشركات</span>
                </div>
            </div>

            {{-- Title --}}
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-extrabold leading-[1.15] mb-4 sm:mb-6 text-balance"
                data-aos="fade-up" data-aos-delay="100">
                {{ $settings['hero_title_ar'] ?? 'نحوّل القوى العاملة في القطاع الصناعي إلى كفاءات قادرة على القيادة' }}
            </h1>

            {{-- Subtitle --}}
            <p class="text-base sm:text-lg lg:text-xl text-white/85 max-w-2xl leading-relaxed mb-7 sm:mb-9"
               data-aos="fade-up" data-aos-delay="200">
                {{ $settings['hero_subtitle_ar'] ?? 'منصة تدريب متخصصة موجهة للشركات والمؤسسات في قطاعات النفط والغاز والصناعات الثقيلة.' }}
            </p>

            {{-- CTA buttons --}}
            <div class="flex flex-col sm:flex-row gap-3 mb-10 sm:mb-12 lg:mb-16"
                 data-aos="fade-up" data-aos-delay="300">
                <a href="{{ route('programs.index') }}" class="btn bg-white text-brand-red hover:bg-brand-gray w-full sm:w-auto justify-center">
                    {{ $settings['hero_cta_primary'] ?? 'استعرض البرامج' }}
                    <svg class="w-4 h-4 -rotate-180" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="{{ route('contact') }}" class="btn btn-ghost w-full sm:w-auto justify-center">
                    {{ $settings['hero_cta_secondary'] ?? 'اطلب استشارة' }}
                </a>
            </div>

            {{-- Trust strip: under supervision of (mini logos) --}}
            @php $supLogos = ($footerPartners ?? collect())->where('type','supervisor')->take(3); @endphp
            @if($supLogos->count())
                <div class="hidden md:flex items-center gap-5 pt-6 border-t border-white/10 max-w-2xl"
                     data-aos="fade-up" data-aos-delay="350">
                    <span class="text-[11px] uppercase tracking-[.2em] text-white/50 font-bold whitespace-nowrap">تحت إشراف</span>
                    <div class="flex items-center gap-5 flex-wrap">
                        @foreach($supLogos as $p)
                            <img src="{{ $p->logo_url }}" alt="{{ $p->name_ar }}"
                                 class="h-9 max-w-[110px] object-contain opacity-75 hover:opacity-100 transition brightness-0 invert">
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Stats --}}
            <div class="mt-8 sm:mt-10 lg:mt-12 grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4 max-w-3xl"
                 data-aos="fade-up" data-aos-delay="400">
                @php
                    $stats = [
                        ['n' => $settings['stat_trainees'] ?? 5400,    'l' => 'متدرّب مؤهَّل', 'suffix' => '+'],
                        ['n' => $settings['stat_programs'] ?? 42,      'l' => 'برنامج تدريبي', 'suffix' => ''],
                        ['n' => $settings['stat_companies'] ?? 128,    'l' => 'شركة شريكة',    'suffix' => '+'],
                        ['n' => $settings['stat_satisfaction'] ?? 97,  'l' => 'نسبة الرضا',    'suffix' => '%'],
                    ];
                @endphp
                @foreach($stats as $s)
                    <div class="px-3 py-3 sm:px-4 sm:py-4 rounded-xl sm:rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10">
                        <div class="flex items-baseline gap-1">
                            <span class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white" data-count="{{ $s['n'] }}">0</span>
                            <span class="text-lg sm:text-xl lg:text-2xl text-brand-flame font-bold">{{ $s['suffix'] }}</span>
                        </div>
                        <p class="text-[11px] sm:text-xs lg:text-sm text-white/70 mt-0.5 sm:mt-1">{{ $s['l'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Scroll indicator (hidden on mobile to save space) --}}
    <a href="#categories"
       class="hidden md:flex absolute bottom-6 left-1/2 -translate-x-1/2 text-white/60 hover:text-white transition flex-col items-center gap-2"
       aria-label="تمرير للأسفل">
        <span class="text-[10px] uppercase tracking-[.3em]">تابع التصفح</span>
        <span class="w-px h-8 bg-white/40 animate-pulse"></span>
    </a>
</section>

{{-- ========================= B2B TRUST STRIP ========================= --}}
<section class="bg-brand-black border-y border-brand-red/20" id="categories">
    <div class="container-x py-10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 lg:gap-10 text-white">
            @php
                $trust = [
                    ['t' => 'نخاطب مدير التدريب', 'd' => 'لا نبيع للأفراد — نقدّم حلولاً متكاملة لإدارات التدريب', 'i' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path stroke-linecap="round" d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>'],
                    ['t' => 'برامج قابلة للتخصيص', 'd' => 'كل برنامج يُعاد ضبطه لطبيعة شركتك ومستوى موظفيك', 'i' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M10.3 4.3a1.7 1.7 0 0 1 3.4 0 1.7 1.7 0 0 0 2.6 1c1.5-.9 3.3.8 2.4 2.4a1.7 1.7 0 0 0 1 2.5 1.7 1.7 0 0 1 0 3.4 1.7 1.7 0 0 0-1 2.5c.9 1.6-.9 3.4-2.4 2.4a1.7 1.7 0 0 0-2.6 1 1.7 1.7 0 0 1-3.4 0 1.7 1.7 0 0 0-2.6-1c-1.5 1-3.3-.8-2.4-2.4a1.7 1.7 0 0 0-1-2.5 1.7 1.7 0 0 1 0-3.4 1.7 1.7 0 0 0 1-2.5C4.4 6.1 6.2 4.3 7.7 5.3a1.7 1.7 0 0 0 2.6-1Z"/><circle cx="12" cy="12" r="3"/></svg>'],
                    ['t' => 'تقارير قابلة للقياس', 'd' => 'تقارير حضور وأداء وتقييم تستلمها إدارة التدريب', 'i' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M9 17v-6m3 6v-3m3 3V8M5 3h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z"/></svg>'],
                    ['t' => 'اعتماد رسمي', 'd' => 'تحت إشراف المؤسسة العامة للتدريب التقني والمهني', 'i' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="m9 12 2 2 4-4m5.62-4.02A11.96 11.96 0 0 1 12 2.94a11.96 11.96 0 0 1-8.62 3.04A12 12 0 0 0 3 9c0 5.6 3.82 10.3 9 11.62 5.18-1.33 9-6.03 9-11.62 0-1.04-.13-2.05-.38-3.02Z"/></svg>'],
                ];
            @endphp
            @foreach($trust as $i => $t)
                <div class="flex items-start gap-4" data-aos="fade-up" data-aos-delay="{{ $i * 70 }}">
                    <span class="w-12 h-12 rounded-xl bg-brand-red/20 text-brand-flame flex items-center justify-center shrink-0">
                        {!! $t['i'] !!}
                    </span>
                    <div>
                        <h3 class="font-extrabold text-sm md:text-base mb-1">{{ $t['t'] }}</h3>
                        <p class="text-xs text-white/65 leading-relaxed">{{ $t['d'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ========================= CATEGORIES ========================= --}}
<section class="section-pad bg-white">
    <div class="container-x">
        <div class="text-center max-w-2xl mx-auto mb-14" data-aos="fade-up">
            <span class="kicker">مجالات تخصصنا</span>
            <h2 class="heading-2 mt-3">برامج متخصصة لاحتياجات القطاع الصناعي</h2>
            <p class="text-brand-ink/70 mt-4">نقدّم برامج تدريبية معتمدة في أبرز التخصصات الفنية والإدارية التي يحتاجها العاملون في الصناعات الثقيلة.</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($categories as $i => $cat)
                <a href="{{ route('programs.index', ['category' => $cat->slug]) }}"
                   class="card-lift group relative p-7 rounded-2xl bg-white border border-brand-gray hover:border-brand-red overflow-hidden"
                   data-aos="fade-up" data-aos-delay="{{ $i * 80 }}">
                    <div class="absolute -top-12 -left-12 w-32 h-32 rounded-full opacity-10 transition-opacity group-hover:opacity-25" style="background:{{ $cat->color ?? '#A01818' }}"></div>
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-white text-2xl font-bold mb-5 shadow-brand" style="background:{{ $cat->color ?? '#A01818' }}">
                        {{ mb_substr($cat->name_ar, 0, 1) }}
                    </div>
                    <h3 class="text-xl font-extrabold text-brand-ink mb-2 group-hover:text-brand-red transition">{{ $cat->name_ar }}</h3>
                    <p class="text-brand-ink/70 text-sm leading-relaxed line-clamp-3">{{ $cat->description_ar }}</p>
                    <div class="mt-5 flex items-center justify-between">
                        <span class="text-xs text-brand-ink/50">{{ $cat->programs_count }} برنامج</span>
                        <span class="inline-flex items-center gap-1 text-sm font-bold text-brand-red group-hover:gap-3 transition-all">
                            استكشف
                            <svg class="w-4 h-4 -rotate-180" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ========================= FEATURED PROGRAMS ========================= --}}
<section class="section-pad bg-brand-gray-2">
    <div class="container-x">
        <div class="flex items-end justify-between gap-6 flex-wrap mb-12">
            <div data-aos="fade-up">
                <span class="kicker">برامج مميَّزة</span>
                <h2 class="heading-2 mt-3 max-w-xl">برامج اختارها فريقنا لتناسب أولويات الشركات</h2>
            </div>
            <a href="{{ route('programs.index') }}" class="btn btn-outline" data-aos="fade-left">
                كل البرامج
                <svg class="w-4 h-4 -rotate-180" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($featuredPrograms as $i => $program)
                @include('components.program-card', ['program' => $program, 'delay' => $i * 80])
            @endforeach
        </div>
    </div>
</section>

{{-- ========================= WHY US ========================= --}}
<section class="section-pad bg-white relative overflow-hidden">
    <div class="absolute -top-20 -right-20 w-80 h-80 rounded-full bg-brand-red/5 blur-3xl"></div>
    <div class="container-x relative">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div data-aos="fade-left">
                <span class="kicker">لماذا OGS</span>
                <h2 class="heading-2 mt-3 mb-6">أكثر من برامج تدريبية — شراكة طويلة الأمد مع شركتك</h2>
                <p class="text-brand-ink/70 leading-relaxed mb-8">
                    نختلف عن مراكز التدريب التقليدية في كل تفصيلة: من اختيار المحاضرين، إلى تخصيص المحتوى لشركتك، وصولاً للتقارير القابلة للقياس التي تستلمها إدارة التدريب بعد كل برنامج.
                </p>

                @php
                    $features = [
                        ['t' => 'محاضرون من قلب الميدان', 'd' => 'خبراء بأكثر من ١٥ سنة في الصناعات الثقيلة، لا مدرّبون أكاديميون فقط.', 'i' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 0 0-5.36-1.84M17 20H7m10 0v-2c0-.66-.13-1.3-.36-1.88M7 20H2v-2a3 3 0 0 1 5.36-1.84M7 20v-2c0-.66.13-1.3.36-1.88m0 0a5 5 0 0 1 9.28 0M15 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2 2 0 1 1-4 0 2 2 0 0 1 4 0ZM7 10a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z"/></svg>'],
                        ['t' => 'محتوى قابل للتخصيص',    'd' => 'كل برنامج يُعاد ضبطه ليناسب طبيعة شركتك ومستوى موظفيك.', 'i' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 0 0-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 0 0-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 0 0-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 0 0-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 0 0 1.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>'],
                        ['t' => 'تقارير قابلة للقياس',     'd' => 'تقارير حضور وأداء وتقييم — تستلمها إدارة التدريب بعد كل برنامج.', 'i' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-6m3 6v-3m3 3V8M5 3h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z"/></svg>'],
                        ['t' => 'اعتماد رسمي',           'd' => 'شهاداتنا معتمدة من المؤسسة العامة للتدريب التقني والمهني.', 'i' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m9 12 2 2 4-4m5.618-4.016A11.955 11.955 0 0 1 12 2.944a11.955 11.955 0 0 1-8.618 3.04A12.02 12.02 0 0 0 3 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016Z"/></svg>'],
                    ];
                @endphp
                <div class="grid sm:grid-cols-2 gap-5">
                    @foreach($features as $f)
                        <div class="flex gap-4 items-start">
                            <span class="w-12 h-12 rounded-xl bg-brand-red/10 text-brand-red flex items-center justify-center shrink-0">{!! $f['i'] !!}</span>
                            <div>
                                <h4 class="font-bold text-brand-ink mb-1">{{ $f['t'] }}</h4>
                                <p class="text-sm text-brand-ink/70 leading-relaxed">{{ $f['d'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="relative" data-aos="fade-right">
                <div class="aspect-[4/5] rounded-3xl overflow-hidden bg-cover bg-center shadow-2xl"
                     style="background-image:url('{{ ($settings['about_image'] ?? null) ? asset('storage/'.$settings['about_image']) : asset('images/brand/about-1.jpg') }}')">
                    <div class="absolute inset-0 bg-gradient-to-t from-brand-black/70 via-transparent to-transparent"></div>
                </div>
                <div class="absolute -bottom-8 -right-8 w-48 h-48 rounded-3xl bg-brand-red flex flex-col items-center justify-center text-white shadow-brand rotate-3">
                    <span class="text-5xl font-extrabold" data-count="15">0</span>
                    <span class="text-sm mt-2 opacity-90">سنة من الخبرة</span>
                </div>
                <div class="absolute -top-6 -left-6 w-28 h-28 rounded-2xl bg-brand-flame/90 backdrop-blur flex items-center justify-center -rotate-6 shadow-brand animate-flame-flicker">
                    <svg class="w-12 h-12 text-white" viewBox="0 0 24 24" fill="currentColor"><path d="M13.5.67s.74 2.65.74 4.8c0 2.06-1.35 3.73-3.41 3.73-2.07 0-3.63-1.67-3.63-3.73l.03-.36C5.21 7.51 4 10.62 4 14a8 8 0 1 0 16 0c0-4.16-2-7.88-6.5-13.33ZM11.71 19a3.16 3.16 0 0 1-3.21-3.1c0-1.45.93-2.47 2.52-2.79 1.6-.33 3.25-1.1 4.18-2.34.36 1.18.54 2.42.54 3.67 0 2.5-2.02 4.56-4.03 4.56Z"/></svg>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ========================= LATEST PROGRAMS ========================= --}}
@if($latestPrograms->count())
<section class="section-pad bg-brand-gray-2">
    <div class="container-x">
        <div class="text-center max-w-2xl mx-auto mb-12" data-aos="fade-up">
            <span class="kicker">أحدث الإضافات</span>
            <h2 class="heading-2 mt-3">أحدث برامجنا التدريبية</h2>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach($latestPrograms as $i => $program)
                @include('components.program-card', ['program' => $program, 'delay' => $i * 80])
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ========================= TESTIMONIALS ========================= --}}
@if($testimonials->count())
<section class="section-pad bg-brand-black text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-tr from-brand-red-900/30 via-transparent to-brand-red/20"></div>
    <div class="container-x relative">
        <div class="text-center max-w-2xl mx-auto mb-12" data-aos="fade-up">
            <span class="kicker !text-brand-flame">شركاء النجاح</span>
            <h2 class="heading-2 mt-3 !text-white">ماذا يقول عملاؤنا؟</h2>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach($testimonials as $i => $t)
                <div class="p-7 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 card-lift" data-aos="fade-up" data-aos-delay="{{ $i * 80 }}">
                    <div class="flex text-brand-flame mb-4">
                        @for($s = 0; $s < $t->rating; $s++)
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 1.5l2.6 5.6 6.1.6-4.5 4 1.3 6L10 14.8 4.5 17.7l1.3-6L1.3 7.7l6.1-.6L10 1.5Z"/></svg>
                        @endfor
                    </div>
                    <p class="text-white/85 leading-relaxed mb-6">"{{ $t->quote_ar }}"</p>
                    <div class="flex items-center gap-4 pt-5 border-t border-white/10">
                        <div class="w-12 h-12 rounded-full bg-brand-red flex items-center justify-center text-lg font-bold">
                            {{ mb_substr($t->author_name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-bold">{{ $t->author_name }}</p>
                            @if($t->author_title || $t->author_company)
                                <p class="text-sm text-white/60">{{ trim(($t->author_title ?? '') . ($t->author_company ? ' · '.$t->author_company : '')) }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ========================= PARTNERS ========================= --}}
@if($partners->count())
    @include('components.partners-section', ['partners' => $partners, 'showCta' => false])
@endif

@endsection
