@php
    $backend = get_theme_option(key: 'backend_general') ?? [];
    $themeBottom = get_theme_option('footer_bottom' . active_language()) ?: get_theme_option('footer_bottomen') ?? get_theme_option('footer_bottom' . app('default_language'));
    $showBottom = isset($backend['footer_show_bottom']) ? ($backend['footer_show_bottom'] !== '0' && $backend['footer_show_bottom'] !== false) : (isset($themeBottom['status']) && $themeBottom['status'] === 'on');
    $copyRight = array_key_exists('footer_copyright', $backend) ? ($backend['footer_copyright'] ?? '') : ($themeBottom['copy_right'] ?? '');
    $menu = array_key_exists('footer_menu', $backend) ? ($backend['footer_menu'] ?? '') : ($themeBottom['menu'] ?? '');
    $menu = strip_footer_excluded_links($menu);
    if (stripos($copyRight, 'CodexShaper') !== false || stripos($copyRight, 'codexshaper.com') !== false) {
        $copyRight = '';
    }
@endphp

@if ($showBottom && (strip_tags($copyRight) !== '' || strip_tags($menu) !== ''))
    <div class="container">
        <div class="bg-[#FFFFFF0F] px-4 py-5 border border-heading/15 border-b-0 rounded-t-lg">
            <div class="grid grid-cols-12 gap-7">
                <div class="col-span-full lg:col-span-6">
                    <div class="text-center lg:text-left">
                        <div class="text-sm !leading-none font-semibold text-heading/80">
                            {!! clean($copyRight) !!}
                        </div>
                    </div>
                </div>
                <div class="col-span-full lg:col-span-6">
                    <div class="text-center lg:text-left">
                        <div
                            class="flex items-center justify-center lg:justify-end space-x-5 divide-x divide-white/15 [&>:not(:first-child)]:pl-5 grow">
                            {!! clean($menu) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
