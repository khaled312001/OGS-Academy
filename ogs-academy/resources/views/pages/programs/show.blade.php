@extends('layouts.app')
@section('seo_title', $program->title_ar)
@section('seo_description', $program->summary_ar ?? $program->subtitle_ar ?? '')
@section('seo_image', $program->cover_image ? $program->cover_url : '')
@section('seo_type', 'article')
@php
    $seoJsonLd = [
        '@context' => 'https://schema.org',
        '@type'    => 'Course',
        'name'     => $program->title_ar,
        'description' => $program->summary_ar ?? $program->subtitle_ar ?? '',
        'provider' => [
            '@type' => 'EducationalOrganization',
            'name'  => $settings['site_name_ar'] ?? 'OGS Academy',
            'sameAs'=> url('/'),
        ],
        'image' => $program->cover_image ? $program->cover_url : null,
        'inLanguage' => 'ar',
        'educationalLevel' => $program->level,
        'timeRequired' => $program->duration_hours ? 'PT' . $program->duration_hours . 'H' : null,
        'hasCourseInstance' => [
            '@type' => 'CourseInstance',
            'courseMode' => 'in-person',
            'location'   => [
                '@type' => 'Place',
                'name'  => $settings['site_name_ar'] ?? 'OGS Academy',
                'address' => $settings['contact_address_ar'] ?? 'Makkah, KSA',
            ],
        ],
    ];
@endphp

@section('content')

{{-- ============ PROGRAM HERO ============ --}}
<section class="relative pt-32 pb-16 bg-brand-black text-white overflow-hidden">
    <div class="absolute inset-0 -z-10">
        @if($program->cover_image)
            <div class="absolute inset-0 bg-cover bg-center opacity-30" style="background-image:url('{{ $program->cover_url }}')"></div>
        @endif
        <div class="absolute inset-0 hero-overlay"></div>
    </div>

    <div class="container-x relative">
        <nav class="text-sm text-white/60 mb-6" data-aos="fade-down">
            <a href="{{ route('home') }}" class="hover:text-white">الرئيسية</a>
            <span class="mx-2">/</span>
            <a href="{{ route('programs.index') }}" class="hover:text-white">البرامج</a>
            @if($program->category)
                <span class="mx-2">/</span>
                <a href="{{ route('programs.index', ['category' => $program->category->slug]) }}" class="hover:text-white">{{ $program->category->name_ar }}</a>
            @endif
        </nav>

        <div class="grid lg:grid-cols-[2fr_1fr] gap-10 items-center">
            <div data-aos="fade-up">
                @if($program->category)
                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-brand-red/20 text-brand-flame text-sm font-bold mb-4">
                        <span class="w-2 h-2 rounded-full bg-brand-flame"></span> {{ $program->category->name_ar }}
                    </span>
                @endif
                <h1 class="text-3xl md:text-5xl font-extrabold leading-tight mb-4">{{ $program->title_ar }}</h1>
                @if($program->subtitle_ar)
                    <p class="text-xl text-white/80 leading-relaxed max-w-2xl">{{ $program->subtitle_ar }}</p>
                @endif

                <div class="flex flex-wrap gap-6 mt-8">
                    @if($program->duration_label)
                        <div class="flex items-center gap-3">
                            <span class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" d="M12 7v5l3 3"/></svg></span>
                            <div>
                                <p class="text-xs text-white/60">المدة</p>
                                <p class="font-bold">{{ $program->duration_label }}</p>
                            </div>
                        </div>
                    @endif
                    @if($program->level)
                        <div class="flex items-center gap-3">
                            <span class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-6m3 6v-3m3 3V8M5 3h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z"/></svg></span>
                            <div>
                                <p class="text-xs text-white/60">المستوى</p>
                                <p class="font-bold">{{ $program->level }}</p>
                            </div>
                        </div>
                    @endif
                    @if($program->certificate_label)
                        <div class="flex items-center gap-3">
                            <span class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0 1 12 2.944a11.955 11.955 0 0 1-8.618 3.04A12.02 12.02 0 0 0 3 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016Z"/></svg></span>
                            <div>
                                <p class="text-xs text-white/60">الشهادة</p>
                                <p class="font-bold">{{ $program->certificate_label }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- CTA card --}}
            <div class="lg:sticky lg:top-28" data-aos="fade-left">
                <div class="rounded-3xl bg-white text-brand-ink p-7 shadow-brand">
                    <p class="text-sm text-brand-ink/60 mb-1">تكلفة البرنامج</p>
                    <p class="text-3xl font-extrabold text-brand-red mb-5">{{ $program->price_label ?? 'حسب الطلب' }}</p>
                    <a href="#inquiry-form" class="btn btn-primary w-full mb-3">اطلب البرنامج لفريقك</a>
                    <a href="https://wa.me/{{ preg_replace('/\D/', '', $settings['contact_whatsapp'] ?? '') }}" target="_blank" rel="noopener" class="btn btn-outline w-full">تواصل عبر واتساب</a>

                    <div class="mt-6 pt-6 border-t border-brand-gray space-y-3 text-sm">
                        @if($program->seats)
                            <p class="flex items-center gap-2 text-brand-ink/70"><svg class="w-4 h-4 text-brand-red" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M17 20h5v-2a3 3 0 0 0-5.36-1.84M17 20H7m10 0v-2c0-.66-.13-1.3-.36-1.88M7 20H2v-2a3 3 0 0 1 5.36-1.84M7 20v-2c0-.66.13-1.3.36-1.88m0 0a5 5 0 0 1 9.28 0M15 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg> المقاعد: <strong>{{ $program->seats }}</strong></p>
                        @endif
                        @if($program->start_date)
                            <p class="flex items-center gap-2 text-brand-ink/70"><svg class="w-4 h-4 text-brand-red" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path stroke-linecap="round" d="M16 2v4M8 2v4M3 10h18"/></svg> يبدأ: <strong>{{ $program->start_date->translatedFormat('j F Y') }}</strong></p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============ INTRO VIDEO ============ --}}
