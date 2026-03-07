<x-dashboard-layout>
    <x-slot:title>{{ translate('Student Progress & Performance') }}</x-slot:title>
    <x-portal::admin.breadcrumb title="Student Progress & Performance" page-to="Enrollments" back-url="{{ route('enrollment.index') }}" />

    @if ($enrollments->count() > 0)
        <div class="card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="table-auto w-full whitespace-nowrap text-left text-gray-500 dark:text-dark-text font-medium leading-none">
                    <thead class="text-primary-500">
                        <tr>
                            <th class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Student') }}
                            </th>
                            <th class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Email') }}
                            </th>
                            <th class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Course / Bundle') }}
                            </th>
                            <th class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Progress') }}
                            </th>
                            <th class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Enrolled') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-dark-border-three">
                        @foreach ($enrollments as $enrollment)
                            @php
                                $userInfo = $enrollment?->user?->userable ?? null;
                                $studentTranslations = parse_translation($userInfo);
                                $courseTitle = null;
                                if ($enrollment->purchase_type == 'course' && $enrollment->course) {
                                    $courseTranslations = parse_translation($enrollment->course);
                                    $courseTitle = $courseTranslations['title'] ?? $enrollment->course?->title;
                                } elseif ($enrollment->purchase_type == 'bundle' && $enrollment->courseBundle) {
                                    $bundleTranslations = parse_translation($enrollment->courseBundle);
                                    $courseTitle = $bundleTranslations['title'] ?? $enrollment->courseBundle?->title;
                                }
                            @endphp
                            <tr>
                                <td class="px-2 py-4 text-heading dark:text-white font-semibold">
                                    {{ $studentTranslations['first_name'] ?? $userInfo?->first_name }}
                                    {{ $studentTranslations['last_name'] ?? $userInfo?->last_name }}
                                </td>
                                <td class="px-2 py-4">{{ $enrollment?->user?->email }}</td>
                                <td class="px-2 py-4">{{ $courseTitle ? str_limit($courseTitle, 40) : '—' }}</td>
                                <td class="px-2 py-4">
                                    @if ($enrollment->status === 'completed')
                                        <span class="badge b-solid badge-success-solid capitalize">{{ translate('Completed') }}</span>
                                    @else
                                        <span class="badge b-solid badge-warning-solid capitalize">{{ translate('In progress') }}</span>
                                    @endif
                                </td>
                                <td class="px-2 py-4">{{ customDateFormate($enrollment->created_at, 'd M Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $enrollments->links('portal::admin.pagination.paginate') }}
        </div>
    @else
        <x-portal::admin.empty-card title="{{ translate('No enrollments yet') }}" />
    @endif
</x-dashboard-layout>
