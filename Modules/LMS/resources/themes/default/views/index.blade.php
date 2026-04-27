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

    // Section visibility — controlled from Admin → Settings Manage → Home Page Sections
    $homeSections = get_theme_option(key: 'home_sections') ?? [];
    $sec = $homeSections['sections'] ?? [];
    $show = function ($key, $default = '1') use ($sec) {
        return ($sec[$key] ?? $default) == '1';
    };
@endphp

<x-frontend-layout :data="$data">
    <!-- START BANNER AREA -->
    <x-theme::hero.hero-one />
    <!-- END BANNER AREA -->

    @if ($show('top_results'))
        <!-- TOP STUDENT RESULTS -->
        <div class="bg-white py-12 sm:py-16">
            <div class="container">
                <div class="text-center max-w-3xl mx-auto">
                    <div class="flex flex-wrap justify-center gap-3 mb-6">
                        <span class="inline-flex items-center px-4 py-2 rounded-full bg-primary/10 text-primary font-bold text-sm">ATAR 99.95</span>
                        <span class="inline-flex items-center px-4 py-2 rounded-full bg-red-50 text-red-600 font-bold text-sm">Medicine (UQ)</span>
                        <span class="inline-flex items-center px-4 py-2 rounded-full bg-amber-50 text-amber-600 font-bold text-sm">Top Achievers</span>
                    </div>
                    <p class="area-description text-lg">
                        {{ translate('Our students turn effort into excellence — because ACE isn\'t luck, it\'s structure.') }}
                    </p>
                    <div class="flex justify-center mt-6">
                        <a href="{{ route('course.list') }}" class="btn b-solid btn-primary-solid btn-lg !rounded-full font-medium !inline-flex items-center justify-center gap-1 leading-none">
                            <span>{{ translate('See How We Do It') }}</span>
                            <i class="ri-arrow-right-up-line text-[18px] leading-none"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if ($show('programs_tiles'))
        <!-- START CATEGORY AREA -->
        <x-theme::category.top-category :categories="$data['categories']" />
        <!-- END CATEGORY AREA -->
    @endif

    @if ($show('popular_courses', '0'))
        <!-- START POPULAR COURSE AREA -->
        <x-theme::course.top-course :courses="$data['courses']" />
        <!-- END POPULAR COURSE AREA -->
    @endif

    @if ($show('upcoming', '0'))
        <!-- START UPCOMING COURSE AREA -->
        <x-theme::course.upcoming-course :upcomingCourses="$data['upcoming_courses']" />
        <!-- END UPCOMING COURSE AREA -->
    @endif

    @if ($show('testimonials'))
        <!-- START TESTIMONIAL AREA -->
        <x-theme::testimonial.testimonial-one :testimonials="$data['testimonials']" />
        <!-- END TESTIMONIAL AREA -->
    @endif

    @if ($show('counter'))
        <!-- START COUNTER AREA -->
        <x-theme::counter.counter-one />
        <!-- END COUNTER AREA -->
    @endif

    @if ($show('instructors'))
        <!-- START INSTRUCTOR AREA -->
        <x-theme::instructor.top-instructor :instructors="$data['instructors']" />
        <!-- END INSTRUCTOR AREA -->
    @endif

    @if ($show('join_us'))
        <!-- START ONLINE VIDEO COURSE AREA -->
        <x-theme::join-us.join-us />
        <!-- END ONLINE VIDEO COURSE AREA -->
    @endif

    @if ($show('subscriptions'))
        <!-- START SUBSCRIPTION AREA -->
        @if (module_enable_check('subscription'))
            <x-theme::subscription.subscription-list :subscriptions="$data['subscriptions']" />
        @endif
        <!-- END SUBSCRIPTION AREA -->
    @endif

</x-frontend-layout>
