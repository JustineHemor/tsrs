<?php

use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Domain\Supplies\Actions\GetSupplyRequestsAction;
use Domain\Supplies\Data\GetSupplyRequestsData;
use Domain\Supplies\Models\SupplyRequest;
use Domain\TripTickets\Actions\GetTripTicketsAction;
use Domain\TripTickets\Data\GetTripTicketsData;
use Domain\TripTickets\Models\TripTicket;
use Illuminate\Pagination\LengthAwarePaginator;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);

    SupplyRequest::factory()->count(10)->create();
});

it('returns paginated supply requests', function () {
    /** @var User $approver */
    $approver = User::factory()->create();
    $approver->assignRole('Supplies Approver');

    $this->actingAs($approver, 'web');

    /** @var GetSupplyRequestsAction $action */
    $action = app(GetSupplyRequestsAction::class);

    $supply_requests = $action(new GetSupplyRequestsData(
        requester_id: null,
        status: null,
        supply_request_id: null,
    ));

    expect($supply_requests)->toBeInstanceOf(LengthAwarePaginator::class);
    expect(count($supply_requests->items()))->toEqual(10);
});

it('returns filtered paginated supply requests', function () {
    /** @var User $requester */
    $requester = User::factory()->create();

    SupplyRequest::factory()->count(2)->create([
        'requester_id' => $requester->id,
    ]);

    $this->actingAs($requester, 'web');

    /** @var GetSupplyRequestsAction $action */
    $action = app(GetSupplyRequestsAction::class);

    $supply_requests = $action(new GetSupplyRequestsData(
        requester_id: null,
        status: null,
        supply_request_id: null,
    ));


    expect($supply_requests)->toBeInstanceOf(LengthAwarePaginator::class);
    expect(count($supply_requests->items()))->toEqual(2);
});
