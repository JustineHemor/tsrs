<?php

namespace Domain\TripTickets\Actions;

use Domain\TripTickets\Data\GetTripTicketsData;
use Domain\TripTickets\Models\TripTicket;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class GetTripTicketsAction
{
    public function __invoke(GetTripTicketsData $data): LengthAwarePaginator
    {
        if (Auth::user()->can('view-all-trip-ticket')) {
            return $this->tripApproverIndex($data);
        }

        return $this->tripRequesterIndex($data);
    }

    private function tripApproverIndex(GetTripTicketsData $data): LengthAwarePaginator
    {
        return TripTicket::query()
            ->with('requester')
            ->when($data->requester_id, function (Builder $query, string $requester_id) {
                $query->where('requester_id', $requester_id);
            })
            ->when($data->status, function (Builder $query, string $status) {
                $query->where('status', $status);
            })
            ->when($data->trip_ticket_id, function (Builder $query, string $trip_ticket_id) {
                $query->where('id', $trip_ticket_id);
            })
            ->latest()
            ->paginate(20);
    }

    private function tripRequesterIndex(GetTripTicketsData $data): LengthAwarePaginator
    {
        return TripTicket::query()
            ->with('requester')
            ->when($data->requester_id, function (Builder $query, string $requester_id) {
                $query->where('requester_id', $requester_id);
            })
            ->when($data->status, function (Builder $query, string $status) {
                $query->where('status', $status);
            })
            ->where('requester_id', Auth::id())
            ->latest()
            ->paginate(20);
    }
}
