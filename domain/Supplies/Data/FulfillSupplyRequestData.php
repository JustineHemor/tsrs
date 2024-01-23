<?php

namespace Domain\Supplies\Data;

use Domain\Supplies\Models\SupplyRequest;

class FulfillSupplyRequestData
{
    public function __construct(
        public SupplyRequest $supplyRequest,
        public readonly int $fulfiller_id,
    )
    {
    }
}
