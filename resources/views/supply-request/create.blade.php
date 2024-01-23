<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Supply Request') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <livewire:supply-request.create />
    </div>
</x-app-layout>
