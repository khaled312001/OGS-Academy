@php
    /** @var \Illuminate\Support\Collection $partners */
    $supervisors = $partners->where('type', 'supervisor')->values();
    $regular     = $partners->whereIn('type', ['partner', 'sponsor', 'accredited'])->values();
@endphp

<section class="relative section-pad overflow-hidden bg-white">
    {{-- Decorative background --}}
    <div class="pointer-events-none absolute inset-0 -z-10">
        <div class="absolute top-1/4 -right-32 w-[28rem] h-[28rem] rounded-full bg-brand-red/[0.04] blur-3xl"></div>
        <div class="absolute bottom-1/4 -left-32 w-[28rem] h-[28rem] rounded-full bg-brand-flame/[0.04] blur-3xl"></div>
        {{-- Subtle grid pattern --}}
        <div class="absolute inset-0 opacity-[0.025]" style="background-image: linear-gradient(#0a0a0a 1px, transparent 1px), linear-gradient(90deg, #0a0a0a 1px, transparent 1px); background-size: 60px 60px;"></div>
    </div>

    <div class="container-x relative">

        {{-- ==== Header ==== --}}
        <div class="text-center max-w-2xl mx-auto mb-16" data-aos="fade-up">
            <span class="kicker">شركاؤنا في النجاح</span>
            <h2 class="heading-2 mt-4">جهات الإشراف والشركاء</h2>
            <p class="text-brand-ink/70 mt-4 leading-relaxed">
                نعمل بإشراف من جهات حكومية وأكاديمية معتمدة، وبشراكة مع نخبة من المؤسسات الرائدة في القطاع الصناعي والتدريبي.
            </p>
        </div>

        {{-- ==== Supervisors (الجهات الإشرافية) ==== --}}
        @if($supervisors->count())
            <div class="mb-16" data-aos="fade-up">
                {{-- Label with flame markers --}}
                <div class="flex items-center justify-center gap-4 mb-10">
                    <span class="hidden sm:block flex-1 max-w-[120px] h-px bg-gradient-to-l from-brand-red/40 to-transparent"></span>
                    <div class="inline-flex items-center gap-3 px-5 py-2.5 rounded-full bg-gradient-to-r from-brand-red-700 to-brand-red text-white shadow-brand">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m9 12 2 2 4-4m5.618-4.016A11.955 11.955 0 0 1 12 2.944a11.955 11.955 0 0 1-8.618 3.04A12.02 12.02 0 0 0 3 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016Z"/>
                        </svg>
                        <span class="text-sm font-extrabold tracking-wide">تحت الإشراف الرسمي</span>
                    </div>
                    <span class="hidden sm:block flex-1 max-w-[120px] h-px bg-gradient-to-r from-brand-red/40 to-transparent"></span>
                </div>

                @php
                    $cols = match (true) {
                        $supervisors->count() <= 1 => 'lg:grid-cols-1',
                        $supervisors->count() === 2 => 'lg:grid-cols-2',
                        $supervisors->count() === 3 => 'lg:grid-cols-3',
                        default => 'lg:grid-cols-4',
                    };
                @endphp
                <div class="grid grid-cols-2 md:grid-cols-3 {{ $cols }} gap-5 max-w-5xl mx-auto">
                    @foreach($supervisors as $i => $p)
                        <a href="{{ $p->website ?: '#' }}" @if($p->website) target="_blank" rel="noopener" @endif
                           class="group relative block rounded-3xl bg-white border border-brand-gray hover:border-brand-red overflow-hidden card-lift"
                           data-aos="fade-up" data-aos-delay="{{ $i * 70 }}">

                            {{-- Top accent bar --}}
                            <span class="absolute top-0 right-6 left-6 h-1 bg-gradient-to-r from-transparent via-brand-red to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></span>

                            {{-- Logo area --}}
                            <div class="aspect-[4/3] flex items-center justify-center p-6 bg-gradient-to-br from-white to-brand-gray-2/40 relative overflow-hidden">
                                {{-- Decorative corner --}}
                                <div class="absolute -top-6 -left-6 w-20 h-20 rounded-full bg-brand-red/0 group-hover:bg-brand-red/10 transition-all duration-500"></div>

                                <img src="{{ $p->logo_url }}" alt="{{ $p->name_ar }}"
                                     class="max-h-full max-w-full object-contain relative transition-all duration-500 grayscale opacity-80 group-hover:grayscale-0 group-hover:opacity-100 group-hover:scale-110">
                            </div>

                            {{-- Caption --}}
                            <div class="px-4 py-3 border-t border-brand-gray bg-white text-center">
                                <p class="text-xs font-bold text-brand-ink leading-tight line-clamp-2 group-hover:text-brand-red transition">
                                    {{ $p->name_ar }}
                                </p>
                                @if($p->name_en)
                                    <p class="text-[10px] text-brand-ink/50 mt-0.5 font-en truncate" dir="ltr">{{ $p->name_en }}</p>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- ==== Regular Partners (الشركاء) ==== --}}
        @if($regular->count())
            <div data-aos="fade-up">
                <div class="flex items-center justify-center gap-4 mb-10">
                    <span class="hidden sm:block flex-1 max-w-[120px] h-px bg-gradient-to-l from-brand-ink/20 to-transparent"></span>
                    <div class="inline-flex items-center gap-3 px-5 py-2.5 rounded-full bg-brand-black text-white">
                        <svg class="w-4 h-4 text-brand-flame" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z"/>
                        </svg>
                        <span class="text-sm font-extrabold tracking-wide">شركاؤنا في القطاع الصناعي</span>
                    </div>
                    <span class="hidden sm:block flex-1 max-w-[120px] h-px bg-gradient-to-r from-brand-ink/20 to-transparent"></span>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    @foreach($regular as $i => $p)
                        <a href="{{ $p->website ?: '#' }}" @if($p->website) target="_blank" rel="noopener" @endif
                           class="group relative aspect-[3/2] rounded-2xl bg-white border border-brand-gray hover:border-brand-red flex items-center justify-center p-5 card-lift overflow-hidden"
                           data-aos="zoom-in" data-aos-delay="{{ ($i % 6) * 50 }}">
                            <img src="{{ $p->logo_url }}" alt="{{ $p->name_ar }}"
                                 class="max-h-full max-w-full object-contain grayscale opacity-70 group-hover:grayscale-0 group-hover:opacity-100 group-hover:scale-110 transition-all duration-500">
                            {{-- Tooltip on hover --}}
                            <span class="absolute inset-x-0 bottom-0 bg-brand-red text-white text-[11px] font-bold py-1.5 text-center translate-y-full group-hover:translate-y-0 transition-transform duration-300 truncate px-2">
                                {{ $p->name_ar }}
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- ==== Bottom CTA strip ==== --}}
        @if(isset($showCta) && $showCta)
            <div class="mt-16 text-center" data-aos="fade-up">
                <p class="text-sm text-brand-ink/60 mb-4">هل ترغب في الانضمام لشبكة شركائنا؟</p>
                <a href="{{ route('contact') }}" class="btn btn-outline">
                    تواصل معنا
                    <svg class="w-4 h-4 -rotate-180" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        @endif
    </div>
</section>
