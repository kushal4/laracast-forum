<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class SubscribeToThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */

    function a_user_sub_to_threads(){

        $this->withoutExceptionHandling();
        $this->signIn();
        $thread=create("App\Thread");
        $this->post($thread->path()."/subscriptions");


        $this->assertCount(1,$thread->subscriptions);
//        $thread->addReply(
//            ['user_id'=>auth()->id(),
//                "body"=>"some repl body"
//            ]
//        );
//        $this->assertCount(1,auth()->user()->notifications);
    }

    /**
     * @test
     */
    function usr_unsub_from_threads(){
        $this->withoutExceptionHandling();
        $this->signIn();
        $thread=create("App\Thread");
        $thread->subscribed();
        $this->delete($thread->path()."/subscriptions");
        $this->assertCount(0,$thread->subscriptions);
    }



}
