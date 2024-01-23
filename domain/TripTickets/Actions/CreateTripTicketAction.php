<?php

namespace Domain\TripTickets\Actions;

use App\Events\NewTripTicketCreated;
use App\Models\User;
use Carbon\Carbon;
use Domain\TripTickets\Data\CreateTripTicketData;
use Domain\TripTickets\Enums\Status;
use Domain\TripTickets\Exceptions\UserNotPermittedException;
use Domain\TripTickets\Models\TripTicket;

class CreateTripTicketAction
{
    public function execute(CreateTripTicketData $data): TripTicket
    {
        if ($this->requesterHasNoPermission($data->requester_id)) {
            throw new UserNotPermittedException('User has no permission to create trip ticket');
        }

        $tripTicket = new TripTicket();

        $tripTicket->requester_id = $data->requester_id;
        $tripTicket->status = Status::PENDING;
        $tripTicket->passenger_count = $data->passenger_count;
        $tripTicket->contact_person = $data->contact_person;
        $tripTicket->contact_number = $data->contact_number;
        $tripTicket->origin = $data->origin_location;
        $tripTicket->origin_datetime = Carbon::parse("$data->origin_date $data->origin_time");
        $tripTicket->drop_off = $data->drop_off_location;
        $tripTicket->drop_off_datetime = Carbon::parse("$data->drop_off_date $data->drop_off_time");
        $tripTicket->pick_up = $data->pick_up_location;
        $tripTicket->pick_up_datetime = $data->pick_up_date && $data->pick_up_time ? Carbon::parse("$data->pick_up_date $data->pick_up_time") : null;
        $tripTicket->vehicle_id = $data->vehicle_id;
        $tripTicket->driver_id = $data->driver_id;
        $tripTicket->purpose = $data->purpose;

        $tripTicket->save();

        NewTripTicketCreated::dispatch($tripTicket);

        return $tripTicket;
    }

    private function requesterHasNoPermission(int $requester_id): bool
    {
        /** @var User $requester */
        $requester = User::query()->findOrFail($requester_id);

        return $requester->cannot('create-trip-ticket');
    }
}
