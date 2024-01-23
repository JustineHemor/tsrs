<div>
    <table class="min-w-full divide-y divide-gray-300">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Type</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Requested At</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Requested By</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Coverage</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white">
            @forelse($reports as $report)
                <tr>
                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ $report->type }}</td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $report->created_at->format('F d, Y h:i A') }}</td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $report->requester->name }}</td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $report->coverage }}</td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                        @if($report->status == \Domain\Reports\Enums\States::DONE)
                            <x-primary-button type="button" wire:click="download({{ $report }})">Download</x-primary-button>
                        @else
                            {{ $report->status->name }}
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 text-center" colspan="6">No trip ticket.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    @if($reports->lastPage() > 1)
        <div class="p-2 border bg-gray-200 rounded-md">
            {{ $reports->links() }}
        </div>
    @endif
</div>
