<?php

namespace App\Livewire\Forms\SupplyRequest;

use Domain\Supplies\Models\SupplyRequest;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ShowForm extends Form
{
    #[Validate([
        'supplyRequestItems.*.name' => 'required',
        'supplyRequestItems.*.quantity' => 'required',
        'supplyRequestItems.*.purpose' => 'required',
    ], message: [
        'supplyRequestItems.*.name.required' => 'The item field is required.',
        'supplyRequestItems.*.quantity.required' => 'The quantity field is required.',
        'supplyRequestItems.*.purpose.required' => 'The purpose field is required.',
    ])]
    public array $supplyRequestItems = [];

    public string $remarks = '';

    public string $note = '';

    public function setSupplyRequest(SupplyRequest $supplyRequest): void
    {
        $this->note = $supplyRequest->note ?? '';
        $this->remarks = $supplyRequest->remarks ?? '';
    }

    public function setSupplyRequestItems(SupplyRequest $supplyRequest): void
    {
        foreach ($supplyRequest->items as $item) {
            $this->supplyRequestItems[] = [
                'id' => $item->id,
                'name' => $item->name,
                'quantity' => $item->quantity,
                'purpose' => $item->purpose,
            ];
        }
    }
}
