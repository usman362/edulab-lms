@php
    // Our Programs — 4 curated tiles per client spec (2026-04).
    // If the matching category exists in the DB it links to its dedicated page;
    // otherwise we fall back to the course listing filtered-by-slug route so
    // clicking never errors out.
    $programTiles = [
        [
            'title' => translate('Tutoring for Year 5-12'),
            'slug' => 'tutoring-for-year-5-12',
            'icon' => 'ri-graduation-cap-line',
            'gradient' => 'linear-gradient(135deg,#fbbf24 0%,#f59e0b 100%)',
            'description' => translate('Personalised tutoring for school students'),
        ],
        [
            'title' => translate('Acceleration Class'),
            'slug' => 'acceleration-class',
            'icon' => 'ri-rocket-line',
            'gradient' => 'linear-gradient(135deg,#34d399 0%,#059669 100%)',
            'description' => translate('Advanced learning beyond the syllabus'),
        ],
        [
            'title' => translate('UCAT Excellence'),
            'slug' => 'ucat-excellence',
            'icon' => 'ri-medal-line',
            'gradient' => 'linear-gradient(135deg,#60a5fa 0%,#2563eb 100%)',
            'description' => translate('UCAT preparation with proven methods'),
        ],
        [
            'title' => translate('Selective Exam Preparation'),
            'slug' => 'selective-exam-preparation',
            'icon' => 'ri-book-open-line',
            'gradient' => 'linear-gradient(135deg,#f472b6 0%,#db2777 100%)',
            'description' => translate('Targeted practice for selective schools'),
        ],
    ];
@endphp

<style>
    .kh-programs-section {
        margin-top: 4rem;
    }
    @media (min-width: 1024px) { .kh-programs-section { margin-top: 7.5rem; } }

    .kh-programs-inner {
        background: #3d2b7e; /* fallback */
        background: linear-gradient(135deg, #3d2b7e 0%, #5b21b6 100%);
        border-radius: 1.5rem;
        padding: 4rem 1.5rem;
        max-width: 1600px;
        margin: 0 auto;
    }
    @media (min-width: 1024px) { .kh-programs-inner { padding: 6rem 2rem; } }

    .kh-programs-grid {
        display: grid;
        grid-template-columns: repeat(1, minmax(0, 1fr));
        gap: 1.25rem;
        margin-top: 3rem;
    }
    @media (min-width: 640px) { .kh-programs-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
    @media (min-width: 1024px) { .kh-programs-grid { grid-template-columns: repeat(4, minmax(0, 1fr)); } }

    .kh-program-tile {
        display: flex; flex-direction: column;
        padding: 2rem 1.5rem;
        background: rgba(255,255,255,.06);
        border: 1px solid rgba(255,255,255,.1);
        border-radius: 1rem;
        text-align: center;
        transition: transform .25s, border-color .25s, background .25s;
        min-height: 260px;
        color: #fff;
        text-decoration: none;
    }
    .kh-program-tile:hover {
        transform: translateY(-4px);
        border-color: #fbbf24;
        background: rgba(255,255,255,.1);
        color: #fff;
    }

    .kh-program-icon {
        width: 72px; height: 72px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 1.25rem;
        font-size: 36px; color: #fff;
    }

    .kh-program-title {
        font-size: 1.125rem;
        font-weight: 700;
        line-height: 1.3;
        margin: 0 0 .5rem;
    }
    @media (min-width: 1280px) { .kh-program-title { font-size: 1.25rem; } }

    .kh-program-desc {
        font-size: .875rem;
        color: rgba(255,255,255,.75);
        line-height: 1.5;
        margin: 0 0 1.25rem;
        flex: 1;
    }

    .kh-program-cta {
        display: inline-flex;
        align-items: center;
        gap: .375rem;
        font-size: .875rem;
        font-weight: 600;
        color: #fbbf24;
        margin-top: auto;
    }
    .kh-program-cta i {
        transition: transform .25s;
    }
    .kh-program-tile:hover .kh-program-cta i {
        transform: translateX(4px);
    }
</style>

<!-- START PROGRAMS AREA -->
<section class="kh-programs-section">
    <div style="padding: 0 12px;">
        <div class="kh-programs-inner">
            <div class="container">
                {{-- HEADER --}}
                <div class="text-center" style="max-width:600px; margin:0 auto;">
                    <div class="area-subtitle subtitle-outline style-two !border-[#F4B826]/15 text-sm uppercase !text-secondary">
                        {{ translate('Our Programs') }}
                    </div>
                    <h2 class="area-title text-white" style="margin-top:.5rem;">
                        {{ translate('Programs we offer') }}
                    </h2>
                    <p style="color:rgba(255,255,255,.7); margin-top:.75rem;">
                        {{ translate('Explore our academic programs designed to help students excel at every stage.') }}
                    </p>
                </div>

                {{-- TILES --}}
                <div class="kh-programs-grid">
                    @foreach ($programTiles as $tile)
                        <a href="{{ route('category.course', $tile['slug']) }}" class="kh-program-tile" aria-label="{{ $tile['title'] }}">
                            <span class="kh-program-icon" style="background: {{ $tile['gradient'] }};">
                                <i class="{{ $tile['icon'] }}"></i>
                            </span>
                            <h3 class="kh-program-title">{{ $tile['title'] }}</h3>
                            <p class="kh-program-desc">{{ $tile['description'] }}</p>
                            <span class="kh-program-cta">
                                {{ translate('Learn more') }} <i class="ri-arrow-right-line"></i>
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!-- END PROGRAMS AREA -->
