<?php

use App\Events\SupplyRequestDenied;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Domain\Supplies\Actions\DenySupplyRequestAction;
use Domain\Supplies\Data\DenySupplyRequestData;
use Domain\Supplies\Enums\Status;
use Domain\Supplies\Models\SupplyRequest;
use Illuminate\Support\Facades\Event;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);
});

it('returns a denied supply request and dispatches an event', function () {
    Event::fake();

    /** @var User $denier */
    $denier = User::factory()->create();
    $denier->assignRole('Supplies Approver');

    /** @var SupplyRequest $supplyRequest */
    $supplyRequest = SupplyRequest::factory()->create();

    /** @var DenySupplyRequestAction $action */
    $action = app(DenySupplyRequestAction::class);

    $result = $action->execute(new DenySupplyRequestData(
        supplyRequest: $supplyRequest,
        denier_id: $denier->id,
        note: 'Testing note',
    ));

    Event::assertDispatched(SupplyRequestDenied::class);
    expect($result)->toBeInstanceOf(SupplyRequest::class);
    expect($result->status)->toEqual(Status::DENIED);
});
