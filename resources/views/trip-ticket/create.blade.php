<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Trip Ticket') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <livewire:trip-ticket.create />
    </div>
</x-app-layout>
