@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @foreach($threads as  $thread)
                <div class="card">
                    <div class="card-header">
                        <div class="level">
                            <h4 class="flex">
                                <a href="{{$thread->path()}}">
                                @if(auth()->check() && $thread->hasUpdatesFor(auth()->user()))
                                <strong>{{$thread->title}}</strong>
                                @else
                                   {{$thread->title}}
                                @endif
                                </a>
                            </h4>
                        </div>
                    </div>

                    <div class="card-body">

                               <div class="body">{{$thread->body}}</div>




                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
