<?php

namespace Domain\Supplies\Actions;

use Domain\Supplies\Data\FulfillSupplyRequestData;
use Domain\Supplies\Models\SupplyRequest;

class FulFillSupplyRequestAction
{
    public function execute(FulfillSupplyRequestData $data): SupplyRequest
    {
        $data->supplyRequest->state()->fulfill($data->fulfiller_id);

        return $data->supplyRequest;
    }
}
