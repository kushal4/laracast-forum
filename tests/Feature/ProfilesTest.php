<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProfilesTest extends TestCase
{

    use DatabaseMigrations;

    /**
     *
     *
     * @test
     */
    public function a_user_has_profile()
    {
        $this->withoutExceptionHandling();
        $user=create('App\User');
        $this->get("/profiles/{$user->name}")
        ->assertSee($user->name);
        
    }

    /**
     * @test
     */

    public function profiles_get_all_assc_threads(){
        $this->withoutExceptionHandling();
        $this->signIn();
       // $user=create('App\User');

        $thread=create('App\Thread',['user_id'=>auth()->id()]);
        $this->get("/profiles/".auth()->user()->name)
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}

