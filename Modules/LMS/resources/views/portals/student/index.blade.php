@php
    $translations = parse_translation(authCheck()?->userable);
    $studentName = $translations['first_name'] ?? (authCheck()?->userable?->first_name ?? '');

    // Flatten enrolled -> course list (courses only, not bundles) for the Khan-style picker
    $myCourses = collect();
    foreach ($data['enrolled'] ?? [] as $enrolled) {
        if ($enrolled->purchase_type == 'course' && $enrolled->course) {
            $myCourses->push($enrolled);
        }
    }

    $firstEnrolled = $myCourses->first();
@endphp

<x-dashboard-layout>
    <x-slot:title>{{ translate('My Learning') }}</x-slot:title>

    {{-- COMPACT WELCOME + STATS STRIP --}}
    <div class="card p-5 mb-4 flex flex-wrap items-center justify-between gap-4">
        <div>
            <p class="text-sm text-gray-500 dark:text-dark-text">
                {{ translate('Today is') }} {{ customDateFormate(now(), 'd M Y') }}
            </p>
            <h1 class="text-heading dark:text-white text-2xl lg:text-3xl font-semibold mt-1">
                {{ translate('Welcome back') }}, {{ $studentName }} 👋
            </h1>
        </div>
        <div class="flex items-center gap-6 flex-wrap">
            <div class="text-center">
                <div class="text-2xl font-bold text-primary-500 leading-none">{{ $data['totalProcessing'] ?? 0 }}</div>
                <div class="text-[11px] uppercase tracking-wider text-gray-500 mt-1">{{ translate('In progress') }}</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-primary-500 leading-none">{{ $data['totalCompleted'] ?? 0 }}</div>
                <div class="text-[11px] uppercase tracking-wider text-gray-500 mt-1">{{ translate('Completed') }}</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-primary-500 leading-none">{{ $data['totalEnrolled'] ?? 0 }}</div>
                <div class="text-[11px] uppercase tracking-wider text-gray-500 mt-1">{{ translate('Enrolled') }}</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-primary-500 leading-none">{{ $data['totalCertificate'] ?? 0 }}</div>
                <div class="text-[11px] uppercase tracking-wider text-gray-500 mt-1">{{ translate('Certificates') }}</div>
            </div>
        </div>
    </div>

    @if ($myCourses->count() > 0)
        {{-- KHAN ACADEMY STYLE SPLIT VIEW --}}
        <div class="grid grid-cols-12 gap-4">

            {{-- LEFT: MY COURSES --}}
            <aside class="col-span-12 lg:col-span-4 xl:col-span-3 card p-0 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-200 dark:border-dark-border">
                    <h6 class="text-heading dark:text-white font-bold leading-none">
                        {{ translate('My Courses') }}
                    </h6>
                    <p class="text-xs text-gray-500 dark:text-dark-text mt-1">
                        {{ translate('Select a course to continue') }}
                    </p>
                </div>
                <div class="max-h-[640px] overflow-y-auto divide-y divide-gray-100 dark:divide-dark-border">
                    @foreach ($myCourses as $index => $enrolled)
                        @php
                            $course = $enrolled->course;
                            $courseTranslations = parse_translation($course);
                            $thumbnail = $course?->thumbnail && fileExists('lms/courses/thumbnails', $course?->thumbnail) == true
                                ? edulab_asset('/lms/courses/thumbnails/' . $course?->thumbnail)
                                : edulab_global_asset('lms/assets/images/placeholder/thumbnail612.jpg');
                            $categoryTranslations = parse_translation($course?->category);
                            $progress = (int) ($enrolled->progress_percentage ?? 0);
                            $instructorName = '';
                            if ($course?->instructors && $course->instructors->count() > 0) {
                                $firstInst = $course->instructors->first();
                                $instTrans = parse_translation($firstInst?->userable);
                                $instructorName = ($instTrans['first_name'] ?? $firstInst?->userable?->first_name ?? '') . ' ' . ($instTrans['last_name'] ?? $firstInst?->userable?->last_name ?? '');
                            }
                            $courseTitle = $courseTranslations['title'] ?? $course?->title;
                            $courseCategory = $categoryTranslations['title'] ?? $course?->category?->title;
                            $courseUrl = route('play.course', $course?->slug);
                        @endphp
                        <button type="button"
                            class="course-picker-item w-full text-left px-5 py-4 flex items-start gap-3 border-l-[3px] transition-colors hover:bg-gray-50 dark:hover:bg-dark-card-two {{ $index === 0 ? 'active border-primary-500 bg-primary-50/40 dark:bg-dark-card-two' : 'border-transparent' }}"
                            data-course-id="{{ $course?->id }}"
                            data-course-title="{{ e($courseTitle) }}"
                            data-course-thumbnail="{{ $thumbnail }}"
                            data-course-category="{{ e($courseCategory ?? '') }}"
                            data-course-instructor="{{ e(trim($instructorName)) }}"
                            data-course-progress="{{ $progress }}"
                            data-course-status="{{ $enrolled->status ?? '' }}"
                            data-course-url="{{ $courseUrl }}"
                            data-course-chapters="{{ $course?->chapters?->count() ?? 0 }}"
                            data-course-description="{{ e(strip_tags($courseTranslations['description'] ?? $course?->description ?? '')) }}">
                            <img src="{{ $thumbnail }}" alt="thumb" class="size-12 rounded-lg object-cover shrink-0">
                            <div class="min-w-0 flex-1">
                                <h6 class="text-sm font-semibold text-heading dark:text-white line-clamp-2 leading-tight">
                                    {{ $courseTitle }}
                                </h6>
                                <div class="mt-2">
                                    <div class="flex items-center justify-between text-[11px] text-gray-500 mb-1">
                                        <span>{{ $progress }}% {{ translate('complete') }}</span>
                                    </div>
                                    <div class="w-full h-1 bg-gray-200 dark:bg-dark-border rounded-full overflow-hidden">
                                        <div class="h-full bg-primary-500 rounded-full" style="width: {{ $progress }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </button>
                    @endforeach
                </div>
            </aside>

            {{-- RIGHT: SELECTED COURSE DETAIL --}}
            <section class="col-span-12 lg:col-span-8 xl:col-span-9 card p-0 overflow-hidden" id="selectedCoursePanel">
                <div class="relative">
                    <img id="selectedCourseThumb"
                        src=""
                        alt="course"
                        class="w-full h-56 md:h-72 object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-5 md:p-8">
                        <span id="selectedCourseCategory"
                            class="inline-block bg-white/20 backdrop-blur text-white text-[11px] uppercase tracking-wider px-3 py-1 rounded-full mb-3"></span>
                        <h2 id="selectedCourseTitle" class="text-white text-2xl md:text-3xl font-bold leading-tight"></h2>
                        <p id="selectedCourseInstructor" class="text-white/80 text-sm mt-2"></p>
                    </div>
                </div>

                <div class="p-5 md:p-8">
                    {{-- PROGRESS + CONTINUE BUTTON --}}
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                        <div class="flex-1">
                            <div class="flex items-center justify-between text-sm mb-2">
                                <span class="font-medium text-heading dark:text-white">{{ translate('Your Progress') }}</span>
                                <span id="selectedCourseProgressLabel" class="font-semibold text-primary-500"></span>
                            </div>
                            <div class="w-full h-2 bg-gray-200 dark:bg-dark-border rounded-full overflow-hidden">
                                <div id="selectedCourseProgressBar"
                                    class="h-full bg-primary-500 rounded-full transition-all duration-500" style="width: 0%"></div>
                            </div>
                        </div>
                        <a id="selectedCourseContinueBtn" href="#"
                            class="btn b-solid btn-primary-solid shrink-0 inline-flex items-center gap-2">
                            <i class="ri-play-circle-line text-lg"></i>
                            <span>{{ translate('Continue Learning') }}</span>
                        </a>
                    </div>

                    {{-- COURSE QUICK INFO --}}
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 pb-6 border-b border-gray-200 dark:border-dark-border">
                        <div>
                            <div class="text-[11px] uppercase tracking-wider text-gray-500">{{ translate('Chapters') }}</div>
                            <div id="selectedCourseChapters" class="text-lg font-semibold text-heading dark:text-white mt-1"></div>
                        </div>
                        <div>
                            <div class="text-[11px] uppercase tracking-wider text-gray-500">{{ translate('Status') }}</div>
                            <div id="selectedCourseStatus" class="text-lg font-semibold text-heading dark:text-white mt-1 capitalize"></div>
                        </div>
                        <div>
                            <div class="text-[11px] uppercase tracking-wider text-gray-500">{{ translate('Category') }}</div>
                            <div id="selectedCourseCategoryInfo" class="text-lg font-semibold text-heading dark:text-white mt-1"></div>
                        </div>
                    </div>

                    {{-- DESCRIPTION --}}
                    <div class="mt-6">
                        <h5 class="text-heading dark:text-white font-semibold mb-3">{{ translate('About this course') }}</h5>
                        <p id="selectedCourseDescription" class="text-gray-600 dark:text-dark-text leading-relaxed line-clamp-6"></p>
                    </div>
                </div>
            </section>
        </div>

        {{-- JS: Course picker interaction --}}
        @push('js')
            <script>
                (function () {
                    const items = document.querySelectorAll(".course-picker-item");
                    if (!items.length) return;

                    const el = {
                        thumb: document.getElementById("selectedCourseThumb"),
                        title: document.getElementById("selectedCourseTitle"),
                        category: document.getElementById("selectedCourseCategory"),
                        categoryInfo: document.getElementById("selectedCourseCategoryInfo"),
                        instructor: document.getElementById("selectedCourseInstructor"),
                        progressLabel: document.getElementById("selectedCourseProgressLabel"),
                        progressBar: document.getElementById("selectedCourseProgressBar"),
                        continueBtn: document.getElementById("selectedCourseContinueBtn"),
                        chapters: document.getElementById("selectedCourseChapters"),
                        status: document.getElementById("selectedCourseStatus"),
                        description: document.getElementById("selectedCourseDescription"),
                    };

                    function render(btn) {
                        const d = btn.dataset;
                        if (el.thumb) el.thumb.src = d.courseThumbnail || "";
                        if (el.title) el.title.textContent = d.courseTitle || "";
                        if (el.category) {
                            el.category.textContent = d.courseCategory || "";
                            el.category.style.display = d.courseCategory ? "" : "none";
                        }
                        if (el.categoryInfo) el.categoryInfo.textContent = d.courseCategory || "—";
                        if (el.instructor) {
                            el.instructor.textContent = d.courseInstructor
                                ? "{{ translate('by') }} " + d.courseInstructor
                                : "";
                        }
                        const pct = parseInt(d.courseProgress || "0", 10);
                        if (el.progressLabel) el.progressLabel.textContent = pct + "%";
                        if (el.progressBar) el.progressBar.style.width = pct + "%";
                        if (el.continueBtn) el.continueBtn.href = d.courseUrl || "#";
                        if (el.chapters) el.chapters.textContent = d.courseChapters || "0";
                        if (el.status) el.status.textContent = d.courseStatus || "—";
                        if (el.description) {
                            el.description.textContent =
                                d.courseDescription && d.courseDescription.trim().length
                                    ? d.courseDescription
                                    : "{{ translate('No description available for this course yet.') }}";
                        }

                        items.forEach((i) => {
                            i.classList.remove("active", "border-primary-500", "bg-primary-50/40", "dark:bg-dark-card-two");
                            i.classList.add("border-transparent");
                        });
                        btn.classList.add("active", "border-primary-500", "bg-primary-50/40", "dark:bg-dark-card-two");
                        btn.classList.remove("border-transparent");
                    }

                    items.forEach((btn) => {
                        btn.addEventListener("click", () => render(btn));
                    });

                    // Auto-select first on load
                    render(items[0]);
                })();
            </script>
        @endpush
    @else
        {{-- EMPTY STATE --}}
        <div class="card p-10 text-center">
            <div class="text-6xl mb-4">📚</div>
            <h5 class="text-heading dark:text-white font-semibold text-lg">{{ translate('No enrolled courses yet') }}</h5>
            <p class="text-gray-500 dark:text-dark-text mt-2">
                {{ translate('Browse available courses and enrol to start learning.') }}
            </p>
            <a href="{{ route('course.list') }}" class="btn b-solid btn-primary-solid inline-block mt-4">
                {{ translate('Browse Courses') }}
            </a>
        </div>
    @endif
</x-dashboard-layout>
