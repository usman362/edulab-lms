@php
    $headerClass = $data['header_class'] ?? 'bg-white py-4 sticky-header';
    $headerWrapperClass = $data['header_wrapper_class'] ?? 'flex items-center';
    $rightActionsWrapperClass = $data['right_actions_wrapper_class'] ?? 'ms-auto flex items-center gap-3';
    $components = $data['components'] ?? [];
    $innerHeaderTop = $components['inner-header-top'] ?? 'default';
    $search = $data['search'] ?? [];
    $header = $data['header'] ?? [];
    $theme = $header['theme'] ?? 'default';
@endphp

@if (!isset($style) && $innerHeaderTop === 'default')
    <x-dynamic-component component='{{ "{$theme}:theme::header.header-top-one" }}' :theme="$theme" :content="$header" />
@endif

<header class=" {{ $headerClass }} ">
    <div class="container">
        @if ($innerHeaderTop && $innerHeaderTop !== 'default')
            <x-dynamic-component component='{{ "{$theme}:theme::header.{$innerHeaderTop}" }}' />
        @endif
        <div class="{{ $headerWrapperClass }}">
            <x-dynamic-component component='{{ "{$theme}:theme::header.logo" }}' :theme="$theme" :data="$data" :default-logo="$data['default_logo'] ?? null" />
            <x-dynamic-component component='{{ "{$theme}:theme::header.menu-one" }}' :menus="$data['menus'] ?? get_menus()" :theme="$theme"
                :class="$data['menu_class'] ?? []" />
            <!-- ACTIONS -->
            <div class="{{ $rightActionsWrapperClass }}">
                <!-- SEARCH (icon toggle, not inline input to avoid overlap) -->
                @if ($search['is_show'] ?? true)
                    <div class="hidden lg:block shrink-0 relative" x-data="{ open: false }">
                        <button type="button" @click="open = !open" aria-label="Toggle search"
                            class="btn-icon size-10 b-light btn-primary-light !rounded-full">
                            <i class="ri-search-line text-lg"></i>
                        </button>
                        <form action="{{ route('course.list') }}" method="GET"
                            x-show="open" x-transition @click.away="open = false"
                            class="absolute top-full right-0 rtl:right-auto rtl:left-0 mt-2 z-50 bg-white shadow-lg rounded-lg p-2 w-72">
                            <input type="search" name="q" placeholder="{{ translate('Search courses...') }}"
                                class="form-input rounded-full text-sm w-full" autofocus>
                        </form>
                    </div>
                @endif

                <!-- ONLINE PLATFORM BUTTON -->
                <a href="{{ url('/page/online-platform') }}" aria-label="Online Platform"
                    class="hidden lg:flex btn b-solid btn-primary-solid h-10 !rounded-full !text-white font-semibold text-sm px-4 shadow-md hover:shadow-lg custom-transition"
                    style="background: linear-gradient(135deg, var(--color-primary), #e52524); border: none;">
                    <i class="ri-computer-line mr-1.5"></i>
                    {{ translate('Online Platform') }}
                </a>

                <x-dynamic-component component='{{ "{$theme}:theme::header.right-side" }}' :theme="$theme"
                    :data="$data" />

                  <!-- MENU BUTTON -->
                @if (!isset($style))
                    <div class="flex-center lg:hidden shrink-0">
                        <button type="button" aria-label="Offcanvas menu" data-offcanvas-id="offcanvas-menu"
                            class="btn-icon b-solid btn-secondary-icon-solid !text-heading dark:text-white font-bold">
                            <i class="ri-menu-unfold-line rtl:before:content-['\ef3d']"></i>
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</header>
