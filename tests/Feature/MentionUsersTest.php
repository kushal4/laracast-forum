<?php

namespace Tests\Feature;


use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MentionUsersTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    function mentiond_usr_in_reply_tobe_notified(){
        $john = create('App\User', ['name' => 'JohnDoe']);
        $this->signIn($john);
        // And we also have a user, JaneDoe.
        $jane = create('App\User', ['name' => 'JaneDoe']);
        // If we have a thread
        $thread = create('App\Thread');
        // And JohnDoe replies to that thread and mentions @JaneDoe.
        $reply = make('App\Reply', [
            'body' => 'Hey @JaneDoe check this out.'
        ]);
        $this->json('post', $thread->path() . '/replies', $reply->toArray());
        // Then @JaneDoe should receive a notification.
        $this->assertCount(1, $jane->notifications);
    }

    /**
     * @test
     */
    function it_can_fetch_mentioned_usrs_withgiven_chars(){
        create("App\User",["name"=>"johndoe"]);
        create("App\User",["name"=>"jandoe"]);
        create("App\User",["name"=>"johndoe2"]);
       $results= $this->json('GET','api/users',["name"=>"john"]);
       $this->assertCount(2,$results->json());

    }


}
