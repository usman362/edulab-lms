<x-frontend-layout>
    <x-theme::breadcrumbs.breadcrumb-one pageTitle="{{ translate('Select difficulty') }}" pageRoute="#" pageName="{{ translate('Quiz') }}" />
    <div class="container py-10">
        <div class="max-w-2xl mx-auto card p-8">
            <h2 class="area-title text-2xl mb-2">{{ translate('Choose question difficulty') }}</h2>
            <p class="text-gray-500 dark:text-dark-text-two mb-8">{{ translate('Questions will appear after you select a difficulty level.') }}</p>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <a href="{{ route('exam.start', ['type' => $type, 'exam_type_id' => $exam_type_id, 'course_id' => $course_id, 'difficulty' => 'simple']) }}"
                    class="flex flex-col items-center justify-center p-6 rounded-xl border-2 border-primary-200 dark:border-dark-border-four hover:border-primary-500 hover:bg-primary-50 dark:hover:bg-primary-500/10 transition-all text-center">
                    <span class="text-3xl mb-2" aria-hidden="true">🟢</span>
                    <span class="font-semibold text-heading dark:text-white">{{ translate('Simple') }}</span>
                </a>
                <a href="{{ route('exam.start', ['type' => $type, 'exam_type_id' => $exam_type_id, 'course_id' => $course_id, 'difficulty' => 'medium']) }}"
                    class="flex flex-col items-center justify-center p-6 rounded-xl border-2 border-primary-200 dark:border-dark-border-four hover:border-primary-500 hover:bg-primary-50 dark:hover:bg-primary-500/10 transition-all text-center">
                    <span class="text-3xl mb-2" aria-hidden="true">🟡</span>
                    <span class="font-semibold text-heading dark:text-white">{{ translate('Medium') }}</span>
                </a>
                <a href="{{ route('exam.start', ['type' => $type, 'exam_type_id' => $exam_type_id, 'course_id' => $course_id, 'difficulty' => 'hard']) }}"
                    class="flex flex-col items-center justify-center p-6 rounded-xl border-2 border-primary-200 dark:border-dark-border-four hover:border-primary-500 hover:bg-primary-50 dark:hover:bg-primary-500/10 transition-all text-center">
                    <span class="text-3xl mb-2" aria-hidden="true">🔴</span>
                    <span class="font-semibold text-heading dark:text-white">{{ translate('Hard') }}</span>
                </a>
            </div>
        </div>
    </div>
</x-frontend-layout>
