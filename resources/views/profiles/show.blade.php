@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row">
        	<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 offset-2">
                <div class="card">
                    <div class="pb-2 mt-4 mb-2">
                        <h4 class="card-title"> {{$profileUser->name}}</h4>
                        <small>Since {{$profileUser->created_at->diffForHumans()}}</small>
                    </div>

                    <div class="card-header ">
                        @forelse($activities as $date=>$activity)
                            <h3 class="alert-heading">{{$date}}</h3>
                            @foreach($activity as $record)
                                @if(view()->exists("profiles.activities.{$record->type}"))
                                @include ("profiles.activities.{$record->type}", ['activity' => $record,"profileUser"=>$profileUser])
                                @endif
                                @endforeach
                            @empty
                            there hasbeen no activity
                    @endforelse
                   
        	</div>
        </div>
    </div>

    </div>


@endsection