<?php

namespace App\Listeners;

use App\Events\SupplyRequestDenied;
use App\Notifications\SupplyRequestDeniedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendSupplyRequestDeniedNotification implements ShouldQueue
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
    public function handle(SupplyRequestDenied $event): void
    {
        Notification::send($event->supplyRequest->requester, new SupplyRequestDeniedNotification($event->supplyRequest));
    }
}
