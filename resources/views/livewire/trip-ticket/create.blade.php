<div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
    @if(! $is_trip_ticket_created)
        <form wire:submit.prevent="create">
            <div>
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="bg-gray-200 bg-opacity-25 p-2">
                        <div class="w-full bg-gray-50 px-4 py-4 sm:px-6">
                            <div class="py-2 flex flex-col">
                                <x-label for="name">Contact Person</x-label>

                                <x-input id="name"
                                         type="text"
                                         wire:model.live="form.name">
                                </x-input>

                                <x-input-error for="form.name"/>
                            </div>

                            <div class="py-2 flex flex-col">
                                <x-label for="mobile_number">Mobile Number</x-label>

                                <x-input id="mobile_number"
                                         type="text"
                                         wire:model.live="form.mobile_number">
                                </x-input>

                                <x-input-error for="form.mobile_number"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-5">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="bg-gray-200 bg-opacity-25 p-2">
                        <div class="w-full bg-gray-50 px-4 py-4 sm:px-6">
                            <div class="flex items-center space-x-2">
                                <div class="py-2 flex flex-col w-full">
                                    <x-label for="origin_location">Departure Location (Origin)</x-label>

                                    <x-input id="origin_location"
                                             type="text"
                                             wire:model.live="form.origin_location">
                                    </x-input>

                                    <x-input-error for="form.origin_location"/>
                                </div>

                                <div class="py-2 flex flex-col">
                                    <x-label for="origin_date">Date</x-label>

                                    <x-input id="origin_date"
                                             type="date"
                                             wire:model.live="form.origin_date">
                                    </x-input>

                                    <x-input-error for="form.origin_date"/>
                                </div>

                                <div class="py-2 flex flex-col">
                                    <x-label for="origin_time">Time</x-label>

                                    <x-input id="origin_time"
                                             type="time"
                                             wire:model.live="form.origin_time">
                                    </x-input>

                                    <x-input-error for="form.origin_time"/>
                                </div>
                            </div>

                            <div class="flex items-center space-x-2">
                                <div class="py-2 flex flex-col w-full">
                                    <x-label for="drop_off_location">Destination (Drop Off)</x-label>

                                    <x-input id="drop_off_location"
                                             type="text"
                                             wire:model.live.debounce.250ms="form.drop_off_location">
                                    </x-input>

                                    <x-input-error for="form.drop_off_location"/>
                                </div>

                                <div class="py-2 flex flex-col">
                                    <x-label for="drop_off_date">Date</x-label>

                                    <x-input id="drop_off_date"
                                             type="date"
                                             wire:model.live="form.drop_off_date">
                                    </x-input>

                                    <x-input-error for="form.drop_off_date"/>
                                </div>

                                <div class="py-2 flex flex-col">
                                    <x-label for="drop_off_time">Time</x-label>

                                    <x-input id="drop_off_time"
                                             type="time"
                                             wire:model.live="form.drop_off_time">
                                    </x-input>

                                    <x-input-error for="form.drop_off_time"/>
                                </div>
                            </div>

                            <div class="block my-2">
                                <label for="is_pick_up_field_included" class="flex items-center">
                                    <x-checkbox id="is_pick_up_field_included" name="is_pick_up_field_included" wire:model.live="is_pick_up_field_included"/>
                                    <span class="ms-2 text-sm text-gray-700">Include Pick Up</span>
                                </label>
                            </div>

                            @if($is_pick_up_field_included)
                                <div class="flex items-center space-x-2">
                                    <div class="py-2 flex flex-col w-full">
                                        <x-label for="pick_up_location">Pick Up Location</x-label>

                                        <x-input id="pick_up_location"
                                                 type="text"
                                                 wire:model.live="form.pick_up_location">
                                        </x-input>

                                        <x-input-error for="form.pick_up_location"/>
                                    </div>

                                    <div class="py-2 flex flex-col">
                                        <x-label for="pick_up_date">Date</x-label>

                                        <x-input id="pick_up_date"
                                                 type="date"
                                                 wire:model.live="form.pick_up_date">
                                        </x-input>

                                        <x-input-error for="form.pick_up_date"/>
                                    </div>

                                    <div class="py-2 flex flex-col">
                                        <x-label for="pick_up_time">Time</x-label>

                                        <x-input id="pick_up_time"
                                                 type="time"
                                                 wire:model.live="form.pick_up_time">
                                        </x-input>

                                        <x-input-error for="form.pick_up_time"/>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-5">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="bg-gray-200 bg-opacity-25 p-2">
                        <div class="w-full bg-gray-50 px-4 py-4 sm:px-6">
                            <div class="py-2 flex flex-col">
                                <x-label for="passenger_count">Passenger Count</x-label>

                                <x-input id="passenger_count"
                                         type="number"
                                         wire:model.live="form.passenger_count">
                                </x-input>

                                <x-input-error for="form.passenger_count"/>
                            </div>

                            <div class="py-2 flex flex-col">
                                <label for="vehicle_id" class="block font-medium text-sm text-gray-700">Vehicle</label>

                                <select id="vehicle_id" name="vehicle_id" wire:model="form.vehicle_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="" selected>Any Vehicle</option>
                                    @foreach($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}">{{ $vehicle->name }} - {{ $vehicle->additional_details }}</option>
                                    @endforeach
                                </select>

                                <x-input-error for="form.vehicle_id"/>
                            </div>

                            <div class="py-2 flex flex-col">
                                <label for="driver_id" class="block font-medium text-sm text-gray-700">Driver</label>

                                <select id="driver_id" name="driver_id" wire:model="form.driver_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="" selected>Any Driver</option>
                                    @foreach($drivers as $driver)
                                        <option value="{{ $driver->id }}">{{ $driver->name }} ({{ $driver->nickname }})</option>
                                    @endforeach
                                </select>

                                <x-input-error for="form.driver_id"/>
                            </div>

                            <div class="py-2 flex flex-col">
                                <label for="purpose" class="block font-medium text-sm text-gray-700">Trip Purpose</label>

                                <textarea name="purpose" id="purpose" cols="30" rows="3" wire:model="form.purpose" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>

                                <x-input-error for="form.purpose"/>
                            </div>

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
                <h2 class="mt-2 font-bold tracking-tight text-green-700 text-3xl">Trip Ticket Created!</h2>
                <p class="mt-6 text-lg leading-8 text-gray-600">You will receive an email notification once the trip ticket has been approved or denied.</p>
                <x-button class="mt-6" wire:click="viewTripTicket">View Trip Ticket</x-button>
            </div>
        </div>
    @endif
</div>
