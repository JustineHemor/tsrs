<div class="max-w-3xl mx-auto sm:px-6 lg:px-8" x-data="{ is_logs_shown: false }">
    <div class="flex justify-between items-center">
        <div class="px-4 sm:px-0">
            <h3 class="text-xl font-semibold leading-7 text-gray-900">Ticket Number: {{ $tripTicket->id }}</h3>
            <x-status-indicator :status="$tripTicket->status"/>
        </div>
        <div>
            <x-primary-button x-on:click="is_logs_shown = ! is_logs_shown">
                <span x-text="is_logs_shown ? 'View Form' : 'View Logs'"></span>
            </x-primary-button>
        </div>
    </div>
    <div class="px-4 sm:px-0 mt-5">
        <p class="text-sm text-gray-500">Created At: {{ $tripTicket->created_at }}</p>
    </div>
    <div x-show="! is_logs_shown">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="bg-gray-200 bg-opacity-25 p-2">
                <div class="w-full bg-gray-50 px-4 py-4 sm:px-6">
                    <div class="py-2 flex flex-col">
                        <x-label for="trip_requester">Trip Requester</x-label>

                        <x-input id="trip_requester"
                                 type="text"
                                 readonly
                                 class="bg-gray-200"
                                 wire:model="form.trip_requester"
                        >
                        </x-input>
                    </div>

                    <div class="py-2 flex flex-col">
                        <x-label for="contact_person">Contact Person</x-label>

                        <x-input id="contact_person"
                                 type="text"
                                 readonly
                                 class="bg-gray-200"
                                 wire:model="form.contact_person"
                        >
                        </x-input>
                    </div>

                    <div class="py-2 flex flex-col">
                        <x-label for="mobile_number">Mobile Number</x-label>

                        <x-input id="mobile_number"
                                 type="text"
                                 readonly
                                 class="bg-gray-200"
                                 wire:model="form.mobile_number"
                        >
                        </x-input>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-5">
            <div class="bg-gray-200 bg-opacity-25 p-2">
                <div class="w-full bg-gray-50 px-4 py-4 sm:px-6">
                    <div class="flex items-start space-x-2">
                        <div class="py-2 flex flex-col w-full">
                            <x-label for="origin_location">Departure (Origin)</x-label>

                            <div class="border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm bg-gray-200 p-2 space-y-2">
                                <p>{{ $form->origin_location }}</p>
                                <p class="text-sm">{{ $form->origin_datetime }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-start space-x-2">
                        <div class="py-2 flex flex-col w-full">
                            <x-label for="drop_off_location">Destination (Drop Off)</x-label>

                            <div class="border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm bg-gray-200 p-2 space-y-2">
                                <p>{{ $form->drop_off_location }}</p>
                                <p class="text-sm">{{ $form->drop_off_datetime }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-start space-x-2">
                        <div class="py-2 flex flex-col w-full">
                            <x-label for="pick_up_location">Pick Up</x-label>

                            <div class="border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm bg-gray-200 p-2 space-y-2">
                                <p>{{ $form->pick_up_location }}</p>
                                @if(filled($form->pick_up_datetime))
                                    <p class="text-sm">{{ $form->pick_up_datetime }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-5">
            <div class="bg-gray-200 bg-opacity-25 p-2">
                <div class="w-full bg-gray-50 px-4 py-4 sm:px-6">
                    <div class="py-2 flex flex-col">
                        <x-label for="passenger_count">Passenger Count</x-label>

                        <x-input id="passenger_count"
                                 type="number"
                                 readonly
                                 class="bg-gray-200"
                                 wire:model.live="form.passenger_count">
                        </x-input>
                    </div>

                    <div class="py-2 flex flex-col">
                        <label for="vehicle_id" class="block font-medium text-sm text-gray-700">Vehicle</label>

                        @can('approve-trip-ticket')
                            <select id="vehicle_id" name="vehicle_id" wire:model.live.debounce.250ms="form.vehicle_id"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Any Vehicle</option>
                                @foreach($vehicles as $vehicle)
                                    @if($vehicle == $tripTicket->vehicle)
                                        <option value="{{ $vehicle->id }}" selected>{{ $vehicle->name }}
                                            - {{ $vehicle->additional_details }}</option>
                                    @else
                                        <option value="{{ $vehicle->id }}">{{ $vehicle->name }}
                                            - {{ $vehicle->additional_details }}</option>
                                    @endif
                                @endforeach
                            </select>
                        @else
                            <x-input id="vehicle_name"
                                     type="text"
                                     readonly
                                     class="bg-gray-200"
                                     value="{{ $tripTicket->vehicle_id ? $tripTicket->vehicle->name . ' - ' . $tripTicket->vehicle->additional_details : 'Any Vehicle' }}">
                            </x-input>
                        @endcan

                        <x-input-error for="form.vehicle_id"/>
                    </div>

                    <div class="py-2 flex flex-col">
                        <label for="driver_id" class="block font-medium text-sm text-gray-700">Driver</label>

                        @can('approve-trip-ticket')
                            <select id="driver_id" name="driver_id" wire:model.live.debounce.250ms="form.driver_id"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Any Driver</option>
                                @foreach($drivers as $driver)
                                    @if($driver == $tripTicket->driver)
                                        <option value="{{ $driver->id }}" selected>{{ $driver->name }}
                                            ({{ $driver->nickname }})
                                        </option>
                                    @else
                                        <option value="{{ $driver->id }}">{{ $driver->name }} ({{ $driver->nickname }}
                                            )
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        @else
                            <x-input id="driver_name"
                                     type="text"
                                     readonly
                                     class="bg-gray-200"
                                     value="{{ $tripTicket->driver_id ? $tripTicket->driver->name . '(' . $tripTicket->driver->nickname . ')' : 'Any Driver' }}">
                            </x-input>
                        @endcan

                        <x-input-error for="form.driver_id"/>
                    </div>

                    <div class="py-2 flex flex-col">
                        <label for="purpose" class="block font-medium text-sm text-gray-700">Trip Purpose</label>

                        <textarea readonly name="purpose" id="purpose" cols="30" rows="3" wire:model="form.purpose"
                                  class="border-gray-300 bg-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>

                        <x-input-error for="form.purpose"/>
                    </div>

                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-5">
            <div class="bg-gray-200 bg-opacity-25 p-2">
                <div class="w-full bg-gray-50 px-4 py-4 sm:px-6">
                    <div class="py-2 flex flex-col">
                        <label for="remarks" class="block font-medium text-sm text-gray-700">Remarks</label>

                        <textarea name="remarks" id="remarks" cols="30" rows="3" wire:model="form.remarks"
                                  @cannot('approve-trip-ticket')
                                      readonly
                                  @endcannot
                                  class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm
                          @cannot('approve-trip-ticket')
                            bg-gray-200
                          @endcannot
                          "></textarea>

                        <x-input-error for="form.remarks"/>
                    </div>

                </div>
            </div>
        </div>
        <div class="overflow-hidden sm:rounded-lg mt-3 flex justify-between items-center p-1">
            @can('deny-trip-ticket')
                <x-deny-button wire:click="deny">Deny</x-deny-button>
            @endcan
            @if($tripTicket->requester_id == auth()->id())
                <x-button wire:click="cancel">Cancel</x-button>
            @endif
            @can('approve-trip-ticket')
                <x-approve-button wire:click="approve">Approve</x-approve-button>
            @endcan
        </div>
    </div>
    <div class="space-y-5" x-show="is_logs_shown">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="bg-gray-200 bg-opacity-25 p-2">
                <div class="w-full bg-gray-50 px-4 py-4 sm:px-6">
                    <div class="py-2 flex flex-col">
                        @if($tripTicket->status == \Domain\TripTickets\Enums\Status::PENDING)
                            <p class="text-gray-900 text-center">There is no recorded logs as the trip ticket is still
                                awaiting approval.</p>
                        @endif
                        <ul role="list" class="divide-y divide-gray-100">
                            @if($tripTicket->approved_at)
                                <li class="py-4">
                                    <div class="flex items-center gap-x-3">
                                        <h3 class="flex-auto truncate text-sm font-semibold leading-6 text-gray-900">
                                            <x-status-indicator :status="\Domain\TripTickets\Enums\Status::APPROVED"/>
                                        </h3>
                                        <time datetime="2023-01-23T11:00"
                                              class="flex-none text-xs text-gray-500">{{ $tripTicket->approved_at->diffForHumans() }}</time>
                                    </div>
                                    <p class="mt-3 truncate text-sm text-gray-500">{{ $tripTicket->approved_at->format('F j, Y h:i A') }}</p>
                                    <p class="mt-3 truncate text-sm text-gray-500">
                                        By: {{ $tripTicket->approver->name }}</p>
                                </li>
                            @endif
                            @if($tripTicket->denied_at)
                                <li class="py-4">
                                    <div class="flex items-center gap-x-3">
                                        <h3 class="flex-auto truncate text-sm font-semibold leading-6 text-gray-900">
                                            <x-status-indicator :status="\Domain\TripTickets\Enums\Status::DENIED"/>
                                        </h3>
                                        <time datetime="2023-01-23T11:00"
                                              class="flex-none text-xs text-gray-500">{{ $tripTicket->denied_at->diffForHumans() }}</time>
                                    </div>
                                    <p class="mt-3 truncate text-sm text-gray-500">{{ $tripTicket->denied_at->format('F j, Y h:i A') }}</p>
                                    <p class="mt-3 truncate text-sm text-gray-500">
                                        By: {{ $tripTicket->denier->name }}</p>
                                </li>
                            @endif
                            @if($tripTicket->cancelled_at)
                                <li class="py-4">
                                    <div class="flex items-center gap-x-3">
                                        <h3 class="flex-auto truncate text-sm font-semibold leading-6 text-gray-900">
                                            <x-status-indicator :status="\Domain\TripTickets\Enums\Status::CANCELLED"/>
                                        </h3>
                                        <time datetime="2023-01-23T11:00"
                                              class="flex-none text-xs text-gray-500">{{ $tripTicket->cancelled_at->diffForHumans() }}</time>
                                    </div>
                                    <p class="mt-3 truncate text-sm text-gray-500">{{ $tripTicket->cancelled_at->format('F j, Y h:i A') }}</p>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