@if($program->intro_video_url)
<section class="bg-brand-black -mt-px">
    <div class="container-x">
        <div class="aspect-video rounded-3xl overflow-hidden -mt-16 mb-12 shadow-2xl bg-brand-gray-2" data-aos="fade-up">
            <iframe src="{{ $program->intro_video_url }}" class="w-full h-full" frameborder="0" allowfullscreen></iframe>
        </div>
    </div>
</section>
@endif

{{-- ============ MAIN CONTENT ============ --}}
<section class="section-pad bg-white">
    <div class="container-x grid lg:grid-cols-[2fr_1fr] gap-12">
        <div class="space-y-12">
            @if($program->summary_ar)
                <div data-aos="fade-up">
                    <span class="kicker">نبذة</span>
                    <h2 class="heading-2 mt-3 mb-5">عن البرنامج</h2>
                    <p class="text-brand-ink/80 leading-relaxed text-lg">{{ $program->summary_ar }}</p>
                </div>
            @endif

            @if(!empty($program->outcomes_ar))
                <div data-aos="fade-up">
                    <span class="kicker">مخرجات التعلم</span>
                    <h2 class="heading-2 mt-3 mb-5">ما الذي سيتقنه المتدرّب؟</h2>
                    <ul class="grid sm:grid-cols-2 gap-4">
                        @foreach($program->outcomes_ar as $o)
                            <li class="flex gap-3 items-start">
                                <span class="w-7 h-7 shrink-0 rounded-full bg-brand-red/10 text-brand-red flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m5 13 4 4L19 7"/></svg>
                                </span>
                                <span class="text-brand-ink/80 leading-relaxed">{{ $o }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if($program->modules->count())
                <div data-aos="fade-up">
                    <span class="kicker">المحاور</span>
                    <h2 class="heading-2 mt-3 mb-5">محتوى البرنامج</h2>
                    <div class="space-y-3" x-data="{ open: 0 }">
                        @foreach($program->modules as $i => $module)
                            <div class="rounded-xl border border-brand-gray bg-white overflow-hidden">
                                <button @click="open = open === {{ $i }} ? -1 : {{ $i }}" type="button"
                                        class="w-full flex items-center justify-between p-5 text-right hover:bg-brand-gray-2 transition">
                                    <div class="flex items-center gap-4">
                                        <span class="w-9 h-9 shrink-0 rounded-lg bg-brand-red text-white flex items-center justify-center font-bold text-sm">{{ $i + 1 }}</span>
                                        <span class="font-bold text-brand-ink">{{ $module->title_ar }}</span>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        @if($module->duration_hours)
                                            <span class="text-xs text-brand-ink/60">{{ $module->duration_hours }} ساعة</span>
                                        @endif
                                        <svg class="w-5 h-5 text-brand-red transition" :class="open === {{ $i }} && 'rotate-180'" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/></svg>
                                    </div>
                                </button>
                                @if($module->description_ar)
                                    <div x-show="open === {{ $i }}" x-collapse class="px-5 pb-5 text-brand-ink/70 leading-relaxed">{{ $module->description_ar }}</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if(!empty($program->prerequisites_ar))
                <div data-aos="fade-up">
                    <span class="kicker">المتطلبات</span>
                    <h2 class="heading-2 mt-3 mb-5">المتطلّبات المسبقة</h2>
                    <ul class="space-y-2">
                        @foreach($program->prerequisites_ar as $p)
                            <li class="flex gap-3 items-start text-brand-ink/80">
                                <span class="w-2 h-2 mt-2 rounded-full bg-brand-flame shrink-0"></span> {{ $p }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        {{-- ===== Inquiry Form Sidebar ===== --}}
        <aside id="inquiry-form" class="lg:sticky lg:top-28 self-start">
            @if(session('success'))
                <div class="mb-5 p-4 rounded-xl bg-green-50 border border-green-200 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <div class="rounded-3xl bg-gradient-to-br from-brand-red via-brand-red-700 to-brand-red-900 text-white p-7 shadow-brand">
                <div class="inline-flex items-center gap-2 bg-white/10 px-3 py-1 rounded-full text-xs font-bold mb-3">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" d="M3 21V9l9-6 9 6v12"/></svg>
                    طلب مؤسسي · B2B
                </div>
                <h3 class="text-xl font-extrabold mb-2">اطلب البرنامج لفريقك</h3>
                <p class="text-white/80 text-sm mb-6">يخدم هذا البرنامج <strong class="text-white">الشركات والمؤسسات</strong> فقط. سيتواصل معك فريقنا خلال يوم عمل لتخصيص البرنامج.</p>

                <form method="POST" action="{{ route('inquiries.store') }}" class="space-y-3" x-data="{ loading: false }" @submit="loading = true">
                    @csrf
                    <input type="hidden" name="program_id" value="{{ $program->id }}">
                    <input type="hidden" name="source" value="program_page">

                    <div>
                        <input type="text" name="full_name" value="{{ old('full_name') }}" required placeholder="الاسم الكامل *"
                               class="w-full rounded-xl bg-white/10 border border-white/20 focus:border-white focus:ring focus:ring-white/30 placeholder-white/60 text-white px-4 py-3 text-sm">
                        @error('full_name') <p class="text-yellow-200 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <input type="text" name="company" value="{{ old('company') }}" required placeholder="اسم الشركة / المؤسسة *"
                               class="w-full rounded-xl bg-white/10 border border-white/20 focus:border-white focus:ring focus:ring-white/30 placeholder-white/60 text-white px-4 py-3 text-sm">
                        @error('company') <p class="text-yellow-200 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <input type="text" name="job_title" value="{{ old('job_title') }}" required placeholder="المسمى الوظيفي *"
                               class="w-full rounded-xl bg-white/10 border border-white/20 focus:border-white focus:ring focus:ring-white/30 placeholder-white/60 text-white px-4 py-3 text-sm">
                        @error('job_title') <p class="text-yellow-200 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="البريد *" dir="ltr"
                               class="w-full rounded-xl bg-white/10 border border-white/20 focus:border-white focus:ring focus:ring-white/30 placeholder-white/60 text-white px-4 py-3 text-sm">
                        <input type="tel" name="phone" value="{{ old('phone') }}" required placeholder="الجوال *" dir="ltr"
                               class="w-full rounded-xl bg-white/10 border border-white/20 focus:border-white focus:ring focus:ring-white/30 placeholder-white/60 text-white px-4 py-3 text-sm">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <input type="number" name="trainees_count" min="1" value="{{ old('trainees_count') }}" placeholder="عدد المتدربين"
                               class="w-full rounded-xl bg-white/10 border border-white/20 focus:border-white focus:ring focus:ring-white/30 placeholder-white/60 text-white px-4 py-3 text-sm">
                        <input type="text" name="preferred_date" value="{{ old('preferred_date') }}" placeholder="التاريخ المفضّل"
                               class="w-full rounded-xl bg-white/10 border border-white/20 focus:border-white focus:ring focus:ring-white/30 placeholder-white/60 text-white px-4 py-3 text-sm">
                    </div>

                    <textarea name="message" rows="3" placeholder="تفاصيل إضافية..."
                              class="w-full rounded-xl bg-white/10 border border-white/20 focus:border-white focus:ring focus:ring-white/30 placeholder-white/60 text-white px-4 py-3 text-sm">{{ old('message') }}</textarea>

                    <button type="submit" :disabled="loading"
                            class="btn w-full bg-white text-brand-red hover:bg-brand-gray font-bold mt-2 disabled:opacity-60 disabled:cursor-wait">
                        <span x-show="!loading">إرسال الطلب</span>
                        <span x-show="loading" class="flex items-center gap-2">
                            <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke-opacity="0.25"/><path stroke-linecap="round" d="M22 12a10 10 0 0 0-10-10"/></svg>
                            جارٍ الإرسال...
                        </span>
                    </button>
                    <p class="text-xs text-white/60 text-center mt-2">بياناتك آمنة. نتواصل فقط لتأهيل طلبك.</p>
                </form>
            </div>
        </aside>
    </div>
</section>

{{-- ============ RELATED ============ --}}
@if($related->count())
<section class="section-pad bg-brand-gray-2">
    <div class="container-x">
        <div class="mb-10" data-aos="fade-up">
            <span class="kicker">برامج ذات صلة</span>
            <h2 class="heading-2 mt-3">قد تهمّك أيضًا</h2>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach($related as $i => $p)
                @include('components.program-card', ['program' => $p, 'delay' => $i * 80])
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
