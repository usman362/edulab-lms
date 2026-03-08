@php
    $backend = get_theme_option(key: 'backend_general') ?? [];
    $themeBottom =
        get_theme_option('footer_bottom' . active_language()) ?:
        get_theme_option('footer_bottomen') ?? get_theme_option('footer_bottom' . app('default_language'));
    $showBottom = isset($backend['footer_show_bottom']) ? ($backend['footer_show_bottom'] !== '0' && $backend['footer_show_bottom'] !== false) : (isset($themeBottom['status']) && $themeBottom['status'] === 'on');
    $copyRight = array_key_exists('footer_copyright', $backend) ? ($backend['footer_copyright'] ?? '') : ($themeBottom['copy_right'] ?? '');
    $menu = array_key_exists('footer_menu', $backend) ? ($backend['footer_menu'] ?? '') : ($themeBottom['menu'] ?? '');
    $menu = strip_footer_excluded_links($menu);
    if (stripos($copyRight, 'CodexShaper') !== false || stripos($copyRight, 'codexshaper.com') !== false) {
        $copyRight = '';
    }
@endphp

@if ($showBottom && (strip_tags($copyRight) !== '' || strip_tags($menu) !== ''))
    <!-- START BOTTOM -->
    <div class="bg-[#FFFFFF0F] py-5 rounded-t-lg">
        <div class="container">
            <div class="grid grid-cols-12 gap-7">
                @if (strip_tags($copyRight) !== '')
                <div class="col-span-full lg:col-span-6">
                    <div class="text-center lg:text-left rtl:lg:text-right">
                        <div class="text-sm !leading-none font-semibold text-white/80">
                            {!! clean($copyRight) !!}
                        </div>
                    </div>
                </div>
                @endif
                <div class="{{ strip_tags($copyRight) !== '' ? 'col-span-full lg:col-span-6' : 'col-span-full' }}">
                    <div class="text-center lg:text-left rtl:lg:text-right">
                        <div
                            class="flex items-center justify-center lg:justify-end space-x-5 rtl:space-x-reverse divide-x rtl:divide-x-reverse divide-white/15 [&>:not(:first-child)]:pl-5 rtl:[&>:not(:first-child)]:pl-0 rtl:[&>:not(:first-child)]:pr-5 grow text-white/80">
                            {!! clean($menu) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
