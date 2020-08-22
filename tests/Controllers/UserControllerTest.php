<?php
use App\Models\User;
use App\Services\UserService\UserServiceInterface;

class UserControllerTest extends TestCase
{

    private $dummyUser = [
        'name' => 'dummy',
        'email' => 'dummy@test.com',
        'password' => 'dummy',
        'event_id' => 1
    ];

    public function setUp(): void
    {
        parent::setUp();

        $this->users = Mockery::mock(User::class);
        $this->app->instance(User::class, $this->users);

        $this->userService = Mockery::mock(UserServiceInterface::class);
        $this->app->instance(UserServiceInterface::class, $this->userService);
    }

    public function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }

    public function testLogin()
    {
        $this->userService->shouldReceive('logIn')->andReturn('token');

        $this->post('/login', [
            'email' => $this->dummyUser['email'],
            'password' => $this->dummyUser['password']
        ]);

        $this->seeJsonEquals([
            'status' => 'ok',
            'api_token' => 'token'
        ]);
    }

    public function testIndex()
    {
        $this->userService->shouldReceive('getUserListByEvent')->andReturn(collect([]));

        $this->get('/users');

        $this->seeJsonEquals([
            'status' => 'ok',
            'data' => []
        ]);

        $this->get('/users?event=1');

        $this->seeJsonEquals([
            'status' => 'ok',
            'data' => []
        ]);
    }

    public function testShow()
    {
        $this->users->shouldReceive('findOrFail')->andReturn('user');

        $this->get('/users/1');

        $this->seeJsonEquals([
            'status' => 'ok',
            'data' => 'user'
        ]);
    }

    public function testStore()
    {
        $this->userService->shouldReceive('newUser')->andReturn('user');

        $this->put('/users', $this->dummyUser);

        $this->seeJsonEquals([
            'status' => 'ok',
            'data' => 'user'
        ]);
    }

    public function testUpdate()
    {
        $this->users->shouldReceive('find')->andReturn($this->users);
        $this->users->shouldReceive('update');

        $this->post('/users/1', $this->dummyUser);

        $this->seeJsonEquals([
            'status' => 'ok'
        ]);
    }

    public function testDestroy()
    {
        $this->users->shouldReceive('findOrFail')->andReturn($this->users);
        $this->users->shouldReceive('delete');

        $this->delete('/users/1');

        $this->seeJsonEquals([
            'status' => 'ok'
        ]);
    }
}
