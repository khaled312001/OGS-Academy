@php
    $logo = ($settings['site_logo_white'] ?? null) ? asset('storage/'.$settings['site_logo_white']) : asset('images/brand/ogs-logo-white.png');
@endphp
<footer class="relative bg-brand-black text-white pt-20 pb-8 mt-20 overflow-hidden">
    {{-- Decorative red gradient --}}
    <div class="pointer-events-none absolute -top-32 -right-32 w-96 h-96 rounded-full bg-brand-red/20 blur-3xl"></div>
    <div class="pointer-events-none absolute -bottom-32 -left-32 w-96 h-96 rounded-full bg-brand-flame/10 blur-3xl"></div>

    <div class="container-x relative">
        {{-- CTA strip --}}
        <div class="rounded-3xl bg-gradient-to-r from-brand-red-900 via-brand-red to-brand-red-700 p-8 md:p-12 mb-16 shadow-brand grid md:grid-cols-2 gap-6 items-center" data-aos="zoom-in">
            <div>
                <span class="kicker !text-white/80">شراكة استراتيجية</span>
                <h3 class="text-2xl md:text-3xl font-extrabold mt-2">هل تبحث عن برنامج تدريبي مخصَّص لشركتك؟</h3>
                <p class="text-white/80 mt-3 max-w-md">فريقنا جاهز لتصميم برنامج يناسب احتياجات فريقك ويتوافق مع أهدافك الميدانية.</p>
            </div>
            <div class="flex md:justify-end gap-3 flex-wrap">
                <a href="{{ route('contact') }}" class="btn bg-white text-brand-red hover:bg-brand-gray">تواصل معنا</a>
                <a href="{{ route('programs.index') }}" class="btn btn-ghost">استعرض البرامج</a>
            </div>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-10">
            <div>
                <img src="{{ $logo }}" class="h-14 mb-6" alt="OGS Academy">
                <p class="text-white/70 leading-relaxed text-sm">
                    {{ $settings['site_tagline_ar'] ?? 'تحت إشراف المؤسسة العامة للتدريب التقني والمهني' }}
                </p>
                @php
                    $socialIcons = [
                        'twitter'   => ['label' => 'X (Twitter)', 'svg' => '<svg viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231L18.244 2.25Zm-1.161 17.52h1.833L7.084 4.126H5.117L17.083 19.77Z"/></svg>'],
                        'linkedin'  => ['label' => 'LinkedIn',    'svg' => '<svg viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4"><path d="M19 0H5a5 5 0 0 0-5 5v14a5 5 0 0 0 5 5h14a5 5 0 0 0 5-5V5a5 5 0 0 0-5-5ZM8 19H5V8h3v11ZM6.5 6.732c-.966 0-1.75-.79-1.75-1.764S5.534 3.204 6.5 3.204s1.75.79 1.75 1.764-.784 1.764-1.75 1.764ZM20 19h-3v-5.604c0-3.368-4-3.113-4 0V19h-3V8h3v1.765C14.396 8.179 20 8.06 20 13.31V19Z"/></svg>'],
                        'instagram' => ['label' => 'Instagram',   'svg' => '<svg viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069ZM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0Zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324ZM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8Zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881Z"/></svg>'],
                        'youtube'   => ['label' => 'YouTube',     'svg' => '<svg viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814ZM9.545 15.568V8.432L15.818 12l-6.273 3.568Z"/></svg>'],
                        'facebook'  => ['label' => 'Facebook',    'svg' => '<svg viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4"><path d="M24 12.073C24 5.405 18.627 0 12 0S0 5.405 0 12.073C0 18.1 4.388 23.094 10.125 24v-8.437H7.078v-3.49h3.047V9.412c0-3.017 1.792-4.682 4.532-4.682 1.313 0 2.686.235 2.686.235v2.971h-1.513c-1.491 0-1.955.93-1.955 1.886v2.262h3.328l-.532 3.49h-2.796V24C19.612 23.094 24 18.1 24 12.073Z"/></svg>'],
                    ];
                @endphp
                <div class="flex gap-3 mt-6">
                    @foreach($socialIcons as $sn => $meta)
                        @if(!empty($settings['social_'.$sn]))
                            <a href="{{ $settings['social_'.$sn] }}" target="_blank" rel="noopener noreferrer"
                               aria-label="{{ $meta['label'] }}"
                               title="{{ $meta['label'] }}"
                               class="w-10 h-10 rounded-full bg-white/10 hover:bg-brand-red flex items-center justify-center transition hover:scale-110">
                                {!! $meta['svg'] !!}
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>

            <div>
                <h4 class="font-bold text-lg mb-5 flex items-center gap-2"><span class="flame-bar"></span> روابط سريعة</h4>
                <ul class="space-y-3 text-sm text-white/70">
                    <li><a href="{{ route('home') }}" class="hover:text-white transition">الرئيسية</a></li>
                    <li><a href="{{ route('programs.index') }}" class="hover:text-white transition">البرامج التدريبية</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-white transition">من نحن</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-white transition">تواصل معنا</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-lg mb-5 flex items-center gap-2"><span class="flame-bar"></span> تصنيفات البرامج</h4>
                <ul class="space-y-3 text-sm text-white/70">
                    @foreach(($navCategories ?? collect()) as $cat)
                        <li><a href="{{ route('programs.index', ['category' => $cat->slug]) }}" class="hover:text-white transition">{{ $cat->name_ar }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-lg mb-5 flex items-center gap-2"><span class="flame-bar"></span> تواصل معنا</h4>
                <ul class="space-y-4 text-sm text-white/80">
                    @if(!empty($settings['contact_address_ar']))
                        <li class="flex gap-3 items-start">
                            <span class="w-8 h-8 shrink-0 rounded-full bg-brand-red/20 flex items-center justify-center"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.66 17.66A8 8 0 1 0 6.34 6.34l5.66 5.66 5.66 5.66Z"/><circle cx="12" cy="12" r="3"/></svg></span>
                            <span>{{ $settings['contact_address_ar'] }}</span>
                        </li>
                    @endif
                    @if(!empty($settings['contact_email']))
                        <li class="flex gap-3 items-center">
                            <span class="w-8 h-8 shrink-0 rounded-full bg-brand-red/20 flex items-center justify-center"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 8l9 6 9-6M3 8v10a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V8M3 8a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2"/></svg></span>
                            <a href="mailto:{{ $settings['contact_email'] }}" dir="ltr">{{ $settings['contact_email'] }}</a>
                        </li>
                    @endif
                    @if(!empty($settings['contact_phone']))
                        <li class="flex gap-3 items-center">
                            <span class="w-8 h-8 shrink-0 rounded-full bg-brand-red/20 flex items-center justify-center"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 0 1 2-2h2.3a1 1 0 0 1 .97.76l1.2 4.8a1 1 0 0 1-.27.95l-2 2a16 16 0 0 0 6.29 6.29l2-2a1 1 0 0 1 .95-.27l4.8 1.2a1 1 0 0 1 .76.97V19a2 2 0 0 1-2 2A17 17 0 0 1 3 5Z"/></svg></span>
                            <a href="tel:{{ $settings['contact_phone'] }}" dir="ltr">{{ $settings['contact_phone'] }}</a>
                        </li>
                    @endif
                    @if(!empty($settings['work_hours_ar']))
                        <li class="flex gap-3 items-center">
                            <span class="w-8 h-8 shrink-0 rounded-full bg-brand-red/20 flex items-center justify-center"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" d="M12 7v5l3 3"/></svg></span>
                            <span>{{ $settings['work_hours_ar'] }}</span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

        {{-- Supervisors strip --}}
        @if(($footerPartners ?? collect())->count())
            <div class="mt-16 pt-10 border-t border-white/10">
                <p class="text-center text-xs uppercase tracking-[.25em] text-white/50 mb-6">تحت إشراف وبشراكة مع</p>
                <div class="flex flex-wrap items-center justify-center gap-x-12 gap-y-6 opacity-80">
                    @foreach($footerPartners as $p)
                        <img src="{{ $p->logo_url }}" alt="{{ $p->name_ar }}" class="h-12 max-w-[140px] object-contain grayscale invert opacity-80 hover:opacity-100 hover:grayscale-0 transition">
                    @endforeach
                </div>
            </div>
        @endif

        <div class="mt-12 pt-8 border-t border-white/10 flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-white/50">
            <p>© {{ now()->year }} {{ $settings['site_name_ar'] ?? 'أكاديمية OGS' }}. جميع الحقوق محفوظة.</p>
            <p>صُمِّم وطُوِّر بواسطة <a href="https://khaledahmed.net" target="_blank" rel="noopener" class="text-white hover:text-brand-flame">Barmagly</a></p>
        </div>
    </div>
</footer>
