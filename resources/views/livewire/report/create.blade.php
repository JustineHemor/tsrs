<div class="flex flex-col gap-4">
    <div>
        <x-label for="from_date">From</x-label>

        <x-input id="from_date"
                 type="date"
                 class="w-full"
                 wire:model="form.from_date">
        </x-input>

        <x-input-error for="form.from_date"/>
    </div>
    <div>
        <x-label for="from_time" class="hidden">From Time</x-label>

        <x-input id="from_time"
                 type="time"
                 class="w-full"
                 wire:model="form.from_time">
        </x-input>

        <x-input-error for="form.from_time"/>
    </div>
    <div>
        <x-label for="to_date">To</x-label>

        <x-input id="to_date"
                 type="date"
                 class="w-full"
                 wire:model="form.to_date">
        </x-input>

        <x-input-error for="form.to_date"/>
    </div>
    <div>
        <x-label for="to_time" class="hidden">To Time</x-label>

        <x-input id="to_time"
                 type="time"
                 class="w-full"
                 wire:model="form.to_time">
        </x-input>

        <x-input-error for="form.to_time"/>
    </div>

    <div>
        <label for="type" class="block font-medium text-sm text-gray-700">Type</label>

        <select id="type" name="type" wire:model="form.type"
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
            <option value="" selected>- Select Report -</option>
            @foreach(\Domain\Reports\Models\Report::GET_REPORTS()->sort() as $report)
                <option value="{{ $report }}">{{ $report }}</option>
            @endforeach
        </select>

        <x-input-error for="form.type"/>
    </div>
    <div>
        <x-primary-button
            wire:loading.attr="disabled"
            wire:target="submit"
            wire:click="submit"
            wire:loading.class="opacity-50"
            class="w-full"
        >Generate Report
        </x-primary-button>
    </div>

</div>
