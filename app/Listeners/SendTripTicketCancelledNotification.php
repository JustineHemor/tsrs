<?php

namespace App\Listeners;

use App\Events\TripTicketCancelled;
use App\Models\User;
use App\Notifications\TripTicketCancelledNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendTripTicketCancelledNotification implements ShouldQueue
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
    public function handle(TripTicketCancelled $event): void
    {
        $users = User::role('Trip Approver')->get();

        Notification::send($users, new TripTicketCancelledNotification($event->tripTicket));
    }
}
