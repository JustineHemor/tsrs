<?php

namespace Domain\TripTickets\Data;

class ApproveTripTicketData
{
    public function __construct(
        public readonly int $trip_ticket_id,
        public readonly int $approver_id,
        public readonly ?int $vehicle_id,
        public readonly ?int $driver_id,
        public readonly string $remarks,
    )
    {
    }
}
