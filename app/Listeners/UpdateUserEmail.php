<?php

namespace App\Listeners;

use App\Actions\User\UpdateUserEmail as UpdateUserEmailAlias;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use SocialiteProviders\Teleserv\Events\UserLoggedIn;

class UpdateUserEmail implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct(public UpdateUserEmailAlias $updateUserEmail)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserLoggedIn $event): void
    {
        ($this->updateUserEmail)(
            user_id: $event->user->id,
            user_email: $event->user->email,
        );
    }
}
