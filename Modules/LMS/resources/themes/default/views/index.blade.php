@php
    $themeLogo = get_theme_option(key: 'theme_logo') ?? [];
    $backendLogo = get_theme_option(key: 'backend_logo') ?? [];
    $logo = (!empty($themeLogo['logo']) || !empty($themeLogo['favicon'])) ? $themeLogo : $backendLogo;
    $logoFile = $logo['logo'] ?? null;
    $footerLogoFile = $logo['footer_logo'] ?? $logoFile;
    $defaultLogo =
        $logoFile && fileExists('lms/theme-options', $logoFile) == true
            ? edulab_asset("lms/theme-options/{$logoFile}")
            : edulab_global_asset('lms/frontend/assets/images/logo/default-logo-dark.svg');

    $footerLogo =
        $footerLogoFile && fileExists('lms/theme-options', $footerLogoFile) == true
            ? edulab_asset("lms/theme-options/{$footerLogoFile}")
            : edulab_global_asset('lms/frontend/assets/images/logo/default-logo-dark.svg');

    $favIcon =
        isset($logo['favicon']) && fileExists('lms/theme-options', $logo['favicon']) == true
            ? edulab_asset("lms/theme-options/{$logo['favicon']}")
            : edulab_global_asset('lms/frontend/assets/images/favicon.ico');

    $data = array_merge($data, [
        'default_logo' => $defaultLogo,
        'footer_logo' => $footerLogo,
        'fav_icon' => $favIcon,
        'menus' => get_menus(),
        'wishlist' => [
            'is_show' => true,
            'icon_image' => edulab_global_asset('lms/frontend/assets/images/icons/wish-list.svg'),
        ],
    ]);
@endphp

<x-frontend-layout :data="$data">
    <!-- START BANNER AREA -->
    <x-theme::hero.hero-one />
    <!-- END BANNER AREA -->

    <!-- START CATEGORY AREA -->
    <x-theme::category.top-category :categories="$data['categories']" />
    <!-- END CATEGORY AREA -->

    <!-- START POPULAR COURSE AREA -->
    <x-theme::course.top-course :courses="$data['courses']" />
    <!-- END POPULAR COURSE AREA -->

    <!-- START TESTIMONIAL AREA -->
    <x-theme::testimonial.testimonial-one :testimonials="$data['testimonials']" />
    <!-- END TESTIMONIAL AREA -->

    <!-- START COUNTER AREA -->
    <x-theme::counter.counter-one />
    <!-- END COUNTER AREA -->

    <!-- START UPCOMING COURSE AREA -->
    <x-theme::course.upcoming-course :upcomingCourses="$data['upcoming_courses']" />
    <!-- END UPCOMING COURSE AREA -->

    <!-- START INSTRUCTOR AREA -->
    <x-theme::instructor.top-instructor :instructors="$data['instructors']" />
    <!-- END INSTRUCTOR AREA -->

    <!-- START ONLINE VIDEO COURSE AREA -->
    <x-theme::join-us.join-us />
    <!-- END ONLINE VIDEO COURSE AREA -->

    <!-- START SUBSCRIPTION AREA -->
    @if (module_enable_check('subscription'))
        <x-theme::subscription.subscription-list :subscriptions="$data['subscriptions']" />
    @endif
    <!-- END SUBSCRIPTION AREA -->

</x-frontend-layout>
