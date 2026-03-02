@section('title', 'Module Management Dashboard')

<x-dashboard-layout>
    <x-slot:title>{{ translate('Dashboard') }}</x-slot:title>
   @if(session()->has('module_errors'))
    <div class="card aleart aleart-danger-light alert alert-danger">
        <ul>
            @foreach(session('module_errors') as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if(!$moduleLicense || empty($moduleLicense))
    <div class="card">
        <form action="{{ route('module-manager.activate') }}" method="POST">
            @csrf
            <input type="hidden" name="module" value="{{ $module }}">
            <div>
                <label for="email" class="form-label">Email*</label>
                <input type="text" id="email" name="email" value="{{ old('email') }}" class="form-input" placeholder="Email" autocomplete="off" class="@error('email') is-invalid @enderror" required >
            </div>
            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <div>
                <label for="purchase_code" class="form-label">Purchase Code*</label>
                <input type="text" id="purchase_code" name="purchase_code" value="{{ old('purchase_code') }}" class="form-input" placeholder="Purchase Code" autocomplete="off" class="@error('purchase_code') is-invalid @enderror" required >
            </div>
            @error('purchase_code')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <button type="submit" class="btn b-outline btn-success-outline btn-sm mt-5">{{ translate('Activate') }}</button>
        </form>
    </div>
    @endif

    @if(count($moduleLicense) > 0)
    <div class="mt-5">
        <h3 class="text-lg font-semibold">{{ translate('Module License Information') }}</h3>
        <table class="table-auto border-collapse w-full whitespace-nowrap text-left text-gray-500 dark:text-dark-text font-medium">
            <thead class="text-heading dark:text-dark-text">
                <tr>
                    <th class="p-6 py-4 bg-primary-200 dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg dk-theme-card-square">{{ translate('Name') }}</th>
                    <th class="p-6 py-4 bg-primary-200 dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg dk-theme-card-square">{{ translate('Email') }}</th>
                    <th class="p-6 py-4 bg-primary-200 dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg dk-theme-card-square w-[500px] min-w-[300px]">{{ translate('Purchase Code') }}</th>
                    <th class="p-6 py-4 bg-primary-200 dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg dk-theme-card-square">{{ translate('License Type') }}</th>
                    <th class="p-6 py-4 bg-primary-200 dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg dk-theme-card-square">{{ translate('Status') }}</th>
                    <th class="p-6 py-4 bg-primary-200 dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg dk-theme-card-square w-10">{{ translate('Action') }}</th>
                </tr>
            </thead>
            <tbody>
               <tr>
                    <td class="p-6 py-4 bg-primary-50 dark:bg-dark-card-one first:rounded-l-lg last:rounded-r-lg dk-theme-card-square">{{ $module }}</td>
                    <td class="p-6 py-4 bg-primary-50 dark:bg-dark-card-one first:rounded-l-lg last:rounded-r-lg dk-theme-card-square">{{ $moduleLicense['email'] }}</td>
                    <td class="p-6 py-4 bg-primary-50 dark:bg-dark-card-one first:rounded-l-lg last:rounded-r-lg dk-theme-card-square w-[500px] min-w-[300px]">{{ $moduleLicense['purchase_code'] }}</td>
                    <td class="p-6 py-4 bg-primary-50 dark:bg-dark-card-one first:rounded-l-lg last:rounded-r-lg dk-theme-card-square">{{ $moduleLicense['license'] }}</td>
                    <td class="p-6 py-4 bg-primary-50 dark:bg-dark-card-one first:rounded-l-lg last:rounded-r-lg dk-theme-card-square">{{ $moduleLicense['status'] == 1 ? translate('Active') : translate('Inactive') }}</td>
                    <td class="p-6 py-4 bg-primary-50 dark:bg-dark-card-one first:rounded-l-lg last:rounded-r-lg dk-theme-card-square w-10">
                        <form action="{{ route('module-manager.deactivate') }}" method="POST">
                            @csrf
                            <input type="hidden" name="module" value="{{ $module }}">
                            <input type="hidden" name="purchase_code" value="{{ $moduleLicense['purchase_code'] }}">
                            <button type="submit" class="btn b-outline btn-danger-outline btn-sm">{{ translate('Deactivate') }}</button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    @endif
</x-dashboard-layout>
