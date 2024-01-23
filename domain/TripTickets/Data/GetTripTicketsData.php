<?php

namespace Domain\TripTickets\Data;

class GetTripTicketsData
{
    public function __construct(
        public readonly ?int $requester_id,
        public readonly ?string $status,
        public readonly ?int $trip_ticket_id,
    )
    {
    }
}
