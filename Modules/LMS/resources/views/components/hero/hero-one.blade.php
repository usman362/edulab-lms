@php
    $hero = get_theme_hero('default');
    $sliders = $hero->sliders ?? [];
@endphp

{{-- Modern hero — redesigned May 2026 for ACE Academic.
     Pure-CSS premium design: typography-driven, animated SVG illustration on right,
     glass-effect badges. No reliance on the uploaded slider image. --}}
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

                            {{-- RIGHT SIDE — pure CSS/SVG illustration, no image needed --}}
                            <div class="col-span-full lg:col-span-6">
                                <div class="hero-illustration relative aspect-square max-w-[560px] mx-auto">
                                    {{-- Central card — ACE branding showcase --}}
                                    <div class="absolute inset-[15%] bg-white rounded-[28px] shadow-2xl shadow-primary/15 p-8 flex flex-col justify-between z-10 border border-gray-100">
                                        <div class="flex items-center gap-3">
                                            <div class="size-12 rounded-2xl bg-gradient-to-br from-primary to-primary/70 flex-center text-white shadow-lg">
                                                <i class="ri-graduation-cap-fill text-2xl"></i>
                                            </div>
                                            <div>
                                                <div class="text-xs uppercase tracking-wider text-gray-500 font-semibold">{{ translate('ACE Academic') }}</div>
                                                <div class="text-sm font-bold text-heading">{{ translate('Brisbane, QLD') }}</div>
                                            </div>
                                        </div>

                                        <div class="my-4">
                                            <div class="text-xs uppercase tracking-wider text-gray-500 font-semibold mb-2">{{ translate('Programs') }}</div>
                                            <div class="space-y-2">
                                                <div class="flex items-center gap-2 text-sm">
                                                    <span class="size-1.5 rounded-full bg-emerald-500"></span>
                                                    <span class="text-heading font-medium">{{ translate('Tutoring Year 5–12') }}</span>
                                                </div>
                                                <div class="flex items-center gap-2 text-sm">
                                                    <span class="size-1.5 rounded-full bg-red-500"></span>
                                                    <span class="text-heading font-medium">{{ translate('Acceleration Class') }}</span>
                                                </div>
                                                <div class="flex items-center gap-2 text-sm">
                                                    <span class="size-1.5 rounded-full bg-indigo-500"></span>
                                                    <span class="text-heading font-medium">{{ translate('UCAT Excellence') }}</span>
                                                </div>
                                                <div class="flex items-center gap-2 text-sm">
                                                    <span class="size-1.5 rounded-full bg-amber-500"></span>
                                                    <span class="text-heading font-medium">{{ translate('Selective Prep') }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="pt-4 border-t border-gray-100">
                                            <div class="flex items-end justify-between">
                                                <div>
                                                    <div class="text-3xl font-bold text-primary leading-none">99.95</div>
                                                    <div class="text-[10px] uppercase tracking-wider text-gray-500 mt-1 font-semibold">{{ translate('Top student ATAR') }}</div>
                                                </div>
                                                <div class="flex -space-x-2">
                                                    <div class="size-8 rounded-full border-2 border-white bg-gradient-to-br from-emerald-400 to-emerald-600 flex-center text-white text-xs font-bold">A</div>
                                                    <div class="size-8 rounded-full border-2 border-white bg-gradient-to-br from-red-400 to-red-600 flex-center text-white text-xs font-bold">S</div>
                                                    <div class="size-8 rounded-full border-2 border-white bg-gradient-to-br from-indigo-400 to-indigo-600 flex-center text-white text-xs font-bold">M</div>
                                                    <div class="size-8 rounded-full border-2 border-white bg-gradient-to-br from-amber-400 to-amber-600 flex-center text-white text-[10px] font-bold">+12</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Floating badge — top right --}}
                                    <div class="hidden sm:flex absolute top-[8%] right-0 z-20 items-center gap-2.5 px-4 py-3 bg-white rounded-2xl shadow-2xl border border-gray-100 animate-[heroFloat_5s_ease-in-out_infinite]">
                                        <span class="size-10 flex-center rounded-xl bg-emerald-100 text-emerald-600">
                                            <i class="ri-shield-check-fill text-xl"></i>
                                        </span>
                                        <div>
                                            <div class="text-[10px] uppercase tracking-wider text-gray-500 leading-none font-semibold">{{ translate('Trusted by') }}</div>
                                            <div class="text-sm font-bold text-heading leading-tight mt-1">{{ translate('500+ Families') }}</div>
                                        </div>
                                    </div>

                                    {{-- Floating badge — bottom left --}}
                                    <div class="hidden sm:flex absolute bottom-[8%] left-0 z-20 items-center gap-2.5 px-4 py-3 bg-white rounded-2xl shadow-2xl border border-gray-100 animate-[heroFloat_5s_ease-in-out_-2.5s_infinite]">
                                        <span class="size-10 flex-center rounded-xl bg-amber-100 text-amber-600">
                                            <i class="ri-medal-2-fill text-xl"></i>
                                        </span>
                                        <div>
                                            <div class="text-[10px] uppercase tracking-wider text-gray-500 leading-none font-semibold">{{ translate('Expert tutors') }}</div>
                                            <div class="text-sm font-bold text-heading leading-tight mt-1">{{ translate('99+ ATAR Coaches') }}</div>
                                        </div>
                                    </div>

                                    {{-- Floating tag — middle right (subject icons) --}}
                                    <div class="hidden lg:flex absolute top-1/2 right-[2%] -translate-y-1/2 z-20 flex-col gap-2 animate-[heroFloat_5s_ease-in-out_-1.25s_infinite]">
                                        <div class="size-11 rounded-2xl bg-white shadow-xl border border-gray-100 flex-center text-blue-500">
                                            <i class="ri-calculator-line text-lg"></i>
                                        </div>
                                        <div class="size-11 rounded-2xl bg-white shadow-xl border border-gray-100 flex-center text-emerald-500">
                                            <i class="ri-flask-line text-lg"></i>
                                        </div>
                                        <div class="size-11 rounded-2xl bg-white shadow-xl border border-gray-100 flex-center text-rose-500">
                                            <i class="ri-book-2-line text-lg"></i>
                                        </div>
                                    </div>

                                    {{-- Decorative blobs --}}
                                    <div class="absolute inset-0 -z-10">
                                        <div class="absolute top-[5%] right-[10%] size-32 rounded-full bg-primary/20 blur-3xl"></div>
                                        <div class="absolute bottom-[10%] left-[5%] size-40 rounded-full bg-amber-300/30 blur-3xl"></div>
                                        <div class="absolute top-[40%] left-[20%] size-24 rounded-full bg-blue-300/20 blur-2xl"></div>
                                    </div>

                                    {{-- Decorative dotted circle (SVG) --}}
                                    <svg class="absolute -top-4 -left-4 size-16 text-primary/30 -z-10" viewBox="0 0 64 64" fill="none">
                                        <circle cx="32" cy="32" r="30" stroke="currentColor" stroke-width="1.5" stroke-dasharray="2 4"/>
                                    </svg>
                                    <svg class="absolute -bottom-4 -right-4 size-20 text-amber-400/40 -z-10" viewBox="0 0 80 80" fill="none">
                                        <circle cx="40" cy="40" r="38" stroke="currentColor" stroke-width="1.5" stroke-dasharray="3 5"/>
                                    </svg>
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
    /* Subtle float animation used by Tailwind arbitrary animate-[heroFloat_...] classes */
    @keyframes heroFloat {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-12px); }
    }
    /* Pulsing soft ring around the central card */
    .hero-illustration::before {
        content: "";
        position: absolute;
        inset: 8%;
        border-radius: 36px;
        border: 1.5px dashed rgba(13, 148, 136, 0.18);
        animation: heroSpin 30s linear infinite;
        z-index: 0;
    }
    @keyframes heroSpin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    /* Reduce motion on mobile for performance */
    @media (max-width: 640px) {
        .hero-illustration::before { animation: none; }
    }
</style>
