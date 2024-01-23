<?php

namespace Domain\Supplies\Data;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class CreateSupplyRequestData extends Data
{
    public function __construct(
        public readonly int $requester_id,
        #[DataCollectionOf(CreateSupplyRequestItemData::class)]
        public readonly DataCollection $items,
        public readonly string $remarks,
    )
    {
    }
}
