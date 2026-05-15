@props([
    'title'       => null,
    'description' => null,
    'image'       => null,
    'type'        => 'website',
    'keywords'    => null,
    'jsonLd'      => null,
])

@php
    $settings = $settings ?? [];
    $siteName    = $settings['site_name_ar'] ?? 'أكاديمية OGS';
    $defaultTitle= $settings['meta_title']  ?? $siteName;
    $defaultDesc = $settings['meta_description'] ?? '';
    $defaultKey  = $settings['meta_keywords'] ?? '';

    $finalTitle  = $title ? trim($title) . ' | ' . $siteName : $defaultTitle;
    $finalDesc   = $description ?: $defaultDesc;
    $finalImage  = $image ?: ( ($settings['hero_image'] ?? null) ? asset('storage/'.$settings['hero_image']) : asset('images/brand/hero-industrial.jpg') );
    $finalKeys   = $keywords ?: $defaultKey;
    $canonical   = url()->current();
    $locale      = app()->getLocale() === 'ar' ? 'ar_SA' : 'en_US';
@endphp

<title>{{ $finalTitle }}</title>
<meta name="description" content="{{ $finalDesc }}">
@if($finalKeys)<meta name="keywords" content="{{ $finalKeys }}">@endif
<meta name="robots" content="index, follow, max-image-preview:large">
<meta name="author" content="{{ $siteName }}">
<link rel="canonical" href="{{ $canonical }}">

{{-- Open Graph --}}
<meta property="og:type" content="{{ $type }}">
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:locale" content="{{ $locale }}">
<meta property="og:title" content="{{ $finalTitle }}">
<meta property="og:description" content="{{ $finalDesc }}">
<meta property="og:url" content="{{ $canonical }}">
<meta property="og:image" content="{{ $finalImage }}">
<meta property="og:image:alt" content="{{ $finalTitle }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">

{{-- Twitter --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $finalTitle }}">
<meta name="twitter:description" content="{{ $finalDesc }}">
<meta name="twitter:image" content="{{ $finalImage }}">

{{-- JSON-LD structured data --}}
@if($jsonLd)
    <script type="application/ld+json">{!! json_encode($jsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endif

{{-- Organization JSON-LD (always) --}}
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type'    => 'EducationalOrganization',
    'name'     => $siteName,
    'alternateName' => $settings['site_name_en'] ?? 'OGS Academy',
    'url'      => url('/'),
    'logo'     => ($settings['site_logo'] ?? null) ? asset('storage/'.$settings['site_logo']) : asset('images/brand/ogs-logo.png'),
    'description' => $defaultDesc,
    'address'  => [
        '@type' => 'PostalAddress',
        'streetAddress'   => $settings['contact_address_ar'] ?? '',
        'addressLocality' => 'Makkah',
        'addressCountry'  => 'SA',
    ],
    'contactPoint' => [
        '@type'       => 'ContactPoint',
        'telephone'   => $settings['contact_phone'] ?? '',
        'email'       => $settings['contact_email'] ?? '',
        'contactType' => 'customer service',
        'areaServed'  => 'SA',
        'availableLanguage' => ['Arabic','English'],
    ],
    'sameAs' => array_values(array_filter([
        $settings['social_twitter']   ?? null,
        $settings['social_linkedin']  ?? null,
        $settings['social_instagram'] ?? null,
        $settings['social_youtube']   ?? null,
        $settings['social_facebook']  ?? null,
    ])),
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
