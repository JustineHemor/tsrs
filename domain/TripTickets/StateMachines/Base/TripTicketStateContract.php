<?php

namespace Domain\TripTickets\StateMachines\Base;

interface TripTicketStateContract
{
    public function initialize();
    public function approve(int $approver_id);
    public function deny(int $denier_id);
    public function cancel();
}
