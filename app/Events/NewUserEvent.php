<?php

namespace App\Events;

use App\Models\User;

class NewUserEvent extends Event
{

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}