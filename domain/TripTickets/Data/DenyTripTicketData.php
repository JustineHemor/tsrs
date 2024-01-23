<?php

namespace Domain\TripTickets\Data;

class DenyTripTicketData
{
    public function __construct(
        public readonly int $trip_ticket_id,
        public readonly int $denier_id,
        public readonly string $remarks,
    )
    {
    }
}
