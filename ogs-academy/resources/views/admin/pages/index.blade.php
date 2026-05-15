@extends('layouts.admin')
@section('title', 'إدارة صفحات الموقع')
@section('subtitle', 'تحرير محتوى كل صفحة من صفحات الموقع — كل قسم، كل صورة، كل نص')

@section('content')

<div class="grid md:grid-cols-2 gap-5">
    @foreach($pages as $slug => $page)
        @php
            $sectionsCount = count($page['sections'] ?? []);
            $hasDbContent  = ! empty($page['page_db_slug']);
            $canEdit       = $sectionsCount > 0 || $hasDbContent;
            $color         = $page['color'] ?? '#A01818';
            $sectionsList  = $page['sections'] ?? [];
        @endphp

        <div class="rounded-2xl bg-white border border-brand-gray overflow-hidden flex flex-col card-lift">

            {{-- ===== Colored brand header (always visible) ===== --}}
            <div class="relative p-5 text-white overflow-hidden" style="background: linear-gradient(135deg, {{ $color }} 0%, #0A0A0A 100%);">
                {{-- Background image overlay (optional, low opacity) --}}
                @if(! empty($page['cover']))
                    <div class="absolute inset-0 bg-cover bg-center opacity-25 mix-blend-luminosity" style="background-image: url('{{ asset($page['cover']) }}');"></div>
                @endif
                {{-- Decorative flame --}}
                <div class="absolute -top-8 -left-8 w-32 h-32 rounded-full bg-white/10 blur-2xl"></div>

                <div class="relative flex items-start justify-between gap-4">
                    <div class="flex-1 min-w-0">
                        <div class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md bg-white/15 backdrop-blur text-[10px] font-bold mb-2" dir="ltr">
                            {{ $page['preview_url'] }}
                        </div>
                        <h3 class="text-xl font-extrabold leading-tight mb-1.5">{{ $page['title'] }}</h3>
                        <p class="text-white/80 text-xs leading-relaxed line-clamp-2">{{ $page['description'] }}</p>
                    </div>
                    <span class="shrink-0 w-12 h-12 rounded-xl bg-white/15 backdrop-blur flex items-center justify-center">
                        @switch($page['icon'])
                            @case('home')   <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="m3 12 9-9 9 9M5 10v10h14V10"/></svg> @break
                            @case('book')   <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M12 6.04A8.97 8.97 0 0 0 6 3.75c-1.05 0-2.06.18-3 .51v14.25A8.99 8.99 0 0 1 6 18c2.3 0 4.41.87 6 2.29m0-14.25a8.97 8.97 0 0 1 6-2.29c1.05 0 2.06.18 3 .51v14.25A8.99 8.99 0 0 0 18 18a8.97 8.97 0 0 0-6 2.29m0-14.25v14.25"/></svg> @break
                            @case('pencil') <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="m16.86 4.49 2.65 2.65a1.5 1.5 0 0 1 0 2.12l-9.4 9.4a2 2 0 0 1-1.06.55l-3.85.66a.5.5 0 0 1-.58-.58l.66-3.85a2 2 0 0 1 .55-1.06l9.4-9.4a1.5 1.5 0 0 1 2.12 0Z"/></svg> @break
                            @case('mail')   <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 8l9 6 9-6M3 8v10a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V8"/></svg> @break
                            @default        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M14 3v6h6M14 3H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9l-6-6Z"/></svg>
                        @endswitch
                    </span>
                </div>
            </div>

            {{-- ===== Sections list ===== --}}
            <div class="p-5 flex-1">
                @if($canEdit)
                    <p class="text-xs text-brand-ink/50 uppercase tracking-wider font-bold mb-3">
                        @if($sectionsCount)
                            {{ $sectionsCount }} {{ $sectionsCount === 1 ? 'قسم قابل للتحرير' : 'أقسام قابلة للتحرير' }}
                        @else
                            محتوى قابل للتحرير
                        @endif
                    </p>
                    <ul class="space-y-2 text-sm">
                        @foreach($sectionsList as $sKey => $section)
                            <li class="flex items-center gap-2.5 px-3 py-2 rounded-lg bg-brand-gray-2/60 hover:bg-brand-gray-2 transition">
                                <span class="w-1.5 h-1.5 rounded-full bg-brand-red shrink-0"></span>
                                <span class="font-semibold text-brand-ink flex-1 truncate">{{ $section['label'] }}</span>
                                <span class="text-xs text-brand-ink/50">{{ count($section['fields'] ?? []) }} حقل</span>
                            </li>
                        @endforeach
                        @if($hasDbContent)
                            <li class="flex items-center gap-2.5 px-3 py-2 rounded-lg bg-brand-gray-2/60 hover:bg-brand-gray-2 transition">
                                <span class="w-1.5 h-1.5 rounded-full bg-brand-flame shrink-0"></span>
                                <span class="font-semibold text-brand-ink flex-1 truncate">المحتوى التفصيلي + الرؤية والقيم</span>
                                <span class="text-xs text-brand-ink/50">محتوى ديناميكي</span>
                            </li>
                        @endif
                    </ul>
                @else
                    <div class="text-center py-4">
                        <p class="text-xs text-brand-ink/50 uppercase tracking-wider font-bold mb-2">صفحة عرض ديناميكي</p>
                        <p class="text-xs text-brand-ink/70 leading-relaxed">{{ $page['note'] ?? 'محتوى هذه الصفحة يتم إدارته من قسم آخر.' }}</p>
                    </div>
                @endif
            </div>

            {{-- ===== Action footer ===== --}}
            <div class="px-5 pb-5 pt-3 border-t border-brand-gray bg-brand-gray-2/30 flex items-center gap-2">
                @if($canEdit)
                    <a href="{{ route('admin.pages.edit', $slug) }}" class="btn btn-primary flex-1 !py-2.5 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="m16.86 4.49 2.65 2.65a1.5 1.5 0 0 1 0 2.12l-9.4 9.4a2 2 0 0 1-1.06.55l-3.85.66a.5.5 0 0 1-.58-.58l.66-3.85a2 2 0 0 1 .55-1.06l9.4-9.4a1.5 1.5 0 0 1 2.12 0Z"/></svg>
                        تعديل الأقسام
                    </a>
                @elseif(! empty($page['cta_links']))
                    @foreach($page['cta_links'] as $cta)
                        <a href="{{ route($cta['route']) }}" class="btn btn-primary flex-1 !py-2.5 text-sm">
                            {{ $cta['label'] }}
                        </a>
                    @endforeach
                @endif

                @if(! empty($page['preview_url']))
                    <a href="{{ url($page['preview_url']) }}" target="_blank" rel="noopener"
                       class="btn btn-outline !py-2.5 !px-4 text-sm shrink-0" title="معاينة على الموقع">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M2 12s4-8 10-8 10 8 10 8-4 8-10 8S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg>
                    </a>
                @endif
            </div>
        </div>
    @endforeach
</div>

<div class="mt-8 p-5 rounded-2xl bg-blue-50 border border-blue-200 text-sm">
    <p class="font-bold text-blue-900 mb-1 flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" d="M12 8v4m0 4h.01"/></svg>
        كيف يعمل هذا القسم؟
    </p>
    <ul class="text-blue-800/80 leading-relaxed text-xs space-y-1 list-disc pr-4">
        <li>كل صفحة من صفحات الموقع منظَّمة في أقسام قابلة للتحرير ظاهرة في الكارد.</li>
        <li>اضغط "تعديل الأقسام" للدخول لمحرّر تفصيلي لكل قسم على حدة.</li>
        <li>التغييرات تظهر مباشرة على الموقع بدون أي خطوات إضافية.</li>
        <li>صفحات مثل "البرامج" و"المقالات" تعرض محتوى ديناميكي من أقسام أخرى — استخدم الأزرار لإدارة المحتوى الخاص بها.</li>
    </ul>
</div>

@endsection
