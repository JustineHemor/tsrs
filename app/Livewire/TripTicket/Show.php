<?php

namespace App\Livewire\TripTicket;

use App\Livewire\Forms\TripTicket\ShowForm;
use Domain\TripTickets\Actions\ApproveTripTicketAction;
use Domain\TripTickets\Actions\CancelTripTicketAction;
use Domain\TripTickets\Actions\DenyTripTicketAction;
use Domain\TripTickets\Data\ApproveTripTicketData;
use Domain\TripTickets\Data\CancelTripTicketData;
use Domain\TripTickets\Data\DenyTripTicketData;
use Domain\TripTickets\Enums\Status;
use Domain\TripTickets\Exceptions\UserCannotCancelTripTicketException;
use Domain\TripTickets\Models\Driver;
use Domain\TripTickets\Models\TripTicket;
use Domain\TripTickets\Models\Vehicle;
use Domain\TripTickets\StateMachines\Exceptions\InvalidStateActionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application as ApplicationAlias;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Show extends Component
{
    use LivewireAlert;

    public Collection $vehicles;

    public Collection $drivers;

    public TripTicket $tripTicket;

    public string $status_color = '';

    public ShowForm $form;

    public Status $status;

    protected $listeners = [
        'confirmDeny',
        'confirmApprove',
        'confirmCancel',
    ];

    public function render(): View|ApplicationAlias|Factory|Application
    {
        return view('livewire.trip-ticket.show');
    }

    public function mount(): void
    {
        $this->vehicles = Vehicle::query()->get();

        $this->drivers = Driver::query()->get();

        $this->status = $this->tripTicket->status;

        $this->form->populateFields($this->tripTicket);
    }

    public function approve(): void
    {
        $this->alert('question', 'Are you sure you want to approve this ticket?', [
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

    public function confirmApprove(ApproveTripTicketAction $approveTripTicketAction): void
    {
        try {
            $this->tripTicket = $approveTripTicketAction->execute(new ApproveTripTicketData(
                trip_ticket_id: $this->tripTicket->id,
                approver_id: Auth::id(),
                vehicle_id: $this->form->vehicle_id,
                driver_id: $this->form->driver_id,
                remarks: $this->form->remarks,
            ));
        } catch (InvalidStateActionException) {
            $this->alert('warning', 'Invalid action, trip ticket is already '.$this->tripTicket->status->value.'.');

            return;
        }

        Session::put('trip-ticket-updated', 'Trip ticket Approved');

        $this->redirectRoute('trip-ticket.index');
    }

    public function deny(): void
    {
        $this->alert('question', 'Are you sure you want to deny this ticket?', [
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

    public function confirmDeny(DenyTripTicketAction $denyTripTicketAction): void
    {
        $this->validate();

        try {
            $this->tripTicket = $denyTripTicketAction->execute(new DenyTripTicketData(
                trip_ticket_id: $this->tripTicket->id,
                denier_id: Auth::id(),
                remarks: $this->form->remarks,
            ));
        } catch (InvalidStateActionException) {
            $this->alert('warning', 'Invalid action, trip ticket is already '.$this->tripTicket->status->value.'.');

            return;
        }

        Session::put('trip-ticket-updated', 'Trip ticket denied');

        $this->redirectRoute('trip-ticket.index');
    }

    public function cancel(): void
    {
        $this->alert('question', 'Are you sure you want to cancel this ticket?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'confirmButtonText' => 'Yes',
            'cancelButtonText' => 'No',
            'confirmButtonColor' => '#1F2937',
            'onConfirmed' => 'confirmCancel',
            'showCancelButton' => true,
            'timer' => null,
        ]);
    }

    public function confirmCancel(CancelTripTicketAction $cancelTripTicketAction): void
    {
        try {
            $this->tripTicket = $cancelTripTicketAction->execute(new CancelTripTicketData(
                trip_ticket_id: $this->tripTicket->id,
                requester_id: Auth::id(),
            ));
        } catch (InvalidStateActionException) {
            $this->alert('warning', 'Invalid action, trip ticket is already ' . $this->tripTicket->status->value . '.');

            return;
        } catch (UserCannotCancelTripTicketException $exception) {
            $this->alert('warning', $exception);

            return;
        }

        Session::put('trip-ticket-updated', 'Trip ticket cancelled');

        $this->redirectRoute('trip-ticket.index');
    }
}
