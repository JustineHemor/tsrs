<?php

namespace App\Livewire\SupplyRequest;

use App\Events\SupplyRequestCreated;
use Domain\Supplies\Actions\CreateSupplyRequestAction;
use Domain\Supplies\Data\CreateSupplyRequestData;
use Domain\Supplies\Data\CreateSupplyRequestItemData;
use Domain\Supplies\Models\SupplyItem;
use Domain\Supplies\Models\SupplyRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Create extends Component
{
    public Collection $supply_items;
    public ?SupplyRequest $supplyRequest = null;

    public string $remarks = '';

    #[Validate([
        'items' => 'required',
        'items.*.name' => 'required',
        'items.*.quantity' => 'required',
        'items.*.purpose' => 'required',
        'items.*.specified_name' => 'required_if:items.*.name,Others',
    ], message: [
        'items.*.name.required' => 'Please select an item.',
        'items.*.quantity.required' => 'The quantity field is required.',
        'items.*.purpose.required' => 'The purpose field is required.',
        'items.*.specified_name.required_if' => 'Please specify the requested item.'
    ])]
    public array $items = [
        [
            'name' => '',
            'specified_name' => '',
            'quantity' => '',
            'purpose' => '',
        ],
    ];

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('livewire.supply-request.create');
    }

    public function mount(): void
    {
        $this->setSupplyItems();
    }

    public function create(CreateSupplyRequestAction $action): void
    {
        $this->validate();

        $this->supplyRequest = $action->execute(new CreateSupplyRequestData(
            requester_id: Auth::id(),
            items: CreateSupplyRequestItemData::collection($this->items),
            remarks: $this->remarks,
        ));

        SupplyRequestCreated::dispatch($this->supplyRequest);
    }

    public function viewSupplyRequest(): void
    {
        $this->redirectRoute('supply-request.show', $this->supplyRequest);
    }

    public function removeItem(int $key): void
    {
        unset($this->items[$key]);
    }

    public function addItemField(): void
    {
        $this->items[] = [
            'name' => '',
            'specified_name' => '',
            'quantity' => '',
            'purpose' => '',
        ];
    }

    private function setSupplyItems(): void
    {
        $this->supply_items = SupplyItem::query()->orderBy('name')->pluck('name', 'name');
        $this->supply_items['Others'] = 'Others';
    }
}
