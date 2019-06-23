<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Filters\ThreadFilters;
use App\Inspections\Spam;
use App\Rules\SpamFree;
use App\Thread;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ThreadsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }


    /**
     * Display a listing of the resource.
     *
     * @param Channel $channel
     * @return \Illuminate\Http\Response
     */
    // public function index($ChannelSlug=null)
    public function index(Channel $channel, ThreadFilters $filters)
    {
        //dd("index");

        //
        /*  if($channel->exists){
             // $channelId=Channel::where('slug',$ChannelSlug)->first();
             // dd($channelId->id);
                 // $chan_id=intval($channelId);
            //  $threads=Thread::where('channel_id',$channelId->id)->latest()->get();
              $threads=$channel->threads()->latest();
              //dd(Thread::latest()->get());
             // dd($channelId);
          }else{
              $threads=Thread::latest();
          }

          if($username=\request('by')){
              $user=\App\User::where('name',$username)->firstOrFail();
              $threads->where('user_id',$user->id);
          }

          $threads=$threads->get();*/


        $threads = $this->getThreads($channel, $filters);
        if(request()->wantsJson()){
            return $threads;
       }


        return view('threads.index', compact('threads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Spam $spam
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // dd($channelId);
        $request->validate(['title' => [new SpamFree,'required'],
            'body' => [new SpamFree,'required'],
            'channel_id' => 'required|exists:channels,id'
        ]);
      //   resolve(Spam::class)->detect($value);->detect($request->body);
        $thread = Thread::create(
            [
                'user_id' => auth()->id(),
                'channel_id' => $request->channel_id,
                'title' => $request->title,
                'body' => $request->body
            ]
        );
        // dd($thread->path());
        return redirect($thread->path())
            ->with('flash',"thread has been created");
    }

    /**
     * Display the specified resource.
     *
     * @param $channelId
     * @param \App\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function show($channel, Thread $thread)
    {
        //dd("this is show");
        //dd($thread);
        //return $thread->replies;
        //$key=sprintf("user.%s.visits.%s",auth()->id(),$thread->id);
        if(auth()->check()){
            auth()->user()->read($thread);
        }

        return view('threads.show', compact('thread'));
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy($channel,Thread $thread)
    {
        //$thread->replies()->delete();
       // dd($thread);
        $this->authorize('update',$thread);
        if($thread->user_id!=auth()->id()){

            abort(403,"You  dont have permission to do this!!!!!");
//            if(\request()->wantsJson()){
//                return response(["status"=>"Persmision denied"],403);
//            }
//            return redirect('/login');
        }
        $thread->delete();
        if(\request()->wantsJson()){

          return response([],204);
       }

       return redirect('/threads');
       // $referer = \request()->ref
       // dd($referer);

    }

    /**
     * @param $threads
     * @return mixed
     */
    public function getThreads(Channel $channel, ThreadFilters $filters)
    {
        $threads = Thread::with('channel')->latest()->filter($filters);
        if ($channel->exists) {
            $threads->where('channel_id', $channel->id);
        }
        //dd($threads->toSql());
        $threads=$threads->get();
      // dd($threads);
        return $threads;

    }

}
