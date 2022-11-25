<x-app-layout>

    <div class="flex mb-3 py-4">
        <div class="flex justify-between w-full items-end">
            <p class="text-gray-400 text-sm">
                <a href="{{route('projects.index')}}">My Projects</a> / {{$project->title}}
            </p>

            <a href="{{route('projects.create')}}" class="btn btn-blue">New Project</a>
        </div>
    </div>

    <div class="lg:flex -mx-3">
        <div class="lg:w-3/4 px-3 mb-6">
            {{--Tasks--}}
            <div class="mb-8">
                <h2 class="text-lg text-gray-400 mb-3">Tasks</h2>

                @forelse($project->tasks as $task)
                    @if ($loop->last)
                        <div class="card">{{$task->body}}</div>
                    @else
                        <div class="card mb-3">{{$task->body}}</div>
                    @endif
                @empty
                    <div class="card text-gray-600">No tasks Yet</div>
                @endforelse
            </div>


            {{--General Notes--}}
            <div class=""><h2 class="text-lg text-gray-400 mb-3">General Notes</h2>

                <label>
                    <textarea class="card w-full min-h-[200px] border-none">General notes</textarea>
                </label>
            </div>

        </div>

        <div class="lg:w-1/4 px-3">
            <x-project.card :project="$project"></x-project.card>
        </div>
    </div>


</x-app-layout>
