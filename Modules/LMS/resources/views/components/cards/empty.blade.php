<div class="bg-white border border-border rounded-2xl mt-5">
    <div class="flex-center flex-col gap-4 p-8 lg:p-12 text-center max-w-screen-sm mx-auto">
        <span class="size-20 flex-center rounded-full bg-primary/10 text-primary mb-1">
            <i class="ri-inbox-line text-4xl"></i>
        </span>
        @if ($title ?? '')
            <h2 class="area-title !text-2xl"> {{ translate($title) }}</h2>
        @endif
        @if (isset($description))
            <p class="area-description">{{ translate($description) }}</p>
        @endif

        @if (isset($btn) && $btn == true)
            <a href="{{ $btnAction ?? route('home.index') }}" class="btn b-solid btn-primary-solid btn-xl font-semibold mt-2" aria-label="Go to home">
                {{ translate($btntext ?? 'Home') }}</a>
        @endif
    </div>
</div>
