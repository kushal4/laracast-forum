<?php

namespace App\Http\Controllers;

use App\Inspections\Spam;
use App\Reply;

use App\Rules\SpamFree;
use App\Thread;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RepliesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }

    public function index($channelId,Thread $thread)
    {
        //dd($thread);
        return $thread->replies()->paginate(4);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param $channelId
     * @param Thread $thread
     * @param Spam $spam
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store($channelId, Thread $thread)
    {
       //dd(request()->all());
      //  Log::alert("store controller");
       /// try{
        //dd("xvxxv");

       /// }catch (Exception $e){
           //dd("exception cauth");
      //      throw new \Exception("test");
       // }

       //dd("dgsdg");
//        $this->validate(\request(),
//            ['body'=>'required']);
//       $spam->detect(\request("body"));
        $reply=null;

        try{
            //dd("xdf");
            //$this->authorize("create",new Reply);
            request()->validate(['body' => ['required',new SpamFree]]);
            //dd(\request("body"));
            //
            // dd("dgdf");
//       if (stripos(\request("body"), "yahoo") !== false) {
////           dd("throw exception ends");
//           throw new \Exception('');
//           }
////
//
//        }
            $reply=$thread->addReply(
                [
                    'body'=>\request('body'),
                    'user_id'=>auth()->id()
                ]);
        }catch(\Exception $e){
          return response("Sorry your reply cant be saved",422);
        }

       // if(\request()->expectsJson()){
            return $reply->load('owner');
       // }

      //  return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Reply $reply
     * @param Spam $spam
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Reply $reply)
    {
        //
        $this->authorize('update',$reply);
       // $this->validateReply();
        request()->validate(['body' => ['required',new SpamFree]]);
       // $spam->detect($request->body);
        $reply->update(["body"=>$request->body]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reply $reply)
    {
//        if($reply->owner->id!=auth()->id()){
//            return response([],403);
//        }
        $this->authorize('update',$reply);

        $reply->delete();

        if(\request()->expectsJson()){
            return response(['status'=>'Reply Deleted']);
        }

        return back();
    }

    public function validateReply(){
        $this->validate(\request(),
            ['body'=>'required']);
      //  resolve(Spam::class)->detect(\request("body"));
    }
}
