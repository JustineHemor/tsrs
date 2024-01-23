<?php

namespace App\Livewire\Forms\TripTicket;

use Domain\TripTickets\Models\TripTicket;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ShowForm extends Form
{
    public string $trip_requester = '';
    public string $contact_person = '';
    public string $mobile_number = '';

    public string $origin_location = '';
    public string $origin_datetime = '';

    public string $drop_off_location = '';
    public string $drop_off_datetime = '';

    public string $pick_up_location = '';
    public string $pick_up_datetime = '';

    public int $passenger_count = 1;
    public ?int $vehicle_id = null;
    public ?int $driver_id = null;
    public string $purpose = '';

    #[Validate('required')]
    public string $remarks = '';

    public function populateFields(TripTicket $tripTicket): void
    {
        $this->trip_requester = $tripTicket->requester->name;
        $this->contact_person = $tripTicket->contact_person;
        $this->mobile_number = $tripTicket->contact_number;

        $this->origin_location = $tripTicket->origin;
        $this->origin_datetime = $tripTicket->origin_datetime->format('F d, Y g:i A');
        $this->drop_off_location = $tripTicket->drop_off;
        $this->drop_off_datetime = $tripTicket->drop_off_datetime->format('F d, Y g:i A');
        $this->pick_up_location = filled($tripTicket->pick_up) ? $tripTicket->pick_up : 'N/A';
        $this->pick_up_datetime = $tripTicket->pick_up_datetime ? $tripTicket->pick_up_datetime->format('F d, Y g:i A') : '';

        $this->passenger_count = $tripTicket->passenger_count;
        $this->vehicle_id = $tripTicket->vehicle_id;
        $this->driver_id = $tripTicket->driver_id;
        $this->purpose = $tripTicket->purpose;

        $this->remarks = $tripTicket->remarks ?? '';
    }
}
