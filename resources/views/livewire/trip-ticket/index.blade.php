<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-end items-end">
            <div class="sm:flex-auto flex space-x-2">
                <div>
                    <h1 class="text-base leading-6 text-gray-900"><label for="trip_ticket_id">Trip Ticket ID: </label>
                    </h1>
                    <x-input id="trip_ticket_id"
                             type="number"
                             wire:model.live.debounce.250ms="trip_ticket_id"
                    >
                    </x-input>
                </div>
                @can('view-all-trip-ticket')
                    <div>
                        <h1 class="text-base leading-6 text-gray-900"><label for="requester_id">Requester: </label></h1>
                        <select id="requester_id" name="requester_id" wire:model.live.debounce.250ms="requester_id"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">- Select -</option>
                            @foreach($requesters as $requester)
                                <option value="{{ $requester->id }}">{{ $requester->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endcan
                <div>
                    <h1 class="text-base leading-6 text-gray-900"><label for="status">Status: </label></h1>
                    <select id="status" name="status" wire:model.live.debounce.250ms="status"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">- Select -</option>
                        @foreach(\Domain\TripTickets\Enums\Status::cases() as $case)
                            <option value="{{ $case->value }}">{{ $case->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{--            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">--}}
            {{--                <button type="button" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Add user</button>--}}
            {{--            </div>--}}
        </div>
        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">ID
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Requester
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Status
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Contact Person
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Passenger Count
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Purpose
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Created At
                                </th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse($tripTickets as $tripTicket)
                                <tr>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                        <a wire:navigate href="{{ route('trip-ticket.show', $tripTicket) }}"
                                           class="text-indigo-600 hover:text-indigo-900">{{ $tripTicket->id }}</a>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $tripTicket->requester->name }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        <x-status-indicator :status="$tripTicket->status"/>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $tripTicket->contact_person }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $tripTicket->passenger_count }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $tripTicket->purpose }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $tripTicket->created_at->format('F j, Y h:i A') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 text-center"
                                        colspan="7">No trip ticket.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        <div class="bg-white p-4 border-t-2">
                            {{ $tripTickets->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
