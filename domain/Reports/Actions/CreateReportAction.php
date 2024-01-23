<?php

namespace Domain\Reports\Actions;

use Domain\Reports\Data\CreateReportData;
use Domain\Reports\Models\Report;

class CreateReportAction
{
    public function __invoke(CreateReportData $data): Report
    {
        $report = new Report();

        $report->requester_id = $data->requester_id;
        $report->filename = $data->type . ' ' . $report->id;
        $report->type = $data->type;
        $report->status = $data->status;
        $report->parameters = [
            'from_date' => $data->from_date,
            'from_time' => $data->from_time ? $data->from_time.':00' : '00:00:00',
            'to_date' => $data->to_date,
            'to_time' => $data->to_time ? $data->to_time.':00' : '23:59:59',
        ];

        $report->save();

        return $report;
    }
}
