<div class="max-w-3xl mx-auto sm:px-6 lg:px-8" x-data="{ is_logs_shown: false }">
    <div class="flex justify-between items-center">
        <div class="px-4 sm:px-0">
            <h3 class="text-xl font-semibold leading-7 text-gray-900">Supply Request
                Number: {{ $supplyRequest->id }}</h3>
            <x-supply-request-status-indicator :status="$supplyRequest->status"/>
        </div>
        <div>
            <x-primary-button x-on:click="is_logs_shown = ! is_logs_shown">
                <span x-text="is_logs_shown ? 'View Form' : 'View Logs'"></span>
            </x-primary-button>
        </div>
    </div>
    <div class="px-4 sm:px-0 mt-5">
        <p class="text-sm text-gray-500">Created At: {{ $supplyRequest->created_at->format('F j, Y h:i A') }}</p>
    </div>
    <div class="space-y-5" x-show="! is_logs_shown">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="bg-gray-200 bg-opacity-25 p-2">
                <div class="w-full bg-gray-50 px-4 py-4 sm:px-6">
                    <div class="py-2 flex flex-col">
                        <x-label for="items" class="mb-2">Requester Name</x-label>

                        <x-input id="requester"
                                 type="text"
                                 readonly
                                 class="bg-gray-200"
                                 value="{{ $supplyRequest->requester->name }}"
                        >
                        </x-input>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="bg-gray-200 bg-opacity-25 p-2 pb-6">
                <x-label for="items" class="px-6 pt-4">Request</x-label>
                <div class="space-y-3">
                    @foreach($form->supplyRequestItems as $key => $supplyRequestItem)
                        <div class="w-full bg-gray-50 px-4 sm:px-6">
                            <div class="flex flex-col">
                                <div class="flex items-center space-x-2">
                                    <div class="py-2 flex flex-col w-full min-w-24">
                                        @can('approve-supplies-request')
                                            <x-input id="form.supplyRequestItems.{{ $key }}.name"
                                                     type="text"
                                                     placeholder="Item"
                                                     wire:model="form.supplyRequestItems.{{ $key }}.name">
                                            </x-input>
                                        @else
                                            <x-input id="form.supplyRequestItems.{{ $key }}.name"
                                                     type="text"
                                                     placeholder="Item"
                                                     readonly
                                                     class="bg-gray-200"
                                                     wire:model="form.supplyRequestItems.{{ $key }}.name">
                                            </x-input>
                                        @endcan
                                    </div>

                                    <div class="py-2 flex flex-col max-w-24">
                                        @can('approve-supplies-request')
                                            <x-input id="form.supplyRequestItems.{{ $key }}.name"
                                                     type="text"
                                                     placeholder="Quantity"
                                                     wire:model="form.supplyRequestItems.{{ $key }}.quantity">
                                            </x-input>
                                        @else
                                            <x-input id="form.supplyRequestItems.{{ $key }}.name"
                                                     type="text"
                                                     placeholder="Quantity"
                                                     readonly
                                                     class="bg-gray-200"
                                                     wire:model="form.supplyRequestItems.{{ $key }}.quantity">
                                            </x-input>
                                        @endcan
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <div class="py-2 flex flex-col w-full min-w-24">
                                        <label for="form.supplyRequestItems.{{ $key }}.purpose"
                                               class="font-medium text-sm text-gray-700 hidden">Purpose</label>

                                        <textarea wire:model="form.supplyRequestItems.{{ $key }}.purpose"
                                                  name="form.supplyRequestItems.{{ $key }}.purpose"
                                                  id="form.supplyRequestItems.{{ $key }}.purpose"
                                                  placeholder="Purpose" cols="30" rows="1"
                                                  @cannot('approve-supplies-request') readonly @endcannot
                                                  class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm @cannot('approve-supplies-request') bg-gray-200 @endcannot"></textarea>
                                    </div>
                                </div>
                                <div>
                                    <x-input-error for="form.supplyRequestItems.{{ $key }}.name"/>
                                    <x-input-error for="form.supplyRequestItems.{{ $key }}.quantity"/>
                                    <x-input-error for="form.supplyRequestItems.{{ $key }}.purpose"/>
                                </div>
                                <div class="mt-4 mb-3">
                                    <div class="w-full border-t border-gray-300"></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="bg-gray-200 bg-opacity-25 p-2">
                <div class="w-full bg-gray-50 px-4 py-4 sm:px-6">
                    <div class="py-2 flex flex-col">
                        <label for="remarks" class="block font-medium text-sm text-gray-700 mb-2">Remarks</label>

                        <textarea name="remarks" id="remarks" cols="30" rows="3" wire:model="form.remarks" readonly
                                  class="bg-gray-200 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>

                        <x-input-error for="form.remarks"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="bg-gray-200 bg-opacity-25 p-2">
                <div class="w-full bg-gray-50 px-4 py-4 sm:px-6">
                    <div class="py-2 flex flex-col">
                        <label for="note" class="block font-medium text-sm text-gray-700 mb-2">Note</label>

                        <textarea name="note" id="note" cols="30" rows="3" wire:model="form.note"
                                  @cannot('approve-supplies-request') readonly
                                  @endcannot class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm  @cannot('approve-supplies-request') bg-gray-200 @endcannot"></textarea>

                        <x-input-error for="form.note"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="overflow-hidden sm:rounded-lg mt-3 flex justify-between items-center p-1">
            @can('deny-supplies-request')
                <x-deny-button wire:click="deny">Deny</x-deny-button>
            @endcan
            @can('approve-supplies-request')
                <x-approve-button wire:click="approve">Approve</x-approve-button>
            @endcan
            @can('fulfill-supplies-request')
                <x-fulfill-button wire:click="fulfill">Fulfill</x-fulfill-button>
            @endcan
        </div>
    </div>
    <div class="space-y-5" x-show="is_logs_shown">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="bg-gray-200 bg-opacity-25 p-2">
                <div class="w-full bg-gray-50 px-4 py-4 sm:px-6">
                    <div class="py-2 flex flex-col">
                        @if($supplyRequest->status == \Domain\Supplies\Enums\Status::PENDING)
                            <p class="text-gray-900 text-center">There is no recorded logs as the supply request is
                                still awaiting approval.</p>
                        @endif
                        <ul role="list" class="divide-y divide-gray-100">
                            @if($supplyRequest->approved_at)
                                <li class="py-4">
                                    <div class="flex items-center gap-x-3">
                                        <h3 class="flex-auto truncate text-sm font-semibold leading-6 text-gray-900">
                                            <x-supply-request-status-indicator
                                                :status="\Domain\Supplies\Enums\Status::APPROVED"/>
                                        </h3>
                                        <time datetime="2023-01-23T11:00"
                                              class="flex-none text-xs text-gray-500">{{ $supplyRequest->approved_at->diffForHumans() }}</time>
                                    </div>
                                    <p class="mt-3 truncate text-sm text-gray-500">{{ $supplyRequest->approved_at->format('F j, Y h:i A') }}</p>
                                    <p class="mt-3 truncate text-sm text-gray-500">
                                        By: {{ $supplyRequest->approver->name }}</p>
                                </li>
                            @endif
                            @if($supplyRequest->denied_at)
                                <li class="py-4">
                                    <div class="flex items-center gap-x-3">
                                        <h3 class="flex-auto truncate text-sm font-semibold leading-6 text-gray-900">
                                            <x-supply-request-status-indicator
                                                :status="\Domain\Supplies\Enums\Status::DENIED"/>
                                        </h3>
                                        <time datetime="2023-01-23T11:00"
                                              class="flex-none text-xs text-gray-500">{{ $supplyRequest->denied_at->diffForHumans() }}</time>
                                    </div>
                                    <p class="mt-3 truncate text-sm text-gray-500">{{ $supplyRequest->denied_at->format('F j, Y h:i A') }}</p>
                                    <p class="mt-3 truncate text-sm text-gray-500">
                                        By: {{ $supplyRequest->denier->name }}</p>
                                </li>
                            @endif
                            @if($supplyRequest->fulfilled_at)
                                <li class="py-4">
                                    <div class="flex items-center gap-x-3">
                                        <h3 class="flex-auto truncate text-sm font-semibold leading-6 text-gray-900">
                                            <x-supply-request-status-indicator
                                                :status="\Domain\Supplies\Enums\Status::FULFILLED"/>
                                        </h3>
                                        <time datetime="2023-01-23T11:00"
                                              class="flex-none text-xs text-gray-500">{{ $supplyRequest->fulfilled_at->diffForHumans() }}</time>
                                    </div>
                                    <p class="mt-3 truncate text-sm text-gray-500">{{ $supplyRequest->fulfilled_at->format('F j, Y h:i A') }}</p>
                                    <p class="mt-3 truncate text-sm text-gray-500">
                                        By: {{ $supplyRequest->fulfiller->name }}</p>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
