<?php

namespace App\Http\Controllers;

use App\Activity;
use App\User;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        //dd("contstruct");
    }

    public function index()
    {
        //
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return void
     */
    public function show(User $user)
    {
        //$activities=$user->activity()->with('subject')->get();

//        $activities=$user->activity()->latest()->with("subject")->get()->groupBy(function($activity){
//           return $activity->created_at->format('Y-m-d');
//        });
        //$activities=$this->getActivity($user);
//    foreach ($user->activity() as  $activity){
//        dd($activity);
//    }
        //($user->activity());
        //return "start ";
        $activities=Activity::feed($user);
        //dd($activities);
        return view('profiles.show', [
            'profileUser' => $user,
            'activities'=>$activities
        ]);
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function getActivity($user){
        return $user->activity()->latest()->with("subject")->get()->groupBy(function($activity){
            return $activity->created_at->format('Y-m-d');
        });
    }
}
