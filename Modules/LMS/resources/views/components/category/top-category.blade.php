@php
    $categories = $categories ?? [];
    $totalCategories = count($categories);

    $categoryRoute = '';
    $categoryBtnText = '';

    if ($totalCategories > 0) {
        $categoryRoute = 'category.list';
        $categoryBtnText = 'View All Programs';
    }

    if (isAdmin() && $totalCategories < 1) {
        $categoryRoute = 'category.create';
        $categoryBtnText = 'Add Category';
    }

    // Default 4 featured program tiles — admin can override via Home Page Sections settings.
    $defaultFeaturedPrograms = [
        ['title' => 'Tutoring for Year 5-12',     'description' => 'Comprehensive subject tutoring from primary to senior levels, covering Maths, English, Science and more.', 'icon' => 'ri-book-open-line',  'slug' => 'tutoring-for-year-5-12',     'color' => '#0d9488'],
        ['title' => 'Acceleration Class',         'description' => 'Advanced programs for students ready to move ahead of their grade level with challenging curriculum.',          'icon' => 'ri-rocket-line',     'slug' => 'acceleration-class',         'color' => '#e52524'],
        ['title' => 'UCAT Excellence',            'description' => 'Structured UCAT preparation with practice exams, strategy sessions, and personalised feedback.',                'icon' => 'ri-stethoscope-line','slug' => 'ucat-excellence',            'color' => '#6366f1'],
        ['title' => 'Selective Exam Preparation', 'description' => 'Targeted coaching for selective school entry exams including BSHS and academic scholarship tests.',              'icon' => 'ri-award-line',      'slug' => 'selective-exam-preparation', 'color' => '#f59e0b'],
    ];
    $homeSections = get_theme_option(key: 'home_sections') ?? [];
    $configuredTiles = $homeSections['tiles'] ?? [];
    $featuredPrograms = [];
    foreach ($defaultFeaturedPrograms as $i => $defaultTile) {
        $featuredPrograms[] = array_merge($defaultTile, $configuredTiles[$i] ?? []);
    }
@endphp
<div class="bg-white pt-10 xl:pt-0 pb-16 sm:pb-24 lg:pb-[120px]">
    <div class="container">
        <!-- HEADER -->
        <div class="grid grid-cols-12 gap-4 items-center">
            <div class="col-span-full md:col-span-7 xl:col-span-6 md:pr-20">
                <div class="area-subtitle">
                    {{ translate('Our Programs') }}
                </div>
                <h2 class="area-title mt-2">
                    {{ translate('Expert Tutoring for Academic') }}
                    <span class="title-highlight-one">
                        {{ translate('Excellence') }}
                    </span>
                </h2>
            </div>

            @if($categoryRoute && $categoryBtnText)
            <div class="col-span-full md:col-span-5 xl:col-span-6 md:justify-self-end">
                <a href="{{ route($categoryRoute) }}"
                    title="{{ $categoryBtnText }}"
                    aria-label="{{ $categoryBtnText }}"
                    class="btn b-solid btn-primary-solid btn-xl !rounded-full font-medium text-[16px] md:text-[18px]">
                    {{ translate($categoryBtnText) }}
                    <span class="hidden md:block">
                        <i class="ri-arrow-right-up-line text-[20px] rtl:before:content-['\ea66']"></i>
                    </span>
                </a>
            </div>
            @endif

        </div>
        <!-- FEATURED TILES (4 fixed programs) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 xl:gap-7 mt-10 lg:mt-[60px]">
            @foreach ($featuredPrograms as $program)
                <a href="{{ route('category.course', $program['slug']) }}"
                   class="group relative bg-white border border-gray-100 rounded-2xl p-6 xl:p-8 hover:shadow-xl hover:-translate-y-1 custom-transition overflow-hidden">
                    <!-- Icon -->
                    <div class="flex-center size-16 rounded-2xl mb-5"
                         style="background: {{ $program['color'] }}15;">
                        <i class="{{ $program['icon'] }} text-3xl" style="color: {{ $program['color'] }};"></i>
                    </div>
                    <!-- Title -->
                    <h5 class="text-heading font-bold text-lg leading-tight group-hover:text-primary custom-transition">
                        {{ translate($program['title']) }}
                    </h5>
                    <!-- Description -->
                    <p class="text-gray-500 text-sm mt-3 leading-relaxed">
                        {{ translate($program['description']) }}
                    </p>
                    <!-- Arrow -->
                    <div class="mt-5 flex items-center gap-2 text-sm font-semibold text-primary opacity-0 group-hover:opacity-100 custom-transition">
                        {{ translate('Learn More') }}
                        <i class="ri-arrow-right-line"></i>
                    </div>
                    <!-- Bottom accent line -->
                    <div class="absolute bottom-0 left-0 right-0 h-1 scale-x-0 group-hover:scale-x-100 custom-transition origin-left"
                         style="background: {{ $program['color'] }};"></div>
                </a>
            @endforeach
        </div>

        {{-- Secondary database-loaded category grid was hidden (2026-04) per client request:
             home page should show only the four curated Ace program tiles, not the full
             category catalogue underneath. Categories like Digital Marketing / UI&UX / Data
             Science were leaking through from the demo seeder. --}}
    </div>
</div>
