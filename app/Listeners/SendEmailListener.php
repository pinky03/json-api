<?php

namespace App\Listeners;

use App\Events\NewUserEvent;
use App\Jobs\SendEmail;

class SendEmailListener
{

    /**
     * Handle the event.
     *
     * @param \App\Events\ExampleEvent $event
     * @return void
     */
    public function handle(NewUserEvent $event)
    {
        $email = $event->user->email;
        dispatch(new SendEmail($email));
    }
}
