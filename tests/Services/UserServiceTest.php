<?php

use App\Models\User;
use App\Models\Event;
use App\Services\UserService\UserService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Event as EventFacade;
use App\Events\NewUserEvent;

class UserServiceTest extends TestCase
{
	public function setUp(): void
	{
		parent::setUp();
		
		$this->users = Mockery::mock(User::class);
		$this->events = Mockery::mock(Event::class);
		
		$this->userService = new UserService($this->users, $this->events);
	}
	
	public function tearDown(): void
	{
		parent::tearDown();
		Mockery::close();
	}
	
	public function testGetUserListByEventAll()
	{
		$this->users
			->shouldReceive('all')
			->andReturn(collect([]));
			
		$users = $this->userService->getUserListByEvent('');
		$this->assertInstanceOf(Collection::class, $users);
	}
	
	public function testGetUserListByEventFilter()
	{
		$this->events
			->shouldReceive('find')
			->andReturn($this->users);
		$this->users
			->shouldReceive('getAttribute')
			->andReturn(collect([]));
		
		$users = $this->userService->getUserListByEvent('1');
		$this->assertInstanceOf(Collection::class, $users);
	}
	
	public function testLogIn()
	{
		Hash::shouldReceive('check')
			->andReturn(true);
		
		$this->users
			->shouldReceive('where')
			->andReturn($this->users);
		$this->users
			->shouldReceive('update')
			->shouldReceive('first')
			->andReturn($this->users);
		$this->users
			->shouldReceive('getAttribute')
			->andReturn('password');
		
		$token = $this->userService->logIn(['email' => '', 'password' => '']);
		$this->assertNotEquals('', $token);
	}
	
	public function testNewUser()
	{
		$this->users
			->shouldReceive('create')
			->andReturn($this->users);
		
		EventFacade::fake();
		
		$user = $this->userService->newUser([]);
		
		EventFacade::assertDispatched(NewUserEvent::class, function($e) {
			return true;
		});
		
		$this->assertEquals($this->users, $user);
	}
}
