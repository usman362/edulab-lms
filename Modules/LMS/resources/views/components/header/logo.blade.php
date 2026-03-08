@php
    $themeLogo = get_theme_option(key: 'theme_logo') ?? [];
    $backendLogo = get_theme_option(key: 'backend_logo') ?? [];
    $logo_name = !empty($themeLogo['logo']) ? $themeLogo['logo'] : (get_theme_option(key: 'logo', parent_key: 'theme_logo') ?? null);
    if (empty($logo_name) && !empty($backendLogo['logo'])) {
        $logo_name = $backendLogo['logo'];
    }
    $mainLogo =
        $logo_name && fileExists('lms/theme-options', $logo_name) == true
            ? edulab_asset("lms/theme-options/{$logo_name}")
            : edulab_global_asset('lms/frontend/assets/images/logo/default-logo-dark.svg');
    $logo = $defaultLogo ?? $mainLogo;
@endphp
<!-- LOGO -->
<a href="{{ route('home.index') }}" class="flex-center">
    <img data-src="{{ $logo }}" alt="Header logo" class="max-w-24 sm:max-w-40">
</a>
