<?php

namespace Domain\Supplies\Enums;

enum Status: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case DENIED = 'denied';
    case FULFILLED = 'fulfilled';
}
