<x-frontend-layout>
    <x-theme::breadcrumbs.breadcrumb-one pageTitle="{{ $page->title }}" pageRoute="{{ url()->current() }}"
        pageName="{{ $page->title }}" />

    <div class="container py-10">
        <div class="max-w-4xl mx-auto">
            <div class="prose prose-lg max-w-none dark:prose-invert">
                {!! clean($page->content) !!}
            </div>
        </div>
    </div>
</x-frontend-layout>
