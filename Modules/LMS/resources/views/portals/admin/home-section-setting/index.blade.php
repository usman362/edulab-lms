<x-dashboard-layout>
    <x-slot:title>{{ translate('Home Page Sections') }}</x-slot:title>
    <x-portal::admin.breadcrumb title="Home Page Sections" page-to="Settings" />

    @php
        $settings = get_theme_option(key: 'home_sections') ?? [];

        // Section visibility defaults
        $sections = [
            'top_results'      => ['label' => 'Top Student Results',     'default' => '1'],
            'programs_tiles'   => ['label' => 'Our Programs (4 tiles)',  'default' => '1'],
            'popular_courses'  => ['label' => 'Our Most Popular Courses','default' => '0'],
            'upcoming'         => ['label' => 'Upcoming Programs',       'default' => '0'],
            'about'            => ['label' => 'About Ace Academics',     'default' => '1'],
            'testimonials'     => ['label' => 'What Our Students Say',   'default' => '1'],
            'counter'          => ['label' => 'Counter / Stats',         'default' => '1'],
            'instructors'      => ['label' => 'Top Instructors',         'default' => '1'],
            'join_us'          => ['label' => 'Join Ace Academics',      'default' => '1'],
            'blogs'            => ['label' => 'Latest Blogs',            'default' => '1'],
            'subscriptions'    => ['label' => 'Subscriptions',           'default' => '1'],
        ];

        // Default 4 program tiles
        $defaultTiles = [
            ['title' => 'Tutoring for Year 5-12', 'description' => 'Comprehensive subject tutoring from primary to senior levels, covering Maths, English, Science and more.', 'icon' => 'ri-book-open-line', 'slug' => 'tutoring-for-year-5-12', 'color' => '#0d9488'],
            ['title' => 'Acceleration Class',     'description' => 'Advanced programs for students ready to move ahead of their grade level with challenging curriculum.',          'icon' => 'ri-rocket-line',     'slug' => 'acceleration-class',     'color' => '#e52524'],
            ['title' => 'UCAT Excellence',        'description' => 'Structured UCAT preparation with practice exams, strategy sessions, and personalised feedback.',                'icon' => 'ri-stethoscope-line','slug' => 'ucat-excellence',        'color' => '#6366f1'],
            ['title' => 'Selective Exam Preparation','description' => 'Targeted coaching for selective school entry exams including BSHS and academic scholarship tests.',         'icon' => 'ri-award-line',      'slug' => 'selective-exam-preparation','color' => '#f59e0b'],
        ];
        $tiles = $settings['tiles'] ?? $defaultTiles;
        // Pad/normalise to exactly 4 tiles
        for ($i = 0; $i < 4; $i++) {
            $tiles[$i] = array_merge($defaultTiles[$i], $tiles[$i] ?? []);
        }
    @endphp

    <div class="card">
        <form enctype="multipart/form-data" class="add_setting" method="POST"
              action="{{ route('theme.setting') }}" data-key="home_sections">
            @csrf

            {{-- ================= Section visibility ================= --}}
            <h6 class="leading-none text-xl font-semibold text-heading">{{ translate('Section Visibility') }}</h6>
            <p class="text-sm text-gray-500 dark:text-dark-text mt-1 mb-6">
                {{ translate('Show or hide each section of the public home page.') }}
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                @foreach ($sections as $key => $meta)
                    @php $val = $settings['sections'][$key] ?? $meta['default']; @endphp
                    <div class="leading-none">
                        <label class="form-label">{{ translate($meta['label']) }}</label>
                        <select name="sections[{{ $key }}]" class="form-input singleSelect">
                            <option value="1" {{ $val == '1' ? 'selected' : '' }}>{{ translate('Show') }}</option>
                            <option value="0" {{ $val == '0' ? 'selected' : '' }}>{{ translate('Hide') }}</option>
                        </select>
                    </div>
                @endforeach
            </div>

            {{-- ================= Program tiles ================= --}}
            <hr class="my-8 border-gray-200 dark:border-dark-border-four">
            <h6 class="leading-none text-xl font-semibold text-heading">{{ translate('Our Programs — 4 Tiles') }}</h6>
            <p class="text-sm text-gray-500 dark:text-dark-text mt-1 mb-6">
                {{ translate('Edit the four program tiles shown on the home page. The Slug should match an existing course category slug; unknown slugs fall back to the full course list.') }}
            </p>

            <div class="space-y-6">
                @foreach ($tiles as $i => $tile)
                    <div class="border border-gray-200 dark:border-dark-border-four rounded-lg p-5">
                        <p class="text-sm font-semibold text-heading mb-4">{{ translate('Tile') }} #{{ $i + 1 }}</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="leading-none">
                                <label class="form-label">{{ translate('Title') }}</label>
                                <input type="text" name="tiles[{{ $i }}][title]" class="form-input"
                                       value="{{ $tile['title'] }}">
                            </div>
                            <div class="leading-none">
                                <label class="form-label">{{ translate('Slug (category)') }}</label>
                                <input type="text" name="tiles[{{ $i }}][slug]" class="form-input"
                                       value="{{ $tile['slug'] }}">
                            </div>
                            <div class="leading-none md:col-span-2">
                                <label class="form-label">{{ translate('Description') }}</label>
                                <textarea name="tiles[{{ $i }}][description]" rows="2" class="form-input">{{ $tile['description'] }}</textarea>
                            </div>
                            <div class="leading-none">
                                <label class="form-label">{{ translate('Icon class (Remix Icon)') }}</label>
                                <input type="text" name="tiles[{{ $i }}][icon]" class="form-input"
                                       value="{{ $tile['icon'] }}" placeholder="ri-book-open-line">
                                <p class="text-xs text-gray-500 mt-1">{{ translate('Browse icons at remixicon.com.') }}</p>
                            </div>
                            <div class="leading-none">
                                <label class="form-label">{{ translate('Accent colour (hex)') }}</label>
                                <input type="text" name="tiles[{{ $i }}][color]" class="form-input"
                                       value="{{ $tile['color'] }}" placeholder="#0d9488">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- ================= Join Ace video ================= --}}
            <hr class="my-8 border-gray-200 dark:border-dark-border-four">
            <h6 class="leading-none text-xl font-semibold text-heading">{{ translate('Join Ace Academics — Video') }}</h6>
            <p class="text-sm text-gray-500 dark:text-dark-text mt-1 mb-6">
                {{ translate('Replace the home page promotional video. Provide a direct MP4 URL, or upload a new video file to /public/lms/frontend/assets/video/ and put the path here (e.g. lms/frontend/assets/video/ace.mp4).') }}
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="leading-none md:col-span-2">
                    <label class="form-label">{{ translate('Video URL or asset path') }}</label>
                    <input type="text" name="join_us_video" class="form-input"
                           value="{{ $settings['join_us_video'] ?? '' }}"
                           placeholder="https://example.com/video.mp4">
                    <p class="text-xs text-gray-500 mt-1">{{ translate('Leave empty to use the bundled default video.') }}</p>
                </div>
            </div>

            <div class="mt-8">
                <button type="submit" class="btn b-solid btn-primary-solid w-max dk-theme-card-square">
                    {{ translate('Save Settings') }}
                </button>
            </div>
        </form>
    </div>
</x-dashboard-layout>
