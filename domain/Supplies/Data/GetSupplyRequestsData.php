<?php

namespace Domain\Supplies\Data;

class GetSupplyRequestsData
{
    public function __construct(
        public readonly ?int $requester_id,
        public readonly ?string $status,
        public readonly ?int $supply_request_id,
    )
    {
    }
}
