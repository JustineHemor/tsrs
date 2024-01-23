<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View Trip Ticket') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @if($user_can_view_component)
            <livewire:trip-ticket.show :tripTicket="$tripTicket" />
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
