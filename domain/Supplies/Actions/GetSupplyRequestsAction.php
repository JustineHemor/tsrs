<?php

namespace Domain\Supplies\Actions;

use Domain\Supplies\Data\GetSupplyRequestsData;
use Domain\Supplies\Models\SupplyRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class GetSupplyRequestsAction
{
    public function __invoke(GetSupplyRequestsData $data)
    {
        if (Auth::user()->can('view-all-supplies-requests')) {
            return $this->tripApproverIndex($data);
        }

        return $this->tripRequesterIndex($data);
    }

    private function tripApproverIndex(GetSupplyRequestsData $data): LengthAwarePaginator
    {
        return SupplyRequest::query()
            ->with([
                'requester',
                'items',
            ])
            ->when($data->requester_id, function (Builder $query, string $requester_id) {
                $query->where('requester_id', $requester_id);
            })
            ->when($data->status, function (Builder $query, string $status) {
                $query->where('status', $status);
            })
            ->when($data->supply_request_id, function (Builder $query, string $trip_ticket_id) {
                $query->where('id', $trip_ticket_id);
            })
            ->latest()
            ->paginate(20);
    }

    private function tripRequesterIndex(GetSupplyRequestsData $data): LengthAwarePaginator
    {
        return SupplyRequest::query()
            ->with([
                'requester',
                'items',
            ])
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
