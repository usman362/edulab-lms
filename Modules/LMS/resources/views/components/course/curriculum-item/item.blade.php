@php
    $startTopicId = $start_topic_id ?? null;
    $auth = $auth ?? '';
    $purchaseCheck = $purchaseCheck ?? '';
    $type_label = $type_label ?? '';
    $locked = !$auth || ($auth && $purchaseCheck === false);

    if ($auth && $purchaseCheck !== false) {
        $route = route('play.course', [
            'slug' => $course->slug,
            'topic_id' => $topic->id,
            'type' => $topic->topic_type?->slug,
            'chapter_id' => $chapterId ?? null,
        ]);
    } else {
        $route = '#';
    }

    $isActive = $startTopicId == $topic->id;
@endphp

<a href="{{ $sideBarShow == 'video-play' ? '#' : $route }}"
    class="group/lesson flex items-center gap-3 pl-5 pr-4 py-2.5 leading-snug border-l-[3px] transition-colors
        {{ $isActive ? 'border-primary bg-primary-50/60 text-primary' : 'border-transparent hover:bg-slate-50 hover:border-slate-300 text-slate-700' }}
        {{ $sideBarShow == 'video-play' ? 'video-lesson-item' : '' }} {{ $locked ? 'cursor-not-allowed opacity-70' : 'cursor-pointer' }}"
    aria-label="{{ $topic->title }}"
    data-type="{{ $sideBarShow == 'video-play' ? $topic->topic_type?->slug : '' }}"
    data-id="{{ $sideBarShow == 'video-play' ? $topic->id : '' }}"
    data-action="{{ $sideBarShow == 'video-play' ? route('learn.course.topic') . '?course_id=' . $course->id . '&chapter_id=' . $topic?->chapter_id . '&topic_id=' . $topic->id : '' }}">

    {{-- TYPE ICON --}}
    <span class="shrink-0 size-7 rounded-full flex-center text-base
        {{ $isActive ? 'bg-primary text-white' : 'bg-slate-100 text-slate-500 group-hover/lesson:bg-slate-200' }}">
        {!! $icon ?? '<i class="ri-circle-line"></i>' !!}
    </span>

    {{-- LESSON META --}}
    <div class="min-w-0 flex-1">
        <div class="text-[13px] font-medium truncate {{ $isActive ? 'text-primary' : 'text-heading' }}">
            {{ $topic->title }}
        </div>
        <div class="flex items-center gap-2 mt-0.5 text-[11px] text-slate-500">
            @if ($type_label)
                <span class="uppercase tracking-wide font-semibold">{{ $type_label }}</span>
            @endif
            @if ($topic->duration)
                <span class="size-1 rounded-full bg-slate-300"></span>
                <span>{{ $topic->duration }} {{ translate('min') }}</span>
            @endif
        </div>
    </div>

    {{-- STATUS ICON --}}
    <span class="shrink-0 text-sm {{ $isActive ? 'text-primary' : 'text-slate-400' }}">
        @if ($locked)
            <i class="ri-lock-line"></i>
        @elseif ($isActive)
            <i class="ri-play-fill"></i>
        @else
            <i class="ri-arrow-right-s-line opacity-0 group-hover/lesson:opacity-100 transition-opacity"></i>
        @endif
    </span>
</a>
