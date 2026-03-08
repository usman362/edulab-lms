 @php
     $activeThemeSnake = key_snake_case(active_theme_slug());
     $themeLogoOption = get_theme_option(key: 'theme_logo_' . $activeThemeSnake) ?? get_theme_option(key: 'theme_logo');
     $backendLogo = get_theme_option(key: 'backend_logo') ?? [];
     $logo = (!empty($themeLogoOption['logo']) || !empty($themeLogoOption['favicon'])) ? $themeLogoOption : $backendLogo;
     $defaultLogo = $defaultLogo ?? edulab_global_asset('lms/frontend/assets/images/logo/default-logo-dark.svg');
     $themeLogo =
         isset($logo['logo']) && fileExists($folder = 'lms/theme-options', $fileName = $logo['logo']) == true
             ? edulab_asset("lms/theme-options/{$logo['logo']}")
             : $defaultLogo;
 @endphp
 <a href="{{ route('home.index') }}" class="flex-center">
     <img data-src="{{ $themeLogo }}" alt="Header site logo" class="max-w-24 sm:max-w-40">
 </a>
