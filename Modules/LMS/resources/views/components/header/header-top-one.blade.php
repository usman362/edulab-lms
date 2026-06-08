@php 
    $general = get_theme_option(key: 'general') ?? []; 
@endphp

<div class="bg-primary py-3 hidden md:block">
    <div class="container">
        <div class="flex items-center justify-start">
            <div class="flex items-center gap-5">
                @if (isset($general['email']))
                    <div class="flex items-center gap-2">
                        <i class="ri-mail-line text-white/80 text-base leading-none"></i>
                        <a href="mailto:{{ $general['email'] }}" aria-label="Contact mail" class="text-sm !leading-none font-semibold text-white/80 hover:text-white custom-transition">
                            {{ $general['email'] }}
                        </a>
                    </div>
                @endif
                @if (isset($general['phone']))
                    <div class="flex items-center gap-2">
                        <i class="ri-phone-line text-white/80 text-base leading-none"></i>
                        <a href="tel:+{{ $general['phone'] }}" aria-label="Contact phone" class="text-sm !leading-none font-semibold text-white/80 hover:text-white custom-transition">
                            {{ translate('Call') }}:
                            {{ $general['phone'] }}
                        </a>
                    </div>
                @endif
            </div>
            {{-- Language switcher hidden: only English --}}
        </div>
    </div>
</div>
