@extends('layouts.app')
@section('seo_title', 'من نحن')
@section('seo_description', 'أكاديمية OGS — مؤسسة تدريبية معتمدة في مكة المكرّمة متخصصة في تدريب القطاع الصناعي تحت إشراف المؤسسة العامة للتدريب التقني والمهني.')

@section('content')

{{-- ===== HERO ===== --}}
<section class="relative pt-40 pb-20 bg-brand-black text-white overflow-hidden">
    <div class="absolute inset-0 hero-overlay"></div>
    <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full bg-brand-red/20 blur-3xl"></div>
    <div class="container-x relative grid lg:grid-cols-[1.2fr_1fr] gap-12 items-center">
        <div data-aos="fade-up">
            <span class="kicker !text-brand-flame">من نحن</span>
            <h1 class="text-4xl md:text-6xl font-extrabold mt-3 leading-tight">{{ $page?->title_ar ?? 'أكاديمية معتمدة للقطاع الصناعي' }}</h1>
            @if($page?->subtitle_ar)
                <p class="text-xl text-white/80 mt-5 leading-relaxed max-w-2xl">{{ $page->subtitle_ar }}</p>
            @endif
        </div>
        <div data-aos="fade-left" class="relative">
            <div class="aspect-square rounded-3xl overflow-hidden shadow-2xl bg-cover bg-center"
                 style="background-image:url('{{ ($settings['about_image'] ?? null) ? asset('storage/'.$settings['about_image']) : asset('images/brand/about-1.jpg') }}')">
            </div>
            <div class="absolute -bottom-6 -right-6 bg-brand-red text-white rounded-2xl p-5 shadow-brand">
                <div class="flex items-baseline gap-1">
                    <span class="text-3xl font-extrabold">{{ $settings['stat_trainees'] ?? '5400' }}</span>
                    <span class="text-brand-flame-light">+</span>
                </div>
                <p class="text-sm text-white/85">متدرّب مؤهَّل</p>
            </div>
        </div>
    </div>
</section>

{{-- ===== CONTENT ===== --}}
@if($page)
<section class="section-pad bg-white">
    <div class="container-x prose prose-lg max-w-3xl mx-auto rtl:text-right" data-aos="fade-up">
        {!! $page->content_ar !!}
    </div>
</section>
@endif

{{-- ===== VISION / MISSION ===== --}}
@php $sections = $page?->sections ?? []; @endphp
<section class="section-pad bg-brand-gray-2">
    <div class="container-x grid md:grid-cols-2 gap-6">
        <div class="p-8 rounded-3xl bg-white shadow-soft card-lift" data-aos="fade-up">
            <div class="w-14 h-14 rounded-2xl bg-brand-red text-white flex items-center justify-center mb-5">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.643C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
            </div>
            <h3 class="text-2xl font-extrabold text-brand-ink mb-3">رؤيتنا</h3>
            <p class="text-brand-ink/70 leading-relaxed">{{ $sections['vision_ar'] ?? 'أن نكون البيت التدريبي الأول للقطاع الصناعي في المنطقة.' }}</p>
        </div>
        <div class="p-8 rounded-3xl bg-brand-black text-white card-lift" data-aos="fade-up" data-aos-delay="100">
            <div class="w-14 h-14 rounded-2xl bg-brand-flame text-white flex items-center justify-center mb-5">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 0 1-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 0 0 6.16-12.12A14.98 14.98 0 0 0 9.631 8.41m5.96 5.96a14.926 14.926 0 0 1-5.841 2.58m-.119-8.54a6 6 0 0 0-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 0 0-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 0 1-2.448-2.448 14.9 14.9 0 0 1 .06-.312m-2.24 2.39a4.493 4.493 0 0 0-1.757 4.306 4.493 4.493 0 0 0 4.306-1.758M16.5 9a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/></svg>
            </div>
            <h3 class="text-2xl font-extrabold mb-3">رسالتنا</h3>
            <p class="text-white/80 leading-relaxed">{{ $sections['mission_ar'] ?? 'تقديم برامج تدريبية مصمَّمة لاحتياجات القطاع الصناعي بمعايير عالمية.' }}</p>
        </div>
    </div>
</section>

{{-- ===== VALUES ===== --}}
@if(!empty($sections['values']))
<section class="section-pad bg-white">
    <div class="container-x">
        <div class="text-center max-w-2xl mx-auto mb-12" data-aos="fade-up">
            <span class="kicker">قيمنا</span>
            <h2 class="heading-2 mt-3">المبادئ التي تحرّك عملنا</h2>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($sections['values'] as $i => $v)
                <div class="p-6 rounded-2xl border border-brand-gray hover:border-brand-red transition card-lift" data-aos="fade-up" data-aos-delay="{{ $i * 80 }}">
                    <span class="text-5xl font-extrabold text-brand-red/15">0{{ $i + 1 }}</span>
                    <h3 class="text-lg font-bold text-brand-ink mt-2 mb-2">{{ $v['title_ar'] }}</h3>
                    <p class="text-sm text-brand-ink/70 leading-relaxed">{{ $v['desc_ar'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ===== WHY US ===== --}}
@if(!empty($sections['why_us']))
<section class="section-pad bg-brand-black text-white">
    <div class="container-x">
        <div class="text-center max-w-2xl mx-auto mb-12" data-aos="fade-up">
            <span class="kicker !text-brand-flame">لماذا تختار OGS</span>
            <h2 class="heading-2 mt-3 !text-white">أربعة أسباب تجعلنا الخيار الأول</h2>
        </div>
        <div class="grid md:grid-cols-2 gap-6">
            @foreach($sections['why_us'] as $i => $w)
                <div class="p-7 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 flex gap-5" data-aos="fade-up" data-aos-delay="{{ $i * 80 }}">
                    <div class="shrink-0 w-12 h-12 rounded-xl bg-brand-flame/20 text-brand-flame flex items-center justify-center font-extrabold">0{{ $i + 1 }}</div>
                    <div>
                        <h3 class="text-lg font-bold mb-2">{{ $w['title_ar'] }}</h3>
                        <p class="text-white/70 leading-relaxed text-sm">{{ $w['desc_ar'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ===== PARTNERS ===== --}}
@if($partners->count())
    @include('components.partners-section', ['partners' => $partners, 'showCta' => true])
@endif

@endsection
