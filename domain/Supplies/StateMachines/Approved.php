<?php

namespace Domain\Supplies\StateMachines;

use App\Events\SupplyRequestFulfilled;
use Carbon\Carbon;
use Domain\Supplies\Enums\Status;
use Domain\Supplies\StateMachines\Base\BaseSupplyRequestState;

class Approved extends BaseSupplyRequestState
{
    public function fulfill(int $fulfiller_id): void
    {
        $this->supplyRequest->status = Status::FULFILLED;
        $this->supplyRequest->fulfilled_at = Carbon::now();
        $this->supplyRequest->fulfiller_id = $fulfiller_id;
        $this->supplyRequest->save();

        SupplyRequestFulfilled::dispatch($this->supplyRequest);
    }
}
