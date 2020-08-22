<?php

namespace App\Services\UserService;

use App\Models\User;
use App\Models\Event;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Events\NewUserEvent;

class UserService implements UserServiceInterface
{

    /**
     *
     * @var User
     */
    private $users;

    /**
     *
     * @var Event
     */
    private $events;

    public function __construct(User $userModel, Event $eventModel)
    {
        $this->users = $userModel;
        $this->events = $eventModel;
    }

    /**
     *
     * {@inheritdoc}
     * @see \App\Services\UserService\UserServiceInterface::getUserListByEvent()
     */
    public function getUserListByEvent(string $eventId): Collection
    {
        if (empty($eventId)) {
            return $this->users->all();
        } else {
            return $this->events->find($eventId)->users;
        }
    }

    /**
     *
     * {@inheritdoc}
     * @see \App\Services\UserService\UserServiceInterface::logIn()
     */
    public function logIn(array $input): string
    {
        $user = $this->users->where('email', $input['email'])->first();

        if (is_null($user)) {
            return '';
        }

        if (Hash::check($input['password'], $user->password)) {
            $newToken = base64_encode(Str::random(40));
            $this->users->where('email', $input['email'])->update([
                'api_token' => $newToken
            ]);

            return $newToken;
        } else {
            return '';
        }
    }

    /**
     *
     * {@inheritdoc}
     * @see \App\Services\UserService\UserServiceInterface::newUser()
     */
    public function newUser(array $input)
    {
        $input['api_token'] = base64_encode(Str::random(40));
        $user = $this->users->create($input);
        event(new NewUserEvent($user));

        return $user;
    }
}
