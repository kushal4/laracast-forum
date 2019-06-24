<?php

namespace App\Policies;

use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Log;

class ReplyPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine whether the user can update the thread.
     *
     * @param  \App\User  $user
     * @param  \App\Thread  $thread
     * @return mixed
     */
    public function update(User $user, Reply $reply)
    {
        return $reply->user_id == $user->id;
    }

    public function create(User $user){
       // dd($user->lastReply);

        if(! $lastrep=$user->fresh()->lastReply){
           // Log::alert("print me!!!!!!!!");
            return true;
        }

                //dd($lastrep->wasJustPublished());



         //   return true;
        //}else{
            return ! $lastrep->wasJustPublished();
       // }

    }
}
