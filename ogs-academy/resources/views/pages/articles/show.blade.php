@extends('layouts.app')
@section('seo_title', $article->title_ar)
@section('seo_description', $article->excerpt_ar ?? $article->subtitle_ar ?? '')
@section('seo_image', $article->cover_image ? $article->cover_url : '')
@section('seo_type', 'article')
@section('seo_keywords', is_array($article->tags) ? implode(', ', $article->tags) : '')
@php
    $seoJsonLd = [
        '@context' => 'https://schema.org',
        '@type'    => 'Article',
        'headline' => $article->title_ar,
        'description' => $article->excerpt_ar ?? '',
        'image'    => $article->cover_image ? $article->cover_url : null,
        'author'   => [
            '@type' => 'Person',
            'name'  => $article->author?->name ?? ($settings['site_name_ar'] ?? 'OGS Academy'),
        ],
        'publisher' => [
            '@type' => 'Organization',
            'name'  => $settings['site_name_ar'] ?? 'OGS Academy',
            'logo'  => [
                '@type' => 'ImageObject',
                'url'   => ($settings['site_logo'] ?? null) ? asset('storage/'.$settings['site_logo']) : asset('images/brand/ogs-logo.png'),
            ],
        ],
        'datePublished' => $article->published_at?->toIso8601String(),
        'dateModified'  => $article->updated_at?->toIso8601String(),
        'mainEntityOfPage' => [
            '@type' => 'WebPage',
            '@id'   => url()->current(),
        ],
        'keywords' => is_array($article->tags) ? implode(', ', $article->tags) : null,
        'inLanguage' => 'ar',
    ];
@endphp

@section('content')

<article>
{{-- ===== HERO ===== --}}
<section class="relative pt-32 pb-16 bg-brand-black text-white overflow-hidden">
    <div class="absolute inset-0 -z-10">
        @if($article->cover_image)
            <div class="absolute inset-0 bg-cover bg-center opacity-30" style="background-image:url('{{ $article->cover_url }}')"></div>
        @endif
        <div class="absolute inset-0 hero-overlay"></div>
    </div>
    <div class="container-x relative">
        <nav class="text-sm text-white/60 mb-6" data-aos="fade-down">
            <a href="{{ route('home') }}" class="hover:text-white">الرئيسية</a>
            <span class="mx-2">/</span>
            <a href="{{ route('articles.index') }}" class="hover:text-white">المقالات</a>
            @if($article->category)
                <span class="mx-2">/</span>
                <a href="{{ route('articles.index', ['category' => $article->category]) }}" class="hover:text-white">{{ $article->category_label }}</a>
            @endif
        </nav>

        <div class="max-w-4xl" data-aos="fade-up">
            @if($article->category)
                <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-brand-red/20 text-brand-flame text-sm font-bold mb-4">
                    <span class="w-2 h-2 rounded-full bg-brand-flame"></span> {{ $article->category_label }}
                </span>
            @endif
            <h1 class="text-3xl md:text-5xl font-extrabold leading-tight mb-4">{{ $article->title_ar }}</h1>
            @if($article->subtitle_ar)
                <p class="text-xl text-white/80 leading-relaxed">{{ $article->subtitle_ar }}</p>
            @endif

            <div class="flex flex-wrap items-center gap-6 mt-8 text-sm text-white/70">
                @if($article->author)
                    <span class="flex items-center gap-2"><img src="{{ $article->author->avatar_url }}" class="w-8 h-8 rounded-full" alt=""> {{ $article->author->name }}</span>
                @endif
                <span class="flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" d="M12 7v5l3 3"/></svg> {{ $article->published_at?->translatedFormat('j F Y') }}</span>
                @if($article->read_minutes)
                    <span class="flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M12 6.04A8.97 8.97 0 0 0 6 3.75c-1.05 0-2.06.18-3 .51v14.25A9 9 0 0 1 6 18c2.3 0 4.4.87 6 2.29m0-14.25a8.97 8.97 0 0 1 6-2.29c1.05 0 2.06.18 3 .51v14.25A9 9 0 0 0 18 18a9 9 0 0 0-6 2.29M12 6.04v14.25"/></svg> {{ $article->read_minutes }} دقائق قراءة</span>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- ===== COVER ===== --}}
@if($article->cover_image)
<section class="bg-brand-black -mt-px">
    <div class="container-x">
        <div class="-mt-12 mb-10 rounded-3xl overflow-hidden shadow-2xl" data-aos="fade-up">
            <img src="{{ $article->cover_url }}" alt="{{ $article->title_ar }}" class="w-full aspect-[21/9] object-cover">
        </div>
    </div>
</section>
@endif

{{-- ===== CONTENT ===== --}}
<section class="section-pad bg-white">
    <div class="container-x grid lg:grid-cols-[1fr_280px] gap-12 max-w-6xl mx-auto">
        <div class="prose prose-lg max-w-none rtl:text-right" data-aos="fade-up">
            {!! $article->content_ar !!}
        </div>

        <aside class="lg:sticky lg:top-28 self-start space-y-6">
            @if(!empty($article->tags))
                <div class="p-5 rounded-2xl bg-brand-gray-2">
                    <h4 class="font-extrabold mb-3 flex items-center gap-2"><span class="flame-bar"></span> الوسوم</h4>
                    <div class="flex flex-wrap gap-2">
                        @foreach($article->tags as $tag)
                            <span class="px-3 py-1 rounded-full bg-white text-xs font-semibold text-brand-ink border border-brand-gray">#{{ $tag }}</span>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="p-5 rounded-2xl bg-gradient-to-br from-brand-red to-brand-red-700 text-white">
                <h4 class="font-extrabold mb-2">هل أعجبك المقال؟</h4>
                <p class="text-white/80 text-sm mb-4">شاركه مع زملائك في القطاع</p>
                <div class="flex gap-2">
                    <a href="https://api.whatsapp.com/send?text={{ urlencode($article->title_ar.' '.url()->current()) }}" target="_blank" class="flex-1 py-2 rounded-xl bg-white/10 hover:bg-white/20 text-xs font-bold text-center transition">واتساب</a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($article->title_ar) }}" target="_blank" class="flex-1 py-2 rounded-xl bg-white/10 hover:bg-white/20 text-xs font-bold text-center transition">تويتر</a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" target="_blank" class="flex-1 py-2 rounded-xl bg-white/10 hover:bg-white/20 text-xs font-bold text-center transition">لينكدإن</a>
                </div>
            </div>
        </aside>
    </div>
</section>
</article>

{{-- ===== RELATED ===== --}}
@if($related->count())
<section class="section-pad bg-brand-gray-2">
    <div class="container-x">
        <div class="mb-10" data-aos="fade-up">
            <span class="kicker">للاطلاع</span>
            <h2 class="heading-2 mt-3">مقالات ذات صلة</h2>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach($related as $i => $r)
                <a href="{{ route('articles.show', $r->slug) }}"
                   class="card-lift group block rounded-2xl overflow-hidden bg-white border border-brand-gray hover:border-brand-red"
                   data-aos="fade-up" data-aos-delay="{{ $i * 80 }}">
                    <div class="aspect-[16/10] overflow-hidden bg-brand-gray-2">
                        <img src="{{ $r->cover_url }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-700" alt="">
                    </div>
                    <div class="p-5">
                        @if($r->category)<span class="text-xs text-brand-red font-bold uppercase tracking-widest">{{ $r->category_label }}</span>@endif
                        <h3 class="text-lg font-extrabold leading-tight line-clamp-2 mt-2 group-hover:text-brand-red transition">{{ $r->title_ar }}</h3>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
