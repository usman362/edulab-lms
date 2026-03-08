<div class="bg-[#1B253A] py-3.5 hidden md:block">
    <div class="max-w-[1600px] mx-auto px-[12px]">
        <div class="flex-center-between">
            <div class="flex items-center justify-start space-x-5 divide-x divide-white/15 [&>:not(:first-child)]:pl-5 grow">
                <p class="area-description text-sm text-white/80">
                    {{ translate( 'New members: get your first 15 days of tutor Premium for free!' ) }}
                    <a href="{{ route('course.list') }}" aria-label="Discount course link" class="text-secondary">{{ translate( 'Unlock discount now' ) }}!</a>
                </p>
            </div>
            {{-- Language switcher hidden: only English --}}
        </div>
    </div>
</div>
