<?php

namespace Domain\TripTickets\Actions;

use Domain\TripTickets\Data\CancelTripTicketData;
use Domain\TripTickets\Exceptions\UserCannotCancelTripTicketException;
use Domain\TripTickets\Models\TripTicket;

class CancelTripTicketAction
{
    public function execute(CancelTripTicketData $data): TripTicket
    {
        /** @var TripTicket $tripTicket */
        $tripTicket = TripTicket::query()->findOrFail($data->trip_ticket_id);

        if ($this->userCannotCancelRequest($data , $tripTicket)) {
            throw new UserCannotCancelTripTicketException('Only the requester can cancel trip ticket');
        }

        $tripTicket->state()->cancel();

        return $tripTicket;
    }

    private function userCannotCancelRequest(CancelTripTicketData $data, TripTicket $tripTicket): bool
    {
        return $data->requester_id != $tripTicket->requester_id;
    }
}
