@extends('layouts.app')

@section("header")
    <link rel="stylesheet" href="/css/vendor/jquery.atwho.css">
    @endsection
@section('content')
    <thread-view :thread="{{ $thread }}" inline-template>
    <div class="container">
        <div class="row ">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" href="">
                      <span class="flex">
                            <a href="{{route('profile',$thread->owner)}}">
                            {{$thread->owner->name}} posted :: {{$thread->title}}
                        </a>
                      </span>
                        @can('update',$thread)
                        <form action="{{$thread->path()}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-default"> Delete</button>
                            </div>
                        </form>
                        @endcan
                        </div>

                    </div>

                    <div class="card-body">
                        {{$thread->body}}
                    </div>
                </div>
            </div>

{{--            @foreach($thread->replies as $reply)--}}
{{--                @include('threads.reply')--}}
{{--            @endforeach--}}
        <replies   @added="repliesCount++" @removed="repliesCount--"></replies>
{{--        <hello-world msg="Welcome to Your Vue.js App"/>--}}


        <div class="col-md-8">
{{--



--}}
                </div>

            <div class="col-md-4">
                <p>
                    This thread was published {{ $thread->created_at->diffForHumans() }} by
                    <a href="#">{{ $thread->owner->name }}</a>, and currently
                    has<span v-text="repliesCount"></span>
                             {{ str_plural('comment', $thread->replies_count) }}
                    .
                </p>
                <p>
                    <subscribe-button :active="{{json_encode($thread->isSubscribedTo)}}"></subscribe-button>
                </p>


            </div>

           <flash message="{{session('flash')}}"></flash>

        </div>
        </div>
    </thread-view>
@endsection
