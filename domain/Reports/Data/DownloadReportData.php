<?php

namespace Domain\Reports\Data;

use Domain\Reports\Enums\States;
use Domain\Reports\Models\Report;

class DownloadReportData
{
    public function __construct(
        public readonly int $user_id,
        public readonly Report $report,
    )
    {
    }
}
