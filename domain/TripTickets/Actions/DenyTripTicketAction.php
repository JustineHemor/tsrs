<?php

namespace Domain\TripTickets\Actions;

use App\Models\User;
use Domain\TripTickets\Data\DenyTripTicketData;
use Domain\TripTickets\Exceptions\UserNotPermittedException;
use Domain\TripTickets\Models\TripTicket;

class DenyTripTicketAction
{
    public function execute(DenyTripTicketData $data): TripTicket
    {
        if ($this->userHasNoPermission($data->denier_id)) {
            throw new UserNotPermittedException('User has no permission to deny trip ticket');
        }

        /** @var TripTicket $tripTicket */
        $tripTicket = TripTicket::query()->findOrFail($data->trip_ticket_id);

        $tripTicket->remarks = $data->remarks;

        $tripTicket->state()->deny($data->denier_id);

        return $tripTicket;
    }

    private function userHasNoPermission(int $approver_id): bool
    {
        /** @var User $approver */
        $approver = User::query()->findOrFail($approver_id);

        return $approver->cannot('deny-trip-ticket');
    }
}
