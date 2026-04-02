<x-frontend-layout>
    <x-theme::breadcrumbs.breadcrumb-one pageTitle="{{ $page->title }}" pageRoute="{{ url()->current() }}"
        pageName="{{ $page->title }}" />

    <div class="container py-10">
        <div class="max-w-4xl mx-auto">
            <div class="prose prose-lg max-w-none dark:prose-invert">
                {!! clean($page->content) !!}
            </div>

            {{-- Show student registration CTA on Online Platform page --}}
            @if ($page->url === 'online-platform')
                <div class="mt-12 bg-primary-50 rounded-2xl p-8 lg:p-12 text-center">
                    <h3 class="area-title text-2xl lg:text-3xl">
                        {{ translate('Get Started on Our Online Platform') }}
                    </h3>
                    <p class="area-description mt-4 max-w-2xl mx-auto">
                        {{ translate('Register as a student to access all available courses, track your progress, and subscribe to the programs that suit your learning goals.') }}
                    </p>
                    <div class="flex flex-wrap justify-center gap-4 mt-8">
                        @guest
                            <a href="{{ route('register.page') }}" aria-label="Student Registration"
                                class="btn b-solid btn-primary-solid btn-lg !rounded-full font-bold shadow-lg hover:shadow-xl custom-transition">
                                <i class="ri-user-add-line mr-2"></i>
                                {{ translate('Register as Student') }}
                            </a>
                            <a href="{{ route('login') }}" aria-label="Login"
                                class="btn b-outline btn-primary-outline btn-lg !rounded-full font-bold">
                                {{ translate('Already have an account? Log In') }}
                            </a>
                        @else
                            <a href="{{ route('course.list') }}" aria-label="Browse Courses"
                                class="btn b-solid btn-primary-solid btn-lg !rounded-full font-bold shadow-lg hover:shadow-xl custom-transition">
                                <i class="ri-book-open-line mr-2"></i>
                                {{ translate('Browse All Courses') }}
                            </a>
                        @endguest
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-frontend-layout>
