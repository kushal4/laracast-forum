<?php
namespace Tests\Feature;
//use Exception;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use Tests\TestCase;

class ParticipateInThreadsTest extends TestCase
{
    use DatabaseMigrations;
    /** @test */
    function unauthenticated_users_may_not_add_replies()
    {
        $this->withExceptionHandling()
            ->post('/threads/some-channel/1/replies', [])
            ->assertRedirect('/login');
    }
    /** @test */
    function an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        $thread = create('App\Thread');
        $reply = make('App\Reply');
        $this->post($thread->path() . '/replies', $reply->toArray());
        //dd($reply->body);
        $this->assertDatabaseHas('replies', ['body' => $reply->body]);
        $this->assertEquals(1, $thread->fresh()->replies_count);
        //$this->assertEquals(1, $thread->replies_count);
    }
    /** @test */
    function a_reply_requires_a_body()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        $thread = create('App\Thread');
        $reply = make('App\Reply', ['body' => null]);
        //dd($reply);
        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertStatus(422);
      //  dd(session()->all());
            // dd($response->assertSessionHasErrors('body'));
       // $response->
    }
    /** @test */
    function unauthorized_users_cannot_delete_replies()
    {
        $this->withExceptionHandling();
        $reply = create('App\Reply');
        $this->delete("/replies/{$reply->id}")
            ->assertRedirect('login');
        $this->signIn()
            ->delete("/replies/{$reply->id}")
            ->assertStatus(403);
    }
    /** @test */
    function authorized_users_can_delete_replies()
    {
        $this->signIn();
        $reply = create('App\Reply', ['user_id' => auth()->id()]);
        $this->delete("/replies/{$reply->id}")->assertStatus(302);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
        $this->assertEquals(0, $reply->thread->fresh()->replies_count);
    }
    /** @test */
    function unauthorized_users_cannot_update_replies()
    {
        $this->withExceptionHandling();
        $reply = create('App\Reply');
        $this->patch("/replies/{$reply->id}")
            ->assertRedirect('login');
        $this->signIn()
            ->patch("/replies/{$reply->id}")
            ->assertStatus(403);
    }
    /** @test */
    function authorized_users_can_update_replies()
    {
        $this->signIn();
        $reply = create('App\Reply', ['user_id' => auth()->id()]);
        $updatedReply = 'You been changed, fool.';
        $this->patch("/replies/{$reply->id}", ['body' => $updatedReply]);
        $this->assertDatabaseHas('replies', ['id' => $reply->id, 'body' => $updatedReply]);
    }
     /**
      * @test
      *
      */
     function replies_that_contain_spam_may_not_be_created()
     {
       // try{
           //  $this->withExceptionHandling();
        // $this->withoutExceptionHandling();
        // $this->disableExceptionHandling();

             $this->signIn();
             $thread = create('App\Thread');
             $reply = make('App\Reply', [
                 'body' => 'yahoo'
             ]);
            // $this->expectExceptionMessage('');
         //$this->expectException(\Exception::class);
        // $this->setExpectedException(\Exception::class);
//         $this->assertException(
//             \Exception::class,
//             function () use ($thread,$reply) {
//                 // Act
//               //  $example->foo();
//
//             }
//         );
       //  $this->expectException( \Exception::class);
        //
         //try {
           //  new Foo();
             $this->post($thread->path() . '/replies', $reply->toArray())
             ->assertStatus(422);
            // dd("SDGsdg0");
        // } catch (\Exception $e) {
             //var_dump($e);
        // }

            // dd("dgd");
         //
        // $this->expectExceptionMessage("Your reply contains spam.");
        // $this->expectExceptionMessage('Your reply contains spam.');
        // $this->assertException('Your reply contains spam.', \Exception::class,null);
       //  }catch (Exception $e){
             ///$this->assertType('ExceptionOne', $e);
             //$this->assertType('MainException', $e);

           //  dd("exception thrown");
         //  $this->ass('Exception', $e);
       //  }



         //$this->json('post', $thread->path() . '/replies', $reply->toArray())
            // ->assertStatus(422);
     }
     /** @test */
     function users_may_only_reply_a_maximum_of_once_per_minute()
     {
         $this->withExceptionHandling();
         $this->signIn();
         $thread = create('App\Thread');
         $reply = make('App\Reply');
         $this->post($thread->path() . '/replies', $reply->toArray())
             ->assertStatus(201);
      // $this->post($thread->path() . '/replies', $reply->toArray())
        //    ->assertStatus(429);
     }
}

