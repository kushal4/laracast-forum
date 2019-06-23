<?php
namespace Tests\Unit;


use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;



class UserTest extends TestCase
{

    use DatabaseMigrations;
    /**
     * @test
     */

    function a_usr_can_fetch_most_rcnt_reply(){
        $user=create("App\User");
        $reply = create('App\Reply', ['user_id' => $user->id]);
        $this->assertEquals($reply->id, $user->lastReply->id);
    }

    /**
     * @test
     */


}
