<?php

namespace Domain\TripTickets\StateMachines;

use App\Events\TripTicketCancelled;
use Carbon\Carbon;
use Domain\TripTickets\Enums\Status;
use Domain\TripTickets\StateMachines\Base\BaseTripTicketState;

class Approved extends BaseTripTicketState
{
    public function cancel(): void
    {
        $this->tripTicket->status = Status::CANCELLED;
        $this->tripTicket->cancelled_at = Carbon::now();
        $this->tripTicket->save();

        TripTicketCancelled::dispatch($this->tripTicket);
    }
}
