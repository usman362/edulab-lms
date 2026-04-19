@php
    $isOrganization = $isOrganization ?? false;
    $isInstructor = $isInstructor ?? false;
    $user = authCheck();
    $searchInstructors = Request()->instructors ?? [];
    $courseStatus = Request()->course_status ?? null;
    $courseType = Request()->course_type ?? null;
    $organizations = Request()->organizations ?? null;
@endphp

<style>
    /* Clean, consistent filter grid that doesn't depend on Tailwind JIT classes */
    .kh-filter-grid {
        display: grid;
        grid-template-columns: repeat(1, minmax(0, 1fr));
        gap: 1rem;
    }
    @media (min-width: 640px) {
        .kh-filter-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
    @media (min-width: 1024px) {
        .kh-filter-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
    }
    @media (min-width: 1440px) {
        .kh-filter-grid { grid-template-columns: repeat(6, minmax(0, 1fr)); }
    }
    .kh-filter-actions {
        display: flex;
        justify-content: flex-end;
        gap: 0.75rem;
        padding-top: 1rem;
        margin-top: 1rem;
        border-top: 1px solid #e5e7eb;
    }
    .kh-filter-field label.form-label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.375rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }
</style>

<div class="card">
    <form method="GET">
        <div class="kh-filter-grid">
            {{-- CATEGORY --}}
            <div class="kh-filter-field">
                <label class="form-label">{{ translate('Category') }}</label>
                <select class="singleSelect selectFilterCategory" name="categories[]" multiple="multiple">
                    @foreach (get_all_category(type: 'cat') as $category)
                        @php $categoryTranslations = parse_translation($category); @endphp
                        <option value="{{ $category->id }}"
                            @if (isset(Request()->categories)) @foreach (Request()->categories as $selectCat)
                                {{ $selectCat == $category->id ? 'selected' : '' }}
                             @endforeach @endif>
                            {{ $categoryTranslations['title'] ?? $category->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- SUB CATEGORY --}}
            <div class="kh-filter-field">
                <label class="form-label">{{ translate('Sub Category') }}</label>
                <select class="singleSelect selectFilterCategory" name="subcategories[]" multiple="multiple">
                    @foreach (get_all_category(type: 'sub') as $subcategory)
                        @php $subCategoryTranslations = parse_translation($subcategory); @endphp
                        <option value="{{ $subcategory->id }}"
                            @if (isset(Request()->subcategories)) @foreach (Request()->subcategories as $selectCat)
                                {{ $selectCat == $subcategory->id ? 'selected' : '' }}
                             @endforeach @endif>
                            {{ $subCategoryTranslations['title'] ?? $subcategory->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- STATUS --}}
            <div class="kh-filter-field">
                <label class="form-label">{{ translate('Status') }}</label>
                <select class="singleSelect" name="course_status">
                    <option selected disabled>{{ translate('Select Status') }}</option>
                    <option value="all" {{ $courseStatus == 'all' ? 'selected' : '' }}>{{ translate('All') }}</option>
                    <option value="Approved" {{ $courseStatus == 'Approved' ? 'selected' : '' }}>{{ translate('Approved') }}</option>
                    <option value="Rejected" {{ $courseStatus == 'Rejected' ? 'selected' : '' }}>{{ translate('Rejected') }}</option>
                    <option value="Pending" {{ $courseStatus == 'Pending' ? 'selected' : '' }}>{{ translate('Pending') }}</option>
                </select>
            </div>

            {{-- COURSE TYPE --}}
            <div class="kh-filter-field">
                <label class="form-label">{{ translate('Course Type') }}</label>
                <select class="singleSelect" name="course_type">
                    <option selected disabled>{{ translate('Select Type') }}</option>
                    <option value="all" {{ $courseType == 'all' ? 'selected' : '' }}>{{ translate('All') }}</option>
                    <option value="free" {{ $courseType == 'free' ? 'selected' : '' }}>{{ translate('Free') }}</option>
                    <option value="paid" {{ $courseType == 'paid' ? 'selected' : '' }}>{{ translate('Paid') }}</option>
                </select>
            </div>

            {{-- ORGANIZATION --}}
            @if (!$isOrganization && !$isInstructor)
                <div class="kh-filter-field">
                    <label class="form-label">{{ translate('Organization') }}</label>
                    <select class="singleSelect organization-list" name="organizations">
                        <option disabled selected>{{ translate('Select Organization') }}</option>
                        @foreach (get_all_organization() as $organization)
                            @php $orgTranslations = parse_translation($organization?->userable); @endphp
                            <option value="{{ $organization->id }}"
                                {{ $organizations == $organization->id ? 'selected' : '' }}>
                                {{ $orgTranslations['name'] ?? $organization?->userable?->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            {{-- INSTRUCTOR --}}
            @if (!$isInstructor)
                <div class="kh-filter-field">
                    <label class="form-label">{{ translate('Instructor') }}</label>
                    <select class="instructor-list selectFilterInstructor" id="instructorOption" multiple="true"
                        name="instructors[]">
                        @foreach (get_all_instructor($user->id ?? null) as $instructor)
                            @php
                                $insUser = $instructor?->userable;
                                $instructorTranslations = parse_translation($insUser);
                            @endphp
                            <option value="{{ $instructor->id }}"
                                @if ($searchInstructors) @foreach ($searchInstructors as $searchInstructor)
                                    {{ $searchInstructor == $instructor->id ? 'selected' : '' }}
                                @endforeach @endif>
                                {{ $instructorTranslations['first_name'] ?? $insUser?->first_name }}
                                {{ $instructorTranslations['last_name'] ?? $insUser?->last_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif
        </div>

        {{-- BUTTONS --}}
        <div class="kh-filter-actions">
            <a href="{{ Request()->url() }}" class="btn b-outline btn-primary-outline dk-theme-card-square">
                <i class="ri-refresh-line"></i> {{ translate('Clear') }}
            </a>
            <button type="submit" class="btn b-solid btn-primary-solid dk-theme-card-square">
                <i class="ri-filter-3-line"></i> {{ translate('Apply Filter') }}
            </button>
        </div>
    </form>
</div>
