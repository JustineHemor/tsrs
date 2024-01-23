<?php

use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Domain\Supplies\Actions\CreateSupplyRequestAction;
use Domain\Supplies\Data\CreateSupplyRequestData;
use Domain\Supplies\Data\CreateSupplyRequestItemData;
use Domain\Supplies\Models\SupplyRequest;
use Domain\Supplies\Models\SupplyRequestItem;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);

    $this->requester = User::factory()->create();
});

it('returns a supply request model', function () {
    $this->requester->assignRole('Trip Requester');

    /** @var CreateSupplyRequestAction $action */
    $action = app(CreateSupplyRequestAction::class);

    $supplyRequest = $action->execute(new CreateSupplyRequestData(
        requester_id: $this->requester->id,
        items: CreateSupplyRequestItemData::collection([[
            'name' => 'Lorem',
            'specified_name' => '',
            'quantity' => '1 pcs',
            'purpose' => 'Ipsum',
        ]]),
        remarks: 'Test',
    ));

    expect($supplyRequest)->toBeInstanceOf(SupplyRequest::class);
});

it('creates supply request items', function () {
    $this->requester->assignRole('Trip Requester');

    /** @var CreateSupplyRequestAction $action */
    $action = app(CreateSupplyRequestAction::class);

    $supplyRequest = $action->execute(new CreateSupplyRequestData(
        requester_id: $this->requester->id,
        items: CreateSupplyRequestItemData::collection([[
            'name' => 'Lorem',
            'specified_name' => '',
            'quantity' => '1 pcs',
            'purpose' => 'Ipsum',
        ]]),
        remarks: 'Test',
    ));

    expect($supplyRequest->items()->first())->toBeInstanceOf(SupplyRequestItem::class);
});
