<?php

namespace Domain\Reports\Types;

use Domain\Reports\Enums\States;
use Domain\TripTickets\Models\TripTicket;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class TripTicketRawDataReport extends GeneratorAbstract
{
    public function build(): void
    {
        $parameters = $this->getParameters();

        $this->report->markStatus(States::GENERATING);

        $filename = $this->createTempFile();

        $file = $this->file;

        $file->fputcsv([
            "REQUESTER",
            "STATUS",
            "CONTACT PERSON",
            "CONTACT NUMBER",
            "ORIGIN",
            "ORIGIN DATETIME",
            "DROP OFF",
            "DROP OFF DATETIME",
            "PICK UP",
            "PICK UP DATETIME",
            "PASSENGER COUNT",
            "VEHICLE",
            "DRIVER",
            "PURPOSE",
            "REMARKS",
            "APPROVED AT",
            "DENIED AT",
            "CANCELLED AT",
            "APPROVER",
            "DENIER",
            "CREATED AT",
        ]);

        TripTicket::query()
            ->with([
                'requester',
                'driver',
                'vehicle',
                'approver',
                'denier',
            ])
            ->where('created_at', '>=', $parameters['from_date'] . ' ' . $parameters['from_time'])
            ->where('created_at', '<=', $parameters['to_date'] . ' ' . $parameters['to_time'])
            ->chunk(500, function (Collection $tripTickets) use ($file) {
                /** @var TripTicket $tripTicket */
                foreach ($tripTickets as $tripTicket) {
                    $file->fputcsv([
                        "REQUESTER" => $tripTicket->requester->name,
                        "STATUS" => $tripTicket->status->name,
                        "CONTACT PERSON" => $tripTicket->contact_person,
                        "CONTACT NUMBER" => $tripTicket->contact_number,
                        "ORIGIN" => Str::squish($tripTicket->origin),
                        "ORIGIN DATETIME" => $tripTicket->origin_datetime,
                        "DROP OFF" => Str::squish($tripTicket->drop_off),
                        "DROP OFF DATETIME" => $tripTicket->origin_datetime,
                        "PICK UP" => Str::squish($tripTicket->pick_up),
                        "PICK UP DATETIME" => $tripTicket->pick_up_datetime,
                        "PASSENGER COUNT" => $tripTicket->passenger_count,
                        "VEHICLE" => $tripTicket->vehicle?->name,
                        "DRIVER" => $tripTicket->driver ? $tripTicket->driver->name . ' (' . $tripTicket->driver->nickname . ')' : '',
                        "PURPOSE" => $tripTicket->purpose,
                        "REMARKS" => $tripTicket->remarks,
                        "APPROVED AT" => $tripTicket->approved_at,
                        "DENIED AT" => $tripTicket->denied_at,
                        "CANCELLED AT" => $tripTicket->cancelled_at,
                        "APPROVER" => $tripTicket->approver?->name,
                        "DENIER" => $tripTicket->denier?->name,
                        "CREATED AT" => $tripTicket->created_at,
                    ]);
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
