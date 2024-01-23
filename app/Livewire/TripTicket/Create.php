<?php

namespace App\Livewire\TripTicket;

use App\Livewire\Forms\TripTicket\CreateForm;
use Domain\TripTickets\Actions\CreateTripTicketAction;
use Domain\TripTickets\Data\CreateTripTicketData;
use Domain\TripTickets\Models\Driver;
use Domain\TripTickets\Models\TripTicket;
use Domain\TripTickets\Models\Vehicle;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application as ApplicationAlias;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class Create extends Component
{
    public Collection $vehicles;

    public Collection $drivers;

    public bool $is_pick_up_field_included = false;

    public CreateForm $form;

    public bool $is_trip_ticket_created = false;

    public ?TripTicket $tripTicket = null;

    public function mount(): void
    {
        $this->vehicles = Vehicle::query()
            ->orderBy('name')
            ->get();

        $this->drivers = Driver::query()
            ->orderBy('name')
            ->get();
    }

    public function updatedFormOriginDate(): void
    {
        if (! $this->form->drop_off_date){
            $this->form->drop_off_date = $this->form->origin_date;
        }

        $this->cloneOriginDateToPickUpDate();
    }

    public function updatedFormDropOffLocation(): void
    {
        $this->cloneOriginLocationToPickUpLocation();
    }

    public function updatedIsPickUpFieldIncluded(): void
    {
        $this->cloneOriginDateToPickUpDate();

        $this->cloneOriginLocationToPickUpLocation();
    }

    public function create(CreateTripTicketAction $createTripTicketAction): void
    {
        $this->validate();

        $this->tripTicket = $createTripTicketAction->execute(CreateTripTicketData::fromForm($this->form, Request::user()));

        $this->is_trip_ticket_created = true;
    }

    public function viewTripTicket(): void
    {
        $this->redirectRoute('trip-ticket.show', $this->tripTicket);
    }

    public function render(): View|ApplicationAlias|Factory|Application
    {
        return view('livewire.trip-ticket.create');
    }

    private function cloneOriginDateToPickUpDate(): void
    {
        if ($this->is_pick_up_field_included and ! $this->form->pick_up_date) {
            $this->form->pick_up_date = $this->form->origin_date;
        } else {
            $this->form->pick_up_date = '';
        }
    }

    private function cloneOriginLocationToPickUpLocation(): void
    {
        if ($this->is_pick_up_field_included) {
            $this->form->pick_up_location = $this->form->drop_off_location;
        } else {
            $this->form->pick_up_location = '';
        }
    }
}
