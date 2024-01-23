<?php

namespace App\Listeners;

use App\Events\SupplyRequestCreated;
use App\Models\User;
use App\Notifications\NewSupplyRequestNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendNewSupplyRequestNotification implements ShouldQueue
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
    public function handle(SupplyRequestCreated $event): void
    {
        $users = User::role('Supplies Approver')->get();

        Notification::send($users, new NewSupplyRequestNotification($event->supplyRequest));
    }
}
