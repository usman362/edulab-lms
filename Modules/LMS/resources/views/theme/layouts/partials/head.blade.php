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
        :root {
            --color-primary: {{ $primaryColor }};
            --color-secondary: {{ $primaryColor }};
        }

        header img {
            max-height: 75px !important;
        }

        nav {
            padding-left: 100px !important;
        }
    </style>
</head>
