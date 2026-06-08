<x-frontend-layout>
    <div class="bg-white py-16 sm:py-20 lg:py-[120px]">
        <div class="container">
            <div class="max-w-xl mx-auto text-center">
                <span class="inline-flex size-20 rounded-full bg-primary/10 text-primary items-center justify-center mb-7">
                    <i class="ri-checkbox-circle-fill text-5xl"></i>
                </span>
                <h1 class="area-title">{{ translate('Thank you!') }}</h1>
                <p class="area-description text-lg mt-4">
                    {{ translate('Your payment was successful and your enrolment is confirmed. A receipt has been emailed to you.') }}
                </p>

                <div class="flex flex-wrap items-center justify-center gap-4 mt-9">
                    <a href="{{ route('course.list') }}" aria-label="Start learning"
                        class="btn b-solid btn-primary-solid btn-xl font-semibold">
                        {{ translate('Start Learning') }}
                        <i class="ri-arrow-right-up-line text-[18px] ml-1"></i>
                    </a>
                    <a href="{{ route('home.index') }}" aria-label="Back to home"
                        class="btn b-outline btn-primary-outline btn-xl font-semibold">
                        {{ translate('Back to Home') }}
                    </a>
                </div>

                {{-- Reassurance strip --}}
                <div class="flex flex-wrap items-center justify-center gap-x-8 gap-y-3 mt-12 pt-8 border-t border-border text-sm text-heading/70">
                    <div class="flex items-center gap-2"><i class="ri-shield-check-line text-primary"></i> {{ translate('Secure payment') }}</div>
                    <div class="flex items-center gap-2"><i class="ri-mail-check-line text-primary"></i> {{ translate('Receipt emailed') }}</div>
                    <div class="flex items-center gap-2"><i class="ri-customer-service-2-line text-primary"></i> {{ translate('Support available') }}</div>
                </div>
            </div>
        </div>
    </div>
</x-frontend-layout>
