<?php

namespace App\Livewire\TripTicket;

use App\Models\User;
use Domain\TripTickets\Actions\GetTripTicketsAction;
use Domain\TripTickets\Data\GetTripTicketsData;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application as ApplicationAlias;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    use LivewireAlert;

    public Collection $requesters;

    public ?int $requester_id = null;
    public string $status = '';
    public ?int $trip_ticket_id = null;

    public function render(GetTripTicketsAction $getTripTicketsAction): View|ApplicationAlias|Factory|Application
    {
        $this->getRequesters();

        $tripTickets = $getTripTicketsAction(new GetTripTicketsData(
            requester_id: $this->requester_id,
            status: $this->status,
            trip_ticket_id: $this->trip_ticket_id,
        ));

        return view('livewire.trip-ticket.index', [
            'tripTickets' => $tripTickets,
        ]);
    }

    public function updated(): void
    {
        $this->resetPage();
    }

    public function mount(): void
    {
        $this->checkSessionAlert();

        $this->getRequesters();
    }

    public function checkSessionAlert(): void
    {
        if (Session::has('trip-ticket-updated')) {
            $this->alert('success', Session::get('trip-ticket-updated'));

            Session::forget('trip-ticket-updated');
        }
    }

    private function getRequesters(): void
    {
        $this->requesters = User::query()
            ->orderBy('name')
            ->get();
    }
}
