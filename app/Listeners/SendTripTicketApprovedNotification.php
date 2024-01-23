<?php

namespace App\Listeners;

use App\Events\TripTicketApproved;
use App\Notifications\TripTicketApprovedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendTripTicketApprovedNotification implements ShouldQueue
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
    public function handle(TripTicketApproved $event): void
    {
        Notification::send($event->tripTicket->requester, new TripTicketApprovedNotification($event->tripTicket));
    }
}
