<?php

namespace Domain\Supplies\Actions;

use Domain\Supplies\Data\ApproveSupplyRequestData;
use Domain\Supplies\Data\UpdateSupplyRequestItemData;
use Domain\Supplies\Models\SupplyRequest;
use Domain\Supplies\Models\SupplyRequestItem;

class ApproveSupplyRequestAction
{
    public function execute(ApproveSupplyRequestData $data): SupplyRequest
    {
        $data->supplyRequest->note = $data->note;

        $data->supplyRequest->state()->approve($data->approver_id);

        foreach($data->supply_request_items as $item) {
            $this->updateSupplyRequestItem($item);
        }

        return $data->supplyRequest;
    }

    private function updateSupplyRequestItem(UpdateSupplyRequestItemData $item): void
    {
        /** @var SupplyRequestItem $supplyRequestItem */
        $supplyRequestItem = SupplyRequestItem::query()->findOrFail($item->id);

        $supplyRequestItem->name = $item->name;
        $supplyRequestItem->quantity = $item->quantity;
        $supplyRequestItem->purpose = $item->purpose;

        $supplyRequestItem->save();
    }
}
