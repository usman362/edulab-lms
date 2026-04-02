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

    <!-- OUR MISSION & VALUES -->
    <div class="bg-primary-50 py-16 sm:py-24">
        <div class="container">
            <div class="text-center max-w-3xl mx-auto mb-12">
                <div class="area-subtitle">{{ translate('Our Mission') }}</div>
                <h2 class="area-title mt-2">
                    {{ translate('Effort to Excellence.') }}
                    <span class="title-highlight-one">{{ translate("That's how you ACE it.") }}</span>
                </h2>
                <p class="area-description mt-5">
                    {{ translate('Ace Academics was built on a simple principle: effort, when applied with the right structure, leads to excellence. That is why we focus on proven strategies, consistent feedback, and a learning environment where students feel challenged and supported.') }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-7">
                <!-- Value 1 -->
                <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-lg custom-transition">
                    <div class="flex-center size-14 rounded-xl bg-primary/10 mb-5">
                        <i class="ri-lightbulb-line text-2xl text-primary"></i>
                    </div>
                    <h5 class="text-heading font-bold text-lg">{{ translate('Structured Learning') }}</h5>
                    <p class="text-gray-500 mt-3 leading-relaxed text-sm">
                        {{ translate('Every program at Ace Academics is designed with a clear structure — weekly planning frameworks, subject-specific strategies, and continuous performance tracking so students always know where they stand and what to focus on next.') }}
                    </p>
                </div>
                <!-- Value 2 -->
                <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-lg custom-transition">
                    <div class="flex-center size-14 rounded-xl bg-red-50 mb-5">
                        <i class="ri-user-heart-line text-2xl text-red-500"></i>
                    </div>
                    <h5 class="text-heading font-bold text-lg">{{ translate('Personalised Support') }}</h5>
                    <p class="text-gray-500 mt-3 leading-relaxed text-sm">
                        {{ translate('We understand that every student learns differently. Our tutors work one-on-one and in small groups to identify each student\'s unique strengths and areas for improvement, tailoring their approach accordingly.') }}
                    </p>
                </div>
                <!-- Value 3 -->
                <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-lg custom-transition">
                    <div class="flex-center size-14 rounded-xl bg-amber-50 mb-5">
                        <i class="ri-trophy-line text-2xl text-amber-500"></i>
                    </div>
                    <h5 class="text-heading font-bold text-lg">{{ translate('Proven Results') }}</h5>
                    <p class="text-gray-500 mt-3 leading-relaxed text-sm">
                        {{ translate('Our students consistently achieve outstanding results — from ATAR 99.95 to medicine admissions and selective school placements. We measure success not just by grades, but by the confidence and skills students develop along the way.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- WHAT WE OFFER -->
    <div class="container py-16 sm:py-24">
        <div class="text-center max-w-3xl mx-auto mb-12">
            <div class="area-subtitle">{{ translate('What We Offer') }}</div>
            <h2 class="area-title mt-2">
                {{ translate('Comprehensive Academic') }}
                <span class="title-highlight-one">{{ translate('Programs') }}</span>
            </h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="text-center p-6 rounded-2xl border border-gray-100 hover:shadow-lg custom-transition group">
                <div class="flex-center size-16 rounded-2xl bg-primary/10 mx-auto mb-4 group-hover:bg-primary group-hover:text-white custom-transition">
                    <i class="ri-book-open-line text-3xl text-primary group-hover:text-white custom-transition"></i>
                </div>
                <h6 class="font-bold text-heading">{{ translate('Tutoring for Year 5-12') }}</h6>
                <p class="text-gray-500 text-sm mt-2">{{ translate('Maths, English, Science and more') }}</p>
            </div>
            <div class="text-center p-6 rounded-2xl border border-gray-100 hover:shadow-lg custom-transition group">
                <div class="flex-center size-16 rounded-2xl bg-red-50 mx-auto mb-4 group-hover:bg-red-500 custom-transition">
                    <i class="ri-rocket-line text-3xl text-red-500 group-hover:text-white custom-transition"></i>
                </div>
                <h6 class="font-bold text-heading">{{ translate('Acceleration Class') }}</h6>
                <p class="text-gray-500 text-sm mt-2">{{ translate('Advanced programs beyond grade level') }}</p>
            </div>
            <div class="text-center p-6 rounded-2xl border border-gray-100 hover:shadow-lg custom-transition group">
                <div class="flex-center size-16 rounded-2xl bg-indigo-50 mx-auto mb-4 group-hover:bg-indigo-500 custom-transition">
                    <i class="ri-stethoscope-line text-3xl text-indigo-500 group-hover:text-white custom-transition"></i>
                </div>
                <h6 class="font-bold text-heading">{{ translate('UCAT Excellence') }}</h6>
                <p class="text-gray-500 text-sm mt-2">{{ translate('Medicine pathway preparation') }}</p>
            </div>
            <div class="text-center p-6 rounded-2xl border border-gray-100 hover:shadow-lg custom-transition group">
                <div class="flex-center size-16 rounded-2xl bg-amber-50 mx-auto mb-4 group-hover:bg-amber-500 custom-transition">
                    <i class="ri-award-line text-3xl text-amber-500 group-hover:text-white custom-transition"></i>
                </div>
                <h6 class="font-bold text-heading">{{ translate('Selective Exam Prep') }}</h6>
                <p class="text-gray-500 text-sm mt-2">{{ translate('BSHS & scholarship exams') }}</p>
            </div>
        </div>
    </div>

    <!-- CTA SECTION -->
    <div class="bg-primary py-16 sm:py-20">
        <div class="container text-center">
            <h2 class="text-white text-3xl lg:text-4xl font-bold">{{ translate('Ready to Start Your Journey?') }}</h2>
            <p class="text-white/80 mt-4 max-w-2xl mx-auto text-lg">
                {{ translate('Join hundreds of students who have transformed their academic performance with Ace Academics.') }}
            </p>
            <div class="flex flex-wrap justify-center gap-4 mt-8">
                <a href="{{ route('contact.page') }}" class="btn b-solid bg-white text-primary btn-lg !rounded-full font-bold hover:bg-gray-100 custom-transition">
                    {{ translate('Enquire Now') }}
                    <i class="ri-arrow-right-up-line ml-1"></i>
                </a>
                <a href="{{ route('course.list') }}" class="btn b-outline border-white text-white btn-lg !rounded-full font-bold hover:bg-white/10 custom-transition">
                    {{ translate('Browse Programs') }}
                </a>
            </div>
        </div>
    </div>

</x-frontend-layout>
