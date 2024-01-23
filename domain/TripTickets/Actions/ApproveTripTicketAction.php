<?php

namespace Domain\TripTickets\Actions;

use App\Models\User;
use Domain\TripTickets\Data\ApproveTripTicketData;
use Domain\TripTickets\Exceptions\UserNotPermittedException;
use Domain\TripTickets\Models\TripTicket;

class ApproveTripTicketAction
{
    public function execute(ApproveTripTicketData $data): TripTicket
    {
        if ($this->userHasNoPermission($data->approver_id)) {
            throw new UserNotPermittedException('User has no permission to approve trip ticket');
        }

        /** @var TripTicket $tripTicket */
        $tripTicket = TripTicket::query()->findOrFail($data->trip_ticket_id);

        $tripTicket->vehicle_id = $data->vehicle_id;
        $tripTicket->driver_id = $data->driver_id;
        $tripTicket->remarks = $data->remarks;

        $tripTicket->state()->approve($data->approver_id);

        return $tripTicket;
    }

    private function userHasNoPermission(int $approver_id): bool
    {
        /** @var User $approver */
        $approver = User::query()->findOrFail($approver_id);

        return $approver->cannot('approve-trip-ticket');
    }
}
