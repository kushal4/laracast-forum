<?php

namespace App;

use App\Events\ThreadHasNewReply;
use App\Events\ThreadRecievedNewReply;
use App\Filters\ThreadFilters;
use App\Notifications\ThreadWasUpdated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Thread extends Model
{
    use RecordsActivity;
    protected $guarded=[];

    protected $appends=["isSubscribedTo"];


    protected static function boot()
    {
        parent::boot();
        // static::addGlobalScope('replyCount',function ($builder){
        //    $builder->withCount("replies");
        // });

        static::deleting(function ($thread){
            $thread->replies()->delete();
        });


    }

    public function path()
    {
       // dd($this->id);
       // return "/threads/$this->id";
        return "/threads/{$this->channel->slug}/{$this->id}";
       // return "/threads/".$this->channel->slug."/".$this->id;
    }

    public function replies(){
        return $this->hasMany(Reply::class);
    }

    public function owner(){
        return $this->belongsTo(User::class,'user_id');
    }


    public function addReply($reply){
        $reply=  $this->replies()->create($reply);
        event(new ThreadRecievedNewReply($reply));
        //event(new ThreadHasNewReply($this,$reply));
//$this->notifySubscribers($reply);

//       // Log::alert("Addreply hit here");
//        $this->subscriptions
////            ->filter(function($sub) use ($reply){
////                return $sub->user_id!=$reply->user_id;
////        }
//                ->where("user_id","!=",$reply->user_id)
//->each->notify($reply);
//            ->each(function($sub) use ($reply){
//                $sub->user->notify(new ThreadWasUpdated($this,$reply));
//            });
//        foreach ($this->subscriptions as $subscription){
//
//            if($subscription->user_id!=$reply->user_id){
//                $subscription->user->notify(new ThreadWasUpdated($this,$reply));
//            }else{
//                Log::alert("both users were same");
//            }
//
//        }
        //$this->increment("replies_count");
       // dd("came to here");
        return $reply;
    }

    public function notifySubscribers($reply){
        $this->subscriptions
            ->where("user_id","!=",$reply->user_id)
            ->each
            ->notify($reply);
    }

    public function channel(){
        return $this->belongsTo(Channel::class);
    }

    /**
     * Apply all relevant thread filters.
     *
     * @param  Builder       $query
     * @param  ThreadFilters $filters
     * @return Builder
     */
    public function scopeFilter($query, ThreadFilters $filters)
    {
        return $filters->apply($query);
    }

    public function subscribed($user_id=null){

        $this->subscriptions()->create([
            "user_id"=>$user_id?:auth()->id()
        ]);

        return $this;
    }

    public function unsubscribed($user_id=null){
        $this->subscriptions()->where("user_id",$user_id?:auth()->id())->delete();
    }

    public function subscriptions(){
        return $this->hasMany(ThreadSubscription::class);
    }

    public function getisSubscribedToAttribute()
    {
        return $this->subscriptions()
            ->where("user_id",auth()->id())
            ->exists();
    }

    public  function hasUpdatesFor(){

        $key=auth()->user()->visitedcacheKey($this);
        return $this->updated_at > cache($key);
    }
}
