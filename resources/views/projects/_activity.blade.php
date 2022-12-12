<div class="card mt-3">
    <ul class="">
        @foreach($project->activity as $activity)
            <li class="capitalize text-sm"> @include("projects.activities._{$activity->description}")
                <span class="text-xs">
                    {{Str::limit($activity->subject?->body,10)}} {{$activity->created_at->diffForHumans(['syntax'=>1,'short'=>true])}}
                </span>
            </li>
        @endforeach
    </ul>
</div>
