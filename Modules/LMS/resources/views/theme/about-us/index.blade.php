@php
    $aboutUs = get_theme_option('about_us' . active_language()) ?: get_theme_option('about_usen');

    $imageName = $aboutUs['banner_img_elearning'] ?? '';
    $aboutImg =
        isset($imageName) && fileExists('lms/theme-options', $imageName) == true
            ? edulab_asset('/lms/theme-options/' . $imageName)
            : edulab_global_asset('lms/frontend/assets/images/banner/banner_placeholder_2.svg');
@endphp
<x-frontend-layout>
    <x-theme::breadcrumbs.breadcrumb-one pageTitle="About Us" pageRoute="About Us" pageName="About Us" />

    <!-- HERO SECTION -->
    <div class="container py-12 lg:py-20">
        <div class="grid grid-cols-12 gap-x-4 xl:gap-x-12 gap-y-7 items-center">
            <div class="col-span-full lg:col-span-6">
                <div class="rounded-2xl overflow-hidden shadow-lg">
                    <img data-src="{{ $aboutImg }}" alt="About Us" class="w-full h-auto">
                </div>
            </div>
            <div class="col-span-full lg:col-span-6">
                <div class="lg:pl-[5%] rtl:lg:pl-0 rtl:lg:pr-[5%]">
                    <div class="area-subtitle">{{ translate('Who We Are') }}</div>
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
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- OUR MISSION & VALUES (tile layout) -->
    <div class="bg-primary-50 py-16 sm:py-24">
        <div class="container">
            <!-- MISSION TILE -->
            <div class="bg-white rounded-3xl shadow-md border border-primary-100 p-8 lg:p-12 max-w-4xl mx-auto mb-14 text-center relative overflow-hidden">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-primary/10 text-primary text-xs font-bold uppercase tracking-wider">
                    <i class="ri-flag-line"></i> {{ translate('Our Mission') }}
                </span>
                <h2 class="area-title mt-4">
                    {{ translate('Effort to Excellence.') }}
                    <span class="title-highlight-one">{{ translate("That's how you ACE it.") }}</span>
                </h2>
                <p class="area-description mt-5 leading-relaxed">
                    {{ translate('Ace Academics was built on a simple principle: effort, when applied with the right structure, leads to excellence. That is why we focus on proven strategies, consistent feedback, and a learning environment where students feel challenged and supported.') }}
                </p>
                <span class="absolute -top-10 -right-10 size-40 rounded-full bg-primary/5 -z-0"></span>
                <span class="absolute -bottom-12 -left-12 size-48 rounded-full bg-amber-100/40 -z-0"></span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
                <!-- Value 1 -->
                <div class="group bg-white rounded-2xl p-7 shadow-sm hover:shadow-xl hover:-translate-y-1 custom-transition border border-gray-100 relative overflow-hidden">
                    <div class="flex-center size-14 rounded-xl bg-primary/10 mb-5">
                        <i class="ri-lightbulb-line text-2xl text-primary"></i>
                    </div>
                    <h5 class="text-heading font-bold text-lg group-hover:text-primary custom-transition">{{ translate('Structured Learning') }}</h5>
                    <p class="text-gray-500 mt-3 leading-relaxed text-sm">
                        {{ translate('Every program at Ace Academics is designed with a clear structure — weekly planning frameworks, subject-specific strategies, and continuous performance tracking so students always know where they stand and what to focus on next.') }}
                    </p>
                    <span class="absolute bottom-0 left-0 right-0 h-1 bg-primary scale-x-0 group-hover:scale-x-100 origin-left custom-transition"></span>
                </div>
                <!-- Value 2 -->
                <div class="group bg-white rounded-2xl p-7 shadow-sm hover:shadow-xl hover:-translate-y-1 custom-transition border border-gray-100 relative overflow-hidden">
                    <div class="flex-center size-14 rounded-xl bg-red-50 mb-5">
                        <i class="ri-user-heart-line text-2xl text-red-500"></i>
                    </div>
                    <h5 class="text-heading font-bold text-lg group-hover:text-red-500 custom-transition">{{ translate('Personalised Support') }}</h5>
                    <p class="text-gray-500 mt-3 leading-relaxed text-sm">
                        {{ translate('We understand that every student learns differently. Our tutors work one-on-one and in small groups to identify each student\'s unique strengths and areas for improvement, tailoring their approach accordingly.') }}
                    </p>
                    <span class="absolute bottom-0 left-0 right-0 h-1 bg-red-500 scale-x-0 group-hover:scale-x-100 origin-left custom-transition"></span>
                </div>
                <!-- Value 3 -->
                <div class="group bg-white rounded-2xl p-7 shadow-sm hover:shadow-xl hover:-translate-y-1 custom-transition border border-gray-100 relative overflow-hidden">
                    <div class="flex-center size-14 rounded-xl bg-amber-50 mb-5">
                        <i class="ri-trophy-line text-2xl text-amber-500"></i>
                    </div>
                    <h5 class="text-heading font-bold text-lg group-hover:text-amber-500 custom-transition">{{ translate('Proven Results') }}</h5>
                    <p class="text-gray-500 mt-3 leading-relaxed text-sm">
                        {{ translate('Our students consistently achieve outstanding results — from ATAR 99.95 to medicine admissions and selective school placements. We measure success not just by grades, but by the confidence and skills students develop along the way.') }}
                    </p>
                    <span class="absolute bottom-0 left-0 right-0 h-1 bg-amber-500 scale-x-0 group-hover:scale-x-100 origin-left custom-transition"></span>
                </div>
            </div>
        </div>
    </div>

    <!-- WHAT WE OFFER (tile layout, matches home programs tiles) -->
    <div class="container py-16 sm:py-24">
        <div class="text-center max-w-3xl mx-auto mb-12">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-primary/10 text-primary text-xs font-bold uppercase tracking-wider">
                <i class="ri-stack-line"></i> {{ translate('What We Offer') }}
            </span>
            <h2 class="area-title mt-3">
                {{ translate('Comprehensive Academic') }}
                <span class="title-highlight-one">{{ translate('Programs') }}</span>
            </h2>
        </div>

        @php
            $offerings = [
                ['title' => 'Tutoring for Year 5-12',     'desc' => 'Maths, English, Science and more',          'icon' => 'ri-book-open-line',  'color' => '#0d9488', 'slug' => 'tutoring-for-year-5-12'],
                ['title' => 'Acceleration Class',         'desc' => 'Advanced programs beyond grade level',      'icon' => 'ri-rocket-line',     'color' => '#e52524', 'slug' => 'acceleration-class'],
                ['title' => 'UCAT Excellence',            'desc' => 'Medicine pathway preparation',              'icon' => 'ri-stethoscope-line','color' => '#6366f1', 'slug' => 'ucat-excellence'],
                ['title' => 'Selective Exam Prep',        'desc' => 'BSHS & scholarship exams',                  'icon' => 'ri-award-line',      'color' => '#f59e0b', 'slug' => 'selective-exam-preparation'],
            ];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 xl:gap-7">
            @foreach ($offerings as $item)
                <a href="{{ route('category.course', $item['slug']) }}"
                   class="group relative bg-white border border-gray-100 rounded-2xl p-6 xl:p-8 hover:shadow-xl hover:-translate-y-1 custom-transition overflow-hidden">
                    <div class="flex-center size-16 rounded-2xl mb-5"
                         style="background: {{ $item['color'] }}15;">
                        <i class="{{ $item['icon'] }} text-3xl" style="color: {{ $item['color'] }};"></i>
                    </div>
                    <h5 class="text-heading font-bold text-lg leading-tight group-hover:text-primary custom-transition">
                        {{ translate($item['title']) }}
                    </h5>
                    <p class="text-gray-500 text-sm mt-3 leading-relaxed">
                        {{ translate($item['desc']) }}
                    </p>
                    <div class="mt-5 flex items-center gap-2 text-sm font-semibold text-primary opacity-0 group-hover:opacity-100 custom-transition">
                        {{ translate('Learn More') }} <i class="ri-arrow-right-line"></i>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 h-1 scale-x-0 group-hover:scale-x-100 custom-transition origin-left"
                         style="background: {{ $item['color'] }};"></div>
                </a>
            @endforeach
        </div>
    </div>

    <!-- CTA SECTION -->
    <div class="relative py-20 sm:py-24 overflow-hidden"
         style="background: linear-gradient(135deg, var(--color-primary) 0%, #0f766e 60%, #e52524 130%);">
        <span class="absolute -top-24 -left-24 size-72 rounded-full bg-white/10 blur-3xl"></span>
        <span class="absolute -bottom-24 -right-24 size-80 rounded-full bg-white/10 blur-3xl"></span>

        <div class="container text-center relative z-10">
            <h2 class="text-white text-3xl lg:text-5xl font-bold leading-tight">
                {{ translate('Ready to Start Your') }}
                <span class="inline-block bg-white/15 backdrop-blur-sm px-4 py-1 rounded-2xl">
                    {{ translate('Journey?') }}
                </span>
            </h2>
            <p class="text-white/85 mt-5 max-w-2xl mx-auto text-lg">
                {{ translate('Join hundreds of students who have transformed their academic performance with Ace Academics.') }}
            </p>
            <div class="flex flex-wrap justify-center gap-4 mt-10">
                <a href="{{ route('contact.page') }}"
                   class="inline-flex items-center gap-2 px-8 py-4 rounded-full bg-white text-primary font-bold text-base shadow-xl hover:shadow-2xl hover:-translate-y-0.5 custom-transition">
                    <i class="ri-customer-service-2-line text-lg"></i>
                    {{ translate('Enquire Now') }}
                    <i class="ri-arrow-right-up-line text-lg"></i>
                </a>
                <a href="{{ route('course.list') }}"
                   class="inline-flex items-center gap-2 px-8 py-4 rounded-full bg-white/10 backdrop-blur-sm border-2 border-white text-white font-bold text-base hover:bg-white hover:text-primary custom-transition">
                    <i class="ri-book-open-line text-lg"></i>
                    {{ translate('Browse Programs') }}
                </a>
            </div>
        </div>
    </div>

</x-frontend-layout>
