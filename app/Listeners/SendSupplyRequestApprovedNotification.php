<?php

namespace App\Listeners;

use App\Events\SupplyRequestApproved;
use App\Notifications\SupplyRequestApprovedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendSupplyRequestApprovedNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SupplyRequestApproved $event): void
    {
        Notification::send($event->supplyRequest->requester, new SupplyRequestApprovedNotification($event->supplyRequest));
    }
}
