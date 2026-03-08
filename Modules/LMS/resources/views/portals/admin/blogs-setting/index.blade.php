<x-dashboard-layout>
    <x-slot:title>{{ translate('Blogs Settings') }}</x-slot:title>
    <x-portal::admin.breadcrumb title="Blogs Settings" page-to="Settings" />
    <div class="card">
        @php
            $settings = get_theme_option(key: 'blogs_settings') ?? [];
        @endphp
        <form enctype="multipart/form-data" class="add_setting" method="POST"
            action="{{ route('theme.setting') }}" data-key="blogs_settings">
            @csrf
            <h6 class="leading-none text-xl font-semibold text-heading">{{ translate('Blogs Settings') }}</h6>
            <p class="text-sm text-gray-500 dark:text-dark-text mt-1 mb-6">{{ translate('Configure how blogs are displayed on the website.') }}</p>
            <div class="space-y-6">
                <div class="leading-none">
                    <label for="posts_per_page" class="form-label">{{ translate('Posts per page') }}</label>
                    <input type="number" id="posts_per_page" name="posts_per_page" class="form-input" min="1" max="50"
                        value="{{ $settings['posts_per_page'] ?? 9 }}" placeholder="9">
                    <p class="text-sm text-gray-500 dark:text-dark-text mt-1">{{ translate('Number of blog posts on the blog listing page.') }}</p>
                </div>
                <div class="leading-none">
                    <label for="home_blog_item" class="form-label">{{ translate('Blogs on home page') }}</label>
                    <input type="number" id="home_blog_item" name="home_blog_item" class="form-input" min="1" max="20"
                        value="{{ $settings['home_blog_item'] ?? 3 }}" placeholder="3">
                    <p class="text-sm text-gray-500 dark:text-dark-text mt-1">{{ translate('Number of blog posts shown in the home page blog section.') }}</p>
                </div>
                <div class="leading-none">
                    <label for="excerpt_length" class="form-label">{{ translate('Excerpt length') }}</label>
                    <input type="number" id="excerpt_length" name="excerpt_length" class="form-input" min="20" max="500"
                        value="{{ $settings['excerpt_length'] ?? 120 }}" placeholder="120">
                    <p class="text-sm text-gray-500 dark:text-dark-text mt-1">{{ translate('Character count for blog excerpt in listing.') }}</p>
                </div>
                <div class="leading-none">
                    <label class="form-label">{{ translate('Show author') }}</label>
                    <select name="show_author" class="form-input singleSelect">
                        <option value="1" {{ ($settings['show_author'] ?? '1') == '1' ? 'selected' : '' }}>{{ translate('Yes') }}</option>
                        <option value="0" {{ isset($settings['show_author']) && $settings['show_author'] == '0' ? 'selected' : '' }}>{{ translate('No') }}</option>
                    </select>
                </div>
                <div class="leading-none">
                    <label class="form-label">{{ translate('Show date') }}</label>
                    <select name="show_date" class="form-input singleSelect">
                        <option value="1" {{ ($settings['show_date'] ?? '1') == '1' ? 'selected' : '' }}>{{ translate('Yes') }}</option>
                        <option value="0" {{ isset($settings['show_date']) && $settings['show_date'] == '0' ? 'selected' : '' }}>{{ translate('No') }}</option>
                    </select>
                </div>
                <div class="leading-none">
                    <label class="form-label">{{ translate('Show featured image') }}</label>
                    <select name="show_featured_image" class="form-input singleSelect">
                        <option value="1" {{ ($settings['show_featured_image'] ?? '1') == '1' ? 'selected' : '' }}>{{ translate('Yes') }}</option>
                        <option value="0" {{ isset($settings['show_featured_image']) && $settings['show_featured_image'] == '0' ? 'selected' : '' }}>{{ translate('No') }}</option>
                    </select>
                </div>
                <div class="leading-none">
                    <label class="form-label">{{ translate('Show category') }}</label>
                    <select name="show_category" class="form-input singleSelect">
                        <option value="1" {{ ($settings['show_category'] ?? '1') == '1' ? 'selected' : '' }}>{{ translate('Yes') }}</option>
                        <option value="0" {{ isset($settings['show_category']) && $settings['show_category'] == '0' ? 'selected' : '' }}>{{ translate('No') }}</option>
                    </select>
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
