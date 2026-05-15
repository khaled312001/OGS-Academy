@extends('layouts.app')
@section('seo_title', 'البرامج التدريبية')
@section('seo_description', 'استعرض كل البرامج التدريبية المتخصصة في قطاعات النفط والغاز والصناعات الثقيلة بإشراف المؤسسة العامة للتدريب التقني والمهني.')

@section('content')

{{-- ============ PAGE HERO ============ --}}
<section class="relative pt-40 pb-16 bg-brand-black text-white overflow-hidden">
    <div class="absolute inset-0 hero-overlay"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 rounded-full bg-brand-red/20 blur-3xl"></div>
    <div class="container-x relative">
        <div class="max-w-3xl" data-aos="fade-up">
            <span class="kicker !text-brand-flame">برامجنا التدريبية</span>
            <h1 class="text-4xl md:text-5xl font-extrabold mt-3 leading-tight">برامج معتمدة تصنع فرقًا في فِرق العمل</h1>
            <p class="text-white/80 text-lg mt-5 max-w-2xl leading-relaxed">
                استكشف برامجنا المصمَّمة خصيصًا لاحتياجات القطاع الصناعي. كل برنامج قابل للتخصيص ليناسب طبيعة شركتك ومستوى موظفيك.
            </p>
        </div>
    </div>
</section>

{{-- ============ FILTERS + LIST ============ --}}
<section class="section-pad bg-brand-gray-2">
    <div class="container-x">
        {{-- Filters --}}
        <form method="GET" action="{{ route('programs.index') }}" class="mb-10 grid lg:grid-cols-[1fr_auto] gap-4 items-center" data-aos="fade-up">
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('programs.index') }}" class="px-4 py-2 rounded-full font-semibold text-sm transition {{ !$activeSlug ? 'bg-brand-red text-white shadow-brand' : 'bg-white text-brand-ink hover:bg-brand-red hover:text-white' }}">
                    الكل
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('programs.index', ['category' => $cat->slug]) }}"
                       class="px-4 py-2 rounded-full font-semibold text-sm transition {{ $activeSlug === $cat->slug ? 'bg-brand-red text-white shadow-brand' : 'bg-white text-brand-ink hover:bg-brand-red hover:text-white' }}">
                        {{ $cat->name_ar }}
                    </a>
                @endforeach
            </div>
            <div class="relative">
                <input type="search" name="q" value="{{ request('q') }}" placeholder="ابحث عن برنامج..."
                       class="w-full lg:w-72 pl-4 pr-12 py-3 rounded-full border border-brand-gray bg-white focus:border-brand-red focus:ring focus:ring-brand-red/15 text-sm">
                <svg class="absolute top-3 right-4 w-5 h-5 text-brand-ink/50" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="m21 21-4.3-4.3"/></svg>
            </div>
        </form>

        @if($programs->count())
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($programs as $i => $program)
                    @include('components.program-card', ['program' => $program, 'delay' => ($i % 3) * 80])
                @endforeach
            </div>

            <div class="mt-12">
                {{ $programs->links() }}
            </div>
        @else
            <div class="text-center py-20" data-aos="fade-up">
                <div class="w-20 h-20 rounded-full bg-brand-red/10 text-brand-red flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="m21 21-4.3-4.3"/></svg>
                </div>
                <h3 class="text-xl font-bold text-brand-ink mb-2">لا توجد برامج مطابقة</h3>
                <p class="text-brand-ink/60">جرّب مصطلح بحث آخر أو تصفّح كل البرامج</p>
                <a href="{{ route('programs.index') }}" class="btn btn-primary mt-6">عرض كل البرامج</a>
            </div>
        @endif
    </div>
</section>

@endsection
