<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateThreadsTest extends TestCase
{
    /**
     * @test
     */

    public  function  guest_may_not_create_threads(){
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->withoutExceptionHandling();
        $thread=make('App\Thread');
       // dd($thread);
        $this->post('/threads',$thread->toArray());
        $response = $this->get($thread->path());
        //We should see the new Thread

        $response->assertSee($thread->title)
            ->assertSee($thread->body);
    }


   /**
    * @test
    */

   use DatabaseMigrations;
   public function an_authenticated_user_can_create_threads(){
       //Given signed user
      // $this->withoutExceptionHandling();

     //  $this->actingAs(create('App\User'));
       $this->signIn();

       // when we hit the endpoint
       //$thread=create('App\Thread');
       $thread=make('App\Thread');
       //dd($thread);
      $response= $this->post('/threads',$thread->toArray());
    // dd($response->headers->get('Location'));
       //Then, When we hit the Thread page
       $this->get($response->headers->get('Location'))
           ->assertSee($thread->title)
           ->assertSee($thread->body);
       //$response = $this->get($thread->path());
       //We should see the new Thread

       //$response->assertSee($thread->title)
        //   ->assertSee($thread->body);
   }

    /**
     * @test
     */
    public function a_thread_canbe_deleted(){
        $this->signIn();
        $thread=create('App\Thread',["user_id"=>auth()->id()]);
        $reply=create('App\Reply',['thread_id'=>$thread->id]);
        $response=$this->json('DELETE',$thread->path());
        $response->assertStatus(204);
        $this->assertDatabaseMissing('threads',['id'=>$thread->id]);
        $this->assertDatabaseMissing('replies',['id'=>$reply->id]);
        $this->assertDatabaseMissing('activities',
            ['id'=>$thread->id,
                "subject_type"=>get_class($thread)
            ]
        );
        $this->assertDatabaseMissing('activities',
            ['id'=>$reply->id,
                "subject_type"=>get_class($reply)
            ]
        );
    }

        /**
    * @test
    */

 //  public  function  a_thread_requires_title(){

      //  $this->publishThread(['title'=>null])
        //    ->assertSessionHasErrors('title');
  // }

   public function publishThread($override=[]){
       $thread=make('App\Thread',['title'=>null]);
       //  dd($thread);

       return $this->post('/threads',$thread->toArray());;

   }
}
