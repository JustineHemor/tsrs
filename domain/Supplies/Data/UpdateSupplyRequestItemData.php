<?php

namespace Domain\Supplies\Data;

use Spatie\LaravelData\Data;

class UpdateSupplyRequestItemData extends Data
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $quantity,
        public readonly string $purpose,
    )
    {
    }
}
