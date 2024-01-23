<?php

namespace Domain\Supplies\StateMachines\Base;

interface SupplyRequestStateContract
{
    public function initialize();
    public function approve(int $approver_id);
    public function deny(int $denier_id);
    public function fulfill(int $fulfiller_id);
}
