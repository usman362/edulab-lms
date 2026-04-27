<x-frontend-layout>
    <x-theme::breadcrumbs.breadcrumb-one pageTitle="{{ $page->title }}" pageRoute="{{ url()->current() }}"
        pageName="{{ $page->title }}" />

    <div class="container pb-10 -mt-4 lg:-mt-6">
        <div class="max-w-4xl mx-auto">
            <div class="prose prose-lg max-w-none dark:prose-invert
                        [&>*:first-child]:!mt-0
                        [&_h1:first-child]:!mt-0 [&_h2:first-child]:!mt-0 [&_h3:first-child]:!mt-0
                        [&>div:first-child>*:first-child]:!mt-0">
                {!! clean($page->content) !!}
            </div>

            {{-- Workshop / Free Resources structured items --}}
            @php
                $eventPageKey = match ($page->url) {
                    'workshop' => 'workshop',
                    'free-resources' => 'free_resources',
                    default => null,
                };
                $events = $eventPageKey
                    ? \Modules\LMS\Models\WorkshopEvent::where('page', $eventPageKey)
                        ->where('status', 1)
                        ->orderBy('sort_order')
                        ->orderByDesc('event_date')
                        ->latest()
                        ->get()
                    : collect();
            @endphp

            @if ($events->count())
                <div class="mt-12 space-y-8">
                    @foreach ($events as $event)
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md custom-transition overflow-hidden">
                            <div class="grid grid-cols-12 gap-0">
                                @if ($event->image)
                                    <div class="col-span-full md:col-span-5 lg:col-span-4">
                                        <img src="{{ edulab_asset('lms/workshop-events/' . $event->image) }}"
                                             alt="{{ $event->title }}"
                                             class="w-full h-full object-cover aspect-video md:aspect-auto">
                                    </div>
                                @endif
                                <div class="col-span-full {{ $event->image ? 'md:col-span-7 lg:col-span-8' : '' }} p-6 lg:p-8">
                                    <h3 class="text-heading text-2xl font-bold !mt-0">{{ $event->title }}</h3>

                                    @if ($event->event_date || $event->location)
                                        <div class="flex flex-wrap gap-4 text-sm text-gray-600 mt-3">
                                            @if ($event->event_date)
                                                <span class="inline-flex items-center gap-1.5">
                                                    <i class="ri-calendar-event-line text-primary"></i>
                                                    {{ $event->event_date->format('D, d M Y') }}
                                                </span>
                                            @endif
                                            @if ($event->location)
                                                <span class="inline-flex items-center gap-1.5">
                                                    <i class="ri-map-pin-line text-primary"></i>
                                                    {{ $event->location }}
                                                </span>
                                            @endif
                                        </div>
                                    @endif

                                    @if ($event->description)
                                        <div class="mt-4 text-gray-700 leading-relaxed prose max-w-none">
                                            {!! clean($event->description) !!}
                                        </div>
                                    @endif

                                    @if ($event->video_url)
                                        <a href="{{ $event->video_url }}" target="_blank" rel="noopener"
                                           class="inline-flex items-center gap-2 mt-5 px-5 py-2.5 rounded-full bg-primary text-white font-semibold text-sm hover:shadow-lg custom-transition">
                                            <i class="ri-play-circle-line text-lg"></i>
                                            {{ translate('Watch Video') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

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
