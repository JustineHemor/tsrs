<?php

use App\Events\TripTicketDenied;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Domain\TripTickets\Actions\DenyTripTicketAction;
use Domain\TripTickets\Data\DenyTripTicketData;
use Domain\TripTickets\Enums\Status;
use Domain\TripTickets\Exceptions\UserNotPermittedException;
use Domain\TripTickets\Models\TripTicket;
use Illuminate\Support\Facades\Event;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);

    $this->tripTicket = TripTicket::factory()->create();

    $this->denier = User::factory()->create();
});

it('returns a denied trip ticket', function () {
    $this->denier->assignRole('Trip Approver');

    /** @var DenyTripTicketAction $action */
    $action = app(DenyTripTicketAction::class);

    $tripTicket = $action->execute(new DenyTripTicketData(
        trip_ticket_id: $this->tripTicket->id,
        denier_id: $this->denier->id,
        remarks: 'Test Remarks',
    ));

    expect($tripTicket)->toBeInstanceOf(TripTicket::class);
    expect($tripTicket->status)->toEqual(Status::DENIED);
});

it('throws an exception before denying', function () {
    /** @var DenyTripTicketAction $action */
    $action = app(DenyTripTicketAction::class);

    $action->execute(new DenyTripTicketData(
        trip_ticket_id: $this->tripTicket->id,
        denier_id: $this->denier->id,
        remarks: 'Test Remarks',
    ));
})->throws(UserNotPermittedException::class);

it('dispatches an event after denying ticket', function () {
    Event::fake();

    $this->denier->assignRole('Trip Approver');

    /** @var DenyTripTicketAction $action */
    $action = app(DenyTripTicketAction::class);

    $action->execute(new DenyTripTicketData(
        trip_ticket_id: $this->tripTicket->id,
        denier_id: $this->denier->id,
        remarks: 'Test Remarks',
    ));

    Event::assertDispatched(TripTicketDenied::class);
});
