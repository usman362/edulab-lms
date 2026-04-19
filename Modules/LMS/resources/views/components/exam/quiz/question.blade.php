@php
    // Difficulty → Tailwind-ish inline style colors
    $difficultyStyles = [
        'simple' => ['bg' => '#dcfce7', 'text' => '#166534', 'label' => translate('Easy')],
        'medium' => ['bg' => '#fef9c3', 'text' => '#854d0e', 'label' => translate('Medium')],
        'hard' => ['bg' => '#fee2e2', 'text' => '#991b1b', 'label' => translate('Hard')],
    ];
    $typeLabels = [
        'single-choice' => translate('Single Choice'),
        'multiple-choice' => translate('Multiple Choice'),
        'fill-in-blank' => translate('Fill in the Blank'),
    ];
@endphp

@foreach ($questionList as $key => $question)
    @php
        $diff = $question['difficulty_level'] ?? null;
        $diffMeta = $diff && isset($difficultyStyles[$diff]) ? $difficultyStyles[$diff] : null;
        $qType = $question['question_type'] ?? '';
        $typeLabel = $typeLabels[$qType] ?? ucfirst(str_replace('-', ' ', $qType));
    @endphp
    <form
        action="{{ route('user.submit.quiz.answer', ['quiz_id' => $quizId, 'question_id' => $question['id'], 'type' => $question['question_type']]) }}"
        id="{{ $question['id'] }}" method="POST"
        class="col-span-full lg:col-span-1 bg-white rounded-20 shadow-sm p-7 border border-primary-200 relative">

        <!-- QUESTION META TAGS (top-right) -->
        <div style="position:absolute; top:.75rem; right:.75rem; display:flex; gap:.375rem; flex-wrap:wrap; justify-content:flex-end;">
            @if ($diffMeta)
                <span style="display:inline-flex; align-items:center; gap:.25rem; padding:.125rem .5rem; border-radius:999px; font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:.04em; background:{{ $diffMeta['bg'] }}; color:{{ $diffMeta['text'] }};">
                    {{ $diffMeta['label'] }}
                </span>
            @endif
            <span style="display:inline-flex; align-items:center; padding:.125rem .5rem; border-radius:999px; font-size:11px; font-weight:600; background:#eef2ff; color:#3730a3;">
                {{ $question['mark'] ?? 1 }} {{ translate('Mark') }}{{ ($question['mark'] ?? 1) > 1 ? 's' : '' }}
            </span>
        </div>

        <!-- QUESTION TYPE HINT (small, above question) -->
        <div style="font-size:11px; color:#6b7280; text-transform:uppercase; letter-spacing:.06em; font-weight:600; margin-bottom:.5rem; margin-right:8rem;">
            {{ translate('Question') }} {{ $key + 1 }} · {{ $typeLabel }}
        </div>

        <div class="question area-title text-lg" style="padding-right:2rem;">
            {{ $question['question']['name'] }}
        </div>

        <ul class="question-options mt-6">
            @if ($question['question_type'] != 'fill-in-blank')
                <x-theme::exam.quiz.single-multiple-question :question="$question" disabled="{{ $disabled }}" />
            @else
                <x-theme::exam.quiz.fill-in-blank :question="$question" disabled="{{ $disabled }}" />
            @endif
        </ul>

    </form>
@endforeach
