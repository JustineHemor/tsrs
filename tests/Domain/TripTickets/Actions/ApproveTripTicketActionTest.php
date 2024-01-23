<?php

use App\Events\TripTicketApproved;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Domain\TripTickets\Actions\ApproveTripTicketAction;
use Domain\TripTickets\Data\ApproveTripTicketData;
use Domain\TripTickets\Enums\Status;
use Domain\TripTickets\Exceptions\UserNotPermittedException;
use Domain\TripTickets\Models\TripTicket;
use Illuminate\Support\Facades\Event;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);

    $this->tripTicket = TripTicket::factory()->create();

    $this->approver = User::factory()->create();
});

it('returns an approved trip ticket', function () {
    $this->approver->assignRole('Trip Approver');

    /** @var ApproveTripTicketAction $action */
    $action = app(ApproveTripTicketAction::class);

    $tripTicket = $action->execute(new ApproveTripTicketData(
        trip_ticket_id: $this->tripTicket->id,
        approver_id: $this->approver->id,
        vehicle_id: null,
        driver_id: null,
        remarks: 'Test Remarks',
    ));

    expect($tripTicket)->toBeInstanceOf(TripTicket::class);
    expect($tripTicket->status)->toEqual(Status::APPROVED);
});

it('throws an exception before approval', function () {
    /** @var ApproveTripTicketAction $action */
    $action = app(ApproveTripTicketAction::class);

    $action->execute(new ApproveTripTicketData(
        trip_ticket_id: $this->tripTicket->id,
        approver_id: $this->approver->id,
        vehicle_id: null,
        driver_id: null,
        remarks: 'Test Remarks',
    ));
})->throws(UserNotPermittedException::class);

it('dispatches an event after approving ticket', function () {
    Event::fake();

    $this->approver->assignRole('Trip Approver');

    /** @var ApproveTripTicketAction $action */
    $action = app(ApproveTripTicketAction::class);

    $action->execute(new ApproveTripTicketData(
        trip_ticket_id: $this->tripTicket->id,
        approver_id: $this->approver->id,
        vehicle_id: null,
        driver_id: null,
        remarks: 'Test Remarks',
    ));

    Event::assertDispatched(TripTicketApproved::class);
});
