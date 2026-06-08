@php
    $hero = get_theme_hero('default');
    $sliders = $hero->sliders ?? [];
@endphp

{{-- Modern hero — redesigned May 2026 for ACE Academic.
     Pure-CSS premium design: typography-driven, single-brand (red) illustration
     with ONE reserved gold accent for achievement. No reliance on an uploaded image. --}}
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
                    @endphp
                    <!-- SINGLE SLIDER ITEM -->
                    <div class="swiper-slide">
                        <div class="grid grid-cols-12 gap-8 items-center">
                            {{-- LEFT SIDE (text) --}}
                            <div class="col-span-full lg:col-span-6">
                                @if ($subTitle)
                                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/80 backdrop-blur-sm shadow-card border border-primary/10 mb-5">
                                        <span class="inline-block size-2 rounded-full bg-primary"></span>
                                        <span class="text-sm font-semibold text-primary tracking-wide">{{ $subTitle }}</span>
                                    </div>
                                @endif
                                @if ($title)
                                    <h1 class="text-heading dark:text-white font-extrabold leading-[1.08] tracking-[-0.02em] text-[40px] sm:text-[48px] xl:text-[56px]">
                                        {{ $title }}
                                        @if ($highlightText)
                                            <span class="title-highlight-one">{{ $highlightText }}</span>
                                        @endif
                                    </h1>
                                @endif
                                @if ($description)
                                    <p class="text-heading/70 dark:text-dark-text text-base xl:text-lg leading-relaxed mt-5 xl:mt-6 max-w-xl">
                                        {{ $description }}
                                    </p>
                                @endif
                                <div class="flex flex-wrap items-center gap-4 mt-7 xl:mt-9">
                                    @if (!empty($button))
                                        <a href="{{ $button['link'] ?? '' }}" aria-label="Hero call to action"
                                            class="btn b-solid btn-primary-solid btn-xl font-semibold shadow-card hover:-translate-y-0.5 custom-transition">
                                            {{ $buttonTranslations['name'] ?? $button['name'] ?? translate('Get Started') }}
                                            <i class="ri-arrow-right-up-line text-[20px] ml-1"></i>
                                        </a>
                                    @endif
                                    <a href="{{ route('course.list') }}"
                                        class="inline-flex items-center gap-2 text-heading dark:text-white font-semibold hover:text-primary custom-transition">
                                        <span class="size-10 flex-center rounded-full bg-white shadow-card">
                                            <i class="ri-arrow-right-line text-primary text-lg"></i>
                                        </span>
                                        {{ translate('Browse Programs') }}
                                    </a>
                                </div>

                                {{-- Trust badges row — each proof point appears ONCE --}}
                                <div class="flex flex-wrap items-center gap-6 mt-10 pt-6 border-t border-border">
                                    <div>
                                        <div class="text-2xl xl:text-3xl font-extrabold text-primary leading-none">99.95</div>
                                        <div class="text-xs uppercase tracking-wider text-heading/50 mt-1">{{ translate('Top ATAR') }}</div>
                                    </div>
                                    <div class="h-10 w-px bg-border"></div>
                                    <div>
                                        <div class="text-2xl xl:text-3xl font-extrabold text-primary leading-none">500+</div>
                                        <div class="text-xs uppercase tracking-wider text-heading/50 mt-1">{{ translate('Students Coached') }}</div>
                                    </div>
                                    <div class="h-10 w-px bg-border"></div>
                                    <div>
                                        <div class="text-2xl xl:text-3xl font-extrabold text-primary leading-none">10+</div>
                                        <div class="text-xs uppercase tracking-wider text-heading/50 mt-1">{{ translate('Years Expertise') }}</div>
                                    </div>
                                </div>
                            </div>

                            {{-- RIGHT SIDE — pure CSS illustration, single-brand + one gold accent --}}
                            <div class="col-span-full lg:col-span-6">
                                <div class="hero-illustration relative aspect-square max-w-[560px] mx-auto">
                                    {{-- Central card — ACE program showcase --}}
                                    <div class="absolute inset-[15%] bg-white rounded-[28px] shadow-card-hover p-8 flex flex-col justify-between z-10 border border-border">
                                        <div class="flex items-center gap-3">
                                            <div class="size-12 rounded-2xl bg-gradient-to-br from-primary to-primary-700 flex-center text-white shadow-card">
                                                <i class="ri-graduation-cap-fill text-2xl"></i>
                                            </div>
                                            <div>
                                                <div class="text-xs uppercase tracking-wider text-heading/50 font-semibold">{{ translate('ACE Academic') }}</div>
                                                <div class="text-sm font-bold text-heading">{{ translate('Brisbane, QLD') }}</div>
                                            </div>
                                        </div>

                                        <div class="my-4">
                                            <div class="text-xs uppercase tracking-wider text-heading/50 font-semibold mb-2">{{ translate('Programs') }}</div>
                                            <div class="space-y-2">
                                                <div class="flex items-center gap-2 text-sm">
                                                    <span class="size-1.5 rounded-full bg-primary"></span>
                                                    <span class="text-heading font-medium">{{ translate('Tutoring Year 5–12') }}</span>
                                                </div>
                                                <div class="flex items-center gap-2 text-sm">
                                                    <span class="size-1.5 rounded-full bg-primary"></span>
                                                    <span class="text-heading font-medium">{{ translate('Acceleration Class') }}</span>
                                                </div>
                                                <div class="flex items-center gap-2 text-sm">
                                                    <span class="size-1.5 rounded-full bg-secondary"></span>
                                                    <span class="text-heading font-medium">{{ translate('UCAT Excellence') }}</span>
                                                </div>
                                                <div class="flex items-center gap-2 text-sm">
                                                    <span class="size-1.5 rounded-full bg-secondary"></span>
                                                    <span class="text-heading font-medium">{{ translate('Selective Prep') }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="pt-4 border-t border-border">
                                            <div class="flex items-end justify-between">
                                                <div>
                                                    <div class="flex items-center gap-0.5 text-secondary text-sm">
                                                        <i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i>
                                                    </div>
                                                    <div class="text-[10px] uppercase tracking-wider text-heading/50 mt-1.5 font-semibold">{{ translate('Rated by parents') }}</div>
                                                </div>
                                                <div class="flex -space-x-2">
                                                    <div class="size-8 rounded-full border-2 border-white bg-gradient-to-br from-primary to-primary-700 flex-center text-white text-xs font-bold">A</div>
                                                    <div class="size-8 rounded-full border-2 border-white bg-gradient-to-br from-primary-400 to-primary-600 flex-center text-white text-xs font-bold">S</div>
                                                    <div class="size-8 rounded-full border-2 border-white bg-gradient-to-br from-primary-300 to-primary-500 flex-center text-white text-xs font-bold">M</div>
                                                    <div class="size-8 rounded-full border-2 border-white bg-primary/10 flex-center text-primary text-[10px] font-bold">+12</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Floating badge — top right (trust, brand red) --}}
                                    <div class="hidden sm:flex absolute top-[8%] right-0 z-20 items-center gap-2.5 px-4 py-3 bg-white rounded-2xl shadow-popover border border-border animate-[heroFloat_5s_ease-in-out_infinite]">
                                        <span class="size-10 flex-center rounded-xl bg-primary/10 text-primary">
                                            <i class="ri-shield-check-fill text-xl"></i>
                                        </span>
                                        <div>
                                            <div class="text-[10px] uppercase tracking-wider text-heading/50 leading-none font-semibold">{{ translate('Verified') }}</div>
                                            <div class="text-sm font-bold text-heading leading-tight mt-1">{{ translate('Expert Tutors') }}</div>
                                        </div>
                                    </div>

                                    {{-- Floating badge — bottom left (achievement, the one gold accent) --}}
                                    <div class="hidden sm:flex absolute bottom-[8%] left-0 z-20 items-center gap-2.5 px-4 py-3 bg-white rounded-2xl shadow-popover border border-border animate-[heroFloat_5s_ease-in-out_-2.5s_infinite]">
                                        <span class="size-10 flex-center rounded-xl bg-secondary/10 text-secondary">
                                            <i class="ri-medal-2-fill text-xl"></i>
                                        </span>
                                        <div>
                                            <div class="text-[10px] uppercase tracking-wider text-heading/50 leading-none font-semibold">{{ translate('Specialists') }}</div>
                                            <div class="text-sm font-bold text-heading leading-tight mt-1">{{ translate('UCAT & Selective') }}</div>
                                        </div>
                                    </div>

                                    {{-- Floating subject icons — middle right (mono brand) --}}
                                    <div class="hidden lg:flex absolute top-1/2 right-[2%] -translate-y-1/2 z-20 flex-col gap-2 animate-[heroFloat_5s_ease-in-out_-1.25s_infinite]">
                                        <div class="size-11 rounded-2xl bg-white shadow-card border border-border flex-center text-primary">
                                            <i class="ri-calculator-line text-lg"></i>
                                        </div>
                                        <div class="size-11 rounded-2xl bg-white shadow-card border border-border flex-center text-primary">
                                            <i class="ri-flask-line text-lg"></i>
                                        </div>
                                        <div class="size-11 rounded-2xl bg-white shadow-card border border-border flex-center text-primary">
                                            <i class="ri-book-2-line text-lg"></i>
                                        </div>
                                    </div>

                                    {{-- Decorative blobs (brand tints only) --}}
                                    <div class="absolute inset-0 -z-10">
                                        <div class="absolute top-[5%] right-[10%] size-32 rounded-full bg-primary/20 blur-3xl"></div>
                                        <div class="absolute bottom-[10%] left-[5%] size-40 rounded-full bg-primary/10 blur-3xl"></div>
                                        <div class="absolute top-[40%] left-[20%] size-24 rounded-full bg-primary/5 blur-2xl"></div>
                                    </div>

                                    {{-- Decorative dotted circles --}}
                                    <svg class="absolute -top-4 -left-4 size-16 text-primary/30 -z-10" viewBox="0 0 64 64" fill="none">
                                        <circle cx="32" cy="32" r="30" stroke="currentColor" stroke-width="1.5" stroke-dasharray="2 4"/>
                                    </svg>
                                    <svg class="absolute -bottom-4 -right-4 size-20 text-secondary/40 -z-10" viewBox="0 0 80 80" fill="none">
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

    {{-- Background — soft red wash, brand-tint blobs only --}}
    <div class="absolute inset-0 -z-10 bg-gradient-to-br from-primary-50 via-white to-gray-50"></div>
    <ul class="pointer-events-none">
        <li class="block size-[500px] rounded-full bg-primary/[0.08] blur-[180px] absolute -top-[15%] -left-[10%]"></li>
        <li class="block size-[400px] rounded-full bg-primary/[0.06] blur-[180px] absolute top-1/2 right-[5%] -translate-y-1/2"></li>
        <li class="block size-[600px] rounded-full bg-primary/[0.05] blur-[200px] absolute -bottom-[20%] left-1/3"></li>
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
    /* Slowly-rotating dashed ring around the central card — brand red */
    .hero-illustration::before {
        content: "";
        position: absolute;
        inset: 8%;
        border-radius: 36px;
        border: 1.5px dashed rgb(from var(--color-primary) r g b / 0.18);
        animation: heroSpin 30s linear infinite;
        z-index: 0;
    }
    @keyframes heroSpin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    @media (max-width: 640px) {
        .hero-illustration::before { animation: none; }
    }
</style>
