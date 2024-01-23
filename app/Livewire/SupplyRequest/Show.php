<?php

namespace App\Livewire\SupplyRequest;

use App\Livewire\Forms\SupplyRequest\ShowForm;
use Domain\Supplies\Actions\DenySupplyRequestAction;
use Domain\Supplies\Actions\FulFillSupplyRequestAction;
use Domain\Supplies\Actions\ApproveSupplyRequestAction;
use Domain\Supplies\Data\DenySupplyRequestData;
use Domain\Supplies\Data\FulfillSupplyRequestData;
use Domain\Supplies\Data\ApproveSupplyRequestData;
use Domain\Supplies\Data\UpdateSupplyRequestItemData;
use Domain\Supplies\Enums\Status;
use Domain\Supplies\Models\SupplyRequest;
use Domain\Supplies\StateMachines\Exceptions\InvalidStateActionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Show extends Component
{
    use LivewireAlert;

    public SupplyRequest $supplyRequest;

    public ShowForm $form;

    protected $listeners = [
        'confirmDeny',
        'confirmApprove',
        'confirmFulfill',
    ];

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('livewire.supply-request.show');
    }

    public function mount(): void
    {
        $this->form->setSupplyRequestItems($this->supplyRequest);

        $this->form->setSupplyRequest($this->supplyRequest);
    }

    public function approve(): void
    {
        $this->alert('question', 'Are you sure you want to approve this supply request?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'confirmButtonText' => 'Yes',
            'cancelButtonText' => 'No',
            'onConfirmed' => 'confirmApprove',
            'confirmButtonColor' => '#0A6640',
            'showCancelButton' => true,
            'timer' => null,
        ]);
    }

    public function confirmApprove(ApproveSupplyRequestAction $approveSupplyRequestAction): void
    {
        $this->authorize('approve-supplies-request');

        $this->validate();

        try {
            $supplyRequest = $approveSupplyRequestAction->execute(new ApproveSupplyRequestData(
                approver_id: Auth::id(),
                supplyRequest: $this->supplyRequest,
                supply_request_items: UpdateSupplyRequestItemData::collection($this->form->supplyRequestItems),
                note: $this->form->note,
            ));
        } catch (InvalidStateActionException) {
            $this->alert('warning', 'Invalid action, supply request is already '.$this->supplyRequest->status->value.'.');

            return;
        }

        $this->redirectToIndex($supplyRequest->status);
    }

    public function deny(): void
    {
        $this->alert('question', 'Are you sure you want to deny this supply request?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'confirmButtonText' => 'Yes',
            'cancelButtonText' => 'No',
            'onConfirmed' => 'confirmDeny',
            'confirmButtonColor' => '#7F1D1D',
            'showCancelButton' => true,
            'timer' => null,
        ]);
    }

    public function confirmDeny(DenySupplyRequestAction $denySupplyRequestAction): void
    {
        $this->authorize('deny-supplies-request');

        $this->validate(['form.note' => 'required']);

        try {
            $supplyRequest = $denySupplyRequestAction->execute(new DenySupplyRequestData(
                supplyRequest: $this->supplyRequest,
                denier_id: Auth::id(),
                note: $this->form->note,
            ));
        } catch (InvalidStateActionException) {
            $this->alert('warning', 'Invalid action, supply request is already '.$this->supplyRequest->status->value.'.');

            return;
        }

        $this->redirectToIndex($supplyRequest->status);
    }

    public function fulfill(): void
    {
        $this->alert('question', 'Are you sure you want to fulfill this supply request?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'confirmButtonText' => 'Yes',
            'cancelButtonText' => 'No',
            'onConfirmed' => 'confirmFulfill',
            'confirmButtonColor' => '#38a169',
            'showCancelButton' => true,
            'timer' => null,
        ]);
    }

    public function confirmFulfill(FulFillSupplyRequestAction $fillSupplyRequestAction): void
    {
        $this->authorize('fulfill-supplies-request');

        try {
            $supplyRequest = $fillSupplyRequestAction->execute(new FulfillSupplyRequestData(
                supplyRequest: $this->supplyRequest,
                fulfiller_id: Auth::id(),
            ));
        } catch (InvalidStateActionException) {
            $this->alert('warning', 'Invalid action, supply request is already '.$this->supplyRequest->status->value.'.');

            return;
        }

        $this->redirectToIndex($supplyRequest->status);
    }

    private function redirectToIndex(Status $status): void
    {
        Session::put('supply-request-updated-'.Auth::id(), 'Supply request '. $status->value);

        $this->redirectRoute('supply-request.index');
    }
}
