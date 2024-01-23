<?php

use App\Events\NewTripTicketCreated;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Domain\TripTickets\Actions\CreateTripTicketAction;
use Domain\TripTickets\Data\CreateTripTicketData;
use Domain\TripTickets\Enums\Status;
use Domain\TripTickets\Exceptions\UserNotPermittedException;
use Domain\TripTickets\Models\TripTicket;
use Illuminate\Support\Facades\Event;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);

    $this->requester = User::factory()->create();
});

it('returns a trip ticket', function () {
    $this->requester->assignRole('Trip Requester');

    /** @var CreateTripTicketAction $action */
    $action = app(CreateTripTicketAction::class);

    $tripTicket = $action->execute(new CreateTripTicketData(
        requester_id: $this->requester->id,
        contact_person: 'John Doe',
        contact_number: '09898787987',
        passenger_count: '1',
        origin_location: 'Teleserv',
        origin_date: '2024-01-08',
        origin_time: '08:00:00',
        drop_off_location: 'MOA',
        drop_off_date: '2024-01-08',
        drop_off_time: '13:00:00',
        pick_up_location: null,
        pick_up_date: null,
        pick_up_time: null,
        vehicle_id: null,
        driver_id: null,
        purpose: 'Meeting',
    ));

    expect($tripTicket)->toBeInstanceOf(TripTicket::class);
});

it('saves correct input', function () {
    $this->requester->assignRole('Trip Requester');

    /** @var CreateTripTicketAction $action */
    $action = app(CreateTripTicketAction::class);

    $tripTicket = $action->execute(new CreateTripTicketData(
        requester_id: $this->requester->id,
        contact_person: 'John Doe',
        contact_number: '09898787987',
        passenger_count: '1',
        origin_location: 'Teleserv',
        origin_date: '2024-01-08',
        origin_time: '08:00:00',
        drop_off_location: 'MOA',
        drop_off_date: '2024-01-08',
        drop_off_time: '13:00:00',
        pick_up_location: null,
        pick_up_date: null,
        pick_up_time: null,
        vehicle_id: null,
        driver_id: null,
        purpose: 'Meeting',
    ));

    expect($tripTicket->status)->toEqual(Status::PENDING);
    expect($tripTicket->contact_person)->toEqual('John Doe');
    expect($tripTicket->contact_number)->toEqual('09898787987');
    expect($tripTicket->origin)->toEqual('Teleserv');
    expect($tripTicket->origin_datetime)->toEqual('2024-01-08 08:00:00');
    expect($tripTicket->drop_off)->toEqual('MOA');
    expect($tripTicket->drop_off_datetime)->toEqual('2024-01-08 13:00:00');
    expect($tripTicket->pick_up)->toBeNull();
    expect($tripTicket->pick_up_datetime)->toBeNull();
    expect($tripTicket->vehicle_id)->toBeNull();
    expect($tripTicket->driver_id)->toBeNull();
    expect($tripTicket->purpose)->toEqual('Meeting');
});

it('throws an exception before creation', function () {
    /** @var CreateTripTicketAction $action */
    $action = app(CreateTripTicketAction::class);

    $action->execute(new CreateTripTicketData(
        requester_id: $this->requester->id,
        contact_person: 'John Doe',
        contact_number: '09898787987',
        passenger_count: '1',
        origin_location: 'Teleserv',
        origin_date: '2024-01-08',
        origin_time: '08:00:00',
        drop_off_location: 'MOA',
        drop_off_date: '2024-01-08',
        drop_off_time: '13:00:00',
        pick_up_location: null,
        pick_up_date: null,
        pick_up_time: null,
        vehicle_id: null,
        driver_id: null,
        purpose: 'Meeting',
    ));
})->throws(UserNotPermittedException::class, 'User has no permission to create trip ticket');

it('dispatches an event after a creating ticket', function () {
    Event::fake();

    $this->requester->assignRole('Trip Requester');

    /** @var CreateTripTicketAction $action */
    $action = app(CreateTripTicketAction::class);

    $action->execute(new CreateTripTicketData(
        requester_id: $this->requester->id,
        contact_person: 'John Doe',
        contact_number: '09898787987',
        passenger_count: '1',
        origin_location: 'Teleserv',
        origin_date: '2024-01-08',
        origin_time: '08:00:00',
        drop_off_location: 'MOA',
        drop_off_date: '2024-01-08',
        drop_off_time: '13:00:00',
        pick_up_location: null,
        pick_up_date: null,
        pick_up_time: null,
        vehicle_id: null,
        driver_id: null,
        purpose: 'Meeting',
    ));

    Event::assertDispatched(NewTripTicketCreated::class);
});
