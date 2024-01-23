<?php

namespace Domain\Supplies\StateMachines;

use App\Events\SupplyRequestApproved;
use App\Events\SupplyRequestDenied;
use Carbon\Carbon;
use Domain\Supplies\Enums\Status;
use Domain\Supplies\StateMachines\Base\BaseSupplyRequestState;

class Pending extends BaseSupplyRequestState
{
    public function approve(int $approver_id): void
    {
        $this->supplyRequest->status = Status::APPROVED;
        $this->supplyRequest->approved_at = Carbon::now();
        $this->supplyRequest->approver_id = $approver_id;
        $this->supplyRequest->save();

        SupplyRequestApproved::dispatch($this->supplyRequest);
    }

    public function deny(int $denier_id): void
    {
        $this->supplyRequest->status = Status::DENIED;
        $this->supplyRequest->denied_at = Carbon::now();
        $this->supplyRequest->denier_id = $denier_id;
        $this->supplyRequest->save();

        SupplyRequestDenied::dispatch($this->supplyRequest);
    }
}
