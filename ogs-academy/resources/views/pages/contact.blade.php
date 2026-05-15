@extends('layouts.app')
@section('seo_title', 'تواصل معنا')
@section('seo_description', 'تواصل مع فريق OGS لتصميم برنامج تدريبي مخصَّص لاحتياجات شركتك في مكة المكرمة.')

@section('content')

{{-- HERO --}}
<section class="relative pt-40 pb-20 bg-brand-black text-white overflow-hidden">
    <div class="absolute inset-0 hero-overlay"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 rounded-full bg-brand-red/20 blur-3xl"></div>
    <div class="container-x relative">
        <div class="max-w-3xl" data-aos="fade-up">
            <span class="kicker !text-brand-flame">تواصل معنا</span>
            <h1 class="text-4xl md:text-6xl font-extrabold mt-3 leading-tight">دعنا نبدأ بناء برنامج تدريبي يناسب فريقك</h1>
            <p class="text-xl text-white/80 mt-5 leading-relaxed max-w-2xl">
                فريقنا جاهز للرد على استفساراتك وتصميم برنامج تدريبي مخصَّص لاحتياجات شركتك.
            </p>
        </div>
    </div>
</section>

<section class="section-pad bg-white">
    <div class="container-x grid lg:grid-cols-[1fr_1.2fr] gap-12">

        {{-- Contact info --}}
        <div data-aos="fade-up">
            <span class="kicker">معلومات الاتصال</span>
            <h2 class="heading-2 mt-3 mb-8">تواصل معنا مباشرة</h2>

            <div class="space-y-5">
                @if(!empty($settings['contact_address_ar']))
                    <div class="flex gap-4 items-start p-5 rounded-2xl bg-brand-gray-2">
                        <span class="w-12 h-12 shrink-0 rounded-xl bg-brand-red text-white flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>
                        </span>
                        <div>
                            <p class="text-sm text-brand-ink/60 mb-1">العنوان</p>
                            <p class="font-bold text-brand-ink">{{ $settings['contact_address_ar'] }}</p>
                        </div>
                    </div>
                @endif

                @if(!empty($settings['contact_phone']))
                    <a href="tel:{{ $settings['contact_phone'] }}" class="flex gap-4 items-start p-5 rounded-2xl bg-brand-gray-2 hover:bg-brand-red hover:text-white transition group">
                        <span class="w-12 h-12 shrink-0 rounded-xl bg-brand-red group-hover:bg-white text-white group-hover:text-brand-red flex items-center justify-center transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 0 1 2-2h2.3a1 1 0 0 1 .97.76l1.2 4.8a1 1 0 0 1-.27.95l-2 2a16 16 0 0 0 6.29 6.29l2-2a1 1 0 0 1 .95-.27l4.8 1.2a1 1 0 0 1 .76.97V19a2 2 0 0 1-2 2A17 17 0 0 1 3 5Z"/></svg>
                        </span>
                        <div>
                            <p class="text-sm text-brand-ink/60 group-hover:text-white/70 mb-1 transition">الهاتف</p>
                            <p class="font-bold text-brand-ink group-hover:text-white transition" dir="ltr">{{ $settings['contact_phone'] }}</p>
                        </div>
                    </a>
                @endif

                @if(!empty($settings['contact_email']))
                    <a href="mailto:{{ $settings['contact_email'] }}" class="flex gap-4 items-start p-5 rounded-2xl bg-brand-gray-2 hover:bg-brand-red hover:text-white transition group">
                        <span class="w-12 h-12 shrink-0 rounded-xl bg-brand-red group-hover:bg-white text-white group-hover:text-brand-red flex items-center justify-center transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 8l9 6 9-6M3 8v10a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V8M3 8a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2"/></svg>
                        </span>
                        <div>
                            <p class="text-sm text-brand-ink/60 group-hover:text-white/70 mb-1 transition">البريد الإلكتروني</p>
                            <p class="font-bold text-brand-ink group-hover:text-white transition" dir="ltr">{{ $settings['contact_email'] }}</p>
                        </div>
                    </a>
                @endif

                @if(!empty($settings['work_hours_ar']))
                    <div class="flex gap-4 items-start p-5 rounded-2xl bg-brand-gray-2">
                        <span class="w-12 h-12 shrink-0 rounded-xl bg-brand-red text-white flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" d="M12 7v5l3 3"/></svg>
                        </span>
                        <div>
                            <p class="text-sm text-brand-ink/60 mb-1">ساعات العمل</p>
                            <p class="font-bold text-brand-ink">{{ $settings['work_hours_ar'] }}</p>
                        </div>
                    </div>
                @endif
            </div>

            @if(!empty($settings['contact_map_url']))
                <a href="{{ $settings['contact_map_url'] }}" target="_blank" rel="noopener" class="btn btn-outline mt-8">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498 4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 0 0-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0Z"/></svg>
                    افتح على الخريطة
                </a>
            @endif
        </div>

        {{-- Form --}}
        <div data-aos="fade-left">
            @if(session('success'))
                <div class="mb-6 p-5 rounded-2xl bg-green-50 border border-green-200 text-green-800 flex items-start gap-3">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('contact.store') }}" class="p-8 rounded-3xl bg-brand-gray-2 space-y-5" x-data="{ loading: false }" @submit="loading = true">
                @csrf
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold mb-2 text-brand-ink">الاسم الكامل <span class="text-brand-red">*</span></label>
                        <input type="text" name="full_name" value="{{ old('full_name') }}" required
                               class="w-full rounded-xl bg-white border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">
                        @error('full_name') <p class="text-brand-red text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-2 text-brand-ink">البريد الإلكتروني <span class="text-brand-red">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" required dir="ltr"
                               class="w-full rounded-xl bg-white border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">
                        @error('email') <p class="text-brand-red text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold mb-2 text-brand-ink">رقم الجوال</label>
                        <input type="tel" name="phone" value="{{ old('phone') }}" dir="ltr"
                               class="w-full rounded-xl bg-white border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-2 text-brand-ink">الموضوع</label>
                        <input type="text" name="subject" value="{{ old('subject') }}"
                               class="w-full rounded-xl bg-white border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold mb-2 text-brand-ink">الرسالة <span class="text-brand-red">*</span></label>
                    <textarea name="message" rows="6" required
                              class="w-full rounded-xl bg-white border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">{{ old('message') }}</textarea>
                    @error('message') <p class="text-brand-red text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <button type="submit" :disabled="loading" class="btn btn-primary w-full disabled:opacity-60 disabled:cursor-wait">
                    <span x-show="!loading" class="flex items-center gap-2">
                        إرسال الرسالة
                        <svg class="w-4 h-4 -rotate-180" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </span>
                    <span x-show="loading" class="flex items-center gap-2">
                        <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke-opacity="0.25"/><path stroke-linecap="round" d="M22 12a10 10 0 0 0-10-10"/></svg>
                        جارٍ الإرسال...
                    </span>
                </button>
            </form>
        </div>
    </div>
</section>

{{-- MAP --}}
@if(!empty($settings['contact_map_url']))
<section class="bg-white pb-20">
    <div class="container-x">
        <div class="rounded-3xl overflow-hidden shadow-soft" data-aos="fade-up">
            <iframe src="https://maps.google.com/maps?q=Umm+Al-Qura+University+Makkah&output=embed" class="w-full h-[400px]" frameborder="0"></iframe>
        </div>
    </div>
</section>
@endif

@endsection
