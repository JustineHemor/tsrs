<?php

namespace Domain\TripTickets\StateMachines;

use App\Events\TripTicketApproved;
use App\Events\TripTicketCancelled;
use App\Events\TripTicketDenied;
use Carbon\Carbon;
use Domain\TripTickets\Enums\Status;
use Domain\TripTickets\StateMachines\Base\BaseTripTicketState;

class Pending extends BaseTripTicketState
{
    public function approve(int $approver_id): void
    {
        $this->tripTicket->status = Status::APPROVED;
        $this->tripTicket->approved_at = Carbon::now();
        $this->tripTicket->approver_id = $approver_id;
        $this->tripTicket->save();

        TripTicketApproved::dispatch($this->tripTicket);
    }

    public function deny(int $denier_id): void
    {
        $this->tripTicket->status = Status::DENIED;
        $this->tripTicket->denied_at = Carbon::now();
        $this->tripTicket->denier_id = $denier_id;
        $this->tripTicket->save();

        TripTicketDenied::dispatch($this->tripTicket);
    }

    public function cancel(): void
    {
        $this->tripTicket->status = Status::CANCELLED;
        $this->tripTicket->cancelled_at = Carbon::now();
        $this->tripTicket->save();

        TripTicketCancelled::dispatch($this->tripTicket);
    }
}
