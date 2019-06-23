<?php

namespace Tests\Feature;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Notifications\DatabaseNotification;
use Tests\TestCase;
class NotificationsTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->signIn();
    }

    /** @test */
    function a_notification_is_prepared_when_a_subscribed_thread_receives_a_new_reply_that_is_not_by_the_current_user()
    {
        //create(DatabaseNotification::class);
        $thread = create('App\Thread')->subscribed();
        $this->assertCount(0, auth()->user()->notifications);
        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => 'Some reply here'
        ]);
        $this->assertCount(0, auth()->user()->fresh()->notifications);
        $thread->addReply([
            'user_id' => create('App\User')->id,
            'body' => 'Some reply here'
        ]);
        $this->assertCount(1, auth()->user()->fresh()->notifications);
    }

    /**
     * @test
     */

    function a_user_can_fetch_unread_notfction(){
create(DatabaseNotification::class);
//        $thread = create('App\Thread')->subscribed();
//        $thread->addReply([
//            'user_id' => create('App\User')->id,
//            'body' => 'Some reply here'
//        ]);
        $user=auth()->user();
      // $response= $this->getJson("/profiles/{$user->name}/notifications");
       //$this->assertCount(1,$response);
        $this->assertCount(
            1,
            $this->getJson("/profiles/" . auth()->user()->name . "/notifications")->json()
        );
    }

    /**
     * @test
     */
function  a_user_can_mark_notfction_read(){

    create(DatabaseNotification::class);
//    $thread = create('App\Thread')->subscribed();
//    $thread->addReply([
//        'user_id' => create('App\User')->id,
//        'body' => 'Some reply here'
//    ]);
    //dd($thread->replies);
//    $this->assertCount(1, auth()->user()->unreadNotifications);
//    $notificationId=auth()->user()->unreadNotifications->first()->id;
//
//
//    $this->delete("/profiles/".auth()->user()->name."/notifications/{$notificationId}");

    tap(auth()->user(), function ($user) {
        $this->assertCount(1, $user->unreadNotifications);
        $this->delete("/profiles/{$user->name}/notifications/" . $user->unreadNotifications->first()->id);
        $this->assertCount(0, $user->fresh()->unreadNotifications);
    });
}

}
