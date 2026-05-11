@php
    $hero = get_theme_hero('default');
    $sliders = $hero->sliders ?? [];
@endphp

{{-- Modern hero — redesigned May 2026 for ACE Academic.
     Key changes: removed heavy black image frame, larger image (6 cols),
     soft shadow + rounded corners, refined gradient bg, decorative badges. --}}
<div class="hero-modern relative pt-20 pb-28 xl:pt-28 xl:pb-40 overflow-hidden">
    <div class="container relative z-10">
        <div class="swiper banner-slider">
            <div class="swiper-wrapper">
                @foreach ($sliders as $slider)
                    @php
                        if (!$slider->status) {
                            continue;
                        }
                        $translations = parse_translation($slider);
                        $subTitle = $translations['sub_title'] ?? $slider->sub_title ?? '';
                        $title = $translations['title'] ?? $slider->title ?? '';
                        $highlightText = $translations['highlight_text'] ?? $slider->highlight_text ?? '';
                        $description = $translations['description'] ?? $slider->description ?? '';
                        $button = $slider->buttons ?? [];
                        $buttonTranslations = $translations['buttons'] ?? [];
                        $sliderImg = $slider->image ?? '';
                        $thumbnail =
                            $sliderImg && fileExists('lms/sliders', $sliderImg) == true
                                ? edulab_asset("lms/sliders/{$sliderImg}")
                                : edulab_global_asset('lms/frontend/assets/images/banner/banner_placeholder_2.svg');
                    @endphp
                    <!-- SINGLE SLIDER ITEM -->
                    <div class="swiper-slide">
                        <div class="grid grid-cols-12 gap-8 items-center">
                            {{-- LEFT SIDE (text) — 6 cols on lg+ to give image more room --}}
                            <div class="col-span-full lg:col-span-6">
                                @if ($subTitle)
                                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/80 backdrop-blur-sm shadow-sm border border-primary/10 mb-5">
                                        <span class="inline-block size-2 rounded-full bg-primary animate-pulse"></span>
                                        <span class="text-sm font-semibold text-primary tracking-wide">{{ $subTitle }}</span>
                                    </div>
                                @endif
                                @if ($title)
                                    <h1 class="text-heading dark:text-white font-bold leading-[1.05] text-[40px] sm:text-[52px] xl:text-[64px]">
                                        {{ $title }}
                                        @if ($highlightText)
                                            <span class="title-highlight-one">{{ $highlightText }}</span>
                                        @endif
                                    </h1>
                                @endif
                                @if ($description)
                                    <p class="text-gray-600 dark:text-dark-text text-base xl:text-lg leading-relaxed mt-5 xl:mt-6 max-w-xl">
                                        {{ $description }}
                                    </p>
                                @endif
                                <div class="flex flex-wrap items-center gap-4 mt-7 xl:mt-9">
                                    @if (!empty($button))
                                        <a href="{{ $button['link'] ?? '' }}" aria-label="Hero call to action"
                                            class="btn b-solid btn-primary-solid btn-xl !rounded-full font-semibold text-base shadow-lg shadow-primary/20 hover:shadow-xl hover:shadow-primary/30 hover:-translate-y-0.5 custom-transition">
                                            {{ $buttonTranslations['name'] ?? $button['name'] ?? translate('Get Started') }}
                                            <i class="ri-arrow-right-up-line text-[20px] ml-1"></i>
                                        </a>
                                    @endif
                                    <a href="{{ route('course.list') }}"
                                        class="inline-flex items-center gap-2 text-heading dark:text-white font-semibold hover:text-primary custom-transition">
                                        <span class="size-10 flex-center rounded-full bg-white shadow-md">
                                            <i class="ri-play-fill text-primary text-lg"></i>
                                        </span>
                                        {{ translate('Browse Programs') }}
                                    </a>
                                </div>

                                {{-- Trust badges row --}}
                                <div class="flex flex-wrap items-center gap-6 mt-10 pt-6 border-t border-gray-200/70">
                                    <div>
                                        <div class="text-2xl font-bold text-primary leading-none">99.95</div>
                                        <div class="text-xs uppercase tracking-wider text-gray-500 mt-1">{{ translate('Top ATAR') }}</div>
                                    </div>
                                    <div class="h-10 w-px bg-gray-200"></div>
                                    <div>
                                        <div class="text-2xl font-bold text-primary leading-none">500+</div>
                                        <div class="text-xs uppercase tracking-wider text-gray-500 mt-1">{{ translate('Students Coached') }}</div>
                                    </div>
                                    <div class="h-10 w-px bg-gray-200"></div>
                                    <div>
                                        <div class="text-2xl font-bold text-primary leading-none">10+</div>
                                        <div class="text-xs uppercase tracking-wider text-gray-500 mt-1">{{ translate('Years Expertise') }}</div>
                                    </div>
                                </div>
                            </div>

                            {{-- RIGHT SIDE (image) — full width on mobile, 6 cols lg+. No heavy frame. --}}
                            <div class="col-span-full lg:col-span-6">
                                <div class="hero-image-wrap relative">
                                    <img src="{{ $thumbnail }}" alt="ACE Academic — Expert Tutoring"
                                        class="relative z-10 w-full h-auto rounded-2xl shadow-2xl shadow-primary/10">
                                    {{-- Decorative floating badge top-right --}}
                                    <div class="hidden sm:flex absolute -top-4 -right-4 z-20 items-center gap-2 px-4 py-2.5 bg-white rounded-2xl shadow-xl border border-gray-100">
                                        <span class="size-9 flex-center rounded-xl bg-green-100 text-green-600">
                                            <i class="ri-shield-check-line text-lg"></i>
                                        </span>
                                        <div>
                                            <div class="text-xs text-gray-500 leading-none">{{ translate('Trusted by') }}</div>
                                            <div class="text-sm font-bold text-heading leading-tight mt-0.5">{{ translate('Brisbane Families') }}</div>
                                        </div>
                                    </div>
                                    {{-- Decorative floating badge bottom-left --}}
                                    <div class="hidden sm:flex absolute -bottom-4 -left-4 z-20 items-center gap-2 px-4 py-2.5 bg-white rounded-2xl shadow-xl border border-gray-100">
                                        <span class="size-9 flex-center rounded-xl bg-amber-100 text-amber-600">
                                            <i class="ri-medal-line text-lg"></i>
                                        </span>
                                        <div>
                                            <div class="text-xs text-gray-500 leading-none">{{ translate('99+ ATAR') }}</div>
                                            <div class="text-sm font-bold text-heading leading-tight mt-0.5">{{ translate('Expert Tutors') }}</div>
                                        </div>
                                    </div>
                                    {{-- Subtle decorative blob behind image --}}
                                    <div class="absolute -z-10 -top-6 -right-6 size-40 rounded-full bg-primary/10 blur-2xl"></div>
                                    <div class="absolute -z-10 -bottom-8 -left-8 size-48 rounded-full bg-amber-200/30 blur-3xl"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Background — soft gradient + subtle blobs (no aggressive colours) --}}
    <div class="absolute inset-0 -z-10 bg-gradient-to-br from-emerald-50/60 via-white to-blue-50/40"></div>
    <ul class="pointer-events-none">
        <li class="block size-[500px] rounded-full bg-primary/8 blur-[180px] absolute -top-[15%] -left-[10%]"></li>
        <li class="block size-[400px] rounded-full bg-amber-200/20 blur-[180px] absolute top-1/2 right-[5%] -translate-y-1/2"></li>
        <li class="block size-[600px] rounded-full bg-blue-200/15 blur-[200px] absolute -bottom-[20%] left-1/3"></li>
    </ul>

    <!-- SWIPER PAGINATION -->
    <div class="banner-slider-pagination swiper-custom-pagination absolute w-full !bottom-10 xl:!bottom-14 z-10"></div>
</div>

<style>
    /* Subtle float animation on the image */
    .hero-image-wrap > img {
        animation: heroFloat 6s ease-in-out infinite;
    }
    @keyframes heroFloat {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    /* On mobile, hide floating badges so the image isn't crowded */
    @media (max-width: 640px) {
        .hero-image-wrap > img { animation: none; }
    }
</style>
