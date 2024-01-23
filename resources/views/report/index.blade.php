<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reports') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @if($user_has_permission)
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex gap-4">
                    @can('generate-report')
                        <div class="card bg-white px-2 pt-2 pb-8 flex flex-col gap-4 w-1/4 rounded-md">
                            <livewire:report.create lazy />
                        </div>
                    @endcan
                    @can('view-reports')
                        <div class="flex flex-col w-full bg-white rounded-md">
                            <livewire:report.index lazy />
                        </div>
                    @endcan
                </div>
            </div>
        @else
            <div class="max-w-7xl mx-auto bg-white px-6 py-24 sm:py-32 lg:px-8 rounded-md">
                <div class="mx-auto max-w-2xl text-center">
                    <h2 class="mt-2 text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">Access Not Authorized</h2>
                    <p class="mt-6 text-lg leading-8 text-gray-600">You don't have the necessary permissions to access this resource. Please contact your administrator.</p>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
