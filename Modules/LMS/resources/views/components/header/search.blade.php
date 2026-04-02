<form action="{{ route('course.list') }}" class="shrink-0" method="GET">
    <input type="search" class="form-input {{ $class['input'] ?? ' rounded-full' }} text-sm" name="q"
        placeholder="{{ translate('Search') }}..." style="max-width: 180px;">
</form>
