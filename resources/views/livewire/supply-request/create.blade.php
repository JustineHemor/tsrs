<div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
    @if(! $supplyRequest)
        <form wire:submit.prevent="create" class="space-y-5">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="bg-gray-200 bg-opacity-25 p-2 pb-6">
                    <x-label for="items" class="px-6 pt-4">Request</x-label>
                    <div class="space-y-3">
                        @foreach($items as $key => $item)
                            <div class="w-full bg-gray-50 px-4 sm:px-6">
                                <div class="flex flex-col">
                                    <div class="flex items-center space-x-2">
                                        <div class="py-2 flex flex-col w-full min-w-24">
                                            <label for="items.{{$key}}.name" class="hidden">Request Item {{ $key }}</label>
                                            <select wire:model.live="items.{{$key}}.name" id="items.{{$key}}.name" name="items.{{$key}}.name" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                                <option value="" selected>Select Item</option>
                                                @foreach($supply_items as $supply_item)
                                                    <option value="{{ $supply_item }}"> {{ $supply_item }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        @if($item['name'] == 'Others')
                                            <div class="py-2 flex flex-col w-full min-w-80">
                                                <x-input id="items.{{ $key }}.specified_name"
                                                         type="text"
                                                         placeholder="Please specify"
                                                         wire:model="items.{{ $key }}.specified_name">
                                                </x-input>
                                            </div>
                                        @endif

                                        <div class="py-2 flex flex-col max-w-24">
                                            <x-input id="items.{{ $key }}.quantity"
                                                     type="text"
                                                     placeholder="Quantity"
                                                     wire:model="items.{{ $key }}.quantity">
                                            </x-input>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <div class="py-2 flex flex-col w-full min-w-24">
                                            <label for="items.{{ $key }}.purpose" class="font-medium text-sm text-gray-700 hidden">Purpose</label>

                                            <textarea wire:model="items.{{ $key }}.purpose" name="items.{{ $key }}.remarks" id="items.{{ $key }}.purpose" placeholder="Purpose" cols="30" rows="1" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>

                                            <x-input-error for="items.{{ $key }}.purpose"/>
                                        </div>

                                        @if($key > 0)
                                            <div class="py-2 flex flex-col max-w-20">
                                                <x-button wire:click.prevent="removeItem({{ $key }})">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                                    </svg>
                                                </x-button>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <x-input-error for="items.{{$key}}.name"/>
                                        <x-input-error for="items.{{ $key }}.specified_name"/>
                                        <x-input-error for="items.{{$key}}.quantity"/>
                                        <x-input-error for="items.{{$key}}.purpose"/>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="px-6 pt-4">
                        <x-primary-button wire:click.prevent="addItemField">Add Item</x-primary-button>
                    </div>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="bg-gray-200 bg-opacity-25 p-2">
                    <div class="w-full bg-gray-50 px-4 py-4 sm:px-6">
                        <div class="py-2 flex flex-col">
                            <label for="remarks" class="block font-medium text-sm text-gray-700">Remarks</label>

                            <textarea name="remarks" id="purpose" cols="30" rows="3" wire:model="remarks" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>

                            <x-input-error for="remarks"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-xl mt-3 flex justify-end space-x-2">
                <x-primary-button>Create</x-primary-button>
            </div>
        </form>
    @else
        <div class="max-w-7xl mx-auto bg-white px-6 py-16 rounded-md">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="mt-2 font-bold tracking-tight text-green-700 text-3xl">Supply Request Created!</h2>
                <p class="mt-6 text-lg leading-8 text-gray-600">You will receive an email notification once the supply request has been approved or denied.</p>
                <x-button class="mt-6" wire:click="viewSupplyRequest">View Supply Request</x-button>
            </div>
        </div>
    @endif
</div>
