<x-frontend-layout>
    <x-theme::breadcrumbs.breadcrumb-one pageTitle="Quiz" pageRoute="#" pageName="Quiz" />
    @php
        $quiz = $data['quiz'];
        $userQuiz = $data['userExam'];
        $questionChunks = $data['questions']; // chunked in pairs — flatten below
        $quizStart = $start ?: ($again ?: false);

        // Flatten chunked questions
        $allQuestions = [];
        foreach ($questionChunks as $chunk) {
            foreach ($chunk as $q) {
                $allQuestions[] = $q;
            }
        }
        $totalQuestions = count($allQuestions);

        // Timer setup — only when actively taking the quiz
        $attempt_number = $userQuiz->attempt_number ?? 0;
        $disabled = $attempt_number == $quiz->total_retake ? 'disabled' : '';
        $timerActive = !isInstructor() && $userQuiz && ($start || $again) && !$disabled;
        $durationMinutes = (int) ($quiz->duration ?? 0);
    @endphp

    <input type="hidden" name="course_id" id="courseId" value="{{ $data['course_id'] }}">
    <input type="hidden" name="topic_id" id="topicId" value="{{ $data['topic_id'] }}">
    <input type="hidden" name="chapter_id" id="chapterId" value="{{ $data['chapter_id'] }}" />
    <input type="hidden" id="start-quiz" value="{{ $quizStart }}" />

    <style>
        /* Quiz layout — Khan Academy inspired, one question per page */
        .kh-quiz-wrap { max-width: 900px; margin: 0 auto; }
        .kh-quiz-stats {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: .75rem;
            margin-top: 1.5rem;
        }
        @media (min-width: 640px) { .kh-quiz-stats { grid-template-columns: repeat(3, 1fr); } }
        @media (min-width: 1024px) { .kh-quiz-stats { grid-template-columns: repeat(6, 1fr); } }
        .kh-stat-card {
            background: #f5f3ff;
            border-radius: 12px;
            padding: 1rem .75rem;
            text-align: center;
        }
        .kh-stat-icon {
            width: 38px; height: 38px; border-radius: 50%;
            background: #fff;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto .5rem;
            color: #6366f1;
        }
        .kh-stat-title { font-size: 1.125rem; font-weight: 700; color: #1e293b; line-height: 1.1; }
        .kh-stat-title.danger { color: #dc2626; }
        .kh-stat-desc { font-size: 11px; text-transform: uppercase; letter-spacing: .04em; color: #64748b; margin-top: .25rem; }

        .kh-quiz-progress-bar {
            width: 100%; height: 6px; background: #e2e8f0; border-radius: 999px; overflow: hidden;
            margin: 1.5rem 0 1rem;
        }
        .kh-quiz-progress-fill {
            height: 100%; background: linear-gradient(90deg, #6366f1, #8b5cf6);
            border-radius: 999px; transition: width .3s;
        }

        .kh-question-step { display: none; }
        .kh-question-step.active { display: block; animation: khFadeIn .25s ease-out; }
        @keyframes khFadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .kh-quiz-nav {
            display: flex; justify-content: space-between; align-items: center; gap: .75rem;
            margin-top: 1.5rem; padding-top: 1.5rem;
            border-top: 1px solid #e2e8f0;
        }
        .kh-quiz-counter {
            font-size: 14px; font-weight: 500; color: #475569;
        }
    </style>

    <div class="container">
        <div class="kh-quiz-wrap">
            {{-- QUIZ HEADER --}}
            <div style="display:flex; flex-wrap:wrap; justify-content:space-between; align-items:flex-start; gap:1rem; margin-bottom:1.5rem;">
                <div style="flex:1; min-width:0;">
                    <h2 class="area-title" style="font-size:1.5rem; margin-bottom:.5rem;">
                        {{ $quiz?->topic?->chapter?->course?->title ?? translate('Quiz') }}
                    </h2>
                    <div style="font-size:14px; color:#64748b;">
                        @if ($quiz?->topic?->chapter?->title)
                            <span>{{ $quiz?->topic?->chapter?->title }}</span> ·
                        @endif
                        <span style="color:#6366f1; font-weight:600;">{{ $quiz->title }}</span>
                    </div>
                </div>
                @php
                    $actionRoute = route('play.course', [
                        'slug' => $quiz?->topic?->chapter?->course?->slug,
                        'topic_id' => $quiz?->topic?->id ?? null,
                        'type' => $type,
                        'chapter_id' => $quiz?->topic?->chapter?->id ?? null,
                    ]);
                @endphp
                <a href="{{ $actionRoute }}" class="btn b-solid btn-primary-solid" style="flex-shrink:0;">
                    <i class="ri-arrow-left-line"></i> {{ translate('Course Video') }}
                </a>
            </div>

            {{-- COMPACT QUIZ STATS --}}
            <div class="kh-quiz-stats">
                <div class="kh-stat-card">
                    <div class="kh-stat-icon"><i class="ri-speed-up-line"></i></div>
                    <div class="kh-stat-title">{{ $quiz->pass_mark }}/{{ $quiz->total_mark }}</div>
                    <div class="kh-stat-desc">{{ translate('Pass Mark') }}</div>
                </div>
                <div class="kh-stat-card">
                    <div class="kh-stat-icon"><i class="ri-refresh-line"></i></div>
                    <div class="kh-stat-title">{{ $attempt_number }}/{{ $quiz->total_retake }}</div>
                    <div class="kh-stat-desc">{{ translate('Attempts') }}</div>
                </div>
                <div class="kh-stat-card">
                    <div class="kh-stat-icon"><i class="ri-lightbulb-line"></i></div>
                    <div class="kh-stat-title">{{ $totalQuestions }}</div>
                    <div class="kh-stat-desc">{{ translate('Questions') }}</div>
                </div>
                <div class="kh-stat-card">
                    <div class="kh-stat-icon"><i class="ri-timer-line"></i></div>
                    <div class="kh-stat-title danger"
                        id="quizTimer"
                        data-duration-minutes="{{ $durationMinutes }}"
                        data-timer-active="{{ $timerActive ? '1' : '0' }}">
                        @if ($timerActive)
                            --:--:--
                        @else
                            {{ $durationMinutes }} {{ translate('min') }}
                        @endif
                    </div>
                    <div class="kh-stat-desc">{{ translate('Time Left') }}</div>
                </div>
                <div class="kh-stat-card">
                    <div class="kh-stat-icon"><i class="ri-medal-line"></i></div>
                    <div class="kh-stat-title">{{ $userQuiz->score ?? translate('Pending') }}</div>
                    <div class="kh-stat-desc">{{ translate('Your Score') }}</div>
                </div>
                <div class="kh-stat-card">
                    <div class="kh-stat-icon"><i class="ri-trophy-line"></i></div>
                    <div class="kh-stat-title">
                        @php
                            $status = translate('Not Yet');
                            if (isset($userQuiz->score)) {
                                $status = $quiz->pass_mark <= $userQuiz->score
                                    ? '<span style="color:#16a34a;">' . translate('Passed') . '</span>'
                                    : '<span style="color:#dc2626;">' . translate('Failed') . '</span>';
                            }
                        @endphp
                        {!! $status !!}
                    </div>
                    <div class="kh-stat-desc">{{ translate('Your Result') }}</div>
                </div>
            </div>

            {{-- QUIZ CONTENT --}}
            <div class="lms-quiz-form-container" style="margin-top:2rem;">
                @if (empty($userQuiz))
                    <x-theme::cards.empty title="Let's See What You've Learned!"
                        description="You've learned a lot, now it's time to put it to the test. Don't worry — this quiz is your chance to see how much you've mastered. Ready to show what you know?"
                        btn="true" btntext="Start Quiz Now"
                        btnAction="{{ route('exam.start', ['type' => $type, 'exam_type_id' => $exam_type_id, 'course_id' => $data['course_id'], 'status' => 'start']) }}" />
                @elseif ($totalQuestions === 0)
                    <x-theme::cards.empty title="No Questions Yet"
                        description="This quiz has no questions yet. Please check back later." />
                @else
                    {{-- PROGRESS BAR --}}
                    <div style="display:flex; justify-content:space-between; align-items:center; font-size:14px; color:#475569; font-weight:500;">
                        <span>{{ translate('Progress') }}</span>
                        <span><span id="khCurrentQ">1</span> / {{ $totalQuestions }}</span>
                    </div>
                    <div class="kh-quiz-progress-bar">
                        <div class="kh-quiz-progress-fill" id="khQuizProgress" style="width: {{ $totalQuestions > 0 ? (1 / $totalQuestions * 100) : 0 }}%"></div>
                    </div>

                    {{-- QUESTIONS: ONE AT A TIME --}}
                    <div id="khQuizSteps">
                        @foreach ($allQuestions as $idx => $q)
                            <div class="kh-question-step {{ $idx === 0 ? 'active' : '' }}" data-step="{{ $idx }}">
                                <x-theme::exam.quiz.question :questionList="[$q]" quizId="{{ $quiz->id }}"
                                    disabled="{{ $disabled }}" />
                            </div>
                        @endforeach
                    </div>

                    {{-- NAVIGATION --}}
                    <div class="kh-quiz-nav">
                        <button type="button" id="khPrevBtn" class="btn b-outline btn-primary-outline" disabled style="opacity:.5;">
                            <i class="ri-arrow-left-line"></i> {{ translate('Previous') }}
                        </button>

                        <span class="kh-quiz-counter">
                            <span id="khCurrentQ2">1</span> {{ translate('of') }} {{ $totalQuestions }}
                        </span>

                        @if ($attempt_number >= 1 && $attempt_number !== $quiz->total_retake && !$again && !isInstructor())
                            <a class="btn b-solid btn-primary-solid"
                                href="{{ route('exam.start', ['type' => $type, 'exam_type_id' => $exam_type_id, 'course_id' => $data['course_id'], 'status' => 'try']) }}">
                                {{ translate('Try Again') }}
                            </a>
                        @else
                            <button type="button" id="khNextBtn" class="btn b-solid btn-primary-solid">
                                {{ translate('Next') }} <i class="ri-arrow-right-line"></i>
                            </button>
                            <button type="button" id="khSubmitBtn" class="btn b-solid btn-primary-solid" style="display:none;"
                                onclick="event.preventDefault(); document.getElementById('final-submit').submit();">
                                <i class="ri-check-line"></i> {{ translate('Submit Quiz') }}
                            </button>
                        @endif
                    </div>

                    {{-- HIDDEN FINAL SUBMIT FORM --}}
                    <form id="final-submit" action="{{ route('quiz.store.result', $quiz->id) }}" method="POST" class="hidden">
                        @csrf
                        <input type="hidden" name="course_id" value="{{ $data['course_id'] }}">
                        <input type="hidden" name="topic_id" value="{{ $data['topic_id'] }}">
                        <input type="hidden" name="chapter_id" value="{{ $data['chapter_id'] }}" />
                    </form>
                @endif
            </div>
        </div>
    </div>

    {{-- QUIZ FLOW SCRIPT --}}
    <script>
        (function () {
            // =====  STEP NAVIGATION  =====
            var steps = document.querySelectorAll('.kh-question-step');
            var total = steps.length;
            var prevBtn = document.getElementById('khPrevBtn');
            var nextBtn = document.getElementById('khNextBtn');
            var submitBtn = document.getElementById('khSubmitBtn');
            var currentQ = document.getElementById('khCurrentQ');
            var currentQ2 = document.getElementById('khCurrentQ2');
            var progressFill = document.getElementById('khQuizProgress');
            var current = 0;

            function showStep(index) {
                if (index < 0 || index >= total) return;
                steps.forEach(function (s, i) { s.classList.toggle('active', i === index); });
                current = index;

                if (currentQ) currentQ.textContent = index + 1;
                if (currentQ2) currentQ2.textContent = index + 1;
                if (progressFill) progressFill.style.width = ((index + 1) / total * 100) + '%';

                if (prevBtn) {
                    prevBtn.disabled = index === 0;
                    prevBtn.style.opacity = index === 0 ? '.5' : '1';
                }
                if (nextBtn && submitBtn) {
                    if (index === total - 1) {
                        nextBtn.style.display = 'none';
                        submitBtn.style.display = '';
                    } else {
                        nextBtn.style.display = '';
                        submitBtn.style.display = 'none';
                    }
                }
                // Scroll into view gently
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }

            if (prevBtn) prevBtn.addEventListener('click', function () { showStep(current - 1); });
            if (nextBtn) nextBtn.addEventListener('click', function () { showStep(current + 1); });

            // =====  TIMER  =====
            var timerEl = document.getElementById('quizTimer');
            if (timerEl && timerEl.getAttribute('data-timer-active') === '1') {
                var minutes = parseInt(timerEl.getAttribute('data-duration-minutes') || '0', 10);
                if (isNaN(minutes) || minutes <= 0) minutes = 0;
                var timeLeft = minutes * 60;
                var startFlag = document.getElementById('start-quiz');
                var isStart = startFlag && startFlag.value && startFlag.value !== 'false' && startFlag.value !== '0';

                function fmt(s) {
                    if (s < 0) s = 0;
                    var h = Math.floor(s / 3600);
                    var m = Math.floor((s % 3600) / 60);
                    var sec = s % 60;
                    return String(h).padStart(2, '0') + ':' + String(m).padStart(2, '0') + ':' + String(sec).padStart(2, '0');
                }

                if (timeLeft > 0) {
                    timerEl.textContent = fmt(timeLeft);
                    var iv = setInterval(function () {
                        timeLeft--;
                        if (timeLeft <= 0) {
                            clearInterval(iv);
                            timerEl.textContent = '00:00:00';
                            if (isStart && typeof jQuery !== 'undefined') {
                                jQuery('#final-submit').trigger('submit');
                            } else {
                                var form = document.getElementById('final-submit');
                                if (form) form.submit();
                            }
                        } else {
                            timerEl.textContent = fmt(timeLeft);
                        }
                    }, 1000);
                } else {
                    timerEl.textContent = '00:00:00';
                }
            }

            // =====  SHOW-ANSWER TOGGLE (unchanged) =====
            document.querySelectorAll('.show-answer-btn').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var targetId = this.getAttribute('data-target');
                    var block = targetId ? document.getElementById(targetId) : null;
                    if (block) {
                        block.classList.remove('hidden');
                        this.classList.add('hidden');
                    }
                });
            });
        })();
    </script>
</x-frontend-layout>
