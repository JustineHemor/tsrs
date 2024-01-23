<?php

namespace Domain\Supplies\Data;

use Domain\Supplies\Models\SupplyRequest;

class DenySupplyRequestData
{
    public function __construct(
        public SupplyRequest $supplyRequest,
        public readonly int $denier_id,
        public readonly string $note,
    )
    {
    }
}
