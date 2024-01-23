<?php

namespace Domain\TripTickets\Data;

use App\Livewire\Forms\TripTicket\CreateForm;
use App\Models\User;

class CreateTripTicketData
{
    public function __construct(
        public readonly int $requester_id,
        public readonly string $contact_person,
        public readonly string $contact_number,
        public readonly int $passenger_count,
        public readonly string $origin_location,
        public readonly string $origin_date,
        public readonly string $origin_time,
        public readonly string $drop_off_location,
        public readonly string $drop_off_date,
        public readonly string $drop_off_time,
        public readonly ?string $pick_up_location,
        public readonly ?string $pick_up_date,
        public readonly ?string $pick_up_time,
        public readonly ?int $vehicle_id,
        public readonly ?int $driver_id,
        public readonly string $purpose,
    )
    {
    }

    public static function fromForm(CreateForm $form, User $requester): self
    {
        return new self(
            requester_id: $requester->id,
            contact_person: $form->name,
            contact_number: $form->mobile_number,
            passenger_count: $form->passenger_count,
            origin_location: $form->origin_location,
            origin_date: $form->origin_date,
            origin_time: $form->origin_time,
            drop_off_location: $form->drop_off_location,
            drop_off_date: $form->drop_off_date,
            drop_off_time: $form->drop_off_time,
            pick_up_location: $form->pick_up_location,
            pick_up_date: $form->pick_up_date,
            pick_up_time: $form->pick_up_time,
            vehicle_id: $form->vehicle_id,
            driver_id: $form->driver_id,
            purpose: $form->purpose,
        );
    }
}
