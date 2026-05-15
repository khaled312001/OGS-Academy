<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#A01818">

    <x-seo
        :title="trim(View::yieldContent('seo_title')) ?: null"
        :description="trim(View::yieldContent('seo_description')) ?: null"
        :image="trim(View::yieldContent('seo_image')) ?: null"
        :type="trim(View::yieldContent('seo_type')) ?: 'website'"
        :keywords="trim(View::yieldContent('seo_keywords')) ?: null"
        :jsonLd="$seoJsonLd ?? null" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="icon" type="image/png" href="{{ ($settings['site_favicon'] ?? null) ? asset('storage/'.$settings['site_favicon']) : asset('images/brand/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ ($settings['site_favicon'] ?? null) ? asset('storage/'.$settings['site_favicon']) : asset('images/brand/favicon.png') }}">
    <link rel="alternate" type="application/rss+xml" title="{{ $settings['site_name_ar'] ?? 'OGS' }} - المقالات" href="{{ url('/articles') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="bg-white text-brand-ink font-sans antialiased">

{{-- Skip-to-content link for keyboard users (a11y) --}}
<a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:top-3 focus:right-3 focus:z-[100] focus:bg-brand-red focus:text-white focus:px-4 focus:py-2 focus:rounded-xl focus:shadow-brand focus:font-bold">تخطّي إلى المحتوى الرئيسي</a>

{{-- Reading progress bar --}}
<div data-reading-bar class="fixed top-0 inset-x-0 h-1 z-[60] pointer-events-none">
    <span class="block h-full w-0 bg-gradient-to-l from-brand-flame via-brand-red to-brand-red-700 transition-[width] duration-150"></span>
</div>

@include('components.header')

<main id="main-content" class="min-h-[60vh]" tabindex="-1">
    @yield('content')
</main>

@include('components.footer')

{{-- Back to top button --}}
<button data-back-to-top
        aria-label="العودة لأعلى الصفحة"
        class="fixed bottom-6 right-6 z-40 w-12 h-12 rounded-full bg-brand-red text-white shadow-brand opacity-0 invisible translate-y-2 hover:bg-brand-red-700 hover:scale-110 transition-all duration-300 flex items-center justify-center group">
    <svg class="w-5 h-5 group-hover:-translate-y-0.5 transition" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5"/>
    </svg>
</button>

{{-- Floating WhatsApp button --}}
@if(!empty($settings['contact_whatsapp']))
    <a href="https://wa.me/{{ preg_replace('/\D/', '', $settings['contact_whatsapp']) }}"
       target="_blank" rel="noopener"
       class="fixed bottom-6 left-6 z-40 inline-flex items-center justify-center w-14 h-14 rounded-full bg-[#25D366] text-white shadow-brand hover:scale-110 transition animate-float"
       aria-label="WhatsApp">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7">
            <path d="M20.52 3.48A11.86 11.86 0 0 0 12 0C5.37 0 0 5.37 0 12c0 2.11.55 4.17 1.61 6L0 24l6.27-1.64A11.93 11.93 0 0 0 12 24c6.63 0 12-5.37 12-12 0-3.2-1.25-6.21-3.48-8.52ZM12 21.82a9.82 9.82 0 0 1-5-.36L6.6 21l-3.72.97L3.85 18.4l-.24-.4A9.82 9.82 0 1 1 12 21.82Zm5.4-7.36c-.3-.15-1.77-.87-2.04-.97-.27-.1-.47-.15-.66.15s-.76.97-.93 1.17c-.17.2-.34.22-.64.07-.3-.15-1.26-.46-2.4-1.48a9.02 9.02 0 0 1-1.66-2.06c-.17-.3 0-.46.13-.61.13-.13.3-.34.44-.51.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.07-.15-.66-1.6-.9-2.18-.24-.57-.48-.5-.66-.5h-.56c-.2 0-.5.07-.76.37-.27.3-1 1-1 2.45 0 1.45 1.05 2.86 1.2 3.06.15.2 2.07 3.17 5.02 4.45.7.3 1.25.48 1.67.62.7.22 1.34.19 1.84.12.56-.08 1.77-.72 2.02-1.42.25-.7.25-1.3.17-1.42-.07-.13-.27-.2-.57-.35Z"/>
        </svg>
    </a>
@endif

@stack('scripts')
</body>
</html>
