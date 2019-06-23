{{--<div class="level">--}}
{{--                   <span class="flex">--}}
{{--                       {{$profileUser->name}} published--}}
{{--                       <a href="{{$activity->subject->path()}}">{{$activity->subject->title}}</a>--}}
{{--                       @include("profiles.activities.{$activity->type}")--}}
{{--                       --}}{{--                         <a href="{{route('profile',$thread->owner)}}">{{$thread->creator_name}}</a> posted--}}
{{--                       --}}{{--                   {{$thread->title}}--}}
{{--                   </span>--}}
{{--    <span>--}}
{{--                       {{$thread->created_at->diffForHumans()}}--}}
{{--                   </span>--}}

{{--</div>--}}


{{--</div>--}}

{{--<div class="card-body">--}}
{{--                          {{$activity->subject->body}}--}}
{{--</div>--}}

@component("profiles.activities.activity")
    @slot("heading")
        {{$profileUser->name}} published
        <a href="{{$activity->subject->path()}}">{{$activity->subject->title}}</a>
    @endslot
    @slot("body")
        {{$activity->subject->body}}
    @endslot

@endcomponent