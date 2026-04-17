<style>
    /* Khan Academy-style left sidebar width (inline to avoid Tailwind JIT dependency) */
    .kh-course-sidebar { width: 19.5rem; }
    @media (min-width: 1280px) { .kh-course-sidebar { width: 22rem; } }
</style>
<div id="course-content-drawer"
    class="bg-black/50 fixed size-full inset-0 invisible opacity-0 duration-300 z-[99] lg:bg-transparent lg:visible lg:opacity-100 lg:z-auto">
    <div
        class="course-content-drawer-inner kh-course-sidebar bg-white fixed top-[theme('spacing.header')] left-0 rtl:left-auto rtl:right-0 bottom-0 -translate-x-full rtl:translate-x-full lg:translate-x-0 rtl:lg:translate-x-0 shrink-0 flex flex-col duration-500 border-r border-slate-200 rtl:border-r-0 rtl:border-l">
        {{-- SIDEBAR HEADER --}}
        <div class="px-5 py-4 border-b border-slate-200 flex-center-between shrink-0">
            <div class="min-w-0">
                <div class="text-[11px] uppercase tracking-wider text-slate-500 font-semibold">
                    {{ translate('Course') }}
                </div>
                <h5 class="text-sm text-heading font-bold truncate mt-0.5" title="{{ $course->title }}">
                    {{ $course->title }}
                </h5>
            </div>
            <div class="lg:hidden">
                <button type="button" class="course-content-drawer-close size-8 flex-center text-heading"
                    aria-label="Close course content">
                    <i class="ri-close-line"></i>
                </button>
            </div>
        </div>

        {{-- CURRICULUM SCROLL AREA --}}
        <div class="flex-1 overflow-y-auto">
            <div class="py-1">
                <x-theme::course.curriculum-list
                    :course="$course"
                    sideBarShow="video-play"
                    :data="$data"
                    :auth="$auth"
                    purchaseCheck="{{ $purchaseCheck ?? false }}" />
            </div>
        </div>

        {{-- PROGRESS FOOTER (optional hook — shows if $courseProgress is passed) --}}
        @isset($courseProgress)
            <div class="px-5 py-3 border-t border-slate-200 shrink-0 bg-slate-50">
                <div class="flex-center-between text-xs text-slate-600 mb-1.5">
                    <span>{{ translate('Course Progress') }}</span>
                    <span class="font-semibold">{{ (int) $courseProgress }}%</span>
                </div>
                <div class="w-full h-1.5 bg-slate-200 rounded-full overflow-hidden">
                    <div class="h-full bg-primary rounded-full" style="width: {{ (int) $courseProgress }}%"></div>
                </div>
            </div>
        @endisset
    </div>
</div>
