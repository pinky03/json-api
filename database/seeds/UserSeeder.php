<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Event;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$eventsCount = Event::all('id')->count();
    	
    	factory(User::class, 150)->make()->each(function ($user) use($eventsCount) {
    		$user->event_id = rand(1, $eventsCount);
    		$user->save();
    	});
    	
    	$this->addTestUser();
    	
    }
    
    public function addTestUser()
    {
    	$testUser = factory(User::class)->make();
    	$testUser->event_id = 1;
    	$testUser->name = env('TEST_USER_NAME', 'test');
    	$testUser->email = env('TEST_USER_EMAIL', 'test@test.com');
    	$testUser->password = Hash::make(
    		env('TEST_USER_PASSWORD', 'test')
    	);
    	$testUser->save();
    }
}
