<?php

namespace Domain\TripTickets\StateMachines\Base;

use Domain\TripTickets\Models\TripTicket;
use Domain\TripTickets\StateMachines\Exceptions\InvalidStateActionException;

class BaseTripTicketState implements TripTicketStateContract
{
    public function __construct(public TripTicket $tripTicket)
    {
    }

    public function initialize()
    {
        throw new InvalidStateActionException();
    }

    public function approve(int $approver_id)
    {
        throw new InvalidStateActionException();
    }

    public function deny(int $denier_id)
    {
        throw new InvalidStateActionException();
    }

    public function cancel()
    {
        throw new InvalidStateActionException();
    }
}
