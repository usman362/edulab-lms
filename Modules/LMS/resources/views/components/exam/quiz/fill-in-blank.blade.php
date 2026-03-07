@php
    $answers = [];
    $questionScore = $question['question_score'] ?? null;
@endphp
@foreach ($question['question_answers'] as $questionAnswer)
    @php
        $answers[] = $questionAnswer['answer']['name'];
    @endphp
    <label for="q-2-{{ $questionAnswer['id'] }}"
        class="flex items-start gap-3 dk-border-one rounded-lg p-3.5 cursor-pointer select-none">
        <input type="text" name="answers[{{ $question['id'] }}][{{ $questionAnswer['id'] }}][]"
            class="form-input focus-visible:outline-primary fill-in-blank"
            value="{{ $questionAnswer['take_answer']['value'] ?? '' }}" {{ $disabled }}>
    </label>
@endforeach

@if ($disabled == 'disabled')
    <div class="mt-4">
        <button type="button" class="show-answer-btn btn b-outline btn-primary-outline btn-sm" data-target="show-answer-block-fill-{{ $question['id'] ?? 'q' }}" aria-label="{{ translate('Show Answer') }}">
            {{ translate('Show Answer') }}
        </button>
        <div id="show-answer-block-fill-{{ $question['id'] ?? 'q' }}" class="show-answer-block hidden mt-3">
            <x-theme::exam.quiz.result-show :questionScore="$questionScore" :answers="$answers" />
        </div>
    </div>
    @php
        reset($answers);
    @endphp
@endif
