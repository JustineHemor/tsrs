<?php

use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Domain\TripTickets\Actions\GetTripTicketsAction;
use Domain\TripTickets\Data\GetTripTicketsData;
use Domain\TripTickets\Models\TripTicket;
use Illuminate\Pagination\LengthAwarePaginator;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);

    TripTicket::factory()->count(10)->create();
});

it('returns paginated trip tickets', function () {
    /** @var User $approver */
    $approver = User::factory()->create();
    $approver->assignRole('Trip Approver');

    $this->actingAs($approver, 'web');

    /** @var GetTripTicketsAction $action */
    $action = app(GetTripTicketsAction::class);

    $tripTickets = $action(new GetTripTicketsData(
        requester_id: null,
        status: null,
        trip_ticket_id: null,
    ));


    expect($tripTickets)->toBeInstanceOf(LengthAwarePaginator::class);
    expect(count($tripTickets->items()))->toEqual(10);
});

it('returns filtered paginated trip tickets', function () {
    /** @var User $requester */
    $requester = User::factory()->create();

    TripTicket::factory()->count(2)->create([
        'requester_id' => $requester->id,
    ]);

    $this->actingAs($requester, 'web');

    /** @var GetTripTicketsAction $action */
    $action = app(GetTripTicketsAction::class);

    $tripTickets = $action(new GetTripTicketsData(
        requester_id: null,
        status: null,
        trip_ticket_id: null,
    ));


    expect($tripTickets)->toBeInstanceOf(LengthAwarePaginator::class);
    expect(count($tripTickets->items()))->toEqual(2);
});
