<?php

namespace Domain\Supplies\Data;

use Domain\Supplies\Models\SupplyRequest;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class ApproveSupplyRequestData extends Data
{
    public function __construct(
        public readonly int $approver_id,
        public SupplyRequest $supplyRequest,
        #[DataCollectionOf(UpdateSupplyRequestItemData::class)]
        public readonly DataCollection $supply_request_items,
        public readonly string $note,
    )
    {
    }
}
