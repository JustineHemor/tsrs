<?php

namespace App\Listeners;

use App\Events\NewTripTicketCreated;
use App\Models\User;
use App\Notifications\NewTripTicketNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendNewTripTicketNotification implements ShouldQueue
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
    public function handle(NewTripTicketCreated $event): void
    {
        $users = User::role('Trip Approver')->get();

        Notification::send($users, new NewTripTicketNotification($event->tripTicket));
    }
}
