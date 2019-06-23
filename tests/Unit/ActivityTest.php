<?php

namespace Tests\Feature;

use App\Activity;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ActivityTest extends TestCase
{

    use DatabaseMigrations;

    /**
     *
     *
     * @test
     */
    public function it_records_actvity_whn_thread_created()
    {
        $this->signIn();

        $thread=create('App\Thread');

        $this->assertDatabaseHas("activities",[
            "type"=>"created_thread",
            "user_id"=>auth()->id(),
            "subject_id"=>$thread->id,
            "subject_type"=>"App\Thread"
        ]);
        $activity=Activity::first();
        $this->assertEquals($activity->subject->id,$thread->id);
    }

    /**
     * @test
     */

    public function it_records_actvity_whn_reply_created(){

        $this->signIn();
        $reply=create('App\Reply');
        $this->assertEquals(2,Activity::count());

    }

    /**
     * @test
     */

    public function it_fetches_feed_for_any_usr(){
        //we have user now
        $this->signIn();

        //Add another thread week ago
        create('App\Thread',[
            'user_id'=>auth()->id(),
            'created_at'=>Carbon::now()->subWeek()]
            );
        $feed=Activity::feed(auth()->user());

        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->format('Y-m-d')
        ));
    }
}

