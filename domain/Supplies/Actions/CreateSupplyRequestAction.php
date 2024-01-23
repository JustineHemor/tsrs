<?php

namespace Domain\Supplies\Actions;

use Domain\Reports\Enums\States;
use Domain\Supplies\Data\CreateSupplyRequestData;
use Domain\Supplies\Data\CreateSupplyRequestItemData;
use Domain\Supplies\Models\SupplyRequest;
use Domain\Supplies\Models\SupplyRequestItem;

class CreateSupplyRequestAction
{
    public function execute(CreateSupplyRequestData $data): SupplyRequest
    {
        $supplyRequest = new SupplyRequest();

        $supplyRequest->status = States::PENDING;
        $supplyRequest->requester_id = $data->requester_id;
        $supplyRequest->remarks = $data->remarks;

        $supplyRequest->save();

        foreach ($data->items as $item) {
            $this->createSupplyRequestItem($supplyRequest, $item);
        }

        return $supplyRequest;
    }

    private function createSupplyRequestItem(SupplyRequest $supplyRequest, CreateSupplyRequestItemData $item): void
    {
        $supplyRequestItem = new SupplyRequestItem();

        $supplyRequestItem->supply_request_id = $supplyRequest->id;
        $supplyRequestItem->name = $item->name == 'Others' ? $item->specified_name : $item->name;
        $supplyRequestItem->quantity = $item->quantity;
        $supplyRequestItem->purpose = $item->purpose;

        $supplyRequestItem->save();
    }
}
