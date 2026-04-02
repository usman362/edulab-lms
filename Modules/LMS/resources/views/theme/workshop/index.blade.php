<x-frontend-layout>
    <x-theme::breadcrumbs.breadcrumb-one pageTitle="Academic Performance Workshops" pageRoute="Workshop" pageName="Workshop" />

    <!-- HERO SECTION -->
    <div class="bg-primary-50 py-16 sm:py-24">
        <div class="container">
            <div class="text-center max-w-3xl mx-auto">
                <h1 class="area-title title-lg">
                    {{ translate('Academic Performance') }}
                    <span class="title-highlight-one">{{ translate('Workshops') }}</span>
                </h1>
                <p class="area-description desc-lg mt-5">
                    {{ translate('Sessions focused on study systems, exam strategy, and university entrance clarity.') }}
                </p>
                <div class="flex flex-wrap justify-center gap-3 mt-8">
                    <span class="inline-flex items-center px-5 py-2 rounded-full bg-primary text-white font-bold text-sm tracking-wide">
                        {{ translate('STRUCTURED') }}
                    </span>
                    <span class="inline-flex items-center px-5 py-2 rounded-full bg-heading text-white font-bold text-sm tracking-wide">
                        {{ translate('STRATEGIC') }}
                    </span>
                    <span class="inline-flex items-center px-5 py-2 rounded-full text-white font-bold text-sm tracking-wide" style="background: #e52524;">
                        {{ translate('RESULTS-DRIVEN') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- WHAT THE WORKSHOPS COVER -->
    <div class="container py-16 sm:py-24">
        <div class="text-center max-w-3xl mx-auto mb-12">
            <div class="area-subtitle">{{ translate('Workshop Modules') }}</div>
            <h2 class="area-title mt-2">
                {{ translate('What the Workshops') }}
                <span class="title-highlight-one">{{ translate('Cover') }}</span>
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-7">
            <!-- Module 1 -->
            <div class="bg-white border border-gray-100 rounded-2xl p-8 hover:shadow-xl hover:-translate-y-1 custom-transition group">
                <div class="flex items-start gap-5">
                    <div class="flex-center size-14 rounded-2xl bg-primary/10 shrink-0 group-hover:bg-primary custom-transition">
                        <i class="ri-calendar-todo-line text-2xl text-primary group-hover:text-white custom-transition"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <h5 class="text-heading font-bold text-lg">{{ translate('Study System Design') }}</h5>
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-primary/10 text-primary text-xs font-semibold">30 min</span>
                        </div>
                        <p class="text-gray-500 leading-relaxed">
                            {{ translate('Weekly planning frameworks, subject time allocation, and feedback integration. Learn how to build a study routine that works for your unique schedule and goals.') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Module 2 -->
            <div class="bg-white border border-gray-100 rounded-2xl p-8 hover:shadow-xl hover:-translate-y-1 custom-transition group">
                <div class="flex items-start gap-5">
                    <div class="flex-center size-14 rounded-2xl bg-red-50 shrink-0 group-hover:bg-red-500 custom-transition">
                        <i class="ri-error-warning-line text-2xl text-red-500 group-hover:text-white custom-transition"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <h5 class="text-heading font-bold text-lg">{{ translate('Avoiding Senior Mistakes') }}</h5>
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-red-50 text-red-500 text-xs font-semibold">20 min</span>
                        </div>
                        <p class="text-gray-500 leading-relaxed">
                            {{ translate('Common Year 11-12 errors, active recall concepts, and understanding marking criteria. Avoid the pitfalls that cost students valuable marks.') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Module 3 -->
            <div class="bg-white border border-gray-100 rounded-2xl p-8 hover:shadow-xl hover:-translate-y-1 custom-transition group">
                <div class="flex items-start gap-5">
                    <div class="flex-center size-14 rounded-2xl bg-indigo-50 shrink-0 group-hover:bg-indigo-500 custom-transition">
                        <i class="ri-road-map-line text-2xl text-indigo-500 group-hover:text-white custom-transition"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <h5 class="text-heading font-bold text-lg">{{ translate('Subject & Degree Strategy') }}</h5>
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-indigo-50 text-indigo-500 text-xs font-semibold">20 min</span>
                        </div>
                        <p class="text-gray-500 leading-relaxed">
                            {{ translate('Prerequisite clarity and pathway alignment. Understand how your subject choices affect university admission and career paths.') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Module 4 -->
            <div class="bg-white border border-gray-100 rounded-2xl p-8 hover:shadow-xl hover:-translate-y-1 custom-transition group">
                <div class="flex items-start gap-5">
                    <div class="flex-center size-14 rounded-2xl bg-amber-50 shrink-0 group-hover:bg-amber-500 custom-transition">
                        <i class="ri-file-list-3-line text-2xl text-amber-500 group-hover:text-white custom-transition"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <h5 class="text-heading font-bold text-lg">{{ translate('Exam Preparation Framework') }}</h5>
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-amber-50 text-amber-500 text-xs font-semibold">20 min</span>
                        </div>
                        <p class="text-gray-500 leading-relaxed">
                            {{ translate('Revision timelines and practice exam cycles. Build a repeatable system for exam preparation that reduces stress and maximises performance.') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- POST-WORKSHOP RESOURCES -->
    <div class="bg-primary-50 py-16 sm:py-20">
        <div class="container">
            <div class="grid grid-cols-12 gap-7 items-center">
                <div class="col-span-full lg:col-span-5">
                    <div class="area-subtitle">{{ translate('Take-Home Materials') }}</div>
                    <h2 class="area-title mt-2">
                        {{ translate('Post-Workshop') }}
                        <span class="title-highlight-one">{{ translate('Resources') }}</span>
                    </h2>
                    <p class="area-description mt-4">
                        {{ translate('Every participant receives practical resources to continue applying workshop strategies immediately.') }}
                    </p>
                </div>
                <div class="col-span-full lg:col-span-7">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div class="bg-white rounded-xl p-6 flex items-start gap-4 shadow-sm">
                            <div class="flex-center size-10 rounded-lg bg-primary/10 shrink-0">
                                <i class="ri-layout-grid-line text-lg text-primary"></i>
                            </div>
                            <div>
                                <h6 class="font-bold text-heading text-sm">{{ translate('Planning Template') }}</h6>
                                <p class="text-gray-500 text-xs mt-1">{{ translate('Weekly study planner with subject allocation') }}</p>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl p-6 flex items-start gap-4 shadow-sm">
                            <div class="flex-center size-10 rounded-lg bg-red-50 shrink-0">
                                <i class="ri-checkbox-circle-line text-lg text-red-500"></i>
                            </div>
                            <div>
                                <h6 class="font-bold text-heading text-sm">{{ translate('Exam Checklist') }}</h6>
                                <p class="text-gray-500 text-xs mt-1">{{ translate('Step-by-step revision and exam day checklist') }}</p>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl p-6 flex items-start gap-4 shadow-sm">
                            <div class="flex-center size-10 rounded-lg bg-indigo-50 shrink-0">
                                <i class="ri-brain-line text-lg text-indigo-500"></i>
                            </div>
                            <div>
                                <h6 class="font-bold text-heading text-sm">{{ translate('Active Recall Guide') }}</h6>
                                <p class="text-gray-500 text-xs mt-1">{{ translate('Techniques for effective information retention') }}</p>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl p-6 flex items-start gap-4 shadow-sm">
                            <div class="flex-center size-10 rounded-lg bg-amber-50 shrink-0">
                                <i class="ri-file-text-line text-lg text-amber-500"></i>
                            </div>
                            <div>
                                <h6 class="font-bold text-heading text-sm">{{ translate('Framework Summary') }}</h6>
                                <p class="text-gray-500 text-xs mt-1">{{ translate('Complete workshop framework reference document') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- WORKSHOP FORMAT -->
    <div class="container py-16 sm:py-24">
        <div class="grid grid-cols-12 gap-7">
            <div class="col-span-full lg:col-span-8">
                <div class="area-subtitle">{{ translate('Workshop Details') }}</div>
                <h2 class="area-title mt-2">
                    {{ translate('Workshop') }}
                    <span class="title-highlight-one">{{ translate('Format') }}</span>
                </h2>
                <div class="mt-8 grid grid-cols-2 sm:grid-cols-4 gap-5">
                    <div class="text-center p-5 rounded-2xl bg-primary-50">
                        <i class="ri-time-line text-3xl text-primary"></i>
                        <h6 class="font-bold text-heading mt-3 text-sm">{{ translate('Duration') }}</h6>
                        <p class="text-gray-500 text-sm mt-1">90 {{ translate('Minutes') }}</p>
                    </div>
                    <div class="text-center p-5 rounded-2xl bg-primary-50">
                        <i class="ri-user-line text-3xl text-primary"></i>
                        <h6 class="font-bold text-heading mt-3 text-sm">{{ translate('Audience') }}</h6>
                        <p class="text-gray-500 text-sm mt-1">{{ translate('Years 11-12') }}</p>
                    </div>
                    <div class="text-center p-5 rounded-2xl bg-primary-50">
                        <i class="ri-presentation-line text-3xl text-primary"></i>
                        <h6 class="font-bold text-heading mt-3 text-sm">{{ translate('Delivery') }}</h6>
                        <p class="text-gray-500 text-sm mt-1">{{ translate('Presentation + Discussion') }}</p>
                    </div>
                    <div class="text-center p-5 rounded-2xl bg-primary-50">
                        <i class="ri-folder-download-line text-3xl text-primary"></i>
                        <h6 class="font-bold text-heading mt-3 text-sm">{{ translate('Resources') }}</h6>
                        <p class="text-gray-500 text-sm mt-1">{{ translate('Templates + Checklists') }}</p>
                    </div>
                </div>
            </div>
            <!-- EXPRESSION OF INTEREST -->
            <div class="col-span-full lg:col-span-4">
                <div class="bg-white border border-gray-100 rounded-2xl p-7 shadow-md">
                    <h5 class="text-heading font-bold text-xl text-center mb-6">{{ translate('Expression of Interest') }}</h5>
                    <form action="{{ route('contact.store') }}" method="POST" class="form space-y-4">
                        @csrf
                        <input type="hidden" name="subject" value="Workshop Expression of Interest">
                        <div class="relative">
                            <input type="text" name="name" id="workshop_name" class="form-input rounded-full peer" placeholder="" required />
                            <label for="workshop_name" class="form-label floating-form-label">{{ translate('Name') }} <span class="text-danger">*</span></label>
                        </div>
                        <div class="relative">
                            <input type="email" name="email" id="workshop_email" class="form-input rounded-full peer" placeholder="" required />
                            <label for="workshop_email" class="form-label floating-form-label">{{ translate('Email') }} <span class="text-danger">*</span></label>
                        </div>
                        <div class="relative">
                            <textarea name="message" id="workshop_message" rows="4" class="form-input rounded-2xl h-auto peer" placeholder=""></textarea>
                            <label for="workshop_message" class="form-label floating-form-label">{{ translate('Message (Optional)') }}</label>
                        </div>
                        <button type="submit" aria-label="Submit"
                            class="btn b-solid btn-primary-solid !text-white btn-lg !rounded-full font-bold w-full">
                            {{ translate('Submit Interest') }}
                            <i class="ri-send-plane-line ml-1"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-frontend-layout>
