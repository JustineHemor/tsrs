<?php

namespace Domain\Reports\Enums;

enum States: string
{
    case PENDING = 'pending';
    case GENERATING = 'generating';
    case DONE = 'done';
    case FAILED = 'failed';
}
