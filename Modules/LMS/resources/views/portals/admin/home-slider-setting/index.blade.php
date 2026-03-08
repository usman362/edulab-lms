<x-dashboard-layout>
    <x-slot:title>{{ translate('Home Page Slider Settings') }}</x-slot:title>
    <x-portal::admin.breadcrumb title="Home Page Slider Settings" page-to="Settings" />
    <div class="card">
        @php
            $settings = get_theme_option(key: 'home_slider_settings') ?? [];
        @endphp
        <form enctype="multipart/form-data" class="add_setting" method="POST"
            action="{{ route('theme.setting') }}" data-key="home_slider_settings">
            @csrf
            <h6 class="leading-none text-xl font-semibold text-heading">{{ translate('Home Page Slider Settings') }}</h6>
            <p class="text-sm text-gray-500 dark:text-dark-text mt-1 mb-6">{{ translate('Configure the banner slider on the home page. Slider content is managed under Theme Manage → Slider Manage.') }}</p>
            <div class="space-y-6">
                <div class="leading-none">
                    <label class="form-label">{{ translate('Autoplay') }}</label>
                    <select name="autoplay" class="form-input singleSelect">
                        <option value="1" {{ ($settings['autoplay'] ?? '1') == '1' ? 'selected' : '' }}>{{ translate('Yes') }}</option>
                        <option value="0" {{ isset($settings['autoplay']) && $settings['autoplay'] == '0' ? 'selected' : '' }}>{{ translate('No') }}</option>
                    </select>
                    <p class="text-sm text-gray-500 dark:text-dark-text mt-1">{{ translate('Automatically advance to the next slide.') }}</p>
                </div>
                <div class="leading-none">
                    <label for="autoplay_delay" class="form-label">{{ translate('Autoplay delay (ms)') }}</label>
                    <input type="number" id="autoplay_delay" name="autoplay_delay" class="form-input" min="1000" max="15000" step="500"
                        value="{{ $settings['autoplay_delay'] ?? 5000 }}" placeholder="5000">
                    <p class="text-sm text-gray-500 dark:text-dark-text mt-1">{{ translate('Delay between slides in milliseconds (e.g. 5000 = 5 seconds).') }}</p>
                </div>
                <div class="leading-none">
                    <label class="form-label">{{ translate('Show arrows') }}</label>
                    <select name="show_arrows" class="form-input singleSelect">
                        <option value="1" {{ ($settings['show_arrows'] ?? '1') == '1' ? 'selected' : '' }}>{{ translate('Yes') }}</option>
                        <option value="0" {{ isset($settings['show_arrows']) && $settings['show_arrows'] == '0' ? 'selected' : '' }}>{{ translate('No') }}</option>
                    </select>
                    <p class="text-sm text-gray-500 dark:text-dark-text mt-1">{{ translate('Show previous/next navigation arrows.') }}</p>
                </div>
                <div class="leading-none">
                    <label class="form-label">{{ translate('Show dots / pagination') }}</label>
                    <select name="show_dots" class="form-input singleSelect">
                        <option value="1" {{ ($settings['show_dots'] ?? '1') == '1' ? 'selected' : '' }}>{{ translate('Yes') }}</option>
                        <option value="0" {{ isset($settings['show_dots']) && $settings['show_dots'] == '0' ? 'selected' : '' }}>{{ translate('No') }}</option>
                    </select>
                    <p class="text-sm text-gray-500 dark:text-dark-text mt-1">{{ translate('Show dot pagination below the slider.') }}</p>
                </div>
                <div class="leading-none">
                    <label class="form-label">{{ translate('Loop') }}</label>
                    <select name="loop" class="form-input singleSelect">
                        <option value="1" {{ ($settings['loop'] ?? '1') == '1' ? 'selected' : '' }}>{{ translate('Yes') }}</option>
                        <option value="0" {{ isset($settings['loop']) && $settings['loop'] == '0' ? 'selected' : '' }}>{{ translate('No') }}</option>
                    </select>
                    <p class="text-sm text-gray-500 dark:text-dark-text mt-1">{{ translate('Loop back to the first slide after the last.') }}</p>
                </div>
                <div class="leading-none">
                    <label class="form-label">{{ translate('Pause on hover') }}</label>
                    <select name="pause_on_hover" class="form-input singleSelect">
                        <option value="1" {{ ($settings['pause_on_hover'] ?? '1') == '1' ? 'selected' : '' }}>{{ translate('Yes') }}</option>
                        <option value="0" {{ isset($settings['pause_on_hover']) && $settings['pause_on_hover'] == '0' ? 'selected' : '' }}>{{ translate('No') }}</option>
                    </select>
                    <p class="text-sm text-gray-500 dark:text-dark-text mt-1">{{ translate('Pause autoplay when the user hovers over the slider.') }}</p>
                </div>
                <div class="leading-none">
                    <label class="form-label">{{ translate('Effect') }}</label>
                    <select name="effect" class="form-input singleSelect">
                        <option value="slide" {{ ($settings['effect'] ?? 'slide') == 'slide' ? 'selected' : '' }}>{{ translate('Slide') }}</option>
                        <option value="fade" {{ ($settings['effect'] ?? '') == 'fade' ? 'selected' : '' }}>{{ translate('Fade') }}</option>
                    </select>
                    <p class="text-sm text-gray-500 dark:text-dark-text mt-1">{{ translate('Transition effect between slides.') }}</p>
                </div>
            </div>
            <div class="mt-8">
                <button type="submit" class="btn b-solid btn-primary-solid w-max dk-theme-card-square">
                    {{ translate('Save Settings') }}
                </button>
            </div>
        </form>
    </div>
</x-dashboard-layout>
