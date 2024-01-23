<?php

namespace Domain\Supplies\StateMachines\Base;

use Domain\Supplies\Models\SupplyRequest;
use Domain\Supplies\StateMachines\Exceptions\InvalidStateActionException;

class BaseSupplyRequestState implements SupplyRequestStateContract
{
    public function __construct(public SupplyRequest $supplyRequest)
    {
    }

    public function initialize()
    {
        throw new InvalidStateActionException();
    }

    public function approve(int $approver_id)
    {
        throw new InvalidStateActionException();
    }

    public function deny(int $denier_id)
    {
        throw new InvalidStateActionException();
    }

    public function fulfill(int $fulfiller_id)
    {
        throw new InvalidStateActionException();
    }
}
