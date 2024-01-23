<?php

namespace Domain\Reports\Data;

use Domain\Reports\Enums\States;

class CreateReportData
{
    public function __construct(
        public readonly int $requester_id,
        public readonly string $type,
        public readonly string $from_date,
        public readonly ?string $from_time,
        public readonly string $to_date,
        public readonly ?string $to_time,
        public readonly States $status,
    )
    {
    }
}
