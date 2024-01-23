<?php

namespace App\Listeners;

use App\Events\TripTicketDenied;
use App\Notifications\TripTicketDeniedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendTripTicketDeniedNotification implements ShouldQueue
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
    public function handle(TripTicketDenied $event): void
    {
        Notification::send($event->tripTicket->requester, new TripTicketDeniedNotification($event->tripTicket));
    }
}
