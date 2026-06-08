@php
    $backendSetting = get_theme_option(key: 'backend_general') ?? [];
    $backendLogo = get_theme_option(key: 'backend_logo') ?? [];
    $themeLogo = $data['logo_options'] ?? get_theme_option(key: 'theme_logo') ?? [];
    $logo = !empty($themeLogo['logo']) || !empty($themeLogo['favicon']) ? $themeLogo : $backendLogo;

    $defaultFavIcon =
        isset($logo['favicon']) && fileExists('lms/theme-options', $logo['favicon']) == true
            ? edulab_asset("lms/theme-options/{$logo['favicon']}")
            : edulab_global_asset('lms/frontend/assets/images/favicon.svg');
    $favIcon = $data['fav_icon'] ?? $defaultFavIcon;

    $customScript = get_theme_option('custom_script') ?? [];
    $customCss = $customScript['custom_css'] ?? '';
    $customJs = $customScript['custom_js'] ?? '';
    $primaryColor = $backendSetting['primary_color'] ?? '#0d9488';
    if (!preg_match('/^#[0-9A-Fa-f]{6}$/', $primaryColor)) {
        $primaryColor = '#0d9488';
    }
@endphp

<!DOCTYPE html>
<html lang="{{ app()->getLocale() ?? app('default_language') }}" class="group" dir="{{ active_rtl() }}">

<head>
    {{-- Google tag (gtag.js) — ACE Academic GA4 property G-R4REKGPH05.
         Placed immediately after <head> per Google's install guide. --}}
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-R4REKGPH05"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-R4REKGPH05');
    </script>

    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ $backendSetting['app_name'] ?? translate('Ace Academics') }} — Expert Tutoring in Brisbane</title>
    <meta name="description" content="{{ $backendSetting['site_description'] ?? 'Ace Academics — Achieve academic excellence with expert tutors in Brisbane. Selective School, NAPLAN, ATAR & Scholarship Exam Preparation.' }}">
    <meta name="keywords" content="{{ $backendSetting['site_keywords'] ?? 'tutoring, Brisbane, ATAR, NAPLAN, selective school, scholarship, UCAT, Ace Academics' }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ $favIcon }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&family=Public+Sans:ital,wght@0,100..900;1,100..900&display=swap">
    @stack('css')
    <link rel="stylesheet" href="{{ edulab_global_asset('lms/assets/css/vendor/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ edulab_global_asset('lms/frontend/assets/vendor/css/swiper-bundle.min.css') }}">
    <script src="{{ edulab_global_asset('lms/frontend/assets/vendor/js/lozad.min.js') }}"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.14.3/cdn.min.js"></script>
    <link rel="stylesheet"
        href="{{ edulab_global_asset('lms/frontend/assets/css/output.min.css?v=' . asset_version('lms/frontend/assets/css/output.min.css')) }}">
    @if ($customCss)
        <style>
            {!! $customCss !!}
        </style>
    @endif
    <style>
        /* ── ACE design-system tokens ──────────────────────────────────────────
           The admin's single brand colour ($primaryColor) generates the WHOLE
           red ramp via color-mix so bg-primary-50/100/200 are always a soft-red
           wash (never the old teal) and primary-300..600 are always defined
           (previously undefined → ~572 dead utilities). --color-secondary is a
           RESERVED gold accent (ratings / prestige only), never equal to primary. */
        :root {
            --color-primary: {{ $primaryColor }};
            --color-primary-50: color-mix(in srgb, {{ $primaryColor }} 6%, #fff);
            --color-primary-100: color-mix(in srgb, {{ $primaryColor }} 14%, #fff);
            --color-primary-200: color-mix(in srgb, {{ $primaryColor }} 30%, #fff);
            --color-primary-300: color-mix(in srgb, {{ $primaryColor }} 46%, #fff);
            --color-primary-400: color-mix(in srgb, {{ $primaryColor }} 66%, #fff);
            --color-primary-500: {{ $primaryColor }};
            --color-primary-600: color-mix(in srgb, {{ $primaryColor }} 80%, #000);
            --color-primary-700: color-mix(in srgb, {{ $primaryColor }} 62%, #000);
            --color-secondary: #F4B826;
            --color-section: color-mix(in srgb, {{ $primaryColor }} 6%, #fff);
        }

        /* Logo sizing + nav spacing — kept until logo/menu components absorb these. */
        header img {
            max-height: 56px;
        }
    </style>
</head>
