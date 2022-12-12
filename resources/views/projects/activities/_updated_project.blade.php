{{$activity->user->name}} Updated
@if(count($activity->changes['after']) === 1)
    {{key($activity->changes['after'])}}
@else
    Project
@endif
