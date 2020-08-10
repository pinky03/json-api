<?php 

use App\Models\Event;
use App\Models\User;

class UserControllerTest extends TestCase
{
	private $dummyUser = [
		'name' => 'test',
		'email' => 'test@test.com',
		'password' => 'test',
		'event_id' => 1,
	];
	
	public function setUp():void
	{
		parent::setUp();
		
		$this->users = Mockery::mock(User::class);
		$this->app->instance(User::class, $this->users);
		
		$this->events = Mockery::mock(Event::class);
		$this->app->instance(Event::class, $this->events);
	}
	
	public function testIndex()
	{
		// get all members
		$this->users
			->shouldReceive('all')
			->andReturn([]);
		
		$this->get('/users');
		
		$this->seeJsonEquals([
			'status' => 'ok',
			'data' => [],
		]);
		
		// filter members by event
		$this->events
			->shouldReceive('find')
			->andReturn($this->events);
		$this->events
			->shouldReceive('getAttribute')
			->andReturn([]);
		
		$this->get('/users?event=1');
		
		$this->seeJsonEquals([
			'status' => 'ok',
			'data' => [],
		]);
	}
	
	public function testShow()
	{
		$this->users
			->shouldReceive('findOrFail')
			->andReturn('user');
		
		$this->get('/users/1');
		
		$this->seeJsonEquals([
			'status' => 'ok',
			'data' => 'user',
		]);
	}
	
	public function testStore()
	{
		$this->users
			->shouldReceive('create')
			->andReturn('user');
		
		$this->put('/users', $this->dummyUser);
		
		$this->seeJsonEquals([
			'status' => 'ok',
			'data' => 'user',
		]);
	}
	
	public function testUpdate()
	{
		$this->users
			->shouldReceive('find')
			->andReturn($this->users);
		$this->users
			->shouldReceive('update');
		
		$this->post('/users/1', $this->dummyUser);
		
		$this->seeJsonEquals([
			'status' => 'ok',
		]);
	}
	
	public function testDestroy()
	{
		$this->users
			->shouldReceive('findOrFail')
			->andReturn($this->users);
		$this->users
			->shouldReceive('delete');
		
		$this->delete('/users/1');
		
		$this->seeJsonEquals([
			'status' => 'ok',
		]);
	}
}
