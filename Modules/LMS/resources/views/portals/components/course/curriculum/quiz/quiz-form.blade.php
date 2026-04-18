<!-- Start Add Question Modal (Simplified UX) -->
<div id="editQuiz" tabindex="-1"
    class="fixed inset-0 z-modal flex-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full hidden">
    <div class="p-4 w-full max-w-2xl max-h-full">
        <div class="relative bg-white dark:bg-dark-card-two rounded-lg dk-theme-card-square shadow">
            <button type="button" data-modal-hide="editQuiz"
                class="absolute top-3 end-2.5 hover:bg-gray-200 dark:hover:bg-dark-icon rounded-lg size-8 flex-center">
                <i class="ri-close-fill text-gray-500 dark:text-dark-text text-xl leading-none"></i>
            </button>
            <div class="p-4 md:p-5">
                <div class="pb-4 border-b border-gray-200 dark:border-dark-border">
                    <h6 class="leading-none text-lg font-semibold text-heading">
                        {{ translate('Add Question') }}
                    </h6>
                    <p class="text-xs text-gray-500 mt-1.5">
                        {{ translate('Fill in the question, choose a type, then add the correct answer.') }}
                    </p>
                </div>

                <form action="{{ $action ?? '#' }}" class="flex flex-col gap-6 mt-6 form" method="POST">
                    @csrf
                    <input type="hidden" name="quiz_id" id="quizId">

                    <div class="max-h-[80vh] overflow-auto space-y-4">
                        {{-- QUESTION TITLE --}}
                        <div class="relative">
                            <label for="quiz-question" class="form-label">
                                {{ translate('Question') }} <span class="text-danger">*</span>
                            </label>
                            <textarea name="title" rows="2" id="searchInput" data-search-type="question"
                                class="form-input search-suggestion"
                                placeholder="{{ translate('Type your question here...') }}"></textarea>
                            <div class="search-show"></div>
                            <span class="text-danger error-text title_err"></span>
                        </div>

                        {{-- MARK + TYPE + DIFFICULTY in one row --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="quiz-grade" class="form-label">
                                    {{ translate('Marks') }} <span class="text-danger">*</span>
                                </label>
                                <input type="number" name="mark" id="quiz-grade" class="form-input"
                                    min="1" value="1">
                                <span class="text-danger error-text mark_err"></span>
                            </div>

                            <div>
                                <label class="form-label">
                                    {{ translate('Type') }} <span class="text-danger">*</span>
                                </label>
                                <select class="form-input quiz-type-list" name="question_type" required>
                                    <option value="single-choice" selected>{{ translate('Single choice') }}</option>
                                    <option value="multiple-choice">{{ translate('Multiple choice') }}</option>
                                    <option value="fill-in-blank">{{ translate('Fill in the blank') }}</option>
                                </select>
                                <span class="text-danger error-text question_type_err"></span>
                            </div>

                            <div>
                                <label class="form-label">{{ translate('Difficulty') }}</label>
                                <select class="form-input" name="difficulty_level">
                                    <option value="">{{ translate('Any') }}</option>
                                    <option value="simple">{{ translate('Simple') }}</option>
                                    <option value="medium" selected>{{ translate('Medium') }}</option>
                                    <option value="hard">{{ translate('Hard') }}</option>
                                </select>
                            </div>
                        </div>

                        {{-- DYNAMIC ANSWER AREA --}}
                        <div class="answer-list-area"></div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200 dark:border-dark-border">
                        <button type="button" data-modal-hide="editQuiz"
                            class="btn b-outline btn-primary-outline">
                            {{ translate('Cancel') }}
                        </button>
                        <button type="submit" class="btn b-solid btn-primary-solid inline-flex items-center gap-2">
                            <i class="ri-save-line"></i>
                            {{ translate('Save Question') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Auto-trigger the answer area when the "Add Question" button opens the modal --}}
@push('js')
    <script>
        (function () {
            $(document).on("click", ".add-question", function () {
                setTimeout(function () {
                    var $sel = $("#editQuiz .quiz-type-list");
                    if ($sel.length && !$sel.val()) {
                        $sel.val("single-choice");
                    }
                    $sel.trigger("change");
                }, 50);
            });
        })();
    </script>
@endpush
<!-- End Add Question Modal -->
