<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReplyTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testit_has_owner_inst(){
        $reply=factory('App\Reply')->create();
        $this->assertInstanceOf('App\User',$reply->owner);
    }

    /**
     * @test
     */
    function it_knows_if_just_publshed(){


        $reply=factory('App\Reply')->create();

        $this->assertTrue($reply->wasJustPublished());
        $reply->created_at=Carbon::now()->subMonth();
        $this->assertFalse($reply->wasJustPublished());
    }

    /**
     * @test
     *
     */
    function it_can_detct_all_mentioned_usrs(){

        $reply=make("App\Reply",
            [
                "body"=>"@JohnDoe tells to @JaneDoe"
            ]);
        $this->assertEquals(["JohnDoe","JaneDoe"],$reply->mentionedUsers());

    }

    /**
     * @test
     */
    function it_wraps_usernames_withn_body_withancor_tags(){

        $reply=new \App\Reply(
            [
                "body"=>"Hello @JaneDoe."
            ]);
        $this->assertEquals(
            'Hello <a href="/profiles/JaneDoe">@JaneDoe</a>.',
            $reply->body
        );
    }
}
