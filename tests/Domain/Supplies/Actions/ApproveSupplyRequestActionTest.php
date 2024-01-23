<?php

use App\Events\SupplyRequestApproved;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Domain\Supplies\Actions\ApproveSupplyRequestAction;
use Domain\Supplies\Data\ApproveSupplyRequestData;
use Domain\Supplies\Data\UpdateSupplyRequestItemData;
use Domain\Supplies\Enums\Status;
use Domain\Supplies\Models\SupplyRequest;
use Domain\Supplies\Models\SupplyRequestItem;
use Illuminate\Support\Facades\Event;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);
});

it('returns an approve supply request and dispatches an event', function () {
    Event::fake();

    /** @var User $approver */
    $approver = User::factory()->create();
    $approver->assignRole('Supplies Approver');

    /** @var SupplyRequest $supplyRequest */
    $supplyRequest = SupplyRequest::factory()->create();

    /** @var ApproveSupplyRequestAction $action */
    $action = app(ApproveSupplyRequestAction::class);

    /** @var SupplyRequestItem $item */
    $item = $supplyRequest->items()->first();


    $result = $action->execute(new ApproveSupplyRequestData(
        approver_id: $approver->id,
        supplyRequest: $supplyRequest,
        supply_request_items: UpdateSupplyRequestItemData::collection([[
            'id' => $supplyRequest->id,
            'name' => $item->name,
            'quantity' => $item->quantity,
            'purpose' => $item->purpose,
        ]]),
        note: 'Test',
    ));

    Event::assertDispatched(SupplyRequestApproved::class);
    expect($result)->toBeInstanceOf(SupplyRequest::class);
    expect($result->status)->toEqual(Status::APPROVED);
});

it('updates supply request item after approving', function () {
    /** @var User $approver */
    $approver = User::factory()->create();
    $approver->assignRole('Supplies Approver');

    /** @var SupplyRequest $supplyRequest */
    $supplyRequest = SupplyRequest::factory()->create();

    /** @var ApproveSupplyRequestAction $action */
    $action = app(ApproveSupplyRequestAction::class);

    $result = $action->execute(new ApproveSupplyRequestData(
        approver_id: $approver->id,
        supplyRequest: $supplyRequest,
        supply_request_items: UpdateSupplyRequestItemData::collection([[
            'id' => $supplyRequest->id,
            'name' => 'Changed name',
            'quantity' => 'Changed qty',
            'purpose' => 'Changed purpose',
        ]]),
        note: 'Test',
    ));

    /** @var SupplyRequestItem $item */
    $item = $result->items()->first();

    expect($item->name)->toEqual('Changed name');
    expect($item->quantity)->toEqual('Changed qty');
    expect($item->purpose)->toEqual('Changed purpose');
});
