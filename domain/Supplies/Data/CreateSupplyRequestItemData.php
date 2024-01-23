<?php

namespace Domain\Supplies\Data;

use Spatie\LaravelData\Data;

class CreateSupplyRequestItemData extends Data
{
    public function __construct(
        public readonly string $name,
        public readonly string $specified_name,
        public readonly string $quantity,
        public readonly string $purpose,
    )
    {
    }
}
