<x-frontend-layout>
    @php
        $homeSections = get_theme_option(key: 'home_sections') ?? [];
        $sec = $homeSections['sections'] ?? [];
        $show = function ($key, $default = '1') use ($sec) {
            return ($sec[$key] ?? $default) == '1';
        };
    @endphp

    <!-- START BANNER AREA -->
    <x-theme::hero.hero-one />
    <!-- END BANNER AREA -->

    @if ($show('top_results'))
        <!-- START TOP STUDENT RESULTS AREA -->
        <div class="bg-white py-12 sm:py-16">
            <div class="container">
                <div class="text-center max-w-3xl mx-auto">
                    <div class="flex flex-wrap justify-center gap-3 mb-6">
                        <span class="inline-flex items-center px-4 py-2 rounded-full bg-primary/10 text-primary font-bold text-sm">
                            ATAR 99.95
                        </span>
                        <span class="inline-flex items-center px-4 py-2 rounded-full bg-red-50 text-red-600 font-bold text-sm">
                            Medicine (UQ)
                        </span>
                        <span class="inline-flex items-center px-4 py-2 rounded-full bg-amber-50 text-amber-600 font-bold text-sm">
                            Top Achievers
                        </span>
                    </div>
                    <p class="area-description text-lg">
                        {{ translate('Our students turn effort into excellence — because ACE isn\'t luck, it\'s structure.') }}
                    </p>
                    <a href="{{ route('course.list') }}" class="btn b-solid btn-primary-solid btn-lg !rounded-full font-medium mt-6">
                        {{ translate('See How We Do It') }}
                        <i class="ri-arrow-right-up-line text-[18px] ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
        <!-- END TOP STUDENT RESULTS AREA -->
    @endif

    @if ($show('programs_tiles'))
        <!-- START CATEGORY AREA (Expert Tutoring - 4 tiles) -->
        <x-theme::category.top-category :categories="$data['categories']" />
        <!-- END CATEGORY AREA -->
    @endif

    @if ($show('popular_courses', '0'))
        <!-- START POPULAR COURSE AREA -->
        <x-theme::course.top-course :courseCategories="$data['course_categories']" :courses="$data['courses']" />
        <!-- END POPULAR COURSE AREA -->
    @endif

    @if ($show('upcoming', '0'))
        <!-- START UPCOMING COURSE AREA -->
        <x-theme::course.upcoming-course :upcomingCourses="$data['upcoming_courses']" />
        <!-- END UPCOMING COURSE AREA -->
    @endif

    @if ($show('about'))
        <!-- START ABOUT US AREA (from Ace Academic website) -->
        <div class="bg-white py-16 sm:py-24 lg:py-[120px]">
            <div class="container">
                <div class="grid grid-cols-12 gap-7 xl:gap-12 items-center">
                    <div class="col-span-full lg:col-span-6">
                        @php
                            $aboutUs = get_theme_option('about_us' . active_language()) ?: get_theme_option('about_usen');
                            $imageName = $aboutUs['banner_img_elearning'] ?? '';
                            $aboutImg =
                                isset($imageName) && fileExists('lms/theme-options', $imageName) == true
                                    ? edulab_asset('/lms/theme-options/' . $imageName)
                                    : edulab_global_asset('lms/frontend/assets/images/banner/banner_placeholder_2.svg');
                        @endphp
                        <div class="rounded-2xl overflow-hidden shadow-lg">
                            <img data-src="{{ $aboutImg }}" alt="About Ace Academics" class="w-full h-auto">
                        </div>
                    </div>
                    <div class="col-span-full lg:col-span-6">
                        <div class="area-subtitle">{{ translate('About Us') }}</div>
                        <h2 class="area-title mt-2">
                            {{ translate('About Ace') }}
                            <span class="title-highlight-one">{{ translate('Academics') }}</span>
                        </h2>
                        <div class="mt-5 space-y-4 text-gray-600 leading-relaxed">
                            <p>
                                {{ translate('At Ace Academics, we support students from primary through to senior levels. Whether it is selective school and scholarship preparation, NAPLAN, ICAS, school-based assessments, or ATAR externals, our structured approach helps students build confidence, develop effective study habits, and achieve their academic goals.') }}
                            </p>
                            <p>
                                {{ translate('We work closely with each student to understand their strengths, identify areas for growth, and create a clear plan to move forward. Our tutors are experienced, dedicated, and committed to delivering real results — not just general guidance.') }}
                            </p>
                            <p>
                                {{ translate('Ace Academics was built on a simple principle: effort, when applied with the right structure, leads to excellence. That is why we focus on proven strategies, consistent feedback, and a learning environment where students feel challenged and supported.') }}
                            </p>
                        </div>
                        <div class="flex flex-wrap gap-4 mt-8">
                            <a href="{{ route('about.us') }}" class="btn b-solid btn-primary-solid btn-lg !rounded-full font-medium">
                                {{ translate('Learn More About Us') }}
                                <i class="ri-arrow-right-up-line text-[18px] ml-1"></i>
                            </a>
                            <a href="{{ route('instructor.list') }}" class="btn b-outline btn-primary-outline btn-lg !rounded-full font-medium">
                                {{ translate('Meet Our Tutors') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END ABOUT US AREA -->
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

    @if ($show('blogs'))
        <x-theme::blog.latest-blog-one :blogs="$data['blogs']" />
    @endif

    @if ($show('subscriptions'))
        <!-- START Subscription AREA -->
        <x-theme::subscription.subscription-list :subscriptions="$data['subscriptions']" />
        <!-- END Subscription AREA -->
    @endif

</x-frontend-layout>
