<?php

namespace Domain\Supplies\Actions;

use Domain\Supplies\Data\DenySupplyRequestData;
use Domain\Supplies\Models\SupplyRequest;

class DenySupplyRequestAction
{
    public function execute(DenySupplyRequestData $data): SupplyRequest
    {
        $data->supplyRequest->remarks = $data->note;

        $data->supplyRequest->state()->deny($data->denier_id);

        return $data->supplyRequest;
    }
}
