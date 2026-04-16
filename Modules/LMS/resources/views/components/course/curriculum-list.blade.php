@php
    $sideBarShow = $sideBarShow ?? null;
@endphp

@foreach ($course->chapters as $key => $chapter)
    @php
        $chapterId = $chapter->id;
        $select_chapter_id = $data['chapter_id'] ?? null;
        $start_topic_id = $data['topic_id'] ?? null;
        // Open the chapter that contains the current topic, otherwise the first chapter
        $showClass = $select_chapter_id == $chapterId ? 'panel-show' : ($loop->first && !$select_chapter_id ? 'panel-show' : '');
        $topicCount = $chapter?->topics?->count() ?? 0;
    @endphp

    {{-- CHAPTER (UNIT) BLOCK --}}
    <div class="lms-accordion select-none border-b border-slate-100">
        {{-- CHAPTER HEADER --}}
        <div class="px-5 py-3 cursor-pointer lms-accordion-button {{ $showClass }} group/accordion peer/accordion hover:bg-slate-50 transition">
            <div class="flex items-start justify-between gap-3">
                <div class="min-w-0 flex-1">
                    <div class="text-[10px] uppercase tracking-wider text-slate-500 font-semibold">
                        {{ translate('Unit') }} {{ $key + 1 }}
                    </div>
                    <h5 class="text-sm text-heading font-bold mt-0.5 leading-snug">
                        {{ $chapter->title }}
                    </h5>
                    <div class="text-xs text-slate-500 mt-1">
                        {{ $topicCount }} {{ $topicCount === 1 ? translate('Lesson') : translate('Lessons') }}
                    </div>
                </div>
                <i class="ri-arrow-down-s-line text-slate-500 text-lg mt-0.5 shrink-0 transition-transform group-[.panel-show]/accordion:rotate-180"></i>
            </div>
        </div>

        {{-- CHAPTER LESSONS --}}
        <div class="lms-accordion-panel peer-[.panel-show]/accordion:block hidden bg-white">
            @foreach ($chapter->topics as $key => $chapterTopic)
                @php
                    $topic = $chapterTopic?->topicable ?? null;
                    $slug = $topic?->topic_type?->slug;
                @endphp

                @if ($slug === 'video')
                    <x-theme::course.curriculum-item.item
                        :start_topic_id="$start_topic_id" :chapter_id="$chapterId" :topic="$topic"
                        :course="$course"
                        icon='<i class="ri-play-circle-line"></i>'
                        type_label="{{ translate('Video') }}"
                        sideBarShow="{{ $sideBarShow }}" :key="$key"
                        :auth="$auth ?? false" :purchaseCheck=$purchaseCheck />
                @elseif ($slug === 'reading')
                    <x-theme::course.curriculum-item.item
                        :start_topic_id="$start_topic_id" :chapter_id="$chapterId" :topic="$topic"
                        :course="$course"
                        icon='<i class="ri-book-open-line"></i>'
                        type_label="{{ translate('Reading') }}"
                        sideBarShow="{{ $sideBarShow }}" :key="$key"
                        :auth="$auth ?? false" :purchaseCheck=$purchaseCheck />
                @elseif ($slug === 'supplement')
                    <x-theme::course.curriculum-item.item
                        :start_topic_id="$start_topic_id" :chapter_id="$chapterId" :topic="$topic"
                        :course="$course"
                        icon='<i class="ri-file-text-line"></i>'
                        type_label="{{ translate('Supplement') }}"
                        sideBarShow="{{ $sideBarShow }}" :key="$key"
                        :auth="$auth ?? false" :purchaseCheck=$purchaseCheck />
                @elseif ($slug === 'assignment')
                    <x-theme::course.curriculum-item.item
                        :start_topic_id="$start_topic_id" :chapter_id="$chapterId" :topic="$topic"
                        :course="$course"
                        icon='<i class="ri-edit-box-line"></i>'
                        type_label="{{ translate('Assignment') }}"
                        sideBarShow="{{ $sideBarShow }}" :key="$key"
                        :auth="$auth ?? false" :purchaseCheck=$purchaseCheck />
                @elseif ($slug === 'quiz')
                    <x-theme::course.curriculum-item.item
                        :start_topic_id="$start_topic_id" :chapter_id="$chapterId" :topic="$topic"
                        :course="$course"
                        icon='<i class="ri-questionnaire-line"></i>'
                        type_label="{{ translate('Quiz') }}"
                        sideBarShow="{{ $sideBarShow }}" :key="$key"
                        :auth="$auth ?? false" :purchaseCheck=$purchaseCheck />
                @endif
            @endforeach
        </div>
    </div>
@endforeach
