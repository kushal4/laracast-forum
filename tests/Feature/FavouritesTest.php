<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FavouritesTest extends TestCase
{

    use DatabaseMigrations;

    /**
     * @test
     */

    public function  guest_cant_favourite_anything(){
        $this->withExceptionHandling()
            ->post('replies/1/favorites')
            ->assertRedirect('/login');
       //$this->post('/replies/1/favourites')->assertRedirect()->guest('/login');
    }

    /**
     *
     *
     * @test
     */
    public function an_auth_user_post_replies()
    {
        $this->signIn();
        $reply = create('App\Reply');
        $this->post('replies/' . $reply->id . '/favorites');
        //dd($reply->favourites);
        $this->assertCount(1, $reply->favourites);
    }

    /**
     * @test
     */

    public function an_auth_user_can_fav_reply_once(){
        $this->signIn();
        $reply = create('App\Reply');
        $this->post('replies/' . $reply->id . '/favorites');
        $this->post('replies/' . $reply->id . '/favorites');
        //dd($reply->favourites);
        $this->assertCount(1, $reply->favourites);
    }

    /**
     * @test
     */

    function auth_usr_can_fav_reply(){
        $this->withoutExceptionHandling();
        $this->signIn();
        $reply = create('App\Reply');
        $this->post('replies/' . $reply->id . '/favorites');
        $this->assertCount(1,$reply->favourites);
        $this->delete('replies/' . $reply->id . '/favorites');
        $this->assertCount(0,$reply->fresh()->favourites);

    }
}
