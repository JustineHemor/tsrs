<?php

use App\Events\SupplyRequestFulfilled;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Domain\Supplies\Actions\FulFillSupplyRequestAction;
use Domain\Supplies\Data\FulfillSupplyRequestData;
use Domain\Supplies\Enums\Status;
use Domain\Supplies\Models\SupplyRequest;
use Illuminate\Support\Facades\Event;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);
});

it('returns a fulfilled supply request and dispatches an event', function () {
    Event::fake();

    /** @var User $fulfiller */
    $fulfiller = User::factory()->create();
    $fulfiller->assignRole('Supplies Approver');

    /** @var SupplyRequest $supplyRequest */
    $supplyRequest = SupplyRequest::factory()->approved()->create();

    /** @var FulFillSupplyRequestAction $action */
    $action = app(FulFillSupplyRequestAction::class);

    $result = $action->execute(new FulfillSupplyRequestData(
        supplyRequest: $supplyRequest,
        fulfiller_id: $fulfiller->id,
    ));

    Event::assertDispatched(SupplyRequestFulfilled::class);
    expect($result)->toBeInstanceOf(SupplyRequest::class);
    expect($result->status)->toEqual(Status::FULFILLED);
});
