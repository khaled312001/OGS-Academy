@extends('layouts.app')
@section('seo_title', 'المقالات والأخبار')
@section('seo_description', 'رؤى تخصصية، قصص نجاح، وتحديثات الصناعة — يكتبها فريق OGS من قلب الميدان الصناعي.')

@section('content')

{{-- ===== HERO ===== --}}
<section class="relative pt-40 pb-16 bg-brand-black text-white overflow-hidden">
    <div class="absolute inset-0 hero-overlay"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 rounded-full bg-brand-red/20 blur-3xl"></div>
    <div class="container-x relative">
        <div class="max-w-3xl" data-aos="fade-up">
            <span class="kicker !text-brand-flame">مدوّنة OGS</span>
            <h1 class="text-4xl md:text-5xl font-extrabold mt-3 leading-tight">مقالات وأخبار من قلب الميدان</h1>
            <p class="text-white/80 text-lg mt-5 max-w-2xl leading-relaxed">
                رؤى تخصصية وقصص نجاح وتحديثات الصناعة — يكتبها فريقنا من ميدان العمل الصناعي.
            </p>
        </div>
    </div>
</section>

<section class="section-pad bg-white">
    <div class="container-x">

        {{-- ===== Filter chips ===== --}}
        <form method="GET" class="mb-10 grid lg:grid-cols-[1fr_auto] gap-4 items-center" data-aos="fade-up">
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('articles.index') }}"
                   class="px-4 py-2 rounded-full font-semibold text-sm transition {{ !$activeCategory ? 'bg-brand-red text-white shadow-brand' : 'bg-brand-gray-2 text-brand-ink hover:bg-brand-red hover:text-white' }}">
                    كل المقالات
                </a>
                @foreach($categories as $k => $v)
                    <a href="{{ route('articles.index', ['category' => $k]) }}"
                       class="px-4 py-2 rounded-full font-semibold text-sm transition {{ $activeCategory === $k ? 'bg-brand-red text-white shadow-brand' : 'bg-brand-gray-2 text-brand-ink hover:bg-brand-red hover:text-white' }}">
                        {{ $v }}
                    </a>
                @endforeach
            </div>
            <div class="relative">
                <input type="search" name="q" value="{{ request('q') }}" placeholder="ابحث في المقالات..."
                       class="w-full lg:w-72 pl-4 pr-12 py-3 rounded-full border border-brand-gray bg-white focus:border-brand-red focus:ring focus:ring-brand-red/15 text-sm">
                <svg class="absolute top-3 right-4 w-5 h-5 text-brand-ink/50" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="m21 21-4.3-4.3"/></svg>
            </div>
        </form>

        {{-- ===== Featured ===== --}}
        @if($featured && !$activeCategory && !request('q') && !$articles->onFirstPage() === false)
            <a href="{{ route('articles.show', $featured->slug) }}"
               class="block mb-12 group rounded-3xl overflow-hidden bg-brand-black text-white shadow-soft hover:shadow-brand transition" data-aos="fade-up">
                <div class="grid lg:grid-cols-2">
                    <div class="aspect-[16/10] lg:aspect-auto overflow-hidden">
                        <img src="{{ $featured->cover_url }}" alt="{{ $featured->title_ar }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-105">
                    </div>
                    <div class="p-8 lg:p-12 flex flex-col justify-center">
                        <span class="inline-flex items-center gap-2 self-start px-3 py-1 rounded-full bg-brand-red text-white text-xs font-bold mb-4">⚡ مقال مميَّز</span>
                        @if($featured->category)
                            <span class="text-xs text-brand-flame uppercase tracking-widest mb-3">{{ $featured->category_label }}</span>
                        @endif
                        <h2 class="text-2xl lg:text-3xl font-extrabold leading-tight mb-4 group-hover:text-brand-flame transition">{{ $featured->title_ar }}</h2>
                        @if($featured->excerpt_ar)
                            <p class="text-white/75 leading-relaxed mb-5 line-clamp-3">{{ $featured->excerpt_ar }}</p>
                        @endif
                        <div class="flex items-center gap-5 text-xs text-white/60">
                            <span>{{ $featured->published_at?->translatedFormat('j F Y') }}</span>
                            @if($featured->read_minutes)<span>· {{ $featured->read_minutes }} دقائق قراءة</span>@endif
                        </div>
                    </div>
                </div>
            </a>
        @endif

        {{-- ===== Articles grid ===== --}}
        @if($articles->count())
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($articles as $i => $article)
                    <a href="{{ route('articles.show', $article->slug) }}"
                       class="card-lift group block rounded-2xl overflow-hidden bg-white border border-brand-gray hover:border-brand-red shadow-soft"
                       data-aos="fade-up" data-aos-delay="{{ ($i % 3) * 80 }}">
                        <div class="aspect-[16/10] overflow-hidden bg-brand-gray-2 relative">
                            <img src="{{ $article->cover_url }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-105" alt="">
                            @if($article->category)
                                <span class="absolute top-4 right-4 inline-flex items-center gap-2 bg-white/90 backdrop-blur text-brand-ink text-xs font-bold px-3 py-1.5 rounded-full">
                                    {{ $article->category_label }}
                                </span>
                            @endif
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-extrabold leading-tight line-clamp-2 mb-3 group-hover:text-brand-red transition">{{ $article->title_ar }}</h3>
                            @if($article->excerpt_ar)
                                <p class="text-sm text-brand-ink/70 leading-relaxed line-clamp-2 mb-5">{{ $article->excerpt_ar }}</p>
                            @endif
                            <div class="flex items-center justify-between pt-4 border-t border-brand-gray text-xs text-brand-ink/60">
                                <span>{{ $article->published_at?->translatedFormat('j M Y') ?? '—' }}</span>
                                @if($article->read_minutes)<span>{{ $article->read_minutes }} دقائق</span>@endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="mt-12">{{ $articles->links() }}</div>
        @else
            <div class="text-center py-20" data-aos="fade-up">
                <div class="w-20 h-20 rounded-full bg-brand-red/10 text-brand-red flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 5h14v14H5V5Zm0 4h14M9 5v4"/></svg>
                </div>
                <h3 class="text-xl font-bold text-brand-ink mb-2">لا توجد مقالات منشورة بعد</h3>
                <p class="text-brand-ink/60">سيتم إضافة المحتوى قريبًا — تابعنا!</p>
            </div>
        @endif
    </div>
</section>

@endsection
