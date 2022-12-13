<x-app-layout>

    <div class="flex items-center mb-3 pb-4">
        <div class="flex justify-between w-full items-end">
            <p class="text-gray-400 text-sm">
                <a href="{{route('projects.index')}}">My Projects</a> / {{$project->title}}
            </p>

            <div class="flex items-center">

                @foreach($project->members as $member)
                    <img src="{{gravatar_url($member->email)}}"
                         alt="{{$member->name}}'s avatar"
                         title="{{$member->name}}"
                         class="rounded-full w-8 mr-1">
                @endforeach

                <img src="{{gravatar_url($project->owner->email)}}"
                     alt="{{$project->owner->name}}'s avatar"
                     title="{{$project->owner->name}}"
                     class="rounded-full w-8 mr-1">

                <a href="{{route('projects.edit',$project)}}" class="btn btn-blue ml-5">Edit Project</a>
            </div>
        </div>
    </div>


    <div class="lg:flex -mx-3">
        <div class="lg:w-3/4 px-3 mb-6">
            {{--Tasks--}}
            <div class="mb-8">
                <h2 class="text-lg text-gray-400 mb-3">Tasks</h2>

                @foreach($project->tasks as $task)
                    <div class="card mb-3 py-3.5">
                        <form action="{{route('projects.tasks.update',[$project,$task])}}" method="post">
                            @method('PATCH')
                            @csrf
                            <div class="flex">
                                <label for="body" class="w-full">
                                    <input type="text" name="body" id=""
                                           @class(['border-none p-0 w-full','text-gray-400'=>$task->completed])
                                           value="{{$task->body}}">
                                </label>
                                <label for="completed">
                                    <input type="checkbox" name="completed" id="" class="rounded text-blue-picton"
                                           onchange="this.form.submit()" @checked($task->completed)>
                                </label>
                            </div>
                        </form>
                    </div>
                @endforeach
                <div class="card text-gray-600 py-3.5">
                    <form action="{{route('projects.tasks.store',$project)}}" method="POST"
                          class="flex justify-between items-center">
                        @csrf
                        <label class="grow lg:mr-2">
                            <input type="text" name="body" class="border-none w-full p-0"
                                   placeholder="Begin adding tasks...">
                        </label>
                        <button class="btn btn-blue" type="submit" value="">Add a new task</button>
                    </form>
                </div>
            </div>


            {{--General Notes--}}
            <div class=""><h2 class="text-lg text-gray-400 mb-3">General Notes</h2>

                <form action="{{route('projects.update',$project)}}" method="post">
                    @csrf
                    @method('PATCH')
                    <label>
                        <textarea name="notes"
                                  class="card w-full min-h-[200px] border-none mb-4">{{$project->notes}}</textarea>
                    </label>
                    @if($errors->hasAny())
                        {{print_r($errors)}}
                    @endif
                    <button type="submit" class="btn btn-blue">Save</button>
                </form>
            </div>

        </div>

        <div class="lg:w-1/4 px-3">

            <x-project.card :project="$project"></x-project.card>

            @include('projects._activity')

        </div>
    </div>


</x-app-layout>
