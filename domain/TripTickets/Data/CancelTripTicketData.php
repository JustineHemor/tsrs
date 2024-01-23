<?php

namespace Domain\TripTickets\Data;

class CancelTripTicketData
{
    public function __construct(
        public readonly int $trip_ticket_id,
        public readonly int $requester_id,
    )
    {
    }
}
