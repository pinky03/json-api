<?php 

namespace App\Services\UserService;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserServiceInterface
{
	/**
	 *
	 *
	 * @param string $eventId
	 * @return Collection
	 */
	public function getUserListByEvent(string $eventId): Collection;
	
	/**
	 * Return API token where user matches.
	 * 
	 * @param array $input
	 * @return string
	 */
	public function logIn(array $input): string;
	
	/**
	 * 
	 * 
	 * @param array $input
	 * @return User
	 */
	public function newUser(array $input): User;
	
}