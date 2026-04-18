@php
    // Icon + description per topic type for the visual picker
    $topicMeta = [
        'video' => [
            'icon' => 'ri-play-circle-line',
            'color' => 'bg-blue-50 text-blue-600',
            'description' => translate('Upload or embed a video lesson'),
        ],
        'reading' => [
            'icon' => 'ri-book-open-line',
            'color' => 'bg-emerald-50 text-emerald-600',
            'description' => translate('Text-based lesson or article'),
        ],
        'quiz' => [
            'icon' => 'ri-questionnaire-line',
            'color' => 'bg-purple-50 text-purple-600',
            'description' => translate('Add questions to test learners'),
        ],
        'supplement' => [
            'icon' => 'ri-file-text-line',
            'color' => 'bg-amber-50 text-amber-600',
            'description' => translate('Downloadable files or resources'),
        ],
        'assignment' => [
            'icon' => 'ri-edit-box-line',
            'color' => 'bg-rose-50 text-rose-600',
            'description' => translate('Task for learners to submit'),
        ],
    ];
@endphp

<style>
    /* Guarantee proper scroll in the Add Topic modal without depending on Tailwind JIT arbitrary values */
    #addCourseTopic .kh-topic-modal-scroll {
        max-height: calc(100vh - 4rem);
        overflow-y: auto;
        overflow-x: hidden;
    }
    #addCourseTopic .kh-topic-grid {
        display: grid;
        grid-template-columns: repeat(1, minmax(0, 1fr));
        gap: 0.75rem;
    }
    @media (min-width: 640px) {
        #addCourseTopic .kh-topic-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
    @media (min-width: 1024px) {
        #addCourseTopic .kh-topic-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
    }
    /* Smaller card so 5 options fit without making modal too tall */
    #addCourseTopic .topic-type-card { min-height: 72px; }
</style>
<!-- Start Course Topic Modal -->
<div id="addCourseTopic" tabindex="-1"
    class="fixed inset-0 z-modal w-full hidden overflow-y-auto"
    style="padding: 1rem 0;">
    <div class="p-4 w-full max-w-3xl mx-auto">
        <div class="relative bg-white dark:bg-dark-card-two rounded-lg dk-theme-card-square shadow">
            <button type="button" data-modal-hide="addCourseTopic"
                class="absolute top-3 end-2.5 hover:bg-gray-200 dark:hover:bg-dark-icon rounded-lg size-8 flex-center z-10">
                <i class="ri-close-fill text-gray-500 dark:text-dark-text text-xl leading-none"></i>
            </button>

            <div class="kh-topic-modal-scroll">
                <div class="p-5 md:p-6">

                    {{-- HEADER --}}
                    <div class="pb-4 border-b border-gray-200 dark:border-dark-border">
                        <h6 class="leading-none text-lg font-semibold text-heading dark:text-white" id="topic-header-modal">
                            {{ translate('Add New Topic') }}
                        </h6>
                        <p class="text-xs text-gray-500 dark:text-dark-text mt-1.5">
                            {{ translate('Choose what kind of content you want to add to this chapter.') }}
                        </p>
                    </div>

                    {{-- STEP 1: TOPIC TYPE PICKER --}}
                    <div id="topicTypeList" class="mt-5">
                        <div class="text-[11px] uppercase tracking-wider text-gray-500 font-semibold mb-3">
                            {{ translate('Topic Type') }}
                        </div>

                        {{-- VISUAL CARDS (easier than dropdown) --}}
                        <div class="kh-topic-grid">
                            @foreach (get_all_topic_type() as $topicType)
                                @php
                                    $meta = $topicMeta[$topicType->slug] ?? [
                                        'icon' => 'ri-file-line',
                                        'color' => 'bg-gray-100 text-gray-600',
                                        'description' => '',
                                    ];
                                @endphp
                                <button type="button"
                                    class="topic-type-card group text-left border border-gray-200 dark:border-dark-border rounded-lg p-3 hover:border-primary-500 hover:shadow-md transition-all bg-white dark:bg-dark-card-two"
                                    data-topic-slug="{{ $topicType->slug }}">
                                    <div class="flex items-start gap-2.5">
                                        <div class="size-9 rounded-lg flex-center shrink-0 {{ $meta['color'] }}">
                                            <i class="{{ $meta['icon'] }} text-lg"></i>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div class="font-semibold text-heading dark:text-white text-sm leading-none">
                                                {{ $topicType->name }}
                                            </div>
                                            <p class="text-[11px] text-gray-500 dark:text-dark-text mt-1 leading-snug">
                                                {{ $meta['description'] }}
                                            </p>
                                        </div>
                                    </div>
                                </button>
                            @endforeach
                        </div>

                        {{-- Fallback hidden select so existing course.js handler still works --}}
                        <select class="topic-type-list hidden" name="topic_type" required>
                            <option selected disabled>{{ translate('Select Type') }}</option>
                            @foreach (get_all_topic_type() as $topicType)
                                <option value="{{ $topicType->slug }}">{{ $topicType->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger error-text topic_type_err mt-2 inline-block"></span>
                    </div>

                    {{-- LOADER (shown while fetching the topic type form via AJAX) --}}
                    <div class="flex-center size-full bg-white/80 dark:bg-dark-card-shade absolute inset-0 z-[1000] sniper-loader rounded-lg">
                        <div class="size-10 rounded-50 animate-spin border-4 border-dashed border-primary-500 border-t-transparent"></div>
                    </div>

                    {{-- STEP 2: DYNAMIC FIELDS AREA (populated after type is chosen) --}}
                    <div class="form-field-area mt-5"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Course Topic Modal -->

@push('js')
    <script>
        (function () {
            // When user clicks a topic-type card, set hidden <select> value and trigger change
            // so existing course.js handler (.on('change', '.topic-type-list', ...)) runs.
            $(document).on("click", ".topic-type-card", function () {
                var slug = $(this).data("topic-slug");
                if (!slug) return;

                // Visual highlight on chosen card
                $(".topic-type-card").removeClass("border-primary-500 ring-2 ring-primary-200");
                $(this).addClass("border-primary-500 ring-2 ring-primary-200");

                // Drive the select that course.js watches
                var $sel = $(".topic-type-list");
                if ($sel.val() !== slug) {
                    $sel.val(slug).trigger("change");
                } else {
                    $sel.trigger("change");
                }
            });

            // Reset card selection whenever the modal is reopened via "Add Topic" button
            $(document).on("click", ".add-topic-form", function () {
                $(".topic-type-card").removeClass("border-primary-500 ring-2 ring-primary-200");
            });
        })();
    </script>
@endpush
