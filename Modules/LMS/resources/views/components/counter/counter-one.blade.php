@php
    $counter = get_theme_option(key: 'counter') ?? [];
    $totalExperience = $counter['total_experience'] ?? 1;
    $totalCourse = get_all_course('approved')->count() ?? [];
    $totalCourseText = $totalCourse > 1 ? 'Programs' : 'Program';
    $totalTutor = get_all_instructor()->count() ?? [];
    $totalTutorText = $totalTutor > 1 ? 'Expert Tutors' : 'Expert Tutor';
    $totalStudent = get_all_student()->count() ?? [];
    $totalStudentText = $totalStudent > 1 ? 'Happy Students' : 'Happy Student';
@endphp
<!-- counter -->
@php
    $counterStats = [
        ['value' => $totalCourse > 1 ? $totalCourse . '+' : $totalCourse, 'label' => $totalCourseText],
        ['value' => $totalExperience > 1 ? $totalExperience . '+' : 0,    'label' => 'Years Experience'],
        ['value' => $totalTutor > 1 ? $totalTutor . '+' : $totalTutor,    'label' => $totalTutorText],
        ['value' => $totalStudent > 1 ? $totalStudent . '+' : $totalStudent, 'label' => $totalStudentText],
    ];
@endphp
<div class="container max-w-[1600px] my-16 sm:my-20 lg:my-[120px]">
    <div class="bg-primary px-8 sm:px-10 py-[60px] rounded-[20px] relative overflow-hidden">
        <div class="absolute -top-24 -right-24 size-72 rounded-full bg-white/5 blur-3xl pointer-events-none"></div>
        <div class="grid grid-cols-12 gap-y-8 divide-y lg:divide-y-0 lg:divide-x rtl:lg:divide-x-reverse divide-white/15 relative z-10">
            @foreach ($counterStats as $stat)
                <div class="col-span-6 lg:col-span-3 pt-8 first:pt-0 lg:pt-0">
                    <div class="flex flex-col items-center text-center gap-2.5">
                        <h6 class="text-white text-[40px] sm:text-[48px] xl:text-[54px] font-extrabold leading-none">
                            {{ $stat['value'] }}
                        </h6>
                        <div class="text-white/80 text-sm font-semibold uppercase tracking-wider leading-none">
                            {{ translate($stat['label']) }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
