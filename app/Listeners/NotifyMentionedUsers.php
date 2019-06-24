<?php

namespace App\Listeners;

use App\Events\ThreadRecievedNewReply;
use App\Notifications\YouWereMentioned;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyMentionedUsers
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ThreadRecievedNewReply  $event
     * @return void
     */
    public function handle(ThreadRecievedNewReply $event)
    {


        //$names=;
        collect($event->reply->mentionedUsers())
            ->map(function ($name){
                return User::whereName($name)->first();
            })->filter()
            ->each(function ($user) use ($event){
                $user->notify(new YouWereMentioned($event->reply));
            });
        //dd($names);
//        foreach ($names as $name ) {
//
//            $user=User::whereName($name)->first();
//            //dd($user);
//            if($user){
//                // dd($user->name);
//                $user->notify(new YouWereMentioned($event->reply));
//            }
//        }
    }
}
