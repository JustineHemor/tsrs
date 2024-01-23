<?php

namespace App\Listeners;

use App\Events\SupplyRequestFulfilled;
use App\Notifications\SupplyRequestFulfilledNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendSupplyRequestFulfilledNotification implements ShouldQueue
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
    public function handle(SupplyRequestFulfilled $event): void
    {
        Notification::send($event->supplyRequest->requester, new SupplyRequestFulfilledNotification($event->supplyRequest));
    }
}
