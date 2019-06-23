



{{--<div class="level">--}}
{{--                   <span class="flex">--}}
{{--                    {{$profileUser->name}} replied to--}}
{{--                      <a href="{{$activity->subject->thread->path()}}">{{$activity->subject->thread->title}}</a>--}}
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
{{--    {{$activity->subject->body}}--}}
{{--</div>--}}

@component('profiles.activities.activity')
    @slot('heading')
        {{ $profileUser->name }} replied to
        <a href="{{ $activity->subject->thread->path() }}">"{{ $activity->subject->thread->title }}"</a>
    @endslot

    @slot('body')
        {{ $activity->subject->body }}
    @endslot
@endcomponent

{{--@component("profiles.activities.activity")--}}
{{--        @slot("heading")--}}
{{--            {{$profileUser->name}} replied to--}}
{{--            <a href="{{$activity->subject->thread->path()}}">{{$activity->subject->thread->title}}</a>--}}
{{--            @include("profiles.activities.{$activity->type}")--}}
{{--            @endslot--}}
{{--       @slot("body")--}}
{{--           {{$activity->subject->body}}--}}
{{--           @endslot--}}

{{--    @endcomponent--}}