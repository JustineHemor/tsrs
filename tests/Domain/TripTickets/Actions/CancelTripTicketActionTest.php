<?php

use App\Events\TripTicketCancelled;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Domain\TripTickets\Actions\CancelTripTicketAction;
use Domain\TripTickets\Data\CancelTripTicketData;
use Domain\TripTickets\Enums\Status;
use Domain\TripTickets\Exceptions\UserCannotCancelTripTicketException;
use Domain\TripTickets\Models\TripTicket;
use Illuminate\Support\Facades\Event;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);
});

it('returns a cancelled trip ticket', function () {
    /** @var User $requester */
    $requester = User::factory()->create();

    /** @var TripTicket $tripTicket */
    $tripTicket = TripTicket::factory()->create([
        'requester_id' => $requester->id,
    ]);

    /** @var CancelTripTicketAction $action */
    $action = app(CancelTripTicketAction::class);

    $tripTicket = $action->execute(new CancelTripTicketData(
        trip_ticket_id: $tripTicket->id,
        requester_id: $requester->id
    ));

    expect($tripTicket)->toBeInstanceOf(TripTicket::class);
    expect($tripTicket->status)->toEqual(Status::CANCELLED);
});

it('throws an exception before cancelling', function () {
    /** @var User $requester */
    $requester = User::factory()->create();

    /** @var TripTicket $tripTicket */
    $tripTicket = TripTicket::factory()->create();

    /** @var CancelTripTicketAction $action */
    $action = app(CancelTripTicketAction::class);

    $action->execute(new CancelTripTicketData(
        trip_ticket_id: $tripTicket->id,
        requester_id: $requester->id
    ));
})->throws(UserCannotCancelTripTicketException::class);

it('dispatches an event after cancelling ticket', function () {
    Event::fake();

    /** @var User $requester */
    $requester = User::factory()->create();

    /** @var TripTicket $tripTicket */
    $tripTicket = TripTicket::factory()->create([
        'requester_id' => $requester->id,
    ]);

    /** @var CancelTripTicketAction $action */
    $action = app(CancelTripTicketAction::class);

    $action->execute(new CancelTripTicketData(
        trip_ticket_id: $tripTicket->id,
        requester_id: $requester->id
    ));

    Event::assertDispatched(TripTicketCancelled::class);
});
