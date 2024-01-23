<?php

namespace Domain\TripTickets\Enums;

enum Status: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case DENIED = 'denied';
    case CANCELLED = 'cancelled';
}
