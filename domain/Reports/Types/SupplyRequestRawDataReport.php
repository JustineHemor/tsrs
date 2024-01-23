<?php

namespace Domain\Reports\Types;

use Domain\Reports\Enums\States;
use Domain\Supplies\Models\SupplyRequest;
use Domain\Supplies\Models\SupplyRequestItem;
use Illuminate\Support\Collection;

class SupplyRequestRawDataReport extends GeneratorAbstract
{
    public function build(): void
    {
        $parameters = $this->getParameters();

        $this->report->markStatus(States::GENERATING);

        $filename = $this->createTempFile();

        $file = $this->file;

        $file->fputcsv([
            "ID",
            "REQUESTER",
            "STATUS",
            "REMARKS",
            "NOTE",
            "APPROVED AT",
            "APPROVER",
            "DENIED AT",
            "DENIER",
            "FULFILLED AT",
            "FULFILLER",
            "CREATED_AT",
            "SUPPLY NAME",
            "SUPPLY QUANTITY",
            "SUPPLY PURPOSE",
        ]);

        SupplyRequest::query()
            ->with([
                'requester',
                'approver',
                'denier',
                'fulfiller',
                'items',
            ])
            ->where('created_at', '>=', $parameters['from_date'] . ' ' . $parameters['from_time'])
            ->where('created_at', '<=', $parameters['to_date'] . ' ' . $parameters['to_time'])
            ->chunk(500, function (Collection $supplyRequests) use ($file) {
                /** @var SupplyRequest $supplyRequest */
                foreach ($supplyRequests as $supplyRequest) {
                    /** @var SupplyRequestItem $item */
                    foreach ($supplyRequest->items as $item) {
                        $file->fputcsv([
                            "ID" => $supplyRequest->id,
                            "REQUESTER" => $supplyRequest->requester->name,
                            "STATUS" => $supplyRequest->status->name,
                            "REMARKS" => $supplyRequest->remarks,
                            "NOTE" => $supplyRequest->note,
                            "APPROVED AT" => $supplyRequest->approved_at,
                            "APPROVER" => $supplyRequest->approver?->name,
                            "DENIED AT" => $supplyRequest->denied_at,
                            "DENIER" => $supplyRequest->denier?->name,
                            "FULFILLED AT" => $supplyRequest->fulfilled_at,
                            "FULFILLER" => $supplyRequest->fulfiller?->name,
                            "CREATED_AT" => $supplyRequest->created_at,
                            "SUPPLY NAME" => $item->name,
                            "SUPPLY QUANTITY" => $item->quantity,
                            "SUPPLY PURPOSE" => $item->purpose,
                        ]);
                    }
                }
            });

        $this->setRealFile($file, $filename);
    }

    public function getParameters(): array
    {
        $parameters = $this->report->parameters;

        return [
            'from_date' => $parameters['from_date'] ?? '',
            'from_time' => $parameters['from_time'] ?? '',
            'to_date' => $parameters['to_date'] ?? '',
            'to_time' => $parameters['to_time'] ?? '',
        ];
    }
}
