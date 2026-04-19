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

    <style>
        /* Inline styles so the dashboard doesn't depend on Tailwind JIT classes
           that may not be compiled into output.min.css */
        .kh-dash-hero {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: #fff;
        }
        .kh-course-hero {
            position: relative;
            min-height: 180px;
            max-height: 220px;
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #db2777 100%);
            overflow: hidden;
        }
        .kh-course-hero-img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .kh-course-hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.75), rgba(0,0,0,0.25) 60%, transparent);
        }
        .kh-course-hero-content {
            position: absolute;
            left: 0; right: 0; bottom: 0;
            padding: 1.25rem 1.5rem;
        }
        .kh-course-list { max-height: 640px; overflow-y: auto; }
        .kh-course-list::-webkit-scrollbar { width: 6px; }
        .kh-course-list::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
        .kh-stat { text-align: center; }
        .kh-progress-track {
            width: 100%; height: 8px; background: #e5e7eb; border-radius: 999px; overflow: hidden;
        }
        .kh-progress-bar {
            height: 100%; background: linear-gradient(90deg, #6366f1, #8b5cf6); border-radius: 999px;
            transition: width .5s ease;
        }
        .kh-info-grid {
            display: grid; grid-template-columns: repeat(1, 1fr); gap: 1rem;
        }
        @media (min-width: 640px) {
            .kh-info-grid { grid-template-columns: repeat(3, 1fr); }
        }
        .kh-picker-item {
            display: flex; gap: 0.75rem; width: 100%; text-align: left;
            padding: 0.875rem 1.125rem;
            border-left: 3px solid transparent;
            transition: background .15s, border-color .15s;
            cursor: pointer;
        }
        .kh-picker-item:hover { background: #f8fafc; }
        .kh-picker-item.active {
            background: #eef2ff;
            border-left-color: #6366f1;
        }
        .kh-picker-thumb {
            width: 48px; height: 48px; border-radius: 10px; flex-shrink: 0;
            background: linear-gradient(135deg, #a5b4fc, #c4b5fd);
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 700; font-size: 18px;
            object-fit: cover;
        }
    </style>

    {{-- COMPACT WELCOME + STATS STRIP --}}
    <div class="card p-5 mb-4" style="display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:1rem;">
        <div>
            <p class="text-sm text-gray-500 dark:text-dark-text">
                {{ translate('Today is') }} {{ customDateFormate(now(), 'd M Y') }}
            </p>
            <h1 class="text-heading dark:text-white" style="font-size:1.5rem; font-weight:600; margin-top:.25rem;">
                {{ translate('Welcome back') }}, {{ $studentName }} 👋
            </h1>
        </div>
        <div style="display:flex; align-items:center; gap:1.75rem; flex-wrap:wrap;">
            <div class="kh-stat">
                <div style="font-size:1.5rem; font-weight:700; color:#6366f1; line-height:1;">{{ $data['totalProcessing'] ?? 0 }}</div>
                <div style="font-size:11px; letter-spacing:.08em; text-transform:uppercase; color:#6b7280; margin-top:.25rem;">{{ translate('In progress') }}</div>
            </div>
            <div class="kh-stat">
                <div style="font-size:1.5rem; font-weight:700; color:#6366f1; line-height:1;">{{ $data['totalCompleted'] ?? 0 }}</div>
                <div style="font-size:11px; letter-spacing:.08em; text-transform:uppercase; color:#6b7280; margin-top:.25rem;">{{ translate('Completed') }}</div>
            </div>
            <div class="kh-stat">
                <div style="font-size:1.5rem; font-weight:700; color:#6366f1; line-height:1;">{{ $data['totalEnrolled'] ?? 0 }}</div>
                <div style="font-size:11px; letter-spacing:.08em; text-transform:uppercase; color:#6b7280; margin-top:.25rem;">{{ translate('Enrolled') }}</div>
            </div>
            <div class="kh-stat">
                <div style="font-size:1.5rem; font-weight:700; color:#6366f1; line-height:1;">{{ $data['totalCertificate'] ?? 0 }}</div>
                <div style="font-size:11px; letter-spacing:.08em; text-transform:uppercase; color:#6b7280; margin-top:.25rem;">{{ translate('Certificates') }}</div>
            </div>
        </div>
    </div>

    @if ($myCourses->count() > 0)
        {{-- KHAN ACADEMY STYLE SPLIT VIEW --}}
        <div class="grid grid-cols-12 gap-4">

            {{-- LEFT: MY COURSES --}}
            <aside class="col-span-12 lg:col-span-4 xl:col-span-3 card p-0 overflow-hidden">
                <div style="padding:1rem 1.25rem; border-bottom:1px solid #e5e7eb;">
                    <h6 class="text-heading dark:text-white" style="font-weight:700; line-height:1; margin:0;">
                        {{ translate('My Courses') }}
                    </h6>
                    <p style="font-size:.75rem; color:#6b7280; margin-top:.25rem; margin-bottom:0;">
                        {{ translate('Select a course to continue') }}
                    </p>
                </div>
                <div class="kh-course-list">
                    @foreach ($myCourses as $index => $enrolled)
                        @php
                            $course = $enrolled->course;
                            $courseTranslations = parse_translation($course);
                            $thumbnail = $course?->thumbnail && fileExists('lms/courses/thumbnails', $course?->thumbnail) == true
                                ? edulab_asset('/lms/courses/thumbnails/' . $course?->thumbnail)
                                : null;
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
                            $initial = mb_strtoupper(mb_substr($courseTitle, 0, 1));
                        @endphp
                        <button type="button"
                            class="course-picker-item kh-picker-item {{ $index === 0 ? 'active' : '' }}"
                            style="border-top:{{ $index > 0 ? '1px solid #f1f5f9' : 'none' }};"
                            data-course-id="{{ $course?->id }}"
                            data-course-title="{{ e($courseTitle) }}"
                            data-course-thumbnail="{{ $thumbnail ?? '' }}"
                            data-course-initial="{{ e($initial) }}"
                            data-course-category="{{ e($courseCategory ?? '') }}"
                            data-course-instructor="{{ e(trim($instructorName)) }}"
                            data-course-progress="{{ $progress }}"
                            data-course-status="{{ $enrolled->status ?? '' }}"
                            data-course-url="{{ $courseUrl }}"
                            data-course-chapters="{{ $course?->chapters?->count() ?? 0 }}"
                            data-course-description="{{ e(strip_tags($courseTranslations['description'] ?? $course?->description ?? '')) }}">

                            @if ($thumbnail)
                                <img src="{{ $thumbnail }}" alt="thumb" class="kh-picker-thumb">
                            @else
                                <div class="kh-picker-thumb">{{ $initial }}</div>
                            @endif

                            <div style="min-width:0; flex:1;">
                                <h6 class="text-heading dark:text-white" style="font-size:.875rem; font-weight:600; line-height:1.3; margin:0; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">
                                    {{ $courseTitle }}
                                </h6>
                                <div style="margin-top:.5rem;">
                                    <div style="font-size:11px; color:#6b7280; margin-bottom:.25rem;">
                                        {{ $progress }}% {{ translate('complete') }}
                                    </div>
                                    <div style="height:4px; background:#e5e7eb; border-radius:999px; overflow:hidden;">
                                        <div style="height:100%; background:#6366f1; border-radius:999px; width: {{ $progress }}%;"></div>
                                    </div>
                                </div>
                            </div>
                        </button>
                    @endforeach
                </div>
            </aside>

            {{-- RIGHT: SELECTED COURSE DETAIL --}}
            <section class="col-span-12 lg:col-span-8 xl:col-span-9 card p-0 overflow-hidden" id="selectedCoursePanel">
                {{-- HERO --}}
                <div class="kh-course-hero">
                    <img id="selectedCourseThumb" class="kh-course-hero-img" style="display:none;" alt="course">
                    <div class="kh-course-hero-overlay"></div>
                    <div class="kh-course-hero-content">
                        <span id="selectedCourseCategory"
                            style="display:inline-block; background:rgba(255,255,255,.2); backdrop-filter:blur(8px); color:#fff; font-size:11px; text-transform:uppercase; letter-spacing:.08em; padding:.25rem .75rem; border-radius:999px; margin-bottom:.5rem;"></span>
                        <h2 id="selectedCourseTitle" style="color:#fff; font-size:1.5rem; font-weight:700; line-height:1.2; margin:0;"></h2>
                        <p id="selectedCourseInstructor" style="color:rgba(255,255,255,.85); font-size:.875rem; margin-top:.5rem; margin-bottom:0;"></p>
                    </div>
                </div>

                <div style="padding:1.5rem;">
                    {{-- PROGRESS ROW --}}
                    <div style="display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:1rem; margin-bottom:1.5rem;">
                        <div style="flex:1; min-width:240px;">
                            <div style="display:flex; align-items:center; justify-content:space-between; font-size:.875rem; margin-bottom:.5rem;">
                                <span class="text-heading dark:text-white" style="font-weight:500;">{{ translate('Your Progress') }}</span>
                                <span id="selectedCourseProgressLabel" style="font-weight:600; color:#6366f1;">0%</span>
                            </div>
                            <div class="kh-progress-track">
                                <div id="selectedCourseProgressBar" class="kh-progress-bar" style="width: 0%"></div>
                            </div>
                        </div>
                        <a id="selectedCourseContinueBtn" href="#"
                            class="btn b-solid btn-primary-solid"
                            style="flex-shrink:0; display:inline-flex; align-items:center; gap:.5rem;">
                            <i class="ri-play-circle-line text-lg"></i>
                            <span>{{ translate('Continue Learning') }}</span>
                        </a>
                    </div>

                    {{-- QUICK INFO --}}
                    <div class="kh-info-grid" style="padding-bottom:1.25rem; border-bottom:1px solid #e5e7eb;">
                        <div>
                            <div style="font-size:11px; text-transform:uppercase; letter-spacing:.08em; color:#6b7280;">{{ translate('Chapters') }}</div>
                            <div id="selectedCourseChapters" class="text-heading dark:text-white" style="font-size:1.125rem; font-weight:600; margin-top:.25rem;"></div>
                        </div>
                        <div>
                            <div style="font-size:11px; text-transform:uppercase; letter-spacing:.08em; color:#6b7280;">{{ translate('Status') }}</div>
                            <div id="selectedCourseStatus" class="text-heading dark:text-white" style="font-size:1.125rem; font-weight:600; margin-top:.25rem; text-transform:capitalize;"></div>
                        </div>
                        <div>
                            <div style="font-size:11px; text-transform:uppercase; letter-spacing:.08em; color:#6b7280;">{{ translate('Category') }}</div>
                            <div id="selectedCourseCategoryInfo" class="text-heading dark:text-white" style="font-size:1.125rem; font-weight:600; margin-top:.25rem;"></div>
                        </div>
                    </div>

                    {{-- DESCRIPTION --}}
                    <div style="margin-top:1.25rem;">
                        <h5 class="text-heading dark:text-white" style="font-weight:600; margin-bottom:.75rem;">{{ translate('About this course') }}</h5>
                        <p id="selectedCourseDescription" style="color:#6b7280; line-height:1.6; margin:0; display:-webkit-box; -webkit-line-clamp:6; -webkit-box-orient:vertical; overflow:hidden;"></p>
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
                        // Thumb: only show if we have one; otherwise leave gradient hero background
                        if (el.thumb) {
                            if (d.courseThumbnail) {
                                el.thumb.src = d.courseThumbnail;
                                el.thumb.style.display = "";
                            } else {
                                el.thumb.removeAttribute("src");
                                el.thumb.style.display = "none";
                            }
                        }
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

                        items.forEach((i) => i.classList.remove("active"));
                        btn.classList.add("active");
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
        <div class="card" style="padding:3rem; text-align:center;">
            <div style="font-size:4rem; margin-bottom:1rem;">📚</div>
            <h5 class="text-heading dark:text-white" style="font-weight:600; font-size:1.125rem;">{{ translate('No enrolled courses yet') }}</h5>
            <p style="color:#6b7280; margin-top:.5rem;">
                {{ translate('Browse available courses and enrol to start learning.') }}
            </p>
            <a href="{{ route('course.list') }}" class="btn b-solid btn-primary-solid" style="display:inline-block; margin-top:1rem;">
                {{ translate('Browse Courses') }}
            </a>
        </div>
    @endif
</x-dashboard-layout>
