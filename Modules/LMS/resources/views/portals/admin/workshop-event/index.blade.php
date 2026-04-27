<x-dashboard-layout>
    <x-slot:title>{{ translate('Workshops & Free Resources') }}</x-slot:title>
    <x-portal::admin.breadcrumb title="Workshops & Free Resources" page-to="Content" />

    @php
        $editId = request('edit');
        $editing = $editId ? \Modules\LMS\Models\WorkshopEvent::find($editId) : null;
        $currentPage = $page ?? 'workshop';
    @endphp

    {{-- Success flash --}}
    @if (session('success'))
        <div class="mb-4 px-4 py-3 rounded-lg bg-green-50 text-green-700 border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    {{-- Page filter tabs --}}
    <div class="card mb-5">
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('workshop-event.index', ['page_filter' => 'workshop']) }}"
               class="px-4 py-2 rounded-lg font-semibold text-sm {{ $currentPage === 'workshop' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                {{ translate('Workshop Page') }}
            </a>
            <a href="{{ route('workshop-event.index', ['page_filter' => 'free_resources']) }}"
               class="px-4 py-2 rounded-lg font-semibold text-sm {{ $currentPage === 'free_resources' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                {{ translate('Free Resources Page') }}
            </a>
        </div>
        <p class="text-sm text-gray-500 mt-3">
            {{ translate('Add or edit items shown on the public Workshop and Free Resources pages. Each item can have a flyer image, optional video, date and location. Items are sorted by Sort Order then by date.') }}
        </p>
    </div>

    <div class="grid grid-cols-12 gap-5">
        {{-- ============= FORM ============= --}}
        <div class="col-span-full lg:col-span-5">
            <div class="card">
                <h6 class="leading-none text-xl font-semibold text-heading mb-5">
                    {{ $editing ? translate('Edit Item') : translate('Add New Item') }}
                </h6>

                <form action="{{ $editing ? route('workshop-event.update', $editing->id) : route('workshop-event.store') }}"
                      method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    @if ($editing) @method('PUT') @endif
                    <input type="hidden" name="page" value="{{ $currentPage }}">

                    <div class="leading-none">
                        <label class="form-label">{{ translate('Title') }} <span class="text-red-500">*</span></label>
                        <input type="text" name="title" class="form-input" required
                               value="{{ old('title', $editing->title ?? '') }}">
                    </div>

                    <div class="leading-none">
                        <label class="form-label">{{ translate('Flyer / Image') }}</label>
                        <input type="file" name="image" accept="image/*" class="form-input">
                        @if ($editing && $editing->image)
                            <div class="mt-2">
                                <img src="{{ edulab_asset('lms/workshop-events/' . $editing->image) }}"
                                     alt="Current flyer" class="h-32 rounded border border-gray-200">
                                <p class="text-xs text-gray-500 mt-1">{{ translate('Upload a new file to replace.') }}</p>
                            </div>
                        @endif
                    </div>

                    <div class="leading-none">
                        <label class="form-label">{{ translate('Video URL (YouTube/Vimeo/MP4)') }}</label>
                        <input type="url" name="video_url" class="form-input"
                               placeholder="https://youtube.com/watch?v=..."
                               value="{{ old('video_url', $editing->video_url ?? '') }}">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="leading-none">
                            <label class="form-label">{{ translate('Event Date') }}</label>
                            <input type="date" name="event_date" class="form-input"
                                   value="{{ old('event_date', $editing?->event_date?->format('Y-m-d') ?? '') }}">
                        </div>
                        <div class="leading-none">
                            <label class="form-label">{{ translate('Location') }}</label>
                            <input type="text" name="location" class="form-input"
                                   placeholder="e.g. BCE Brisbane"
                                   value="{{ old('location', $editing->location ?? '') }}">
                        </div>
                    </div>

                    <div class="leading-none">
                        <label class="form-label">{{ translate('Description / Writing') }}</label>
                        <textarea name="description" rows="6" class="form-input"
                                  placeholder="HTML allowed. Describe the workshop, schedule, what to bring, etc.">{{ old('description', $editing->description ?? '') }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">
                            {{ translate('You can paste HTML here (paragraphs, lists, links). Plain text also works.') }}
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="leading-none">
                            <label class="form-label">{{ translate('Sort Order') }}</label>
                            <input type="number" name="sort_order" class="form-input" min="0"
                                   value="{{ old('sort_order', $editing->sort_order ?? 0) }}">
                            <p class="text-xs text-gray-500 mt-1">{{ translate('Lower shows first.') }}</p>
                        </div>
                        <div class="leading-none">
                            <label class="form-label">{{ translate('Status') }}</label>
                            <select name="status" class="form-input">
                                <option value="1" {{ ($editing->status ?? 1) == 1 ? 'selected' : '' }}>{{ translate('Published') }}</option>
                                <option value="0" {{ isset($editing) && !$editing->status ? 'selected' : '' }}>{{ translate('Draft (hidden)') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="submit" class="btn b-solid btn-primary-solid dk-theme-card-square">
                            {{ $editing ? translate('Update') : translate('Save') }}
                        </button>
                        @if ($editing)
                            <a href="{{ route('workshop-event.index', ['page_filter' => $currentPage]) }}"
                               class="btn b-outline btn-secondary-outline dk-theme-card-square">
                                {{ translate('Cancel') }}
                            </a>
                        @endif
                    </div>

                    @if ($errors->any())
                        <div class="px-3 py-2 rounded bg-red-50 text-red-700 text-sm">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </form>
            </div>
        </div>

        {{-- ============= LIST ============= --}}
        <div class="col-span-full lg:col-span-7">
            <div class="card">
                <h6 class="leading-none text-xl font-semibold text-heading mb-5">
                    {{ translate('Existing Items') }}
                    <span class="text-sm text-gray-500 font-normal">({{ count($events) }})</span>
                </h6>

                @if (count($events) === 0)
                    <div class="text-center py-10 text-gray-500">
                        <i class="ri-folder-open-line text-4xl"></i>
                        <p class="mt-2">{{ translate('No items yet. Add your first one using the form on the left.') }}</p>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach ($events as $event)
                            <div class="flex gap-3 p-3 rounded-lg border border-gray-200 dark:border-dark-border-four hover:bg-gray-50 dark:hover:bg-dark-card">
                                @if ($event->image)
                                    <img src="{{ edulab_asset('lms/workshop-events/' . $event->image) }}"
                                         alt="{{ $event->title }}"
                                         class="w-20 h-20 object-cover rounded shrink-0">
                                @else
                                    <div class="w-20 h-20 rounded bg-gray-100 flex-center shrink-0">
                                        <i class="ri-image-line text-2xl text-gray-400"></i>
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-2">
                                        <p class="font-semibold text-heading truncate">{{ $event->title }}</p>
                                        <span class="text-xs px-2 py-0.5 rounded-full {{ $event->status ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }} shrink-0">
                                            {{ $event->status ? translate('Live') : translate('Draft') }}
                                        </span>
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1 flex flex-wrap gap-3">
                                        @if ($event->event_date)
                                            <span><i class="ri-calendar-line"></i> {{ $event->event_date->format('d M Y') }}</span>
                                        @endif
                                        @if ($event->location)
                                            <span><i class="ri-map-pin-line"></i> {{ $event->location }}</span>
                                        @endif
                                        @if ($event->video_url)
                                            <span><i class="ri-video-line"></i> {{ translate('Video') }}</span>
                                        @endif
                                        <span><i class="ri-sort-asc"></i> #{{ $event->sort_order }}</span>
                                    </div>
                                    <div class="flex gap-2 mt-2">
                                        <a href="{{ route('workshop-event.index', ['page_filter' => $currentPage, 'edit' => $event->id]) }}"
                                           class="text-xs text-primary hover:underline">
                                            <i class="ri-edit-line"></i> {{ translate('Edit') }}
                                        </a>
                                        <form action="{{ route('workshop-event.destroy', $event->id) }}" method="POST"
                                              class="inline" onsubmit="return confirm('{{ translate('Delete this item?') }}');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-xs text-red-500 hover:underline">
                                                <i class="ri-delete-bin-line"></i> {{ translate('Delete') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-dashboard-layout>
