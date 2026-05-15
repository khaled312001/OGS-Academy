@php
    /** @var \App\Models\Program $program */
    $delay = $delay ?? 0;
@endphp
<a href="{{ route('programs.show', $program->slug) }}"
   class="card-lift group relative block rounded-2xl overflow-hidden bg-white border border-brand-gray hover:border-brand-red transition shadow-soft"
   data-aos="fade-up" data-aos-delay="{{ $delay }}">

    <div class="aspect-[16/10] overflow-hidden bg-brand-gray-2 relative">
        @if($program->cover_image)
            <img src="{{ $program->cover_url }}" alt="{{ $program->title_ar }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-105">
        @else
            <div class="w-full h-full bg-gradient-to-br from-brand-red via-brand-red-700 to-brand-black flex items-center justify-center">
                <svg class="w-20 h-20 text-white/30" viewBox="0 0 24 24" fill="currentColor"><path d="M13.5.67s.74 2.65.74 4.8c0 2.06-1.35 3.73-3.41 3.73-2.07 0-3.63-1.67-3.63-3.73l.03-.36C5.21 7.51 4 10.62 4 14a8 8 0 1 0 16 0c0-4.16-2-7.88-6.5-13.33Z"/></svg>
            </div>
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-brand-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition"></div>

        @if($program->is_featured)
            <span class="absolute top-4 right-4 bg-brand-flame text-white text-xs font-bold px-3 py-1 rounded-full shadow-brand">
                ⚡ مميَّز
            </span>
        @endif

        @if($program->category)
            <span class="absolute bottom-4 right-4 inline-flex items-center gap-2 bg-white/90 backdrop-blur text-brand-ink text-xs font-bold px-3 py-1.5 rounded-full">
                <span class="w-2 h-2 rounded-full" style="background:{{ $program->category->color ?? '#A01818' }}"></span>
                {{ $program->category->name_ar }}
            </span>
        @endif
    </div>

    <div class="p-6">
        <h3 class="text-lg font-extrabold text-brand-ink leading-tight line-clamp-2 mb-2 group-hover:text-brand-red transition">
            {{ $program->title_ar }}
        </h3>
        @if($program->summary_ar)
            <p class="text-sm text-brand-ink/70 leading-relaxed line-clamp-2 mb-5">{{ $program->summary_ar }}</p>
        @endif

        <div class="flex items-center gap-4 text-xs text-brand-ink/60 mb-5">
            @if($program->duration_label)
                <span class="inline-flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-brand-red" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" d="M12 7v5l3 3"/></svg>
                    {{ $program->duration_label }}
                </span>
            @endif
            @if($program->level)
                <span class="inline-flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-brand-red" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7h7l-4 4m4-4l-4-4M3 17l4-4 4 4-4 4z"/></svg>
                    {{ $program->level }}
                </span>
            @endif
        </div>

        <div class="flex items-center justify-between pt-5 border-t border-brand-gray">
            <span class="text-sm font-bold text-brand-red">{{ $program->price_label ?? 'حسب الطلب' }}</span>
            <span class="inline-flex items-center gap-1 text-sm font-bold text-brand-ink group-hover:text-brand-red group-hover:gap-3 transition-all">
                اكتشف
                <svg class="w-4 h-4 -rotate-180" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </span>
        </div>
    </div>
</a>
